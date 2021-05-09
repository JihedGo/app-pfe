<?php

namespace App\Repository;

use App\Entity\Postule;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * @method Postule|null find($id, $lockMode = null, $lockVersion = null)
 * @method Postule|null findOneBy(array $criteria, array $orderBy = null)
 * @method Postule[]    findAll()
 * @method Postule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostuleRepository extends ServiceEntityRepository
{
    private $security;
    public function __construct(ManagerRegistry $registry, Security $security)
    {
        $this->security = $security;
        parent::__construct($registry, Postule::class);
    }

    // /**
    //  * @return Postule[] Returns an array of Postule objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Postule
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getRefusedPostules(User $user){
        //$user = $this->security->getUser();
        $q = $this->createQueryBuilder('p')
                  ->select('p')
                  ->where('p.student = :val')
                  ->setParameter('val',$user)
                  ->andWhere('p.isAccepted = :val2')
                  ->setParameter(':val2',false)
                  ->andWhere('p.reason is not null')
                  ->getQuery()
                  ->getResult();
        return $q;

    }
}
