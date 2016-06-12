<?php
namespace Appointment\Model;

class Appointment {

    public $id;
    public $username;
    public $reason_id;
    public $start_time;
    public $end_time;

    public function exchangeArray($data) {

        $this->id = (!empty($data['id'])) ? $data['id'] : null;

        $this->name = (!empty($data['username'])) ? $data['username'] : null;

        $this->email = (!empty($data['reason_id'])) ? $data['reason_id'] : null;

        $this->mobile = (!empty($data['start_time'])) ? $data['start_time'] : null;

        $this->address = (!empty($data['end_time'])) ? $data['end_time'] : null;
    }

}