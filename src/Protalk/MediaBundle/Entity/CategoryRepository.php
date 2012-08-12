<?php

namespace Protalk\MediaBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends EntityRepository
{
    /**
     * Get the most used categories
     *
     * @param int $max
     * @return Doctrine Collection
     */
    public function getMostUsedCategories($max = 20)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('c.slug', 'c.name', 'COUNT(m.id) as mediaCount');
        $qb->from('\Protalk\MediaBundle\Entity\Category', 'c');
        $qb->join('c.medias', 'm');
        $qb->where('m.isPublished = 1');
        $qb->groupBy('c.slug');
        $qb->orderBy('mediaCount', 'DESC');
        $qb->setMaxResults($max);

        $query = $qb->getQuery();
        return $query->execute();
    }
}