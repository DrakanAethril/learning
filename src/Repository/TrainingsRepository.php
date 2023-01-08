<?php

namespace App\Repository;

use App\Entity\Trainings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;

/**
 * @extends ServiceEntityRepository<Trainings>
 *
 * @method Trainings|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trainings|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trainings[]    findAll()
 * @method Trainings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trainings::class);
    }

    public function save(Trainings $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Trainings $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

        
    /**
     * getAvailableTrainingsForUser
     *
     * @param  mixed $user
     * @param  mixed $limit
     * @return Trainings[] Returns an array of Trainings objects
     */
    public function getAvailableTrainingsForUser(User $user, ?int $limit = null) : array {
        // get all cohorts for user
        $cohorts = [];
        if(!empty($user->getCohorts())) {
            foreach( $user->getCohorts() as $cohort) {
                $cohorts[] = $cohort->getId();
            }
        }
        if(!empty($cohorts)) {
            $query =  $this->createQueryBuilder('t')
                ->innerJoin('t.cohorts', 'c')
                ->andWhere('c.id in (:cohorts)')
                ->andWhere('t.start_date > '.time())
                ->setParameter('cohorts', implode(',', $cohorts))
                ->orderBy('t.creation_date', 'DESC');

            if(!empty($limit)) $query->setMaxResults($limit);

            return $query->getQuery()->getResult();
        } else {
            return [];
        }
    }

//    /**
//     * @return Trainings[] Returns an array of Trainings objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Trainings
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
