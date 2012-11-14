<?php

########################################################################
# Extension Manager/Repository config file for ext "mpgooglesitesearch".
#
# Auto generated 13-07-2012 12:23
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Google Site Search',
	'description' => 'A simple way to inlcude a Google Site Search into your Website.
To use Google Site Search you will have to create an Account at http://www.google.com/enterprise/search/products_gss.html',
	'category' => 'plugin',
	'author' => 'Mathias Petermann',
	'author_email' => 'mathias.petermann@gmail.com',
	'author_company' => '',
	'shy' => '',
	'priority' => '',
	'module' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '0.9.0',
	'constraints' => array(
		'depends' => array(
			'extbase' => '1.3.0',
			'fluid' => '1.3.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:23:{s:12:"ext_icon.gif";s:4:"d9c1";s:17:"ext_localconf.php";s:4:"7465";s:14:"ext_tables.php";s:4:"01b3";s:13:"test-feed.xml";s:4:"f951";s:39:"Classes/Controller/SearchController.php";s:4:"fde1";s:31:"Classes/Domain/Model/Result.php";s:4:"499b";s:32:"Classes/Utility/ResultParser.php";s:4:"e380";s:34:"Configuration/FlexForms/Search.xml";s:4:"2980";s:34:"Configuration/FlexForms/Widget.xml";s:4:"edc7";s:38:"Configuration/TypoScript/constants.txt";s:4:"484d";s:34:"Configuration/TypoScript/setup.txt";s:4:"7ebf";s:40:"Resources/Private/Language/locallang.xml";s:4:"b3fe";s:86:"Resources/Private/Language/locallang_csh_tx_mpgooglesitesearch_domain_model_result.xml";s:4:"6934";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"8585";s:37:"Resources/Private/Partials/Pager.html";s:4:"dbeb";s:42:"Resources/Private/Partials/SearchForm.html";s:4:"5baa";s:45:"Resources/Private/Templates/Search/Index.html";s:4:"5608";s:46:"Resources/Private/Templates/Search/Result.html";s:4:"936d";s:46:"Resources/Private/Templates/Search/Widget.html";s:4:"1605";s:22:"Tests/Unit/FooTest.php";s:4:"15bd";s:46:"Tests/Unit/Controller/ResultControllerTest.php";s:4:"eefe";s:38:"Tests/Unit/Domain/Model/ResultTest.php";s:4:"18a3";s:14:"doc/manual.sxw";s:4:"8d2d";}',
);

?>