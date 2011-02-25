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
    'version'     => '1.0.2',
    'website'     => 'http://devi.web.id',
    'update_url'  => 'http://devi.web.id/wolf-plugin-versions.xml',
    'require_wolf_version' => '0.7.3'
));

Filter::add('codemirror', 'codemirror/filter_codemirror.php');
Plugin::addController('codemirror', 'codemirror', 'administrator,developer', false);
Plugin::addJavascript('codemirror','codemirror.php');
Plugin::addJavascript('codemirror', 'codemirror/lib/codemirror.js');
Plugin::addJavascript('codemirror', 'codemirror/mode/null/null.js');
Plugin::addJavascript('codemirror', 'codemirror/mode/xml/xml.js');
Plugin::addJavascript('codemirror', 'codemirror/mode/javascript/javascript.js');
Plugin::addJavascript('codemirror', 'codemirror/mode/css/css.js');
Plugin::addJavascript('codemirror', 'codemirror/mode/htmlmixed/htmlmixed.js');
Plugin::addJavascript('codemirror', 'codemirror/mode/clike/clike.js');
Plugin::addJavascript('codemirror', 'codemirror/mode/php/php.js');
