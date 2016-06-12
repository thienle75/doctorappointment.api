<?php
namespace Appointment;

use Appointment\Model\Appointment;
use Appointment\Model\AppointmentTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e) {

        $eventManager        = $e->getApplication()->getEventManager();

        $moduleRouteListener = new ModuleRouteListener();

        $moduleRouteListener->attach($eventManager);
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    public function getServiceConfig() {

        return array(

            'factories' => array(

                'Appointment\Model\UsersTable' =>   function($sm) {

                    $tableGateway = $sm->get('AppointTableGateway');

                    $table = new AppointmentTable($tableGateway);

                    return $table;

                },
                'UsersTableGateway' => function ($sm) {

                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

                    $resultSetPrototype = new ResultSet();

                    $resultSetPrototype->setArrayObjectPrototype(new Appointment());

                    return new TableGateway('appointments', $dbAdapter, null, $resultSetPrototype);

                },
            ),
        );
    }
}
