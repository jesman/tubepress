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
 * Generates the "meat" of the options form (in the form of tabs).
 */
class tubepress_impl_options_ui_DefaultTabsHandler extends tubepress_impl_options_ui_AbstractDelegatingFormHandler implements tubepress_spi_options_ui_FormHandler
{
    const TEMPLATE_VAR_TABS = 'tubepress_impl_options_ui_DefaultTabsHandler__tabs';

    /**
     * Generates the HTML for the "meat" of the options form.
     *
     * @return string The HTML for the options form.
     */
    public final function getHtml()
    {
        $templateBuilder = tubepress_impl_patterns_ioc_KernelServiceLocator::getTemplateBuilder();
        $template        = $templateBuilder->getNewTemplateInstance(TUBEPRESS_ROOT . '/src/main/resources/system-templates/options_page/tabs.tpl.php');
        $tabs            = $this->getDelegateFormHandlers();

        $template->setVariable(self::TEMPLATE_VAR_TABS, $tabs);

        return $template->toString();
    }

    /**
     * Get the delegate form handlers.
     *
     * @return array An array of tubepress_spi_options_ui_FormHandler.
     */
    protected final function getDelegateFormHandlers()
    {
        return tubepress_impl_patterns_ioc_KernelServiceLocator::getOptionsPageTabs();
    }
}