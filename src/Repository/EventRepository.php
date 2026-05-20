<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findUpcoming(int $limit = 10): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.startDate >= :now')
            ->andWhere('e.isApproved = true')
            ->setParameter('now', new \DateTime())
            ->orderBy('e.startDate', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findByMonth(int $year, int $month): array
    {
        $start = new \DateTime("$year-$month-01 00:00:00");
        $end   = (clone $start)->modify('last day of this month')->setTime(23, 59, 59);

        return $this->createQueryBuilder('e')
            ->andWhere('e.startDate BETWEEN :start AND :end')
            ->andWhere('e.isApproved = true')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->orderBy('e.startDate', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAllForAdmin(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
