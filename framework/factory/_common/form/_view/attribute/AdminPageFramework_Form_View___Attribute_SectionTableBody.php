<?php 
/**
	Admin Page Framework v3.8.19 by Michael Uno 
	Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
	<http://en.michaeluno.jp/iloveimg>
	Copyright (c) 2013-2019, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
class iLoveIMGAdminPageFramework_Form_View___Attribute_SectionTableBody extends iLoveIMGAdminPageFramework_Form_View___Attribute_Base {
    public $sContext = 'section_table_content';
    protected function _getAttributes() {
        $_sCollapsibleType = $this->getElement($this->aArguments, array('collapsible', 'type'), 'box');
        return array('class' => $this->getAOrB($this->aArguments['_is_collapsible'], 'iloveimg-collapsible-section-content' . ' ' . 'iloveimg-collapsible-content' . ' ' . 'accordion-section-content' . ' ' . 'iloveimg-collapsible-content-type-' . $_sCollapsibleType, null),);
    }
    }
    