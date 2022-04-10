<?php

namespace App\Repository;

use App\Entity\Source;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SourceRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Source::class);
    }
}