<?php
/**
 * Copyright 2006 - 2013 TubePress LLC (http://tubepress.org)
 *
 * This file is part of TubePress (http://tubepress.org)
 *
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/.
 */
class tubepress_addons_youtube_impl_ioc_YouTubeIocContainerExtensionTest extends tubepress_test_impl_ioc_AbstractIocContainerExtensionTest
{
    protected function buildSut()
    {
        return new tubepress_addons_youtube_impl_ioc_YouTubeIocContainerExtension();
    }


    protected function prepareForLoad()
    {
        $this->expectRegistration(

            'tubepress_addons_youtube_impl_provider_YouTubeUrlBuilder',
            'tubepress_addons_youtube_impl_provider_YouTubeUrlBuilder'
        );

        $this->expectRegistration(

            'tubepress_addons_youtube_impl_embedded_YouTubePluggableEmbeddedPlayerService',
            'tubepress_addons_youtube_impl_embedded_YouTubePluggableEmbeddedPlayerService'

        )->withTag(tubepress_spi_embedded_PluggableEmbeddedPlayerService::_);

        $this->expectRegistration(

            'tubepress_addons_youtube_impl_provider_YouTubePluggableVideoProviderService',
            'tubepress_addons_youtube_impl_provider_YouTubePluggableVideoProviderService'

        )->withArgument(new ehough_iconic_Reference('tubepress_addons_youtube_impl_provider_YouTubeUrlBuilder'))
            ->withTag(tubepress_spi_provider_PluggableVideoProviderService::_);

        $this->expectRegistration(

            'tubepress_addons_youtube_impl_options_ui_YouTubeOptionsPageParticipant',
            'tubepress_addons_youtube_impl_options_ui_YouTubeOptionsPageParticipant'

        )->withTag(tubepress_spi_options_ui_PluggableOptionsPageParticipant::_);

        $this->expectRegistration(

            'tubepress_addons_youtube_impl_listeners_video_YouTubeVideoConstructionListener',
            'tubepress_addons_youtube_impl_listeners_video_YouTubeVideoConstructionListener'
        )->withTag(tubepress_api_ioc_ContainerExtensionInterface::TAG_EVENT_LISTENER,
                array('event' => tubepress_api_const_event_EventNames::VIDEO_CONSTRUCTION, 'method' => 'onVideoConstruction'));;

        $this->expectRegistration(

            'tubepress_addons_youtube_impl_listeners_http_YouTubeHttpErrorResponseListener',
            'tubepress_addons_youtube_impl_listeners_http_YouTubeHttpErrorResponseListener'
        )->withTag(tubepress_api_ioc_ContainerExtensionInterface::TAG_EVENT_LISTENER,
                array('event' => ehough_shortstop_api_Events::RESPONSE, 'method' => 'onResponse'));;

        $this->expectRegistration(

            'tubepress_addons_youtube_impl_options_YouTubeOptionsProvider',
            'tubepress_addons_youtube_impl_options_YouTubeOptionsProvider'
        )->withTag(tubepress_spi_options_PluggableOptionDescriptorProvider::_);

        $this->expectRegistration(

            'tubepress_addons_youtube_impl_listeners_options_YouTubePlaylistPlPrefixRemover',
            'tubepress_addons_youtube_impl_listeners_options_YouTubePlaylistPlPrefixRemover'
        )->withTag(tubepress_api_ioc_ContainerExtensionInterface::TAG_EVENT_LISTENER,
                array('event' => tubepress_api_const_event_EventNames::OPTIONS_NVP_PREVALIDATIONSET, 'method' => 'onPreValidationOptionSet'));
    }
}