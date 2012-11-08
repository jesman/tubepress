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
class tubepress_plugins_jwplayer_impl_patterns_ioc_JwPlayerIocContainerExtensionTest extends TubePressUnitTest
{
    /**
     * @var tubepress_plugins_core_impl_patterns_ioc_IocContainerExtension
     */
    private $_sut;

    /**
     * @var ehough_iconic_impl_ContainerBuilder
     */
    private $_mockParentContainer;

    public function onSetup()
    {
        $this->_sut = new tubepress_plugins_jwplayer_impl_patterns_ioc_JwPlayerIocContainerExtension();

        $this->_mockParentContainer = new ehough_iconic_impl_ContainerBuilder();
    }

    public function testGetAlias()
    {
        $this->assertEquals('jwplayer', $this->_sut->getAlias());
    }

    public function testLoad()
    {
        $this->_sut->load($this->_mockParentContainer);

        foreach ($this->_getExpectedServices() as $service) {

            $definition = $this->_mockParentContainer->getDefinition($service->id);

            $this->assertNotNull($definition);

            $this->assertTrue($definition->getClass() === $service->type);

            if (isset($service->tag)) {

                $this->assertTrue($definition->hasTag($service->tag));
            }
        }
    }

    private function _getExpectedServices()
    {
        $map = array(

          array('tubepress_plugins_jwplayer_impl_options_ui_JwPlayerOptionsPageParticipant',
              'tubepress_plugins_jwplayer_impl_options_ui_JwPlayerOptionsPageParticipant',
              tubepress_spi_options_ui_PluggableOptionsPageParticipant::_),


            array('tubepress_plugins_jwplayer_impl_embedded_JwPlayerPluggableEmbeddedPlayerService',
                'tubepress_plugins_jwplayer_impl_embedded_JwPlayerPluggableEmbeddedPlayerService',
                tubepress_spi_embedded_PluggableEmbeddedPlayerService::_)
        );

        $toReturn = array();

        foreach ($map as $s) {

            $service = new stdClass();
            $service->id = $s[0];
            $service->type = $s[1];

            if (isset($s[2])) {

                $service->tag = $s[2];
            }

            $toReturn[] = $service;
        }

        return $toReturn;
    }
}