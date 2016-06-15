<?php

namespace AlbumTest\Controller;

use Appointment\Controller\AppointmentController;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use PHPUnit_Framework_TestCase;
use AppointmentTest\Bootstrap;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
class AppointmentControllerTest extends PHPUnit_Framework_TestCase
{
    protected $controller;
    protected $request;
    protected $response;
    protected $routeMatch;
    protected $event;

    protected function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();

        $this->controller = new AppointmentController();
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'index'));
        $this->event      = new MvcEvent();

        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);

        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
    }


    public function testAddActionCanBeAccessed()
    {
        $this->routeMatch->setParam('action', 'add');

        $result   = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDeleteActionCanBeAccessed()
    {
        $this->routeMatch->setParam('action', 'edit');

        $result   = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(302, $response->getStatusCode());
    }

   public function testEditActionCanBeAccessed()
    {
        $this->routeMatch->setParam('action', 'edit');
        $result   = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->routeMatch->setParam('action', 'index');

        $result   = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetAppointmentTableReturnsAnInstanceOfAppointmentTable()
    {
        $this->assertInstanceOf('Appointment\Model\AppointmentsTable', $this->controller->getAppointmentsTable());
    }

}