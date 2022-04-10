<?php

namespace App\Repository;

use App\Entity\ArticleCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ArticleCategoryRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, ArticleCategory::class);
    }
}