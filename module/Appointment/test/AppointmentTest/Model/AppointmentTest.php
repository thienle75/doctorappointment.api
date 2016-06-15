<?php
// module/Appointment/test/AppointmentTest/Model/AppointmentTest.php:
namespace AppointmentTest\Model;

use Appointment\Model\Appointment;

use PHPUnit_Framework_TestCase;

class AppointmentTest extends PHPUnit_Framework_TestCase
{
    public function testAppointmentInitialState()
    {
        $appointment = new Appointment();

        $this->assertNull($appointment->username, '"username" should initially be null');
        $this->assertNull($appointment->id, '"id" should initially be null');
        $this->assertNull($appointment->reason, '"reason" should initially be null');
    }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $appointment = new Appointment();
        $data  = array('username' => 'username1',
                       'id'     => 123,
                       'reason'  => 'reason test');

        $appointment->exchangeArray($data);

        $this->assertSame($data['username'], $appointment->username, '"username" was not set correctly');
        $this->assertSame($data['id'], $appointment->id, '"id" was not set correctly');
        $this->assertSame($data['reason'], $appointment->reason, '"reason" was not set correctly');
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $appointment = new Appointment();

        $appointment->exchangeArray(array('username' => 'username1',
                                            'id'     => 123,
                                            'reason'  => 'reason test'));
        $appointment->exchangeArray(array());

        $this->assertNull($appointment->username, '"username" should have defaulted to null');
        $this->assertNull($appointment->id, '"id" should have defaulted to null');
        $this->assertNull($appointment->reason, '"reason" should have defaulted to null');
    }
}