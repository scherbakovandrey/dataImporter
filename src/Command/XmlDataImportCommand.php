<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Logger\ConsoleLogger;
use App\Service\DataImporterContext;
use App\Exception\DataImporterContextException;

#[AsCommand(name: 'app:data-import')]
class XmlDataImportCommand extends Command
{
    public function __construct(private DataImporterContext $dataImporterContext)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('filename', InputArgument::REQUIRED, 'The local or remote name of the XML file')
            ->addArgument('type', InputArgument::OPTIONAL, 'Type of the import [supported types: CSV]')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $logger = new ConsoleLogger($output);

        $filename = $input->getArgument('filename');
        $type = $input->getArgument('type') ? $input->getArgument('type') : 'csv';

        $fileContents = file_get_contents($filename);

        try
        {
            $this->dataImporterContext->handle($fileContents, $type);
        }
        catch (DataImporterContextException $exception)
        {
            $logger->error($exception->getMessage());

            return Command::FAILURE;
        }

        $output->write('The file ' . $filename . ' was imported successfully!');

        return Command::SUCCESS;
    }
}