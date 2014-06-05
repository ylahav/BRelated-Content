<?php 
/**
 * @package Module B-Related Content for Joomla! 2.5+
 * @version $Id:
 * @author Yair Lahav
 * @copyright (C) 2014 - Yair Lahav
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

$html5 = $params->get('html5') ? 1 : 0;
$autoModuleId = $params->get('autoModuleId') ? true : false;
$moduleID = $params->get('moduleId');

if(isset($moduleID)) {
	$moduleID = explode(' ',trim($params->get('moduleId')));
	$moduleID = $moduleID[0];
}
else {
	if($autoModuleId)
		$moduleID = "modBRelateContent" . $module->id;
} 
 
$numberColumns = $params->get('numberColumns');
$columnMargin = $params->get('columnMargin');

if($numberColumns > 0)
	if ($params->get('columnWidth') > 0 && $params->get('columnWidth') <= 100)
		$columnWidth = $params->get('columnWidth');
	else	
		$columnWidth = intval(100 / $numberColumns);
else {
	$numberColumns = 1;
	$columnWidth = 100;
}
?>

<?php if($html5): ?>
	<section <?php if(isset($moduleID)) echo 'id="'.$moduleID.'"'; ?> class="b-related-content-wrapper <?php echo $params->get('moduleclass_sfx'); ?>">
<?php else: ?>
	<div <?php if(isset($moduleID)) echo 'id="'.$moduleID.'"'; ?> class="b-related-content-wrapper <?php echo $params->get('moduleclass_sfx'); ?>">
<?php endif; ?>

		<?php
		// Shows an error if the user didn't select any category
		if($articles <= 0) {
			// Shows a warning if there are no articles to be displayed
			if($articles == 0 && $params->get('warnings'))
				echo JText::sprintf('MOD_B_RELATED_CONTENT_WARNING_3');
			if($articles == -2)
				echo JText::sprintf('MOD_B_RELATED_CONTENT_WARNING_1');
			if($articles == -3)
				echo JText::sprintf('MOD_B_RELATED_CONTENT_WARNING_2');
		}
		else {
						
			// Shows a warning if the user didn't select the proper settings
			if($params->get('warnings')) {
				// Nothing is displayed
				if(!$params->get('title') && !$params->get('introtext') && !$params->get('introtextimage') && !$params->get('readmore') && !$params->get('fulltext') && !$params->get('fullarticleimage'))
					echo JText::sprintf('MOD_B_RELATED_CONTENT_WARNING_1');
			}
	
			if($numberColumns >= 1)
	 			if(($numberArticles + $numberK2Articles) % $numberColumns != 0)  
	 				$columnArticles = intval(($numberArticles + $numberK2Articles) / $numberColumns) + 1;
				else 
	 				$columnArticles = intval(($numberArticles + $numberK2Articles) / $numberColumns);
	 		
	 		$column = 0;
			$i = 0;
			$articleIndex = 0;
			foreach($articles as $article) { ?>
							
					<?php if(($i % $columnArticles == 0) && ($column <= $numberColumns) && ($numberColumns > 1) && ($numberArticles + $numberK2Articles) > 1) : ?>
						<div class="column col-<?php echo $column + 1; ?>">
					<?php $column++; ?>
					<?php endif; ?>
					
					<?php include 'article.php'; ?>
					<?php $i++; $articleIndex++; ?>
					
					<?php if($column >= 1 && $column <= $numberColumns && $i == $columnArticles) : ?>
						</div>
						<?php $i = 0; ?>
					<?php endif; ?>
					<?php 				
			}  // foreach
			
		} ?>
		
		
<?php if($html5) : ?>
	</section>
<?php else: ?>
	</div>
<?php endif; ?>

<?php
	include JPATH_ROOT.DS.'modules'.DS.'mod_b_related_content'.DS.'css'.DS.'style.php';
	$document = JFactory::getDocument();
	$document->addStyleSheet(JURI::base().'modules'.DS.'mod_b_related_content'.DS.'css'.DS.'style.css');
?>
