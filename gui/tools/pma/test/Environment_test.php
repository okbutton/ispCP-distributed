<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * tests for environment like OS, PHP, modules, ...
 *
 * @version $Id: Environment_test.php 11677 2008-10-25 13:37:54Z lem9 $
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
