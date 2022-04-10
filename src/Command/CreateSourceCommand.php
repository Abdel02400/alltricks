<?php

namespace App\Command;

use App\Entity\Source;
use App\Entity\SourceCategory;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateSourceCommand extends Command
{
    protected static $defaultName = 'app:create-source';

    /**
     * @var ManagerRegistry
     */
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return integer
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sourceCategoryBDD = $this->doctrine->getRepository(SourceCategory::class)->findOneBy(['name' => 'BDD']);
        $sourceCategoryRSS = $this->doctrine->getRepository(SourceCategory::class)->findOneBy(['name' => 'RSS']);

        $sourceRSSName = "http://www.lemonde.fr/rss/une.xml";

        $sourceRSS = (new Source())->setName($sourceRSSName)->setSourceCategory($sourceCategoryRSS);

        $output->writeln('L\'ajout dela source avec l\'url suivant : ' . $sourceRSSName . ', a été ajouté');

        return Command::SUCCESS;
    }
}