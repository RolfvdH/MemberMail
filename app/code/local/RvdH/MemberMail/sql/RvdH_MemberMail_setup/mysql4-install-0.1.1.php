<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$entityTypeId     = $setup->getEntityTypeId('customer');
$attributeSetId   = $setup->getDefaultAttributeSetId($entityTypeId);
$attributeGroupId = $setup->getDefaultAttributeGroupId($entityTypeId, $attributeSetId);

$dateFormatIso=Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);  
$setup->addAttribute('customer', 'membermail_date', array(
    'input'         => 'date',
    'type'          => 'datetime',
    'time'          => false,
    'format'        => $dateFormatIso,
    'input_format'  => Varien_Date::DATE_INTERNAL_FORMAT,
    'label'         => Mage::helper('core')->__('Date of membership'),
    'visible'       => 1,
    'required'      => 0,
    'user_defined' => 1,
    'note'      => Mage::helper('core')->__('Use format dd-mm-yy'),
));

$setup->addAttributeToGroup(
    $entityTypeId,
    $attributeSetId,
    $attributeGroupId,
    'membermail_date',
    '999'  //sort_order
);

$oAttribute = Mage::getSingleton('eav/config')->getAttribute('customer', 'membermail_date');
$oAttribute->setData('used_in_forms', array('adminhtml_customer'));
$oAttribute->save();

$setup->endSetup();
