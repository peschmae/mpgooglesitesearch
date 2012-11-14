<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Mathias Petermann <mathias.petermann@gmail.com>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package mpgooglesitesearch
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Mpgooglesitesearch_Domain_Model_Result extends Tx_Extbase_DomainObject_AbstractEntity {

    /**
     * The title of the search result
     *
     * @var string
     */
    protected $title;

    /**
     * The url of the search result
     *
     * @var string
     */
    protected $url;

    /**
     * The content of the search result
     *
     * @var string
     */
    protected $content;

    /**
     * The page size of the search result
     *
     * @var string
     */
    protected $pageSize;

    /**
     * The last modification date of the search result
     *
     * @var string
     */
    protected $lastModified;

    /**
     * The image url of the search result
     *
     * @var string
     */
    protected $image;

    /**
     * The thumbnail url of the search result
     *
     * @var string
     */
    protected $thumbnail;

    /**
     * The mime type of the search result
     *
     * @var string
     */
    protected $mime;

    public function setContent($content) {
        $this->content = $content;
    }

    public function getContent() {
        return $this->content;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function getImage() {
        return $this->image;
    }

    public function setLastModified($lastModified) {
        $this->lastModified = $lastModified;
    }

    public function getLastModified() {
        return $this->lastModified;
    }

    public function setPageSize($pageSize) {
        $this->pageSize = $pageSize;
    }

    public function getPageSize() {
        return $this->pageSize;
    }

    public function setThumbnail($thumbnail) {
        $this->thumbnail = $thumbnail;
    }

    public function getThumbnail() {
        return $this->thumbnail;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setMime($mime) {
        $this->mime = $mime;
    }

    public function getMime() {
        return $this->mime;
    }
}
?>