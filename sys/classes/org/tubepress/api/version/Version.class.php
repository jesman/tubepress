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
 * An OSGi-based version.
 *
 * http://www.osgi.org/wiki/uploads/Links/SemanticVersioning.pdf
 * http://www.osgi.org/javadoc/r4v43/org/osgi/framework/Version.html
 * http://trac.i2p2.de/browser/src/main/java/org/osgi/framework/Version.java?rev=c113cdcdaa29451f600437c9275762580386dbcf
 *
 */
class org_tubepress_api_version_Version
{
    /** Version separator. */
    private static final $_separator = '.';

    /** Major version. */
    private $_major = 0;

    /** Minor version. */
    private $_minor = 0;

    /** Micro version. */
    private $_micro = 0;

    /** Qualifier. */
    private $_qualifier = null;

    public function __construct($major, $minor = 0, $micro = 0, $qualifier = null)
    {
        $this->_major = $major;
        $this->_minor = $minor;
        $this->_micro = $micro;

        if ($qualifier == '') {

            $this->_qualifier = null;

        } else {

            $this->_qualifier = $qualifier;
        }

        $this->_validate();
    }

    public function compareTo($otherVersion)
    {
        if (!($otherVersion instanceof org_tubepress_api_version_Version)) {

            return $this->compareTo(self::parse($otherVersion));
        }

        $result = $this->getMajor() - $otherVersion->getMajor();
        if ($result !== 0) {

            return $result;
        }

        $result = $this->getMinor() - $otherVersion->getMinor();
        if ($result !== 0) {

            return $result;
        }

        $result = $this->getMicro() - $otherVersion->getMicro();
        if ($result !== 0) {

            return $result;
        }

        return strcmp($this->getQualifier(), $otherVersion->getQualifier());
    }

    public static function parse($version)
    {
        if (! is_string($version)) {

            throw new Exception('Can only parse strings to generate version');
        }

        $empty = new org_tubepress_api_version_Version(0, 0, 0);

        if ($version == '' || trim($version) == '') {

            return $empty;
        }

        $pieces = explode(self::$_separator, $version);
        $pieceCount = count($pieces);

        switch ($pieceCount) {

            case 1:

                return new org_tubepress_api_version_Version(intval($version));

            case 2:

                return new org_tubepress_api_version_Version(intval($pieces[0]), intval($pieces[1]));

            case 3:

                return new org_tubepress_api_version_Version(intval($pieces[0]), intval($pieces[1]), intval($pieces[2]));

            case 3:

                return new org_tubepress_api_version_Version(intval($pieces[0]), intval($pieces[1]), intval($pieces[2]), $pieces[3]);

            default:

                throw new Exception("Invalid version: $version");
        }

    }

    public function getMajor()
    {
        return $this->_major;
    }

    public function getMinor()
    {
        return $this->_minor;
    }

    public function getMicro()
    {
        return $this->_micro;
    }

    public function getQualifier()
    {
        return $this->_qualifier;
    }

    private function _validate()
    {
        self::_checkNonNegativeInteger($this->_major, 'Major');
        self::_checkNonNegativeInteger($this->_minor, 'Minor');
        self::_checkNonNegativeInteger($this->_micro, 'Micro');

        if ($this->_qualifier !== null && preg_match_all('/[0-9a-zA-Z_\-]/', $this->_qualifier, $matches) !== 1) {

            throw new Exception("Version qualifier must only consist of alphanumerics plus hyphen and underscore");
        }
    }

    private static function _checkNonNegativeInteger($candidate, $name)
    {
        if (! is_int($candidate)) {

            throw new Exception("$name version must be an integer ($candidate)");
        }

        if ($candidate < 0) {

            throw new Exception("$name version must be non-negative");
        }
    }
}
