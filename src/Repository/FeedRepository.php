<?php

namespace App\Repository;

use App\Entity\Feed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class FeedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Feed::class);
    }

    /**
     * Gets all feeds.
     */
    public function getAllFeedsQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('feeds')
            ->orderBy('feeds.name');
    }

    /**
     * Find feeds filtered by search term.
     */
    public function getFeedsBySearchQueryBuilder(string $search): QueryBuilder
    {
        return $this->getAllFeedsQueryBuilder()
            ->andWhere('LOWER(feeds.name) LIKE LOWER(:search)')
            ->setParameter('search', '%' . $search . '%');
    }

    public function newFeed($url = '', $name = '', $description = ''): Feed
    {
        $feed = new Feed();
        $feed->setUrl($url);
        $feed->setName($name);
        $feed->setDescription($description);
        return $feed;
    }


    public function save(Feed $feed): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($feed);
        $entityManager->flush();
    }
}
