<?php
namespace Appointment\Controller;

use Appointment\Model\Appointment;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

Class AppointmentController extends AbstractRestfulController{
    protected $appointmentTable;

    public function getList()
    {
        return ['Appointments' => $this->getAppointmentsTable()->fetchAll()];
    }

    public function create($data)
    {
        $appointment = new Appointment();
        if ($appointment->isValid($data)){
            return $this->getAppointmentsTable()->saveAppointment($appointment);
        }
        
    }

    public function update($id,$data)
    {
        $appointment = new Appointment();
        if ($appointment->isValid($data)){
            return $this->getAppointmentsTable()->saveAppointment($appointment);
        }
    }

    public function delete($id)
    {
        $this->getAppointmentsTable()->deleteAppointment($id);
        return new JsonModel(array(
            'Appointment' => 'deleted',
        ));
    }
    public function getAppointmentsTable() {

        if (!$this->appointmentTable) {

            $sm = $this->getServiceLocator();

            $this->appointmentTable = $sm->get('Appointment\Model\AppointmentsTable');
        }

        return $this->appointmentTable;
    }


}