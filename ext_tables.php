<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Search',
	'GSS Result Page'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Widget',
	'GSS Widget (for menus)'
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'GoogleSiteSearch');


$extensionName = t3lib_div::underscoredToUpperCamelCase($_EXTKEY);
$pluginSignature = strtolower($extensionName) . '_search';

$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY.'/Configuration/FlexForms/Search.xml');

$pluginSignature = strtolower($extensionName) . '_widget';

$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY.'/Configuration/FlexForms/Widget.xml');

?>