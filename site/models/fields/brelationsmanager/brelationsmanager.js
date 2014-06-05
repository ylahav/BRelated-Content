/**
 * @copyright	Copyright (C) 2014 Yair Lahav
 * http://www.bonimba.co.il
 * Module B Related Content
 * @license		GNU/GPL
 * */
 
	function BAddRelation(c_type, ids, dids, number) {
		if (!c_type) c_type = '-1';
		if (!ids) ids = '';
		if (!dids) dids = '';
		if (!number) number = '';
		index = checkIndex(0);
		var brelation = new Element('li', {
			'class': 'b-relation',
			'id': 'b-relation' + index
		});
                optios_str = '<option value="-1"';
                if(c_type=='-1') {
                    optios_str += ' selected="selected">';
                } else {
                    optios_str += '>';
                }
                optios_str += Joomla.JText._('MOD_B_RELATED_CONTENT_RELATION_SOURCE_ITEM_TYPE_SELECT', 'Select the content type') + '</option>';

                optios_str += '<option value="article"';
                if(c_type=='article') {
                    optios_str += ' selected="selected">';
                } else {
                    optios_str += '>';
                }
                optios_str += Joomla.JText._('MOD_B_RELATED_CONTENT_RELATION_SOURCE_ITEM_TYPE_ARTICLE', 'Article') + '</option>';
                
                optios_str += '<option value="category"';
                if(c_type=='category') {
                    optios_str += ' selected="selected">';
                } else {
                    optios_str += '>';
                }
                optios_str += Joomla.JText._('MOD_B_RELATED_CONTENT_RELATION_SOURCE_ITEM_TYPE_CATEGORY', 'Category') + '</option>';

                optios_str += '<option value="menu"';
                if(c_type=='menu') {
                    optios_str += ' selected="selected">';
                } else {
                    optios_str += '>';
                }
                optios_str += Joomla.JText._('MOD_B_RELATED_CONTENT_RELATION_SOURCE_ITEM_TYPE_MENU', 'Menu') + '</option>';

                optios_str += '<option value="hikashop"';
                if(c_type=='hikashop') {
                    optios_str += ' selected="selected">';
                } else {
                    optios_str += '>';
                }
                optios_str += Joomla.JText._('MOD_B_RELATED_CONTENT_RELATION_SOURCE_ITEM_TYPE_HIKASHOP', 'Hikashop') + '</option>';

		brelation.set('html', ''
			+ '<div class="b-relation-header">'
                            + '<div class="b-relation-number">' + index + '</div>'
			+ '</div>'
			+ '<div class="b-relation-container">'
                            + '<input name="b-relation-delete' + index + '" class="b-relation-delete" type="button" value="' + Joomla.JText._('MOD_B_RELATED_CONTENT_RELATION_REMOVE_SYMBOL', '') + '" onclick="javascript:removeRelation(this.getParent().getParent());" />'
                            + '<div class="b-sources">'
                                + '<h3 class="b-sources-header">' + Joomla.JText._('MOD_B_RELATED_CONTENT_RELATION_SOURCE_LABEL', 'Relate these items') + '</h3>'
                        	+ '<div class="b-sources-label">' + Joomla.JText._('MOD_B_RELATED_CONTENT_RELATION_SOURCE_ITEM_TYPE_LABEL', 'Item type') + '</div>'
				+ '<div class="b-sources-type">'
                                    + '<select name="b-source-type" class="b-source-type" onchange="javascript:storesetwarning();">' + optios_str + '</select>'
				+ '</div>'
				+ '<div class="b-sources-input">'
                                    + '<div class="b-sources-label">' + Joomla.JText._('MOD_B_RELATED_CONTENT_RELATION_SOURCE_ITEM_IDS_LABEL', 'IDs') + '</div>'
                                    + '<input name="b-source-ids' + index + '" class="b-source-ids" type="text" value="' + ids + '" onchange="javascript:storesetwarning();" />'
				+ '</div>'
                            + '</div>'
				+ '<div class="b-destinations">'
					+ '<h3 class="b-destination-header">' + Joomla.JText._('MOD_B_RELATED_CONTENT_RELATION_DESTINATION_LABEL', 'To these items') + '</h3>'
					+ '<div class="b-destinations-label">' + Joomla.JText._('MOD_B_RELATED_CONTENT_RELATION_DESTINATION_CATEGORIES_LABEL', 'Categories') + '</div>'
					+ '<div class="b-destinations-input">'
						+ '<input name="b-destination-ids' + index + '" class="b-destination-ids" type="text" value="' + dids + '" onchange="javascript:storesetwarning();" />'
					+ '</div>'
					+ '<div class="b-destinations-label">' + Joomla.JText._('MOD_B_RELATED_CONTENT_RELATION_DESTINATION_ARTICLES_COUNT_LABEL', 'Number of articles') + '</div>'
					+ '<div class="b-destinations-input">'
						+ '<input class="b-destination-numberArticles" type="text"  value="' + number + '" name="b-destination-numberArticles'+ index + '" onchange="javascript:storesetwarning();" />'
					+ '</div>'
				+ '</div>'
			+ '</div>');
		document.id('b-relations').adopt(brelation);
		
		storeRelations();
	}
	
	function checkIndex(i) {
		while ($('b-relation' + i)) {
			i++;
		}
		return i;
	}
	
	function removeRelation(aRelation) {
		if (confirm(Joomla.JText._('MOD_B_RELATED_CONTENT_RELATION_REMOVE', 'Remove this relation') + ' ?')) {
			aRelation.destroy();
			storeRelations();
		}
	}

        function storesetwarning() {
            storeRelations();
        }

	function storeRelations() {
		var i = 0;
		var relations = new Array();
		document.id('b-relations').getElements('.b-relation').each(function(el) {
			aRelation = new Object();
                        
                        aRelation['type']   = el.getElement('.b-source-type').value;
			aRelation['ids'] = el.getElement('.b-source-ids').value;
			aRelation['dids']  = el.getElement('.b-destination-ids').value;
			aRelation['number']     = el.getElement('.b-destination-numberArticles').value;
			relations[i] = aRelation;
			i++;
		});
		relations = JSON.encode(relations);
		relations = relations.replace(/"/g, "|bb|");
		document.id('b-all-relations').value = relations;
	}

	function callRelations() {
		var relations = JSON.decode(document.id('b-all-relations').value.replace(/\|bb\|/g, "\""));
		if (relations) {
			relations.each(function(relation) {
			BAddRelation( relation['type'],
                            relation['ids'],
                            relation['dids'],
                            relation['number']);
			});
		}
	}
	
	window.addEvent('domready', function() {
		callRelations();

	});
