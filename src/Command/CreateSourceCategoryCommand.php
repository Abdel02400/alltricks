<?php

namespace App\Command;

use App\Entity\SourceCategory;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateSourceCategoryCommand extends Command
{
    protected static $defaultName = 'app:create-source-category';

    /**
     * @var ManagerRegistry
     */
    private ManagerRegistry $doctrine;

    /**
     * @param ManagerRegistry $doctrine
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        parent::__construct();
    }

    protected function configure()
    {
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return integer
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sourceCategoryBDD = (new SourceCategory())->setName('BDD');
        $sourceCategoryRSS = (new SourceCategory())->setName('RSS');

        try {
            $this->doctrine->getManager()->persist($sourceCategoryBDD);
            $this->doctrine->getManager()->persist($sourceCategoryRSS);
            $this->doctrine->getManager()->flush();
        } catch (\Exception $e) {
            $output->writeln('L\'ajout des sources category a échoué : ' . $e->getMessage());
            return Command::FAILURE;
        }
        
        $output->writeln('L\'ajout des sources category a été effectué avec succès');
        return Command::SUCCESS;
    }
}