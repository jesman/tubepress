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

/**
 * Adds Vimeo as a video provider.
 */
class tubepress_plugins_vimeo_impl_listeners_VimeoProviderRegistrar
{
    public function onBoot(ehough_tickertape_api_Event $bootEvent)
    {
        $serviceCollectionsRegistry = tubepress_impl_patterns_ioc_KernelServiceLocator::getServiceCollectionsRegistry();

        $serviceCollectionsRegistry->registerService(

            tubepress_spi_provider_VideoProvider::_,
            new tubepress_plugins_vimeo_impl_provider_VimeoProvider(

                new tubepress_plugins_vimeo_impl_provider_VimeoUrlBuilder()
            )
        );
    }
}
