<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ArticleRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Article::class);
    }
}