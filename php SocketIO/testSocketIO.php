<?php
/**
 * Created by PhpStorm.
 * User: johnliu95
 * Date: 2017-11-02
 * Time: 2:25 PM
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/phpunit-5.7.23.phar';
use Workerman\Worker;
use PHPSocketIO\SocketIO;

class socketIOTest extends \PHPUnit_Framework_TestCase{
    public function testHelloWorldToBeHelloWorld(){
        test();
        $this->assertTrue(true);
    }
}