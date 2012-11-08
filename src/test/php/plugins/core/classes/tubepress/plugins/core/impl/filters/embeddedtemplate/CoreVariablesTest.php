<?php
/**
 * Copyright 2006 - 2012 Eric D. Hough (http://ehough.com)
 *
 * This file is part of TubePress (http://tubepress.org)
 *
 * TubePress is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * TubePress is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with TubePress.  If not, see <http://www.gnu.org/licenses/>.
 *
 */
class tubepress_impl_plugin_filters_embeddedtemplate_CoreVariablesTest extends TubePressUnitTest
{
	private $_sut;

    private $_mockExecutionContext;

	function onSetup()
	{
        global $tubepress_base_url;

        $tubepress_base_url = '<tubepress_base_url>';

		$this->_sut = new tubepress_plugins_core_impl_filters_embeddedtemplate_CoreVariables();

        $this->_mockExecutionContext = $this->createMockSingletonService(tubepress_spi_context_ExecutionContext::_);
	}

	function testAlter()
	{
	    $mockTemplate = \Mockery::mock('ehough_contemplate_api_Template');

        $this->_mockExecutionContext->shouldReceive('get')->once()->with(tubepress_api_const_options_names_Embedded::AUTOPLAY)->andReturn(false);
        $this->_mockExecutionContext->shouldReceive('get')->once()->with(tubepress_api_const_options_names_Embedded::EMBEDDED_WIDTH)->andReturn(660);
        $this->_mockExecutionContext->shouldReceive('get')->once()->with(tubepress_api_const_options_names_Embedded::EMBEDDED_HEIGHT)->andReturn(732);

        $mockTemplate->shouldReceive('setVariable')->once()->with(tubepress_api_const_template_Variable::EMBEDDED_DATA_URL, 'http://tubepress.org');
        $mockTemplate->shouldReceive('setVariable')->once()->with(tubepress_api_const_template_Variable::TUBEPRESS_BASE_URL, '<tubepress_base_url>');
        $mockTemplate->shouldReceive('setVariable')->once()->with(tubepress_api_const_template_Variable::EMBEDDED_AUTOSTART, 'false');
        $mockTemplate->shouldReceive('setVariable')->once()->with(tubepress_api_const_template_Variable::EMBEDDED_WIDTH, 660);
        $mockTemplate->shouldReceive('setVariable')->once()->with(tubepress_api_const_template_Variable::EMBEDDED_HEIGHT, 732);
        $mockTemplate->shouldReceive('setVariable')->once()->with(tubepress_api_const_template_Variable::VIDEO_ID, 'video-id');

        $event = new tubepress_api_event_TubePressEvent($mockTemplate);
        $event->setArguments(array(

            'dataUrl' => new ehough_curly_Url('http://tubepress.org'),
            'videoId' => 'video-id',
            'providerName' => 'video-provider-name',
            'embeddedImplementationName' => 'embedded-impl-name'
        ));

        $this->_sut->onEmbeddedTemplate($event);
	    $this->assertEquals($mockTemplate, $event->getSubject());
	}

    function onTearDown()
    {
        global $tubepress_base_url;

        unset($tubepress_base_url);
    }
}