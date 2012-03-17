<?php if (!defined('IN_CMS')) { exit(); }

/**
 * CodeMirror plugin for wolfcms
 *
 * @package Plugins
 * @subpackage codemirror
 *
 * @author Devi Mandiri<devi[dot]mandiri[at]gmail[dot]com>
 * @license UNLICENSE - http://unlicense.org
 */
 
Plugin::setInfos(array(
    'id'          => 'codemirror',
    'title'       => __('CodeMirror syntax highlighter'),
    'description' => __('Provides syntax highlighter using CodeMirror for backend.'),
    'version'     => '1.0.3',
    'website'     => 'http://devi.web.id',
    'update_url'  => 'http://devi.web.id/wolf-plugin-versions.xml',
    'require_wolf_version' => '0.7.5'
));

Filter::add('codemirror', 'codemirror/filter_codemirror.php');
Plugin::addController('codemirror', 'codemirror', 'administrator,developer', false);

// compression using https://github.com/mishoo/UglifyJS
// codemirror.js, xml.js, javascript.js, css.js, htmlmixed.js,  clike.js, php,js, markdown.js
Plugin::addJavascript('codemirror', 'assets/js/codemirror-bundled.js');

Plugin::addJavascript('codemirror', 'assets/js/codemirror-ui.min.js');

Plugin::addJavascript('codemirror','codemirror.php');

