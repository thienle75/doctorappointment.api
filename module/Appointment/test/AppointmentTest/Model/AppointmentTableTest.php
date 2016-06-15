<?php
// module/Appointment/test/AppointmentTest/Model/AppointmentTableTest.php:
namespace Appointment\Model;

use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;

class AppointmentTableTest extends PHPUnit_Framework_TestCase
{
    public function testFetchAllReturnsAllAppointments()
    {
        $resultSet        = new ResultSet();
        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway',
                                           array('select'), array(), '', false);
        $mockTableGateway->expects($this->once())
                         ->method('select')
                         ->with()
                         ->will($this->returnValue($resultSet));

        $AppointmentTable = new AppointmentsTable($mockTableGateway);

        $this->assertSame($resultSet, $AppointmentTable->fetchAll());
    }
    public function testCanRetrieveAnAppointmentByItsId()
    {
        $Appointment = new Appointment();
        $Appointment->exchangeArray(array('id'     => 123,
                                    'name' => 'name 1',
                                    'username' => 'username1',
                                    'start_time' => '2016-06-16',
                                    'end_time' => '2016-06-16',
                                    'reason'  => 'Headache'));

        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Appointment());
        $resultSet->initialize(array($Appointment));

        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
        $mockTableGateway->expects($this->once())
                         ->method('select')
                         ->with(array('id' => 123))
                         ->will($this->returnValue($resultSet));

        $AppointmentTable = new AppointmentTable($mockTableGateway);

        $this->assertSame($Appointment, $AppointmentTable->getAppointment(123));
    }

    public function testCanDeleteAnAppointmentByItsId()
    {
        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('delete'), array(), '', false);
        $mockTableGateway->expects($this->once())
                         ->method('delete')
                         ->with(array('id' => 123));

        $AppointmentTable = new AppointmentTable($mockTableGateway);
        $AppointmentTable->deleteAppointment(123);
    }

    public function testSaveAppointmentWillInsertNewAppointmentsIfTheyDontAlreadyHaveAnId()
    {
        $AppointmentData = array('username' => 'username2', 'reason' => 'Sick');
        $Appointment     = new Appointment();
        $Appointment->exchangeArray($AppointmentData);

        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('insert'), array(), '', false);
        $mockTableGateway->expects($this->once())
                         ->method('insert')
                         ->with($AppointmentData);

        $AppointmentTable = new AppointmentTable($mockTableGateway);
        $AppointmentTable->saveAppointment($Appointment);
    }

    public function testSaveAppointmentWillUpdateExistingAppointmentsIfTheyAlreadyHaveAnId()
    {
        $AppointmentData = array('id' => 123, 'username' => 'username2', 'reason' => 'Sick');
        $Appointment     = new Appointment();
        $Appointment->exchangeArray($AppointmentData);

        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Appointment());
        $resultSet->initialize(array($Appointment));

        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway',
                                           array('select', 'update'), array(), '', false);
        $mockTableGateway->expects($this->once())
                         ->method('select')
                         ->with(array('id' => 123))
                         ->will($this->returnValue($resultSet));
        $mockTableGateway->expects($this->once())
                         ->method('update')
                         ->with(array('username' => 'username2', 'reason' => 'Sick'),
                                array('id' => 123));

        $AppointmentTable = new AppointmentTable($mockTableGateway);
        $AppointmentTable->saveAppointment($Appointment);
    }

    public function testExceptionIsThrownWhenGettingNonexistentAppointment()
    {
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Appointment());
        $resultSet->initialize(array());

        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
        $mockTableGateway->expects($this->once())
                         ->method('select')
                         ->with(array('id' => 123))
                         ->will($this->returnValue($resultSet));

        $AppointmentTable = new AppointmentTable($mockTableGateway);

        try
        {
            $AppointmentTable->getAppointment(123);
        }
        catch (\Exception $e)
        {
            $this->assertSame('Could not find row 123', $e->getMessage());
            return;
        }

        $this->fail('Expected exception was not thrown');
    }
}