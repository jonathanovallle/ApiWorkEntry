<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,EntityManagerInterface $manager)
    {
        parent::__construct($registry, User::class);
        $this->manager = $manager;
    }

    public function saveUser($name, $email, $createAt)
    {
        $newUser = new User();

        $newUser
            ->setName($name)
            ->setEmail($email)
            ->setCreatedAt($createAt);

        $this->manager->persist($newUser);
        $this->manager->flush();
    }

    public function updateUser(user $user): User
    {
        $this->manager->persist($user);
        $this->manager->flush();

        return $user;
    }

    public function findAllUsers()
    {
        return $this->createQueryBuilder('user')
            ->andWhere('user.deletedAt is null')
            ->getQuery()
            ->getArrayResult()
        ;
    }

    public function findUser($id)
    {
        return $this->createQueryBuilder('user')
            ->andWhere('user.deletedAt is null')
            ->andWhere('user.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getArrayResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
