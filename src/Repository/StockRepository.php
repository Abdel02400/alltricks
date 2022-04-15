<?php

namespace App\Repository;

use App\Entity\Stock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class StockRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Stock::class);
    }
}