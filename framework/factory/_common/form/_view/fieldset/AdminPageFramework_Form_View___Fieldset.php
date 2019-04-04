<?php 
/**
	Admin Page Framework v3.8.19 by Michael Uno 
	Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
	<http://en.michaeluno.jp/iloveimg>
	Copyright (c) 2013-2019, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
abstract class iLoveIMGAdminPageFramework_Form_View___Fieldset_Base extends iLoveIMGAdminPageFramework_Form_Utility {
    public $aFieldset = array();
    public $aFieldTypeDefinitions = array();
    public $aOptions = array();
    public $aErrors = array();
    public $oMsg;
    public $aCallbacks = array();
    public function __construct($aFieldset, $aOptions, $aErrors, &$aFieldTypeDefinitions, &$oMsg, array $aCallbacks = array()) {
        $this->aFieldset = $this->_getFormatted($aFieldset, $aFieldTypeDefinitions);
        $this->aFieldTypeDefinitions = $aFieldTypeDefinitions;
        $this->aOptions = $aOptions;
        $this->aErrors = $this->getAsArray($aErrors);
        $this->oMsg = $oMsg;
        $this->aCallbacks = $aCallbacks + array('hfID' => null, 'hfTagID' => null, 'hfName' => null, 'hfNameFlat' => null, 'hfInputName' => null, 'hfInputNameFlat' => null, 'hfClass' => null,);
        $this->_loadScripts($this->aFieldset['_structure_type']);
    }
    private function _getFormatted($aFieldset, $aFieldTypeDefinitions) {
        return $this->uniteArrays($aFieldset, $this->_getFieldTypeDefaultArguments($aFieldset['type'], $aFieldTypeDefinitions) + iLoveIMGAdminPageFramework_Form_Model___Format_Fieldset::$aStructure);
    }
    private function _getFieldTypeDefaultArguments($sFieldType, $aFieldTypeDefinitions) {
        $_aFieldTypeDefinition = $this->getElement($aFieldTypeDefinitions, $sFieldType, $aFieldTypeDefinitions['default']);
        $_aDefaultKeys = $this->getAsArray($_aFieldTypeDefinition['aDefaultKeys']);
        $_aDefaultKeys['attributes'] = array('fieldrow' => $_aDefaultKeys['attributes']['fieldrow'], 'fieldset' => $_aDefaultKeys['attributes']['fieldset'], 'fields' => $_aDefaultKeys['attributes']['fields'], 'field' => $_aDefaultKeys['attributes']['field'],);
        return $_aDefaultKeys;
    }
    static private $_bIsLoadedJSScripts = false;
    static private $_bIsLoadedJSScripts_Widget = false;
    private function _loadScripts($sStructureType = '') {
        if ('widget' === $sStructureType && !self::$_bIsLoadedJSScripts_Widget) {
            new iLoveIMGAdminPageFramework_Form_View___Script_Widget;
            self::$_bIsLoadedJSScripts_Widget = true;
        }
        if (self::$_bIsLoadedJSScripts) {
            return;
        }
        self::$_bIsLoadedJSScripts = true;
        new iLoveIMGAdminPageFramework_Form_View___Script_Utility;
        new iLoveIMGAdminPageFramework_Form_View___Script_OptionStorage;
        new iLoveIMGAdminPageFramework_Form_View___Script_AttributeUpdator;
        new iLoveIMGAdminPageFramework_Form_View___Script_RepeatableField($this->oMsg);
        new iLoveIMGAdminPageFramework_Form_View___Script_SortableField;
    }
    protected function _getRepeaterFieldEnablerScript($sFieldsContainerID, $iFieldCount, $aSettings) {
        $_sSmallButtons = '"' . $this->___getRepeatableButtonHTML($sFieldsContainerID, ( array )$aSettings, $iFieldCount, true) . '"';
        $_sNestedFieldsButtons = '"' . $this->___getRepeatableButtonHTML($sFieldsContainerID, ( array )$aSettings, $iFieldCount, false) . '"';
        $_aJSArray = json_encode($aSettings);
        $_sScript = <<<JAVASCRIPTS
jQuery( document ).ready( function() {
    var _oButtonPlaceHolders = jQuery( '#{$sFieldsContainerID} > .iloveimg-field.without-child-fields .repeatable-field-buttons' );
    /* If the button place-holder is set in the field type definition, replace it with the created output */
    if ( _oButtonPlaceHolders.length > 0 ) {
        _oButtonPlaceHolders.replaceWith( $_sSmallButtons );
    } 
    /* Otherwise, insert the button element at the beginning of the field tag */
    else { 
        /**
         * Adds the buttons
         * Check whether the button container already exists for WordPress 3.5.1 or below.
         * @todo 3.8.0 Examine the below conditional line whether the behavior does not break for nested fields.
         */
        if ( ! jQuery( '#{$sFieldsContainerID} .iloveimg-repeatable-field-buttons' ).length ) { 
            jQuery( '#{$sFieldsContainerID} > .iloveimg-field.without-nested-fields' ).prepend( $_sSmallButtons );
        }
        /**
         * Support for nested fields.
         * For nested fields, add the buttons to the fields tag.
         */
        jQuery( '#{$sFieldsContainerID} > .iloveimg-field.with-nested-fields' ).prepend( $_sNestedFieldsButtons );
        
        /**
         * Support for inline mixed fields.
         */
        // jQuery( '#{$sFieldsContainerID} > .iloveimg-field.with-mixed-fields' ).prepend( $_sNestedFieldsButtons );
        
    }     
    jQuery( '#{$sFieldsContainerID}' ).updateiLoveIMGAdminPageFrameworkRepeatableFields( $_aJSArray ); // Update the fields     
});
JAVASCRIPTS;
        return "<script type='text/javascript'>" . '/* <![CDATA[ */' . $_sScript . '/* ]]> */' . "</script>";
    }
    private function ___getRepeatableButtonHTML($sFieldsContainerID, array $aArguments, $iFieldCount, $bSmall = true) {
        $_oFormatter = new iLoveIMGAdminPageFramework_Form_Model___Format_RepeatableField($aArguments, $this->oMsg);
        $_aArguments = $_oFormatter->get();
        $_sSmallButtonSelector = $bSmall ? ' button-small' : '';
        return "<div " . $this->___getContainerAttributes($_aArguments) . " >" . "<a " . $this->___getRemvoeButtonAttribtes($sFieldsContainerID, $_sSmallButtonSelector, $iFieldCount) . ">-</a>" . "<a " . $this->___getAddButtonAttribtes($_aArguments, $sFieldsContainerID, $_sSmallButtonSelector) . ">+</a>" . "</div>" . $this->getModalForDisabledRepeatableElement('repeatable_field_disabled_' . $sFieldsContainerID, $_aArguments['disabled']);
    }
    private function ___getAddButtonAttribtes($aArguments, $sFieldsContainerID, $sSmallButtonSelector) {
        $_sPlusButtonAttributes = array('class' => 'repeatable-field-add-button button-secondary repeatable-field-button button' . $sSmallButtonSelector, 'title' => $this->oMsg->get('add'), 'data-id' => $sFieldsContainerID, 'href' => empty($aArguments['disabled']) ? null : '#TB_inline?width=' . $aArguments['disabled']['box_width'] . '&height=' . $aArguments['disabled']['box_height'] . '&inlineId=' . 'repeatable_field_disabled_' . $sFieldsContainerID,);
        return $this->getAttributes($_sPlusButtonAttributes);
    }
    private function ___getRemvoeButtonAttribtes($sFieldsContainerID, $sSmallButtonSelector, $iFieldCount) {
        $_aMinusButtonAttributes = array('class' => 'repeatable-field-remove-button button-secondary repeatable-field-button button' . $sSmallButtonSelector, 'title' => $this->oMsg->get('remove'), 'style' => $iFieldCount <= 1 ? 'visibility: hidden' : null, 'data-id' => $sFieldsContainerID,);
        return $this->getAttributes($_aMinusButtonAttributes);
    }
    private function ___getContainerAttributes($aArguments) {
        $_aContainerAttributes = array('class' => $this->getClassAttribute('iloveimg-repeatable-field-buttons', !empty($aArguments['disabled']) ? 'disabled' : ''),);
        unset($aArguments['disabled']['message']);
        if (empty($aArguments['disabled'])) {
            unset($aArguments['disabled']);
        }
        return $this->getAttributes($_aContainerAttributes) . ' ' . $this->getDataAttributes($aArguments);
    }
    protected function _getSortableFieldEnablerScript($sFieldsContainerID) {
        $_sScript = <<<JAVASCRIPTS
    jQuery( document ).ready( function() {
        jQuery( this ).enableiLoveIMGAdminPageFrameworkSortableFields( '$sFieldsContainerID' );
    });
JAVASCRIPTS;
        return "<script type='text/javascript' class='iloveimg-sortable-field-enabler-script'>" . '/* <![CDATA[ */' . $_sScript . '/* ]]> */' . "</script>";
    }
    }
    class iLoveIMGAdminPageFramework_Form_View___Fieldset extends iLoveIMGAdminPageFramework_Form_View___Fieldset_Base {
        public function get() {
            $_aOutputs = array();
            $_oFieldError = new iLoveIMGAdminPageFramework_Form_View___Fieldset___FieldError($this->aErrors, $this->aFieldset['_section_path_array'], $this->aFieldset['_field_path_array'], $this->aFieldset['error_message']);
            $_aOutputs[] = $_oFieldError->get();
            $_oFieldsFormatter = new iLoveIMGAdminPageFramework_Form_Model___Format_Fields($this->aFieldset, $this->aOptions);
            $_aFields = $_oFieldsFormatter->get();
            $_aOutputs[] = $this->_getFieldsOutput($this->aFieldset, $_aFields, $this->aCallbacks);
            return $this->_getFinalOutput($this->aFieldset, $_aOutputs, count($_aFields));
        }
        private function _getFieldsOutput($aFieldset, array $aFields, array $aCallbacks = array()) {
            $_aOutput = array();
            foreach ($aFields as $_isIndex => $_aField) {
                $_aOutput[] = $this->_getEachFieldOutput($_aField, $_isIndex, $aCallbacks, $this->isLastElement($aFields, $_isIndex));
            }
            return implode(PHP_EOL, array_filter($_aOutput));
        }
        private function _getEachFieldOutput($aField, $isIndex, array $aCallbacks, $bIsLastElement = false) {
            $_aFieldTypeDefinition = $this->_getFieldTypeDefinition($aField['type']);
            if (!is_callable($_aFieldTypeDefinition['hfRenderField'])) {
                return '';
            }
            $_oSubFieldFormatter = new iLoveIMGAdminPageFramework_Form_Model___Format_EachField($aField, $isIndex, $aCallbacks, $_aFieldTypeDefinition);
            $aField = $_oSubFieldFormatter->get();
            return $this->_getFieldOutput(call_user_func_array($_aFieldTypeDefinition['hfRenderField'], array($aField)), $aField, $bIsLastElement);
        }
        private function _getFieldOutput($sContent, $aField, $bIsLastElement) {
            $_oFieldAttribute = new iLoveIMGAdminPageFramework_Form_View___Attribute_Field($aField);
            return $aField['before_field'] . "<div " . $_oFieldAttribute->get() . ">" . $sContent . $this->_getUnsetFlagFieldInputTag($aField) . $this->_getDelimiter($aField, $bIsLastElement) . "</div>" . $aField['after_field'];
        }
        private function _getUnsetFlagFieldInputTag($aField) {
            if (false !== $aField['save']) {
                return '';
            }
            return $this->getHTMLTag('input', array('type' => 'hidden', 'name' => '__unset_' . $aField['_fields_type'] . '[' . $aField['_input_name_flat'] . ']', 'value' => $aField['_input_name_flat'], 'class' => 'unset-element-names element-address',));
        }
        private function _getFieldTypeDefinition($sFieldTypeSlug) {
            return $this->getElement($this->aFieldTypeDefinitions, $sFieldTypeSlug, $this->aFieldTypeDefinitions['default']);
        }
        private function _getDelimiter($aField, $bIsLastElement) {
            return $aField['delimiter'] ? "<div " . $this->getAttributes(array('class' => 'delimiter', 'id' => "delimiter-{$aField['input_id']}", 'style' => $this->getAOrB($bIsLastElement, "display:none;", ""),)) . ">" . $aField['delimiter'] . "</div>" : '';
        }
        private function _getFinalOutput($aFieldset, array $aFieldsOutput, $iFieldsCount) {
            $_oFieldsetAttributes = new iLoveIMGAdminPageFramework_Form_View___Attribute_Fieldset($aFieldset);
            return $aFieldset['before_fieldset'] . "<fieldset " . $_oFieldsetAttributes->get() . ">" . $this->_getEmbeddedFieldTitle($aFieldset) . $this->_getChildFieldTitle($aFieldset) . $this->_getFieldsetContent($aFieldset, $aFieldsOutput, $iFieldsCount) . $this->_getExtras($aFieldset, $iFieldsCount) . "</fieldset>" . $aFieldset['after_fieldset'];
        }
        private function _getEmbeddedFieldTitle($aFieldset) {
            if (!$aFieldset['_is_title_embedded']) {
                return '';
            }
            $_oFieldTitle = new iLoveIMGAdminPageFramework_Form_View___FieldTitle($aFieldset, '', $this->aOptions, $this->aErrors, $this->aFieldTypeDefinitions, $this->aCallbacks, $this->oMsg);
            return $_oFieldTitle->get();
        }
        private function _getChildFieldTitle($aFieldset) {
            if (!$aFieldset['_nested_depth']) {
                return '';
            }
            if ($aFieldset['_is_title_embedded']) {
                return '';
            }
            $_oFieldTitle = new iLoveIMGAdminPageFramework_Form_View___FieldTitle($aFieldset, array('iloveimg-child-field-title'), $this->aOptions, $this->aErrors, $this->aFieldTypeDefinitions, $this->aCallbacks, $this->oMsg);
            return $_oFieldTitle->get();
        }
        private function _getFieldsetContent($aFieldset, $aFieldsOutput, $iFieldsCount) {
            if (is_scalar($aFieldset['content'])) {
                return $aFieldset['content'];
            }
            $_oFieldsAttributes = new iLoveIMGAdminPageFramework_Form_View___Attribute_Fields($aFieldset, array(), $iFieldsCount);
            return "<div " . $_oFieldsAttributes->get() . ">" . $aFieldset['before_fields'] . implode(PHP_EOL, $aFieldsOutput) . $aFieldset['after_fields'] . "</div>";
        }
        private function _getExtras($aField, $iFieldsCount) {
            $_aOutput = array();
            $_oFieldDescription = new iLoveIMGAdminPageFramework_Form_View___Description($aField['description'], 'iloveimg-fields-description');
            $_aOutput[] = $_oFieldDescription->get();
            $_aOutput[] = $this->_getDynamicElementFlagFieldInputTag($aField);
            $_aOutput[] = $this->_getFieldScripts($aField, $iFieldsCount);
            return implode(PHP_EOL, array_filter($_aOutput));
        }
        private function _getDynamicElementFlagFieldInputTag($aFieldset) {
            if (!empty($aFieldset['repeatable'])) {
                return $this->_getRepeatableFieldFlagTag($aFieldset);
            }
            if (!empty($aFieldset['sortable'])) {
                return $this->_getSortableFieldFlagTag($aFieldset);
            }
            return '';
        }
        private function _getRepeatableFieldFlagTag($aFieldset) {
            return $this->getHTMLTag('input', array('type' => 'hidden', 'name' => '__repeatable_elements_' . $aFieldset['_structure_type'] . '[' . $aFieldset['_field_address'] . ']', 'class' => 'element-address', 'value' => $aFieldset['_field_address'], 'data-field_address_model' => $aFieldset['_field_address_model'],));
        }
        private function _getSortableFieldFlagTag($aFieldset) {
            return $this->getHTMLTag('input', array('type' => 'hidden', 'name' => '__sortable_elements_' . $aFieldset['_structure_type'] . '[' . $aFieldset['_field_address'] . ']', 'class' => 'element-address', 'value' => $aFieldset['_field_address'], 'data-field_address_model' => $aFieldset['_field_address_model'],));
        }
        private function _getFieldScripts($aField, $iFieldsCount) {
            $_aOutput = array();
            $_aOutput[] = !empty($aField['repeatable']) ? $this->_getRepeaterFieldEnablerScript('fields-' . $aField['tag_id'], $iFieldsCount, $aField['repeatable']) : '';
            $_aOutput[] = !empty($aField['sortable']) && ($iFieldsCount > 1 || !empty($aField['repeatable'])) ? $this->_getSortableFieldEnablerScript('fields-' . $aField['tag_id']) : '';
            return implode(PHP_EOL, $_aOutput);
        }
    }
    