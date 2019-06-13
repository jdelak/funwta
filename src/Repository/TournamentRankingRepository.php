<?php

namespace App\Repository;

use App\Entity\TournamentRanking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TournamentRanking|null find($id, $lockMode = null, $lockVersion = null)
 * @method TournamentRanking|null findOneBy(array $criteria, array $orderBy = null)
 * @method TournamentRanking[]    findAll()
 * @method TournamentRanking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TournamentRankingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TournamentRanking::class);
    }
    
    public function findByTournament($tournament){
        return $this->createQueryBuilder('t')
            ->andWhere('t.tournament = :tournament')
            ->setParameter('tournament', $tournament)
            ->orderBy('t.points', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return TournamentRanking[] Returns an array of TournamentRanking objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TournamentRanking
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
