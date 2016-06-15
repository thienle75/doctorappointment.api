<?php
namespace Appointment\Model;

use Zend\Db\TableGateway\TableGateway;

class AppointmentsTable{
    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getAppointment($id){
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id'=>$id]);
        $row = $rowset->current();
        if (!$row){
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
}