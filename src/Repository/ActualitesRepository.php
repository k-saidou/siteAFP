<?php

namespace App\Repository;

use App\Entity\Actualites;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Actualites|null find($id, $lockMode = null, $lockVersion = null)
 * @method Actualites|null findOneBy(array $criteria, array $orderBy = null)
 * @method Actualites[]    findAll()
 * @method Actualites[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActualitesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Actualites::class);
    }


     /**
     * @return Actualites[]
     */
    public function findAllActualites(): array
    {
        
        $conn = $this->getEntityManager()->getConnection();

    $sql = '
    SELECT * FROM Actualites 
    WHERE date_at 
    ORDER BY date_at DESC LIMIT 6
        ';
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // returns an array of arrays (i.e. a raw data set)
    return $stmt->fetchAll();

        // returns an array of Product objects
    }


    /**
     * @return Actualites[]
     */
    public function findAllMesactu(): array
    {

        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT * FROM `actualites`
        WHERE `iduser_id`=`id`';

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();

        // returns an array of Product objects
    }

    
/*
    public function findLastActualites(int $nb=5){
        return $this->createQueryBuilder('a')
            ->andWhere('a.id = :id')
            ->setParameter('id','$id')
            ->orderBy('a.dateAt', 'DESC')
            ->setMaxResults($nb)
            ->getQuery()
            ->getResult()
    ;

    }*/

    /* /**
      * @return Actualites[] Returns an array of Actualites objects
      */
    

    /*
    public function findOneBySomeField($value): ?Actualites
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
