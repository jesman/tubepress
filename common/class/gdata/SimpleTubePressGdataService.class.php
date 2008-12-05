<?php
/**
 * Copyright 2006, 2007, 2008 Eric D. Hough (http://ehough.com)
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
 * Represents an HTML-embeddable YouTube player
 *
 */
class SimpleTubePressGdataService implements TubePressGdataService
{
    
    /**
     * Fetches the RSS from YouTube (or from cache)
     * 
     * @param TubePressOptionsManager $tpom The TubePress options manager
     * 
     * @return DOMDocument The raw RSS from YouTube
     */
    public function fetch($url, $useCache)
    {   
        $data = "";
        if ($useCache) {
        	/* get a handle to the cache */
        	$cache = new Cache_Lite(array("cacheDir" => sys_get_temp_dir()));
        	
            /* cache miss? */
            if (!($data = $cache->get($url))) {
        	
        	    /* go out and grab the response */
                $data = $this->_fetchFromNetwork($url);
                /* and save it to the cache for next time */
          	    $cache->save($data, $url);
            }
        } else {
        	$data = $this->_fetchFromNetwork($url);
        }

        $doc = new DOMDocument();
    
        if (strpos($data, "<") === FALSE) {
        	throw new Exception("YouTube didn't like your request: " . $data);
        }
        if ($doc->loadXML($data) === FALSE) {
        	throw new Exception("YouTube returned invalid XML: " . $data);
        }
        
        return $doc;
    }
    
    private function _fetchFromNetwork($request) {
    	$data = "";
    	$request = str_replace("&amp;", "&", $request);
    	$req = new HTTP_Request($request);
    	$call = $req->sendRequest();
        if (!PEAR::isError($call)) {
            $data = $req->getResponseBody();
        } else {
        	throw new Exception("Couldn't connect to YouTube");
        }
        $req->disconnect();
        return $data;
    }
}