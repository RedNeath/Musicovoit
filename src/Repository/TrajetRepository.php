<?php

namespace App\Repository;

use App\Entity\Trajet;
use App\Entity\Ville;
use DateInterval;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trajet>
 *
 * @method Trajet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trajet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trajet[]    findAll()
 * @method Trajet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrajetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trajet::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Trajet $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Trajet $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Trajet[] Returns an array of Trajet objects
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
    public function findOneBySomeField($value): ?Trajet
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @param string $from
     * @param string $to
     * @param DateTime $on
     * @param int $with
     * @return Trajet[]
     */
    public function search(string $from, string $to, DateTime $on, int $with) : array {
        $builder = $this->createQueryBuilder('t');

        $builder = $builder
            ->innerJoin('t.depart', 'vd')
            ->innerJoin('t.arrivee', 'va')
            ->where($builder->expr()->like('vd.nom', ':from'))
            ->andWhere($builder->expr()->like('va.nom', ':to'))
            ->andWhere($builder->expr()->between('t.date', $on->format('Y-m-d'), $on->modify('+1 day')->format('Y-m-d')))
            ->andWhere('t.places >= :with')
            ->setParameter('from', $from)
            ->setParameter('to', $to)
            ->setParameter('with', $with)
            ->orderBy('t.date', 'ASC');

        return $builder->getQuery()->getResult();
    }
}
