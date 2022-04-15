<?php

namespace App\Command;

use App\Entity\Article;
use App\Entity\Stock;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateStockCommand extends Command
{
    protected static $defaultName = 'app:create-stock';

    private ManagerRegistry $doctrine;

    /**
     * @param ManagerRegistry $doctrine
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        parent::__construct();
    }

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setHelp('Cette commande permet d\'ajouter les stocks');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return integer
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var Article[]|null */
        $articles = $this->doctrine->getRepository(Article::class)->findAll();

        if (empty($articles)) {
            $output->writeln('<fg=black;bg=red>Avant d\'ajouter les stocks, veuillez ajouter les articles via la commande suivante : php bin/console app:create-article</>');
            return Command::FAILURE;
        }

        try {
            foreach($articles as $article) {
                $articlesCategory = $article->getArticleCategory();
                
                for ($i = 0; $i < 4; $i++) {
                    $sizeClothes = ['S', 'M', 'L', 'XL'];
                    $sizeShoes = ['37', '37 1/2', '38', '39'];
    
                    if ($articlesCategory->getName() === 'clothes') {
                        $randomKey = array_rand($sizeClothes);
                        $size = $sizeClothes[$randomKey];
                    } else {
                        $randomKey = array_rand($sizeShoes);
                        $size = $sizeShoes[$randomKey];
                    }
    
                    $stock = (new Stock())
                                ->setArticle($article)
                                ->setQuantity($i)
                                ->setPrice(number_format((float) mt_rand(0, 2000) / 10, 2, '.', ''))
                                ->setSize($size);
    
                    $this->doctrine->getManager()->persist($stock);            
                }
            }
    
            $this->doctrine->getManager()->flush();
        } catch (\Exception $e) {
            $output->writeln('<fg=black;bg=red>L\'ajout des stocks a échoué : ' . $e->getMessage() . '</>');
            return Command::FAILURE;
        }

        $output->writeln('<fg=black;bg=green>L\'ajout des stocks a été effectué');
        return Command::SUCCESS;
    }
}