<?php

declare(strict_types=1);

namespace Meetup\Repository;

use Doctrine\ORM\EntityRepository;
use Meetup\Entity\Meetup;

/**
 * Class MeetupRepository
 * @package Meetup\Repository
 */
class MeetupRepository extends EntityRepository
{
    /**
     * @param array $datas
     *
     * @return Meetup
     */
    public function add(array $datas) : Meetup
    {
        $meetup = new Meetup();
        $meetup->setTitle($datas['title']);
        $meetup->setDescription($datas['description']);

        $startDate = new \DateTime($datas['startDate']);
        $endDate = new \DateTime($datas['endDate']);

        $meetup->setStartDate($startDate);
        $meetup->setEndDate($endDate);

        $this->getEntityManager()->persist($meetup);
        $this->getEntityManager()->flush($meetup);

        return $meetup;
    }

    /**
     * @param Meetup $meetup
     * @param array  $datas
     *
     * @return Meetup
     */
    public function edit(Meetup $meetup, array $datas) : Meetup
    {
        $meetup->setTitle($datas['title']);
        $meetup->setDescription($datas['description']);

        $startDate = new \DateTime($datas['startDate']);
        $endDate = new \DateTime($datas['endDate']);

        $meetup->setStartDate($startDate);
        $meetup->setEndDate($endDate);

        $this->getEntityManager()->flush($meetup);

        return $meetup;
    }

    /**
     * @param $meetup
     */
    public function delete($meetup)
    {
        $this->getEntityManager()->remove($meetup);
        $this->getEntityManager()->flush($meetup);
    }
}
