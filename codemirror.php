<?php
header('Content-Type: application/x-javascript');
$pluginDir = dirname($_SERVER['PHP_SELF']).'/codemirror/';
?>

function addCss(css){
	var style = document.createElement('link');
		style.rel = 'stylesheet';
		style.type  = "text/css";
		style.href   = css;
	document.getElementsByTagName('head')[0].appendChild(style);
};

var cmEditor = {};

function setCM(el){
	if (typeof cmEditor[el] !== 'undefined') return false; 

	cmEditor[el] = CodeMirror.fromTextArea(
		document.getElementById(el), {
			mode: 'text/html',
			lineNumbers: true
		});
};

// doesn't work (yet)
function resetCM(el){
	if (typeof cmEditor[el] !== 'undefined'){
		//$("#"+el).html(cmEditor[el].getValue());
		cmEditor[el].toTextArea();
		delete cmEditor[el];
	}
};

$(function(){

	var css = ['lib/codemirror.css','mode/xml/xml.css','mode/javascript/javascript.css','mode/css/css.css'];

	for ( var i = 0; i < css.length; i++ )
		addCss('<?php echo $pluginDir; ?>' + css[i]);

	addCss('<?php echo dirname($_SERVER['PHP_SELF']); ?>/codemirror2.css');

	if ($("#layout_content").length > 0) setCM("layout_content");

	$('.filter-selector').live('wolfSwitchFilterOut', function(event, filtername, elem) {
		if (filtername == 'codemirror') resetCM(elem.attr('id'));
	});

	$('.filter-selector').live('wolfSwitchFilterIn', function(event, filtername, elem) {
		if (filtername == 'codemirror') setCM(elem.attr('id'));
	});

	if ($("#file_content").length > 0){
		var cm_url = $("#file_manager-plugin a").attr("href");
		var cm_idx = cm_url.indexOf("file_manager");
		var cm_url = cm_url.substr(0, cm_idx) + "codemirror/cm_integrate";
		$.get(cm_url, function(data){
			if (data === "1") {
				setCM("file_content");
			}
		});
	}

});
