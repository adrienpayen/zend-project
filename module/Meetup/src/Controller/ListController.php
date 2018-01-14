<?php

declare(strict_types=1);

namespace Meetup\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class ListController
 * @package Meetup\Controller
 */
final class ListController extends AbstractActionController
{
    private $meetupRepository;

    public function __construct($meetupRepository)
    {
        $this->meetupRepository = $meetupRepository;
    }

    public function indexAction()
    {
        return new ViewModel([
            'meetups' => $this->meetupRepository->findAll()
        ]);
    }

    public function detailAction()
    {
        $id = $this->params()->fromRoute('id');

        return new ViewModel([
            'meetup' => $this->meetupRepository->find($id)
        ]);
    }
}
