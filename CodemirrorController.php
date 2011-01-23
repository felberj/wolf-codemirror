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
 
class CodemirrorController extends PluginController {

    public function __construct() {
		parent::__construct();
        $this->setLayout('backend');
        $this->assignToLayout('sidebar', new View('../../plugins/codemirror/views/sidebar'));
    }

    public function index() {
		$this->settings();
    }

    public function settings() {
        $this->display('codemirror/views/settings', Plugin::getAllSettings('codemirror'));
    }
    
    public function save()
    {
        if (!array_key_exists('cmintegrate', $_POST))
			$cmintegrate = '0';
		else
			$cmintegrate = '1';            
            
		$settings = array('file_manager' => $cmintegrate);
		if (Plugin::setAllSettings($settings, 'codemirror'))
			Flash::set('success', 'CodeMirror - '.__('plugin settings saved.'));
		else
			Flash::set('error', 'CodeMirror - '.__('plugin settings not saved!'));
		
		redirect(get_url('plugin/codemirror/settings'));        
	}
	
	public function cm_integrate()
	{
		if (Plugin::getSetting('file_manager','codemirror') === '1')
		{
			echo '1';
		} else {
			echo '0';
		}
	}

}
