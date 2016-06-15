<?php
namespace Appointment\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
class Appointment implements InputFilterAwareInterface{

    public $id;
    public $username;
    public $reason;
    public $start_time;
    public $end_time;
    protected $inputFilter;

    public function exchangeArray($data) {

        $this->id = (!empty($data['id'])) ? $data['id'] : null;

        $this->name = (!empty($data['username'])) ? $data['username'] : null;

        $this->email = (!empty($data['reason'])) ? $data['reason'] : null;

        $this->mobile = (!empty($data['start_time'])) ? $data['start_time'] : null;

        $this->address = (!empty($data['end_time'])) ? $data['end_time'] : null;
    }

    public function getArrayCopy(){
        return get_object_vars($this);
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter){
            $inputFilter = new InputFilter();

            $inputFilter->add([
               'name' => 'id',
                'required' => true,
                'filter'  => [
                    [
                        'name'=> 'Int'
                    ]
                ]
            ]);

            $inputFilter->add([
                'name' => 'username',
                'required' => true,
                'filter'  => [
                    [
                        'name'=> 'StripTags'
                    ],
                    [
                        'name'=>'StringTrim'
                    ]
                ],
                'validator' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'       => 1,
                            'max'       => 200,
                        ]
                    ]
                ]
            ]);
            $inputFilter->add([
                'name' => 'reason',
                'required' => true,
                'filter'  => [
                    [
                        'name'=> 'StripTags'
                    ],
                    [
                        'name'=>'StringTrim'
                    ]
                ],
                'validator' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'       => 1,
                            'max'       => 200,
                        ]
                    ]
                ]
            ]);
            $inputFilter->add([
                'type' => 'Zend\Form\Element\DateTime',
                'name' => 'start_time',
                'required' => true,
                'options' => [
                    'label' => 'Appointment Date/Time',
                    'format' => 'Y-m-d\TH:iP'
                ],
                'attributes' => [
                    'min' => '2016-01-01T00:00:00Z',
                    'max' => '2020-01-01T00:00:00Z',
                    'step' => '1', // minutes; default step interval is 1 min
                ]
            ]);
            $inputFilter->add([
                'type' => 'Zend\Form\Element\DateTime',
                'name' => 'end_time',
                'required' => false,
                'options' => [
                    'label' => 'Appointment Date/Time',
                    'format' => 'Y-m-d\TH:iP'
                ],
                'attributes' => [
                    'min' => '2016-01-01T00:00:00Z',
                    'max' => '2020-01-01T00:00:00Z',
                    'step' => '1', // minutes; default step interval is 1 min
                ]
            ]);
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}