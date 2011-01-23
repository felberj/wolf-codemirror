<?php if (!defined('IN_CMS')) { exit(); }

$settings = Plugin::getAllSettings('codemirror');

$settings = array(
	'file_manager' => isset($settings['file_manager']) ? $settings['file_manager'] : '0',
	);

Plugin::setAllSettings($settings, 'codemirror');
