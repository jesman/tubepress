<?php
require_once '/Applications/MAMP/bin/php5/lib/php/PHPUnit/Framework.php';
require_once 'LogImplTest.php';

class LogTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite("TubePress Log Tests");
        $suite->addTestSuite('org_tubepress_log_LogImplTest');
        return $suite;
    }
}
?>