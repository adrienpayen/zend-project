<?php

declare(strict_types=1);

namespace Meetup\Controller;

use Meetup\Repository\MeetupRepository;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class DeleteController
 * @package Meetup\Controller
 */
final class DeleteController extends AbstractActionController
{
    private $meetupRepository;

    public function __construct(MeetupRepository $meetupRepository)
    {
        $this->meetupRepository = $meetupRepository;
    }

    public function indexAction()
    {
        $id = $this->params()->fromRoute('id');
        $meetup = $this->meetupRepository->find($id);

        $this->meetupRepository->delete($meetup);

        return $this->redirect()->toRoute(
            'meetup'
        );
    }
}
