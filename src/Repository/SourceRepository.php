<?php

namespace App\Repository;

use App\Entity\Source;
use App\Entity\SourceCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

class SourceRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Source::class);
    }

    /**
     * @return Source|null
     */
    public function findOneBySourceCategoryBDD(): ?Source
    {
        $entityManager = $this->getEntityManager();

        $result = $entityManager->createQuery(
            'SELECT sources
            FROM App\Entity\Source sources
            INNER JOIN App\Entity\SourceCategory sourcesCategory
            WHERE sources.sourceCategory = sourcesCategory.id
            AND sourcesCategory.name = \'BDD\''
        )->getResult();

        return count($result) === 1 ? $result[0] : null;
    }
}