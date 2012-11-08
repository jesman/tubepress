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
class tubepress_impl_embedded_DefaultEmbeddedPlayerHtmlGeneratorTest extends TubePressUnitTest
{
    /**
     * @var tubepress_spi_embedded_EmbeddedHtmlGenerator
     */
    private $_sut;

    private $_mockExecutionContext;

    private $_mockEventDispatcher;

    private $_mockThemeHandler;

    public function onSetup()
    {
        $this->_sut = new tubepress_impl_embedded_DefaultEmbeddedPlayerHtmlGenerator();

        $this->_mockExecutionContext = $this->createMockSingletonService(tubepress_spi_context_ExecutionContext::_);
        $this->_mockEventDispatcher  = $this->createMockSingletonService('ehough_tickertape_api_IEventDispatcher');
        $this->_mockThemeHandler     = $this->createMockSingletonService(tubepress_spi_theme_ThemeHandler::_);
    }

    public function testMatchingCustomPlayer()
    {
        $mockEmbeddedPlayer = $this->createMockPluggableService(tubepress_spi_embedded_PluggableEmbeddedPlayerService::_);
        $mockEmbeddedPlayer->shouldReceive('getName')->twice()->andReturn('z');
        $mockEmbeddedPlayer->shouldReceive('getDataUrlForVideo')->once()->with('video-id')->andReturn('data-url');
        $mockEmbeddedPlayer->shouldReceive('getHandledProviderName')->once()->andReturn('some-provider');

        $this->_mockExecutionContext->shouldReceive('get')->once()->with(tubepress_api_const_options_names_Embedded::PLAYER_IMPL)->andReturn('z');

        $mockTemplate = Mockery::mock('ehough_contemplate_api_Template');
        $mockEmbeddedPlayer->shouldReceive('getTemplate')->once()->with($this->_mockThemeHandler)->andReturn($mockTemplate);

        $this->_mockEventDispatcher->shouldReceive('dispatch')->once()->with(tubepress_api_const_event_CoreEventNames::EMBEDDED_TEMPLATE_CONSTRUCTION,
            Mockery::on(function ($arg) use ($mockTemplate) {

                return $arg instanceof ehough_tickertape_api_Event && $arg->getSubject() === $mockTemplate
                    && $arg->getArgument('videoId') === 'video-id'
                    && $arg->getArgument('providerName') === 'some-provider'
                    && $arg->getArgument('dataUrl') === 'data-url'
                    && $arg->getArgument('embeddedImplementationName') === 'z';
            }));

        $mockTemplate->shouldReceive('toString')->once()->andReturn('templateAsString');

        $this->_mockEventDispatcher->shouldReceive('dispatch')->once()->with(tubepress_api_const_event_CoreEventNames::EMBEDDED_HTML_CONSTRUCTION,
            Mockery::on(function ($arg) use ($mockTemplate) {

                return $arg instanceof ehough_tickertape_api_Event && $arg->getSubject() === 'templateAsString'
                    && $arg->getArgument('videoId') === 'video-id'
                    && $arg->getArgument('providerName') === 'some-provider'
                    && $arg->getArgument('dataUrl') === 'data-url'
                    && $arg->getArgument('embeddedImplementationName') === 'z';
            }));

        $html = $this->_sut->getHtml('video-id');

        $this->assertEquals('templateAsString', $html);
    }

