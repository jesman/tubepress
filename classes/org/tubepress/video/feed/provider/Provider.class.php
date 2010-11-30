<?php
/**
 * Copyright 2006 - 2010 Eric D. Hough (http://ehough.com)
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

function_exists('tubepress_load_classes')
    || require dirname(__FILE__) . '/../../../../tubepress_classloader.php';
tubepress_load_classes(array('org_tubepress_options_manager_OptionsManager'));

/**
 * Interface to a remove video provider
 */
interface org_tubepress_video_feed_provider_Provider
{
    const DIRECTORY = 'directory';
    const YOUTUBE   = 'youtube';
    const VIMEO     = 'vimeo';

    /**
     * Get the video feed result.
     *
     * @return org_tubepress_video_feed_FeedResult The feed result.
     */
    public function getMultipleVideos();

    /**
     * Fetch a single video.
     *
     * @param string                       $customVideoId The video ID to fetch.
     *
     * @return org_tubepress_video_Video The video.
     */
    public function getSingleVideo($customVideoId);
}
