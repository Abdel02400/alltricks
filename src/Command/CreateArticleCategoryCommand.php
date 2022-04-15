<?php

namespace App\Command;

use App\Entity\ArticleCategory;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateArticleCategoryCommand extends Command
{
    protected static $defaultName = 'app:create-article-category';

    /**
     * @var ManagerRegistry
     */
    private ManagerRegistry $doctrine;

    /**
     * @param ManagerRegistry $doctrine
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        parent::__construct();
        $this->doctrine = $doctrine;
    }

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setHelp('Cette commande permet de générer les articles category (Clothes avec comme select label => taille, Shoes avec comme select label => pointure)');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return integer
     */
    protected function execute(
        InputInterface $input, 
        OutputInterface $output
    ): int
    {        
        $articleCategoryClothes = (new ArticleCategory())
                                ->setName('clothes')
                                ->setSelectLabel('Taille');
                                
        $articleCategoryShoes = (new ArticleCategory())
                                ->setName('shoes')
                                ->setSelectLabel('Pointure');

        try {
            $this->doctrine->getManager()->persist($articleCategoryClothes);
            $this->doctrine->getManager()->persist($articleCategoryShoes);
            $this->doctrine->getManager()->flush();
        } catch (\Exception $e) {
            $output->writeln('<fg=black;bg=red>L\'ajout des articles category a échoué : ' . $e->getMessage() . '</>');
            return Command::FAILURE;
        }
        
        $output->writeln('<fg=black;bg=green>L\'ajout des articles category (Clothes avec comme select label => taille, Shoes avec comme select label => pointure) a été effectué avec succès</>');
        return Command::SUCCESS;
    }
}