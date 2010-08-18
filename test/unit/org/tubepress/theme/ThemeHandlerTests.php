<?php
require_once 'PHPUnit/Framework.php';
require_once 'SimpleThemeHandlerTest.php';

class ThemeHandlerTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Tubepress Theme Handler Tests');
        $suite->addTestSuite('org_tubepress_theme_SimpleThemeHandlerTest');
        return $suite;
    }
}
?>
