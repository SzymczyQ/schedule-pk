<?php

namespace App\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UpdateScheduleCommand
 * @package App\Command
 */
class UpdateScheduleCommand extends ContainerAwareCommand
{
    /**
     * @var OutputInterface $output
     */
    private $output;

    /**
     * UpdateScheduleCommand constructor.
     * @param null|string $name
     */
    public function __construct(?string $name = null)
    {
        parent::__construct($name);
    }

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('app:schedule:update')
            ->setDescription('Parse and update schedule.')
            ->setHelp('Use this command to parse and update schedule...')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $result = [];
        $excel = \PhpOffice\PhpSpreadsheet\IOFactory::load('file.xls');
        $rows = $excel->getActiveSheet()->toArray();
        foreach ($rows as $rowIndex => $row) {
            if ($rowIndex > 16) {
                continue;
            }

            foreach ($row as $cellIndex => $cell) {
                if ($cellIndex > 40) {
                    continue;
                }

                dump($cell);
            }
//            die();
        }


//        $worksheet = $excel->getActiveSheet();
//        foreach ($worksheet->getRowIterator() as $row) {
//            $cellIterator = $row->getCellIterator();
//            $cellIterator->setIterateOnlyExistingCells(true);
//            foreach ($cellIterator as $cell) {
//                dump($cell->getParent());
//            }
//            die();
//        }
    }
}
