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
class Tx_Mpgooglesitesearch_Utility_ResultParser {
    /**
     * The search result XML that gets returned by google
     *
     * @var DOMDocument of search results
     */
    protected $xml;

    /**
     * Load the XML string into a DOMDocument
     *
     * @var string the XML as a string
     * @return void
     */
    public function fetchXml($query, $start, $resultsPerPage, $cseNumber, $language, $countrycode) {

        $url = 'http://www.google.com/search?client=google-csbe&output=xml_no_dtd'.
            '&cr=country'.$countrycode.
            '&lr=lang_'.$language.
            '&cx='.$cseNumber.
            '&start='.$start.
            '&num='.$resultsPerPage.
            '&q='.urlencode($query);

        if (ini_get('allow_url_fopen') == 1) {
            $searchResultString = file_get_contents($url);

        } elseif (function_exists('curl_init')) {
            $curlSession = curl_init();

            curl_setopt($curlSession, CURLOPT_URL, $url);
            curl_setopt($curlSession, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

            $searchResultString = curl_exec($curlSession);

            curl_close($curlSession);
        } else {
            throw new Exception('Neither cUrl nor allow_url_fopen allowed.');
        }

        $this->xml = DOMDocument::loadXML($searchResultString);
    }

    /**
     * Parse the xml for the search results
     *
     * @var array of search results
     */
    public function getSearchResultArray() {
        if(empty($this->xml) || !($this->xml instanceof DomDocument)) {
            throw new Exception('No XML Loaded');
        }

        $results = $this->xml->getElementsByTagName('R');

        $resultArray = Array();
        foreach($results as $result) {
            $resultObject = t3lib_div::makeInstance('Tx_Mpgooglesitesearch_Domain_Model_Result');

            // Get basic properties
            $resultObject->setTitle($result->getElementsByTagName('T')->item(0)->nodeValue);
            $resultObject->setUrl($result->getElementsByTagName('U')->item(0)->nodeValue);
            $resultObject->setContent($result->getElementsByTagName('S')->item(0)->nodeValue);

            $pageMap = $result->getElementsByTagName('PageMap')->item(0);

            // ToDo: Can't this be writter nicer?
            if (is_object($pageMap)) {
                foreach($pageMap->getElementsByTagName('DataObject') as $dataObj) {
                    if ($dataObj->getAttribute('type') == 'metatags') {
                        // Get LastModified (every result got this)
                        foreach ($dataObj->getElementsByTagName('Attribute') as $attr) {
                            if ($attr->getAttribute('name') == 'lastmodified') {
                                $resultObject->setLastModified($attr->getAttribute('value'));
                            }
                        }
                    } elseif ($dataObj->getAttribute('type') == 'cse_image') {
                        // If there is an image, get the url
                        foreach ($dataObj->getElementsByTagName('Attribute') as $attr) {
                            if ($attr->getAttribute('name') == 'src') {
                                $resultObject->setImage($attr->getAttribute('value'));
                            }
                        }
                    } elseif ($dataObj->getAttribute('type') == 'cse_thumbnail') {
                        // If there is a thumbnail, get the url and the dimensions
                        $thumbnailArray = Array();
                        foreach ($dataObj->getElementsByTagName('Attribute') as $attr) {
                            $thumbnailArray[$attr->getAttribute('name')] = $attr->getAttribute('value');
                        }
                        $resultObject->setThumbnail($thumbnailArray);
                    }

                }
            }

            if ($result->hasAttribute('MIME')) {
                $resultObject->setMime($result->getAttribute('MIME'));
            }
			$cNode = $result->getElementsByTagName('HAS')->item(0)->getElementsByTagName('C')->item(0);
			if(is_object($cNode)) {
				$pageSize = $cNode->getAttribute('SZ');
				$resultObject->setPageSize($pageSize);
			}


            $resultArray[] = $resultObject;
        }

        return $resultArray;
    }

    /**
     * Read the general information from the xml
     *
     * @var array with the general information
     */
    public function getGeneralInformation() {
        if (empty($this->xml) || !($this->xml instanceof DomDocument)) {
            throw new Exception('No XML Loaded');
        }
        $general = Array();

        $general['numberOfResults'] =  $this->xml->getElementsByTagName('M')->item(0)->nodeValue;

        if (is_object($this->xml->getElementsByTagName('RES')->item(0))) {
            if ($this->xml->getElementsByTagName('RES')->item(0)->hasAttribute('SN')) {
                $general['start'] = $this->xml->getElementsByTagName('RES')->item(0)->getAttribute('SN');
            }

            if ($this->xml->getElementsByTagName('RES')->item(0)->hasAttribute('EN')) {
                $general['end'] = $this->xml->getElementsByTagName('RES')->item(0)->getAttribute('EN');
            }
        }

        return $general;
    }
}
