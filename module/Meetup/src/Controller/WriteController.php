<?php

declare(strict_types=1);

namespace Meetup\Controller;

use Meetup\Entity\Meetup;
use Meetup\Form\MeetupForm;
use Meetup\Repository\MeetupRepository;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Exception\RuntimeException;
use Zend\View\Model\ViewModel;

/**
 * Class WriteController
 * @package Meetup\Controller
 */
final class WriteController extends AbstractActionController
{
    private $form;
    private $repository;

    /**
     * WriteController constructor.
     *
     * @param MeetupForm       $form
     * @param MeetupRepository $repository
     */
    public function __construct(MeetupForm $form, MeetupRepository $repository)
    {
        $this->form = $form;
        $this->repository = $repository;
    }

    /**
     * @return \Zend\Http\Response|ViewModel
     * @throws \Exception
     */
    public function addAction() : ViewModel
    {
        $form = $this->form;
        $viewModel = new ViewModel(['form' => $form->prepare()]);
        /** @var Request $request */
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return $viewModel;
        }

        $data = $this->params()->fromPost();
        $form->setData($data);

        if(!$form->isValid()) {
            return $viewModel;
        }

        $meetup = $form->getData();

        $this->repository->add($meetup);

        return $this->redirect()->toRoute(
            'meetup'
        );
    }

    /**
     * @return \Zend\Http\Response|ViewModel
     */
    public function editAction() : ViewModel
    {
        $id = $this->params()->fromRoute('id');

        /** @var Meetup $meetup */
        $meetup = $this->repository->find($id);
        $form = $this->form;
        $form->setData([
            'title' => $meetup->getTitle(),
            'description' => $meetup->getDescription(),
            'startDate' => $meetup->getStartDate(),
            'endDate' => $meetup->getEndDate(),
        ]);

        $viewModel = new ViewModel(['form' => $form->prepare()]);
        /** @var Request $request */
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return $viewModel;
        }

        $data = $this->params()->fromPost();
        $form->setData($data);

        if(!$form->isValid()) {
            return $viewModel;
        }

        $datas = $this->form->getData();
        $this->repository->edit($meetup, $datas);

        return $this->redirect()->toRoute(
            'meetup'
        );
    }
}