    public function testMatchingProviderBased()
    {
        $mockEmbeddedPlayer = $this->createMockPluggableService(tubepress_spi_embedded_PluggableEmbeddedPlayerService::_);
        $mockEmbeddedPlayer->shouldReceive('getHandledProviderName')->twice()->andReturn('xyz');
        $mockEmbeddedPlayer->shouldReceive('getDataUrlForVideo')->once()->with('video-id')->andReturn('data-url');
        $mockEmbeddedPlayer->shouldReceive('getName')->twice()->andReturn('z');

        $this->_mockExecutionContext->shouldReceive('get')->once()->with(tubepress_api_const_options_names_Embedded::PLAYER_IMPL)->andReturn(tubepress_api_const_options_values_PlayerImplementationValue::PROVIDER_BASED);

        $mockVideoProvider = $this->createMockPluggableService(tubepress_spi_provider_PluggableVideoProviderService::_);
        $mockVideoProvider->shouldReceive('recognizesVideoId')->once()->with('video-id')->andReturn(true);
        $mockVideoProvider->shouldReceive('getName')->once()->andReturn('xyz');

        $mockTemplate = Mockery::mock('ehough_contemplate_api_Template');
        $mockEmbeddedPlayer->shouldReceive('getTemplate')->once()->with($this->_mockThemeHandler)->andReturn($mockTemplate);

        $this->_mockEventDispatcher->shouldReceive('dispatch')->once()->with(tubepress_api_const_event_CoreEventNames::EMBEDDED_TEMPLATE_CONSTRUCTION,
            Mockery::on(function ($arg) use ($mockTemplate) {

                return $arg instanceof ehough_tickertape_api_Event && $arg->getSubject() === $mockTemplate
                    && $arg->getArgument('videoId') === 'video-id'
                    && $arg->getArgument('providerName') === 'xyz'
                    && $arg->getArgument('dataUrl') === 'data-url'
                    && $arg->getArgument('embeddedImplementationName') === 'z';
            }));

        $mockTemplate->shouldReceive('toString')->once()->andReturn('templateAsString');

        $this->_mockEventDispatcher->shouldReceive('dispatch')->once()->with(tubepress_api_const_event_CoreEventNames::EMBEDDED_HTML_CONSTRUCTION,
            Mockery::on(function ($arg) use ($mockTemplate) {

                return $arg instanceof ehough_tickertape_api_Event && $arg->getSubject() === 'templateAsString'
                    && $arg->getArgument('videoId') === 'video-id'
                    && $arg->getArgument('providerName') === 'xyz'
                    && $arg->getArgument('dataUrl') === 'data-url'
                    && $arg->getArgument('embeddedImplementationName') === 'z';
            }));

        $html = $this->_sut->getHtml('video-id');

        $this->assertEquals('templateAsString', $html);
    }

    public function testProvidersRecognizeButNoPlayersDo()
    {
        $mockEmbeddedPlayer = $this->createMockPluggableService(tubepress_spi_embedded_PluggableEmbeddedPlayerService::_);
        $mockEmbeddedPlayer->shouldReceive('getHandledProviderName')->once()->andReturn('xyz');
        $mockEmbeddedPlayer->shouldReceive('getName')->once()->andReturn('tex');

        $this->_mockExecutionContext->shouldReceive('get')->once()->with(tubepress_api_const_options_names_Embedded::PLAYER_IMPL)->andReturn(tubepress_api_const_options_values_PlayerImplementationValue::PROVIDER_BASED);

        $mockVideoProvider = $this->createMockPluggableService(tubepress_spi_provider_PluggableVideoProviderService::_);
        $mockVideoProvider->shouldReceive('recognizesVideoId')->once()->with('video-id')->andReturn(true);
        $mockVideoProvider->shouldReceive('getName')->once()->andReturn('something else');

        $html = $this->_sut->getHtml('video-id');

        $this->assertNull($html);
    }

    public function testNoProvidersRecognize()
    {
        $this->createMockPluggableService(tubepress_spi_embedded_PluggableEmbeddedPlayerService::_);

        $this->_mockExecutionContext->shouldReceive('get')->once()->with(tubepress_api_const_options_names_Embedded::PLAYER_IMPL)->andReturn(tubepress_api_const_options_values_PlayerImplementationValue::PROVIDER_BASED);

        $mockVideoProvider = $this->createMockPluggableService(tubepress_spi_provider_PluggableVideoProviderService::_);
        $mockVideoProvider->shouldReceive('recognizesVideoId')->once()->with('video-id')->andReturn(false);

        $html = $this->_sut->getHtml('video-id');

        $this->assertNull($html);
    }

    public function testNoMatchingProviderPlayers()
    {
        $this->createMockPluggableService(tubepress_spi_embedded_PluggableEmbeddedPlayerService::_);

        $this->_mockExecutionContext->shouldReceive('get')->once()->with(tubepress_api_const_options_names_Embedded::PLAYER_IMPL)->andReturn(tubepress_api_const_options_values_PlayerImplementationValue::PROVIDER_BASED);

        $html = $this->_sut->getHtml('video-id');

        $this->assertNull($html);
    }
}
