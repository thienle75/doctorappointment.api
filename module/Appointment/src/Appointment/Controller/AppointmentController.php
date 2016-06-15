<?php
namespace Appointment\Controller;

use Appointment\Model\Appointment;
use Appointment\Model\AppointmentsTable;

use Zend\Mvc\Controller\AbstractRestfulController;

Class AppointmentController extends AbstractRestfulController{
    protected $appointmentTable;

    public function getList()
    {
        return ['users' => $this->getUsersTable()];
    }

    public function create($data)
    {

    }

    public function update($id,$data)
    {

    }

    public function delete($id)
    {

    }
    public function getUsersTable() {

        if (!$this->appointmentTable) {

            $sm = $this->getServiceLocator();

            $this->appointmentTable = $sm->get('Appointment\Model\AppointmentsTable');
        }

        return $this->appointmentTable;
    }
    

}