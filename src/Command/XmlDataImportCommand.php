<?php

declare(strict_types=1);

namespace App\Command;

use App\Exception\DataImporterContextException;
use App\Exception\XmlDataImporterException;
use App\Service\DataImporterContext;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Psr\Log\LoggerInterface;

#[AsCommand(name: 'app:data-import')]
class XmlDataImportCommand extends Command
{
    public function __construct(private readonly DataImporterContext $dataImporterContext, private readonly LoggerInterface $logger)
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
        $filename = $input->getArgument('filename');
        $type = $input->getArgument('type') ? $input->getArgument('type') : 'csv';

        try {
            $this->dataImporterContext->handle($filename, $type);
        } catch (DataImporterContextException|XmlDataImporterException $exception) {
            $this->logger->error($exception->getMessage());

            return Command::FAILURE;
        }

        $output->write('The file '.$filename.' was imported successfully!');

        return Command::SUCCESS;
    }
}
