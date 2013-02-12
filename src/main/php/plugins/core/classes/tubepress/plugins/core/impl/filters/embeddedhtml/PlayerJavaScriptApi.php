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
 * Registers videos with the JS player API.
 */
class tubepress_plugins_core_impl_filters_embeddedhtml_PlayerJavaScriptApi
{
    public function onEmbeddedHtml(tubepress_api_event_TubePressEvent $event)
    {
        $context   = tubepress_impl_patterns_sl_ServiceLocator::getExecutionContext();

        if (! $context->get(tubepress_api_const_options_names_Embedded::ENABLE_JS_API)) {

        	return;
        }

        $html    = $event->getSubject();
        $videoId = $event->getArgument('videoId');
        $final   = $html . <<<EOT
<script type="text/javascript">
   var tubePressDomInjector = tubePressDomInjector || [], tubePressEmbeddedApi = tubePressEmbeddedApi || [];
       tubePressDomInjector.push(['loadEmbeddedApiJs']);
       tubePressEmbeddedApi.push(['register', '$videoId' ]);
</script>
EOT;

        $event->setSubject($final);
    }
}
