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
class Tx_Mpgooglesitesearch_Controller_SearchController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * action index
	 *
	 * @return void
	 */
	public function indexAction() {
		// Nothing to do here, just display the view
	}

	/**
	 * action search
	 *
	 * @param string $query the search query
	 * @param string $page the page to display
	 * @return void
	 */
	public function resultAction($query, $page = 0) {

        $resultsPerPage = $this->settings['flexform']['resultsPerPage'];
        $start = $page*$resultsPerPage;

        if (!empty($query)) {
            $resultParser = t3lib_div::makeInstance('Tx_Mpgooglesitesearch_Utility_ResultParser');

            $cseNumber = $this->settings['flexform']['gssid'];
            $language = $this->getLanguage($GLOBALS['TSFE']->sys_language_uid);
            $countrycode = $this->getCountrycode($GLOBALS['TSFE']->sys_language_uid);

            $resultParser->fetchXml($query, $start, $resultsPerPage, $cseNumber, $language, $countrycode);

            $generalInformation = $resultParser->getGeneralInformation();
            $results = $resultParser->getSearchResultArray();

            if ($generalInformation['numberOfResults'] > $resultsPerPage) {
                $pager = array();

				$pager['showPageLinks'] = $this->settings['showPageLinks'] == 1;
				if ($pager['showPageLinks']) {
					$pager['pages'] = $this->generatePageLinks(ceil($generalInformation['numberOfResults'] / $resultsPerPage), $page);

					if ($pager['pages'][0]['argument'] !== 0 && $this->settings['showFirstPageLink']) {
						$pager['showFirstPageLink'] = true;
					}
				}

                if ($generalInformation['numberOfResults'] >= $start + $resultsPerPage) {
                    $pager['nextPage'] = $page+1;
                } else {
                    $pager['nextPage'] = false;
                }

                if ($start > 0) {
                    $pager['prevPage'] = $page-1;
                    $pager['hasPrevPage'] = true;
                } else {
                    $pager['hasPrevPage'] = false;
                }

                $this->view->assign('pager', $pager);
            }


            if (count($results) == 0) {
                $this->view->assign('noResultText', 'noSearchResults');
            } else {
                $this->view->assign('results', $results);
                $this->view->assign('general', $generalInformation);
            }

            $this->view->assign('query', $query);

        } else {
            $this->view->assign('noResultText', 'emptyQuery');
        }
	}

	/**
	 * action widget
	 *
	 * @return void
	 */
	public function widgetAction() {
        $this->view->assign('resultPageUid', $this->settings['flexform']['resultpage']);
	}


/* HELPER FUNCTIONS */

	/**
	 * Create an array of page links
	 *
	 * @param int $pageCount Total number of pages
	 * @param int $currentPage Current result page (zero based)
	 *
	 * @return array
	 */
	private function generatePageLinks($pageCount, $currentPage) {
		$pageLinkCount = intval($this->settings['pageLinkCount']);

		if ($currentPage < ceil($pageLinkCount / 2)) {
			$pagesStart = 0;
			$pagesEnd = $pageLinkCount;
		} else if ($currentPage >= $pageCount - ceil($pageLinkCount/2)) {
			$pagesStart = $pageCount - $pageLinkCount;
			$pagesEnd = $pageCount;
		} else {
			$pagesStart = $currentPage - floor($pageLinkCount / 2);
			$pagesEnd = $currentPage + ceil($pageLinkCount / 2);
		}

		$pages = array();
		for ($i = $pagesStart; $i < $pagesEnd; $i++) {
			array_push($pages, array(
				'isCurrent' => $currentPage == $i,
				'number' => $i + 1,
				'argument' => $i
			));
		}

		return $pages;
	}

	/**
     * get's the language from the typoscript settings
     *
     * @param string $languageUid the language uid
     * @return string
     */
    protected function getLanguage($languageUid) {
        if (isset($this->settings['languages'][$languageUid]['shortcut'])) {
            $language = $this->settings['languages'][$languageUid]['shortcut'];

        } elseif (isset($this->settings['languages']['default']['shortcut'])) {
            $language = $this->settings['languages']['default']['shortcut'];

        } else {
            $language = 'en';
        }

        return $language;
    }

    /**
     * get's the country code from the typoscript settings
     *
     * @param string $languageUid the language uid
     * @return string
     */
    protected function getCountrycode($languageUid) {
        if (isset($this->settings['languages'][$languageUid]['countrycode'])) {
            $countrycode = $this->settings['languages'][$languageUid]['countrycode'];

        } elseif (isset($this->settings['languages']['default']['countrycode'])) {
            $countrycode = $this->settings['languages']['default']['countrycode'];

        } else {
            $countrycode = 'uk';
        }

        return $countrycode;
    }

}
?>