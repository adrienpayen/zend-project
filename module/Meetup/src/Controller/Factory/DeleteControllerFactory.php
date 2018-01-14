<?php

declare(strict_types=1);

namespace Meetup\Controller\Factory;

use Doctrine\ORM\EntityManager;
use Meetup\Controller\DeleteController;
use Meetup\Entity\Meetup;
use Psr\Container\ContainerInterface;

/**
 * Class DeleteControllerFactory
 * @package Meetup\Controller\Factory
 */
final class DeleteControllerFactory
{
    public function __invoke(ContainerInterface $container) : DeleteController
    {
        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        $meetupRepository = $entityManager->getRepository(Meetup::class);

        return new DeleteController($meetupRepository);
    }
}
