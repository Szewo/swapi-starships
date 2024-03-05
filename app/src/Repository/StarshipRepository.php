<?php

namespace App\Repository;

use App\Entity\Starship;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Starship>
 *
 * @method Starship|null find($id, $lockMode = null, $lockVersion = null)
 * @method Starship|null findOneBy(array $criteria, array $orderBy = null)
 * @method Starship[]    findAll()
 * @method Starship[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StarshipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Starship::class);
    }
}
