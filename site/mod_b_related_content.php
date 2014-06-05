<?php
/**
 * @package Module B Related Content
 * @version $Id:
 * @author Yair Lahav
 * @copyright (C) 2014 - Yair Lahav
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
 
// no direct access
defined('_JEXEC') or die('Restricted access');
 
// Fix for Joomla 3
if(!defined('DS'))
	define('DS',DIRECTORY_SEPARATOR);

require_once(dirname(__FILE__).DS.'helper.php');

$language = JFactory::getLanguage();
$language->load('mod_b_related_content');

if($params->get('logfile'))
	modBRelatedContentHelper::logThis(1, print_r($params, true));

$addCurrentID = $params->get('itemid') ? true : false;
$useContentCatRouter = $params->get('contentCatUrl') ? true : false;

$numberArticles = $params->get('numberArticles');
$numberK2Articles = $params->get('numberArticlesK2');

$articles = modBRelatedContentHelper::getArticles($params);

if($articles > 0) { 
	$i = 0;
	foreach($articles as $article) {
		$urls[$i] = modBRelatedContentHelper::getUrl($article, $addCurrentID, $useContentCatRouter);
		
		if($params->get('logfile')) {
			modBRelatedContentHelper::logThis(2, print_r($article, true));
			modBRelatedContentHelper::logThis(3, print_r($urls[$i], true));
		}
		
		$i++;
	}
}

require(JModuleHelper::getLayoutPath('mod_b_related_content'));
?>
