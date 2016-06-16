<?php
namespace Appointment\Model;

use Zend\Validator;
use Zend\Validator\Date;
use Zend\Validator\StringLength;
use Zend\Validator\ValidatorInterface;

class Appointment implements ValidatorInterface{

    public $id;
    public $username;
    public $reason;
    public $start_time;
    public $end_time;
    public $messages;

    public function exchangeArray($data) {

        $this->id = (!empty($data['id'])) ? $data['id'] : null;

        $this->username = (!empty($data['username'])) ? $data['username'] : null;

        $this->reason = (!empty($data['reason'])) ? $data['reason'] : null;

        $this->start_time = (!empty($data['start_time'])) ? $data['start_time'] : null;

        $this->end_time = (!empty($data['end_time'])) ? $data['end_time'] : null;
    }

    public function getArrayCopy(){
        return get_object_vars($this);
    }

    public function isValid($data)
    {
        $this->exchangeArray($data);
        $stringValidator = new StringLength(1);

        $stringValidator->setMessage(
            'The string \'%value%\' is too short; it must be at least %min% ' .
            'characters',
            StringLength::TOO_SHORT);

        if (!$stringValidator->isValid($this->username)){
            $this->messages[] = $stringValidator->getMessages();
        }
        if (!$stringValidator->isValid($this->reason)){
            $this->messages[] = $stringValidator->getMessages();
        }
        $dateValidator = new Date();
        if (!$dateValidator->isValid($this->start_time)){
            $this->messages[] = $dateValidator->getMessages();
        }
        if (isEmpty($this->messages)){
            return true;
        }
        return false;
    }
    public function getMessages()
    {
        return $this->messages;
    }

}