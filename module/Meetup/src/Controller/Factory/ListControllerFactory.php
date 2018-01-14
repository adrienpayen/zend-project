<?php

declare(strict_types=1);

namespace Meetup\Controller\Factory;

use Meetup\Entity\Meetup;
use Doctrine\ORM\EntityManager;
use Meetup\Controller\ListController;
use Psr\Container\ContainerInterface;

/**
 * Class ListControllerFactory
 * @package Meetup\Controller\Factory
 */
final class ListControllerFactory
{
    public function __invoke(ContainerInterface $container) : ListController
    {
        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        $meetupRepository = $entityManager->getRepository(Meetup::class);

        return new ListController($meetupRepository);
    }
}
