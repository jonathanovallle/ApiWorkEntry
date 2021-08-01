<?php

namespace App\Repository;

use App\Entity\WorkEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method WorkEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkEntry[]    findAll()
 * @method WorkEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,EntityManagerInterface $manager)
    {
        parent::__construct($registry, WorkEntry::class);
        $this->manager = $manager;
    }

    public function saveWorkEntry($userId, $createdAt, $startDate)
    {
        $newWorkEntry = new WorkEntry();

        $newWorkEntry
            ->setUserId($userId)
            ->setCreatedAt($createdAt)
            ->setStartDate($startDate);

        $this->manager->persist($newWorkEntry);
        $this->manager->flush();
    }

    public function findWorkEntryById($id)
    {

        return $this->createQueryBuilder('work')
            ->andWhere('work.id = :val')
            ->andWhere('work.deletedAt is null')
            ->setParameter('val', $id)
            ->getQuery()
            ->getArrayResult()
        ;
    }

    public function findWorkEntryByUserId($id)
    {

        return $this->createQueryBuilder('work')
            ->andWhere('work.userId = :val')
            ->andWhere('work.deletedAt is null')
            ->setParameter('val', $id)
            ->getQuery()
            ->getArrayResult()
        ;
    }

    public function updateWorkEntry(WorkEntry $WorkEntry): WorkEntry
    {
        $this->manager->persist($WorkEntry);
        $this->manager->flush();

        return $WorkEntry;
    }

    // /**
    //  * @return WorkEntry[] Returns an array of WorkEntry objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WorkEntry
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
