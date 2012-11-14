<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Search',
	array(
		'Search' => 'index, result',
		
	),
	// non-cacheable actions
	array(
		'Search' => 'result',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Widget',
	array(
		'Search' => 'widget',
		
	),
	// non-cacheable actions
	array(

	)
);

?>