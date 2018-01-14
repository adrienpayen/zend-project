<?php

declare(strict_types=1);

namespace Meetup;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Meetup\Form\MeetupForm;
use Zend\Router\Http\Literal;
use Meetup\Controller;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'meetup' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/meetup',
                    'defaults' => [
                        'controller' => Controller\ListController::class,
                        'action'     => 'index'
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [

                    // List
                    'detail' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => '/:id',
                            'defaults' => [
                                'action' => 'detail',
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*',
                            ],
                        ],
                    ],

                    // Add
                    'add' => [
                        'type' => Literal::class,
                        'options' => [
                            'route'    => '/add',
                            'defaults' => [
                                'controller' => Controller\WriteController::class,
                                'action'     => 'add',
                            ],
                        ],
                    ],

                    // Edit
                    'edit' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => '/edit/:id',
                            'defaults' => [
                                'controller' => Controller\WriteController::class,
                                'action'     => 'edit',
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*',
                            ],
                        ],
                    ],

                    // Delete
                    'delete' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/delete/:id',
                            'defaults' => [
                                'controller' => Controller\DeleteController::class,
                                'action'     => 'index'
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*'
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\ListController::class => Controller\Factory\ListControllerFactory::class,
            Controller\WriteController::class => Controller\Factory\WriteControllerFactory::class,
            Controller\DeleteController::class => Controller\Factory\DeleteControllerFactory::class
        ]
    ],
    'service_manager' => [
        'factories' => [
            MeetupForm::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'meetup/list/index' => __DIR__ . '/../view/meetup/index/index.phtml',
            'meetup/list/detail' => __DIR__ . '/../view/meetup/list/detail.phtml',
            'meetup/write/add' => __DIR__ . '/../view/meetup/write/add.phtml',
            'meetup/write/edit' => __DIR__ . '/../view/meetup/write/edit.phtml',
        ],
    ],
    'doctrine' => [
        'driver' => [
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'meetup_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__.'/../src/Entity/',
                ],
            ],

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => [
                'drivers' => [
                    // register `application_driver` for any entity under namespace `Application\Entity`
                    'Meetup\Entity' => 'meetup_driver',
                ],
            ],
        ],
    ],
];
