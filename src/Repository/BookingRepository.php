<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }
    
    

    // /**
    //  * @return Booking[] Returns an array of Booking objects
    //  */
    
    public function findByDate($value1, $value2)
    {
        return $this->createQueryBuilder('b')
            ->select(array('sum(b.nbOfSeats) as seats','b.date','b.beginAt','b.endAt'))
            ->where('b.date > :value1')
            ->andWhere('b.date < :value2')
            ->setParameter('value1', $value1)
            ->setParameter('value2', $value2)
            ->groupBy('b.date')
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Booking
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
