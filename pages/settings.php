<?php
#
$addon = rex_addon::get('thumb');

$form = rex_config_form::factory($addon->name);

$field = $form->addInputField('text', 'hcti_api_key', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('thumb_config_hcti_api_key_label'));
$field->setNotice(rex_i18n::msg('thumb_config_hcti_api_key_notice'));

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $addon->i18n('thumb_config'), false);
$fragment->setVar('body', $form->get(), false);
echo $fragment->parse('core/page/section.php');
