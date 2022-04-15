<?php

namespace App\Service;

use App\DBAL\MultiDatabaseConnectionWrapper;
use App\Entity\Source;
use App\Entity\Stock;
use App\Repository\SourceRepository;
use Doctrine\Persistence\ManagerRegistry;

class ArticleService
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @return array
     */
    public function getArticlesFromDatabase(): array
    {
        $connection = $this->doctrine->getConnection();

        if(!$connection instanceof MultiDatabaseConnectionWrapper) {
            throw new \RuntimeException('La connection a échoué');
        }
        
        /** @var SourceRepository $sourceBDDRepository */
        $sourceBDDRepository = $this->doctrine->getRepository(Source::class);

        $sourceBDD = $sourceBDDRepository->findOneBySourceCategoryBDD();

        $connection->selectDatabase($sourceBDD->getDatabaseName(), $sourceBDD->getDatabaseUser(), $sourceBDD->getDatabasePassword(), $sourceBDD->getDatabaseDomain(), $sourceBDD->getDatabasePort());

        /** @var array */
        $result = $connection->executeQuery('SELECT *, a.name as name, ac.name as category_name FROM articles as a INNER JOIN articles_category as ac WHERE a.article_category_id = ac.id')->fetchAllAssociative();
        
        if (count($result) === 0) return $result;

        $groupResult = [];

        foreach($result as $element)
        {
            $articleName = $element['name'];

            /** @var array */
            $stocks = $connection->executeQuery('SELECT *, s.id as id, a.id as article_id FROM stocks as s INNER JOIN articles as a WHERE s.article_id = a.id AND a.name = "' . $articleName . '" ')->fetchAllAssociative();
            $element['stocks'] = $stocks;
            $groupResult[$articleName] = $element; 
        }

        return $groupResult;
    }

    /**
     * @return array
     */
    public function getArticlesFromRSS(): array 
    {
        $mockArticles = simplexml_load_file(__DIR__ . '/../Mock/articles.xml', 'SimpleXMLElement');

        $result = [];

        foreach($mockArticles as $article)
        {
            $result[current($article->name)] = [];
            $result[current($article->name)]['name'] = current($article->name);
            $result[current($article->name)]['content'] = current($article->content);
            $result[current($article->name)]['img_src'] = current($article->img_src);
            $result[current($article->name)]['select_label'] = current($article->select_label);
            $result[current($article->name)]['stocks'] = [];
            foreach($article->stocks as $stock) {
                $result[current($article->name)]['stocks'][] = [
                    'id' => current($stock->stock->id),
                    'quantity' => current($stock->stock->quantity),
                    'price' => current($stock->stock->price),
                    'size' => current($stock->stock->size)
                ];
            }
        }

        return $result;
    }
}