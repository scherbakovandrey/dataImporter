<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:generate-file')]
class GenerateXmlFileCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $rooms = 100000;
        $datesPerRoom = 1000;

        $pregeneratedDates = [];
        $date = new \DateTime();
        for ($i = 0; $i < $datesPerRoom; ++$i) {
            $date->modify('+1 day');
            $pregeneratedDates[] = $date->format('Y-m-d');
        }

        echo '<hotel>';
        echo "\t<rooms>";
        for ($i = 0; $i < $rooms; ++$i) {
            echo "\t\t<room id=\"$i\">";
            foreach ($pregeneratedDates as $date) {
                echo "\t\t\t<vacancy date=\"$date\">".mt_rand(0, 1)."</vacancy>\n";
            }
            echo "\t\t</room>";
        }
        echo "\t</rooms>";
        echo '</hotel>';

        return Command::SUCCESS;
    }
}
