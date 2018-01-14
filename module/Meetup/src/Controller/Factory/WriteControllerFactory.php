<?php

declare(strict_types=1);

namespace Meetup\Controller\Factory;

use Doctrine\ORM\EntityManager;
use Meetup\Controller\WriteController;
use Meetup\Entity\Meetup;
use Meetup\Form\MeetupForm;
use Psr\Container\ContainerInterface;

/**
 * Class WriteControllerFactory
 * @package Meetup\Controller\Factory
 */
final class WriteControllerFactory
{
    public function __invoke(ContainerInterface $container) : WriteController
    {
        $repository = $container->get(EntityManager::class)->getRepository(Meetup::class);
        $form = $container->get(MeetupForm::class);

        return new WriteController($form, $repository);
    }
}
