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
	ob_start();
	header('Content-type: text/css'); 
?>

.b-related-content-wrapper .column {
	width: <?php echo $columnWidth; ?>%;
	margin-right: <?php echo $columnMargin; ?>px;
	float: left;
}
		
.b-related-content-wrapper .column:last-child { margin-right: auto; }
	
.b-related-content-wrapper .clearfix { clear: both; }
		
<?php if($params->get('customCss')): ?>
	.b-related-content .title h<?php echo $params->get('styleTitle'); ?> <?php if($params->get('linktitle')) echo "a"; ?> {
		color: <?php echo $params->get('styleTitleColor'); ?>;
	}
	
	<?php if($params->get('linktitle')): ?>
		.b-related-content .title h<?php echo $params->get('styleTitle'); ?> a:hover {
			color: <?php echo $params->get('styleTitleColorOver'); ?>;
		}
	<?php endif; ?>
	
	<?php if($params->get('readmore')): ?>
		.b-related-content .readmore a {
			color: <?php echo $params->get('styleReadmoreColor'); ?>;
		}
	
		.b-related-content .readmore a:hover {
			color: <?php echo $params->get('styleReadmoreColorOver'); ?>;
		}
	<?php endif; ?>		
<?php endif; ?>

<?php
	$output = ob_get_contents();
	ob_end_clean();
	$fp = fopen(JPATH_ROOT.DS.'modules'.DS.'mod_b-related-content'.DS.'css'.DS.'style.css','w');
	fwrite($fp,$output);
	fclose($fp);
?>
