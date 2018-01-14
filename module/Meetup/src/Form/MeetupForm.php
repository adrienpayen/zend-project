<?php

declare(strict_types=1);

namespace Meetup\Form;

use Zend\Form\Element\Date;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\Callback;
use Zend\Validator\StringLength;

/**
 * Class MeetupForm
 * @package Meetup\Form
 */
class MeetupForm extends Form implements InputFilterProviderInterface
{
    /**
     * MeetupForm constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->add(
            [
            'type'  => 'csrf',
            'name' => 'csrf',
            'options' => [
                'csrf_options' => [
                    'timeout' => 600
                ]
            ],
            ]
        );
        $this->add(
            [
            'name'    => 'title',
            'type'    => Text::class,
            'options' => [
                'label' => 'Titre *',
            ],
            'attributes' => [
                'class' => 'form-control'
            ]
            ]
        );
        $this->add(
            [
            'name'    => 'description',
            'type'    => Textarea::class,
            'options' => [
                'label' => 'Description *'
            ],
            'attributes' => [
                'class' => 'form-control',
                'rows' => 10
            ]
            ]
        );
        $this->add(
            [
            'name'    => 'startDate',
            'type'    => Date::class,
            'options' => [
                'label' => 'Début *'
            ],
            'attributes' => [
                'class' => 'form-control'
            ]
            ]
        );
        $this->add(
            [
            'name'    => 'endDate',
            'type'    => Date::class,
            'options' => [
                'label' => 'Fin *'
            ],
            'attributes' => [
                'class' => 'form-control'
            ]
            ]
        );
        $this->add(
            [
            'name'       => 'send',
            'type'       => Submit::class,
            'attributes' => [
                'value' => 'Submit',
                'class' => 'btn btn-primary'
            ],
            ]
        );
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification() :array
    {
        return [
            'title' => [
                'validators' => [
                    [
                        'name' => StringLength::class,
                        'required' => true,
                        'options' => [
                            'min' => 2,
                            'max' => 50,
                        ],
                    ],
                ],
            ],
            'description' => [
                'validators' => [
                    [
                        'name' => StringLength::class,
                        'required' => true,
                        'options' => [
                            'min' => 5,
                            'max' => 2000,
                        ],
                    ],
                ],
            ],
            'endDate' => [
                'validators' => [
                    [
                        'name' => 'Callback',
                        'options' => [
                            'messages' => [
                                Callback::INVALID_VALUE => 'The end date should be greater than start date',
                            ],
                            'callback' => function ($value, $context = []) {
                                $startDate = new \DateTime($context['startDate']);
                                $endDate = new \DateTime($value);

                                return $startDate < $endDate;
                            },
                        ],
                    ]
                ]
            ]
        ];
    }
}
