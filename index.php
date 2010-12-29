<?php
/* Security measure */
if (!defined('IN_CMS')) { exit(); }

/**
 * CodeMirror plugin for wolfcms
 *
 * @package plugins
 * @subpackage editor
 *
 * @author Devi Mandiri<devi[dot]mandiri[at]gmail[dot]com>
 * @copyright 2010 Devi Mandiri http://devi.web.id/
 * @license MIT License
 */
Plugin::setInfos(array(
    'id'          => 'codemirror',
    'title'       => __('CodeMirror syntax highlighter'),
    'description' => __('Syntax highlighter using CodeMirror (layouts and snippets only).'),
    'version'     => '1.0.0', 
    'website'     => 'http://devi.web.id',
    'update_url'  => 'http://devi.web.id/wolf-plugin-versions.xml',
    'require_wolf_version' => '0.7.0'
));

Filter::add('codemirror', 'codemirror/filter_codemirror.php');

Plugin::addJavascript('codemirror', 'codemirror/js/codemirror.js');
Plugin::addJavascript('codemirror','codemirror.php');