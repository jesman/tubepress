<?php

require_once dirname(__FILE__) . '/../../../../../classes/org/tubepress/util/FilesystemUtils.class.php';

class org_tubepress_util_FilesystemUtilsTest extends PHPUnit_Framework_TestCase
{
	function testLs()
	{
	    $dir = realpath(dirname(__FILE__) . '/../../../../../i18n');
	    $expected = array(
            "$dir/tubepress-de_DE.mo",
            "$dir/tubepress-de_DE.po",
            "$dir/tubepress-es_ES.mo",
            "$dir/tubepress-es_ES.po",
            "$dir/tubepress-fr_FR.mo",
            "$dir/tubepress-fr_FR.po",
            "$dir/tubepress-he_IL.mo",
            "$dir/tubepress-he_IL.po",
            "$dir/tubepress-it_IT.mo",
            "$dir/tubepress-it_IT.po",
            "$dir/tubepress-pt_BR.mo",
            "$dir/tubepress-pt_BR.po",
            "$dir/tubepress-ru_RU.mo",
            "$dir/tubepress-ru_RU.po",
            "$dir/tubepress-sv_SE.mo",
            "$dir/tubepress-sv_SE.po",
            "$dir/tubepress.mo",
            "$dir/tubepress.pot"
	    );
		$result = org_tubepress_util_FilesystemUtils::getFilenamesInDirectory($dir, 'log prefix');
		$this->assertEquals($expected, $result);
	}
	
	/**
	 * @expected Exception
	 */
	function testNoSuchDir()
	{
	    org_tubepress_util_FilesystemUtils::getFilenamesInDirectory('fake dir', 'log prefix');
	}
}
?>