<?php

namespace App\Command;

use App\Entity\Article;
use App\Entity\ArticleCategory;
use App\Entity\Source;
use App\Repository\SourceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CreateArticleCommand extends Command
{
    protected static $defaultName = 'app:create-article';

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
        $this->setHelp('Cette commande permet d\'ajouter les articles');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return integer
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        try {
            $mockArticles = file_get_contents(__DIR__ . '/../Mock/articles.json');

            $articles = json_decode($mockArticles);
    
            /** @var SourceRepository $sourceBDDRepository */
            $sourceBDDRepository = $this->doctrine->getRepository(Source::class);

            $sourceBDD = $sourceBDDRepository->findOneBySourceCategoryBDD();
    
            foreach($articles as $article) {
                $articleToString = json_encode($article);
                
                /**
                 * @var Article $articleEntity
                 */
                $articleEntity = $serializer->deserialize($articleToString, Article::class, 'json');
    
                $articleCategory = $this->doctrine->getRepository(ArticleCategory::class)->findOneBy(["name" => $article->article_category_name]);
    
                $articleEntity
                    ->setSource($sourceBDD)
                    ->setArticleCategory($articleCategory);
                    
                $this->doctrine->getManager()->persist($articleEntity);    
            }
    
            $this->doctrine->getManager()->flush();
        } catch (\Exception $e) {
            $output->writeln('<fg=black;bg=red>L\'ajout des articles a échoué : ' . $e->getMessage() . '</>');
            return Command::FAILURE;
        }

        $output->writeln('<fg=black;bg=green>L\'ajout des articles a échoué a été effectué</>');
        return Command::SUCCESS;
    }
}