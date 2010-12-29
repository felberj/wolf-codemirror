<?php 
$pluginDir = dirname($_SERVER['PHP_SELF']).'/codemirror/';
?>

// dummy
function setTextToolbarArea(){}

codemirrorSettings = {}

var cmEditor;

function setCodeMirror(el){	
	if (cmEditor != undefined) return false;
	cmEditor =  CodeMirror.fromTextArea(el, {
        height: "500px",
        lineNumbers: true,
        tabMode: 'spaces',
        textWrapping: false,
        path: "<?php echo $pluginDir; ?>js/",
        parserfile: [
			"parsexml.js",
			"parsecss.js",
			"tokenizejavascript.js",
			"parsejavascript.js",
			"../contrib/php/js/tokenizephp.js", 
			"../contrib/php/js/parsephp.js",
			"../contrib/php/js/parsephphtmlmixed.js"
		],
        stylesheet: [
			"<?php echo $pluginDir; ?>css/xmlcolors.css",
			"<?php echo $pluginDir; ?>css/jscolors.css",
			"<?php echo $pluginDir; ?>css/csscolors.css",
			"<?php echo $pluginDir; ?>contrib/php/css/phpcolors.css"
		],
        
        continuousScanning: 500        
	});
	
	$('.CodeMirror-wrapping').css({		
		'width':'auto',
		'margin':'1em 0 1.5em 0',
		'background': '#fff',
		'border':'1px solid #bbb'
	});
      
	$('.CodeMirror-line-numbers').css({
		'width': '2.2em',
		'color': '#aaa',
		'background-color': '#eee',
		'text-align': 'right',
		'padding-right': '.3em',
		'font-size': '10pt',		
		'padding-top': '.4em'
	});
	
	$('span.syntax-error').css({'background':'#fff'});
}
	
$(function(){
	if ($('#layout_content').length > 0) setCodeMirror('layout_content');
	if ($('#snippet_content').length > 0) {
		$('#snippet_content').parent().find('> p:has(select)').remove();
		setCodeMirror('snippet_content');		
	}
});