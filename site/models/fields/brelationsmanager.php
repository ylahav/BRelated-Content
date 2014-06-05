<?php

/**
 * @copyright	Copyright (C) 2014 Yair Lahav
 * http://www.bonimba.co.il
 * @license		GNU/GPL
 * */
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');

JText::script('MOD_B_RELATED_CONTENT_RELATION_LABEL');
JText::script('MOD_B_RELATED_CONTENT_RELATION_SOURCE_LABEL');
JText::script('MOD_B_RELATED_CONTENT_RELATION_SOURCE_ARTICELS_LABEL');
JText::script('MOD_B_RELATED_CONTENT_RELATION_SOURCE_CATEGORIES_LABEL');
JText::script('MOD_B_RELATED_CONTENT_RELATION_SOURCE_MENUS_LABEL');
JText::script('MOD_B_RELATED_CONTENT_RELATION_DESTINATION_LABEL');
JText::script('MOD_B_RELATED_CONTENT_RELATION_DESTINATION_CATEGORIES_LABEL');

class JFormFieldBRelationsManager extends JFormField {

	protected $type = 'brelationsmanager';
	
	protected function getInput() {
		$document = JFactory::getDocument();
		$document->addScriptDeclaration("JURI='" . JURI::root() . "';");
		$path = 'modules/mod_b_related_content/models/fields/brelationsmanager/';
		JHTML::_('script', $path . 'brelationsmanager.js');
		JHTML::_('stylesheet', $path . 'brelationsmanager.css');
		$html ='<input name="' . $this->name . '" id="b-all-relations" class="b-all-relations" type="hidden" value="' . $this->value . '" />';
		$html.='<input name="baddrelation" id="baddrelation" type="button" value="' . JText::_('MOD_B_RELATED_CONTENT_ADD_RELATION') . '" onclick="javascript:BAddRelation();"/>';
		$html.='<ul id="b-relations" style="clear:both;"></ul>';
		$html.='<input name="baddrelation" id="baddrelation" type="button" value="' . JText::_('MOD_B_RELATED_CONTENT_ADD_RELATION') . '" onclick="javascript:BAddRelation();"/>';
		return $html;
	}
	
	protected function getLabel() {
		return '';
	}
}
?>

