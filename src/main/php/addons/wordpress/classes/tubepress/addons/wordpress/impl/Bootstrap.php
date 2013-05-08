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

/**
 * Registers a few extensions to allow TubePress to work inside WordPress.
 */
class tubepress_addons_wordpress_impl_Bootstrap
{
    public function boot()
    {
        $environmentDetector = tubepress_impl_patterns_sl_ServiceLocator::getEnvironmentDetector();

        if (! $environmentDetector->isWordPress()) {

            //short circuit
            return;
        }

        /**
         * @var $eventDispatcher ehough_tickertape_ContainerAwareEventDispatcher
         */
        $eventDispatcher = tubepress_impl_patterns_sl_ServiceLocator::getEventDispatcher();

        $eventDispatcher->addListenerService(

            tubepress_api_const_event_EventNames::BOOT_COMPLETE,
            array('tubepress_addons_wordpress_impl_listeners_boot_WordPressOptionsRegistrar', 'onBoot')
        );

        $eventDispatcher->addListenerService(

            tubepress_api_const_event_EventNames::BOOT_COMPLETE,
            array('tubepress_addons_wordpress_impl_listeners_boot_WordPressApiIntegrator', 'onBoot')
        );

        $eventDispatcher->addListenerService(

            tubepress_api_const_event_EventNames::TEMPLATE_OPTIONS_UI_MAIN,
            array('tubepress_addons_wordpress_impl_listeners_template_options_OptionsUiTemplateListener', 'onOptionsUiTemplate')
        );
    }
}