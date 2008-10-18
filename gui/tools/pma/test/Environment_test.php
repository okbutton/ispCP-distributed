<?php
/* vim: expandtab sw=4 ts=4 sts=4: */
/**
 * tests for environment like OS, PHP, modules, ...
 *
 * @version $Id: Environment_test.php 10835 2007-10-17 14:08:40Z cybot_tm $
 * @package phpMyAdmin-test
 */

/**
 *
 */
require_once 'PHPUnit/Framework.php';

class Environment_test extends PHPUnit_Framework_TestCase
{
    public function testPhpVersion()
    {
        $this->assertTrue(version_compare('5.2', phpversion(), '<='),
            'phpMyAdmin requires PHP 5.2 or above');
    }

    public function testMySQL()
    {
        $this->markTestIncomplete();
    }

    public function testSession()
    {
        $this->markTestIncomplete();
    }
}
?>
