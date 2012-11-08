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
class tubepress_plugins_core_impl_shortcode_SearchInputPluggableShortcodeHandlerServiceTest extends TubePressUnitTest
{
    /**
     * @var tubepress_plugins_core_impl_shortcode_SearchInputPluggableShortcodeHandlerService
     */
    private $_sut;

    private $_mockExecutionContext;

    private $_mockThemeHandler;

    private $_mockEventDispatcher;

    function onSetup()
    {
        $this->_sut = new tubepress_plugins_core_impl_shortcode_SearchInputPluggableShortcodeHandlerService();

        $this->_mockExecutionContext = $this->createMockSingletonService(tubepress_spi_context_ExecutionContext::_);
        $this->_mockEventDispatcher  = $this->createMockSingletonService('ehough_tickertape_api_IEventDispatcher');
        $this->_mockThemeHandler     = $this->createMockSingletonService(tubepress_spi_theme_ThemeHandler::_);

    }

    function testShouldNotExecute()
    {
        $this->_mockExecutionContext->shouldReceive('get')->once()->with(tubepress_api_const_options_names_Output::OUTPUT)->andReturn(tubepress_api_const_options_values_OutputValue::SEARCH_RESULTS);

        $this->assertFalse($this->_sut->shouldExecute());
    }

    function testExecute()
    {
        $mockTemplate = Mockery::mock('ehough_contemplate_api_Template');
        $mockTemplate->shouldReceive('toString')->once()->andReturn('template-string');

        $this->_mockThemeHandler->shouldReceive('getTemplateInstance')->once()->with('search/search_input.tpl.php', TUBEPRESS_ROOT . '/src/main/resources/default-themes/default')->andReturn($mockTemplate);

        $this->_mockEventDispatcher->shouldReceive('hasListeners')->once()->with(tubepress_api_const_event_CoreEventNames::SEARCH_INPUT_TEMPLATE_CONSTRUCTION)->andReturn(true);
        $this->_mockEventDispatcher->shouldReceive('dispatch')->once()->with(tubepress_api_const_event_CoreEventNames::SEARCH_INPUT_TEMPLATE_CONSTRUCTION, Mockery::on(function ($arg) use ($mockTemplate) {

            return $arg instanceof tubepress_api_event_TubePressEvent && $arg->getSubject() === $mockTemplate;
        }));

        $this->_mockEventDispatcher->shouldReceive('hasListeners')->once()->with(tubepress_api_const_event_CoreEventNames::SEARCH_INPUT_HTML_CONSTRUCTION)->andReturn(true);
        $this->_mockEventDispatcher->shouldReceive('dispatch')->once()->with(tubepress_api_const_event_CoreEventNames::SEARCH_INPUT_HTML_CONSTRUCTION, Mockery::on(function ($arg) {

            return $arg instanceof tubepress_api_event_TubePressEvent && $arg->getSubject() === 'template-string';
        }));

        $this->assertEquals('template-string', $this->_sut->getHtml());

    }
}