<?php
/**
 * Copyright 2006, 2007, 2008, 2009 Eric D. Hough (http://ehough.com)
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
 * A YouTube video that TubePress can pass around easily
 */
class TubePressVideo
{
    private $_author;
    private $_category;
    private $_description;
    private $_id;
    private $_rating;
    private $_ratings;
    private $_length;
    private $_tags;
    private $_thumbUrls;
    private $_title;
    private $_uploadTime;
    private $_youTubeUrl;
    private $_views;
    
    /**
     * Get the video's author
     * 
     * @return string The YouTube username of the person that uploaded
     *                 the video.
     * 
     * Example: "3hough"
     */
    public function getAuthor()
    {
        return $this->_author; 
    }
    
    /**
     * Get the video's category
     * 
     * @return string The YouTube-defined category of the video
     * 
     * Example: "Sports"
     */
    public function getCategory()
    {    
        return $this->_category; 
    }
    
    /**
     * Returns the "default" YouTube thumbnail URL for this video
     *
     * @return string the "default" thumbnail URL for this video
     */
    public function getDefaultThumbURL()
    {
        return "http://img.youtube.com/vi/" . $this->getId() . "/default.jpg";
    }    
    
    /**
     * Get the video's description
     * 
     * @return string The description field of the video.
     * 
     * Example: "This is a great video."
     */
    public function getDescription() 
    { 
        return $this->_description; 
    }
    
    /**
     * Get the video's ID
     * 
     * @return string The YouTube video ID
     * 
     * Example: "3EVVD77X2FD"
     */
    public function getId()
    {
        return $this->_id; 
    }
    
    /**
     * Get the video's length
     * 
     * @return string The runtime of the video
     * 
     * Example: "3:25"
     */
    public function getLength() 
    {      
        return $this->_length; 
    }    
    
    /**
     * Get a random thumbnail URL for this video
     *
     * @return string A random thumbnail URL for this video
     */
    public function getRandomThumbURL()
    {
        $thumbs = $this->getThumbUrls();
        return $thumbs[array_rand($this->getThumbUrls())];
    }    
    
    /**
     * Get the video's average rating
     * 
     * @return string The average rating of the video
     * 
     * Example: "4.3"
     */
    public function getRating() 
    {
        return $this->_rating; 
    }
    
    /**
     * Get the number of ratings
     * 
     * @return string The number of times this video has been rated.
     * 
     * Example: "3hough"
     */
    public function getRatings() 
    {
        return $this->_ratings; 
    }
    
    /**
     * Get the video's tags
     * 
     * @return array The tags of this video
     * 
     * Example: "beer sports women awesome"
     */
    public function getTags() 
    {        
        return $this->_tags; 
    }
    
    /**
     * Get the video's thumbnail URLs
     * 
     * @return string All of the video's thumbnail URLs
     * 
     * Example: "http://img.youtube.com/355VDRRJK8/default.jpg"
     */
    public function getThumbUrls() 
    {   
        return $this->_thumbUrls; 
    }
    
    /**
     * Get the video's title
     * 
     * @return string The title of the video
     * 
     * Example: "My Awesome Video"
     */
    public function getTitle() 
    {       
        return $this->_title; 
    }
    
    /**
     * Get the video's upload time
     * 
     * @return string The timestamp of when this video was uploaded
     * 
     * Example: "3hough"
     */
    public function getUploadTime() 
    {  
        return $this->_uploadTime; 
    }
    
    /**
     * Get the video's view count
     * 
     * @return string The number of times this video has been viewed
     * 
     * Example: "3hough"
     */
    public function getViews() 
    {       
        return $this->_views; 
    }    
    
    /**
     * Get the video's URL on YouTube
     * 
     * @return string The absolute URL of this video's home on YouTube
     * 
     * Example: "http://www.youtube.com/v/355VDRRJK8"
     */
    public function getYouTubeUrl() 
    {  
        return $this->_youTubeUrl; 
    }
    
    /**
     * Set this video's author
     *
     * @param string $author The YouTube author of this video
     * 
     * @return void
     */
    public function setAuthor($author) 
    {
        $this->_author = $author; 
    }
    
    /**
     * Set this video's category
     *
     * @param string $category The YouTube category of this video
     * 
     * @return void
     */
    public function setCategory($category) 
    {         
        $this->_category = $category; 
    }
    
    /**
     * Set the description for this video
     *
     * @param string $description The description for this video
     * 
     * @return void
     */
    public function setDescription($description) 
    {   
        $this->_description = $description; 
    }
    
    /**
     * Set the YouTube video ID of this video
     *
     * @param string $id The YouTube video ID of this video
     * 
     * @return void
     */
    public function setId($id) 
    {          
        $this->_id = $id; 
    }
    
    /**
     * Set the length of this video
     *
     * @param string $length The runtime of this video
     * 
     * @return void
     */
    public function setLength($length) 
    {
        $this->_length = $length; 
    }    
    
    /**
     * Set the average rating of this video
     *
     * @param string $rating The average rating of this video
     * 
     * @return void
     */
    public function setRating($rating)
    {      
        $this->_rating = $rating; 
    }
    
    /**
     * Set the number of ratings of this video
     *
     * @param string $ratings The bumber of times this video has been rated
     * 
     * @return void
     */
    public function setRatings($ratings)
    { 
        $this->_ratings = $ratings;  
    }

    /**
     * Set the tags of this video
     *
     * @param array $tags The tags of this video
     * 
     * @return void
     */
    public function setTags($tags)
    {
        $this->_tags = $tags; 
    }
    
    /**
     * Set the thumbnail URLs of this video
     *
     * @param array $thumbUrls The thumbnail URLs of this video
     * 
     * @return void
     */
    public function setThumbUrls($thumbUrls) 
    {
        $this->_thumbUrls = $thumbUrls; 
    }

    /**
     * Set the title of this video
     *
     * @param string $title The title of this video
     * 
     * @return void
     */
    public function setTitle($title) 
    {               
        $this->_title = $title; 
    }
    
    /**
     * Set the upload time of this video
     *
     * @param string $uploadTime The upload time of this video
     * 
     * @return void
     */
    public function setUploadTime($uploadTime) 
    {     
        $this->_uploadTime = $uploadTime; 
    }
    
    /**
     * Set the number of views of this video
     *
     * @param string $views The number of views for this video
     * 
     * @return void
     */
    public function setViews($views) 
    {
        $this->_views = $views; 
    }    
    
    /**
     * Set the YouTube URL of this video
     *
     * @param string $youTubeUrl The YouTube URL of this video
     * 
     * @return void
     */
    public function setYouTubeUrl($youTubeUrl) 
    {
        $this->_youTubeUrl = $youTubeUrl; 
    }    
}
?>