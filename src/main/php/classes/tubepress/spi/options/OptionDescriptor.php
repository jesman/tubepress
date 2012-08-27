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
 * TubePress option descriptor.
 */
class tubepress_spi_options_OptionDescriptor
{
    const _ = 'tubepress_spi_options_OptionDescriptor';

    /** What's the name, y'all? */
    private $_name;

    /** Acceptable values. */
    private $_acceptableValues;

    /** Aliases. */
    private $_aliases = array();

    /** What's the default value for this option? */
    private $_defaultValue;

    /** Friendly description. */
    private $_description;

    /** Providers for which this option does not work. */
    private $_excludedProviders = array();

    /** Is this boolean? */
    private $_isBoolean = false;

    /** You got a label? */
    private $_label;

    /** Pro only? */
    private $_proOnly = false;

    /** Should we store this option in persistent storage? */
    private $_shouldPersist = true;

    /** Can this option be set via shortcode? */
    private $_shortcodeSettable = true;

    /** Regex describing valid values that this option can take on (from a string). */
    private $_validValueRegex;

    /**
     * Constructor.
     *
     * @param string $name
     *
     * @throws InvalidArgumentException If the name is null or empty.
     */
    public function __construct($name)
    {
        if (! is_string($name) || ! isset($name)) {

            throw new InvalidArgumentException('Must supply an option name');
        }

        $this->_name = $name;
    }

    public function getAcceptableValues()
    {
        return $this->_acceptableValues;
    }

    public function getAliases()
    {
        return $this->_aliases;
    }

    public function getDefaultValue()
    {
        return $this->_defaultValue;
    }

    public function getDescription()
    {
        return $this->_description;
    }

    public function getLabel()
    {
        return $this->_label;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function getValidValueRegex()
    {
        return $this->_validValueRegex;
    }

    public function hasDescription()
    {
        return $this->_description !== null;
    }

    public function hasDiscreteAcceptableValues()
    {
        return ! empty($this->_acceptableValues);
    }

    public function hasLabel()
    {
        return $this->_label !== null;
    }

    public function hasValidValueRegex()
    {
        return $this->_validValueRegex !== null;
    }

    public function isAbleToBeSetViaShortcode()
    {
        return $this->_shortcodeSettable;
    }

    public function isApplicableToVimeo()
    {
        return ! in_array(tubepress_spi_provider_Provider::VIMEO, $this->_excludedProviders);
    }

    public function isApplicableToYouTube()
    {
        return ! in_array(tubepress_spi_provider_Provider::YOUTUBE, $this->_excludedProviders);
    }

    public function isBoolean()
    {
        return $this->_isBoolean;
    }

    public function isApplicableToAllProviders()
    {
        return empty($this->_excludedProviders);
    }

    public function isMeantToBePersisted()
    {
        return $this->_shouldPersist;
    }

    public function isProOnly()
    {
        return $this->_proOnly;
    }

    public function setAcceptableValues($values)
    {
        $this->_checkNotBoolean();
        $this->_checkRegexNotSet();

        $this->_acceptableValues = $values;
    }

    public function setAliases($aliases)
    {
        if (! is_array($aliases)) {

            throw new InvalidArgumentException('Aliases must be an array for ' . $this->getName());
        }

        $this->_aliases = $aliases;
    }

    public function setBoolean()
    {
        $this->_checkAcceptableValuesNotSet();
        $this->_checkRegexNotSet();

        $this->_isBoolean = true;
    }

    public function setCannotBeSetViaShortcode()
    {
        $this->_shortcodeSettable = false;
    }

    public function setDefaultValue($value)
    {
        $this->_defaultValue = $value;
    }

    public function setDescription($description)
    {
        if (! is_string($description)) {

            throw new InvalidArgumentException('Description must be a string for ' . $this->getName());
        }

        $this->_description = $description;
    }

    public function setDoNotPersist()
    {
        $this->_shouldPersist = false;
    }

    public function setExcludedProviders($excludedProviders)
    {
        if (! is_array($excludedProviders)) {

            throw new InvalidArgumentException('Excluded providers must be an array for ' . $this->getName());
        }

        $this->_excludedProviders = $excludedProviders;
    }

    public function setLabel($label)
    {
        if (! is_string($label)) {

            throw new InvalidArgumentException('Label must be a string for ' . $this->getName());
        }

        $this->_label = $label;
    }

    public function setProOnly()
    {
        $this->_proOnly = true;
    }

    public function setValidValueRegex($validValueRegex)
    {
        if (! is_string($validValueRegex)) {

            throw new InvalidArgumentException('Regex must be a string for ' . $this->getName());
        }

        $this->_checkAcceptableValuesNotSet();
        $this->_checkNotBoolean();

        $this->_validValueRegex = $validValueRegex;
    }

    private function _checkRegexNotSet()
    {
        if (isset($this->_validValueRegex)) {

            throw new InvalidArgumentException($this->getName() . ' already has a regex set');
        }
    }

    private function _checkAcceptableValuesNotSet()
    {
        if (! empty($this->_acceptableValues)) {

            throw new InvalidArgumentException($this->getName() . ' already has acceptable values set');
        }
    }

    private function _checkNotBoolean()
    {
        if ($this->_isBoolean === true) {

            throw new InvalidArgumentException($this->getName() . ' is set to be a boolean');
        }
    }
}
