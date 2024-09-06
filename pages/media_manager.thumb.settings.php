<?php
#
$addon = rex_addon::get('thumb');

$form = rex_config_form::factory($addon->name);

$field = $form->addSelectField('bestellung', $value = null, ['class'=>'form-control selectpicker']);
$field->setLabel("Anbieter");
$select = $field->getSelect();
$select->addOption('hc2i.io', 'hc2i');
$select->addOption('html2image.net', 'h2in');

$field = $form->addInputField('text', 'hcti_username', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('thumb_config_hcti_username_label'));
$field->setNotice(rex_i18n::msg('thumb_config_hcti_username_notice'));

$field = $form->addInputField('text', 'hcti_api_key', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('thumb_config_hcti_api_key_label'));
$field->setNotice(rex_i18n::msg('thumb_config_hcti_api_key_notice'));

$field = $form->addInputField('text', 'h2in_api_key', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('thumb_config_h2in_api_key_label'));
$field->setNotice(rex_i18n::msg('thumb_config_h2in_api_key_notice'));

$field = $form->addSelectField('media_manager_profile', $value = null, ['class'=>'form-control selectpicker']);
$field->setLabel(rex_i18n::msg('thumb_config_media_manager_profile_label'));
$field->setNotice(rex_i18n::msg('thumb_config_media_manager_profile_notice'));
$select = $field->getSelect();
// Get available media manager profiles
$query = 'SELECT id, status, name FROM ' . rex::getTablePrefix() . 'media_manager_type ORDER BY status, name';

$profiles = rex_sql::factory()->getArray($query);
foreach ($profiles as $profile) {
    $select->addOption($profile['name'], $profile['name']);
}

/* Select Fragment html.php or svg.php */
$field = $form->addSelectField('fragment', $value = null, ['class'=>'form-control']);
$field->setLabel(rex_i18n::msg('thumb_config_fragment_label'));
$select = $field->getSelect();
$select->addOption('thumb/html.php', 'thumb/html.php');
$select->addOption('thumb/svg.php', 'thumb/svg.php');


$field = $form->addMediaField('background_image');
$field->setPreview(1);
// Legt die erlaubten Typen fest
$field->setTypes('jpg,gif,png,svg');
$field->setLabel('Bild');


$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $addon->i18n('thumb_config'), false);
$fragment->setVar('body', $form->get(), false);
echo $fragment->parse('core/page/section.php');
