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

function setCM(el, modeParser){
	if (typeof cmEditor[el] !== 'undefined') return false; 

	var cmMode = 'htmlmixed';

	if (modeParser != null) { cmMode = modeParser; }

	cmEditor[el] = CodeMirror.fromTextArea(
		document.getElementById(el), {
			mode: cmMode,
			lineNumbers: true
		});
};

function resetCM(el,stay){
	if (typeof cmEditor[el] !== 'undefined'){
		cmEditor[el].toTextArea();
		delete cmEditor[el];
		
		// switcher
		if (stay != null) return false;
		var cmSwitch = "codemirror-" + el;
		$("label[for="+cmSwitch+"]").remove();
		$("#"+cmSwitch).remove();
	}
};

function setSwitcher(target,id){
	var cmSwitch = 'codemirror-' + id;

	if ($("#"+cmSwitch).length > 0) return false;

	var el = '<label for="'+cmSwitch+'" style="margin: 0 4px 0 50px;">Highlight</label>'+
		'<select id="'+cmSwitch+'">'+
		'<option value="javascript">Javascript</option>'+
		'<option value="xml">XML/HTML</option>'+
		'<option value="css">CSS</option>'+
		'<option value="htmlmixed" selected="selected">Mixed-mode HTML</option>'+
		'</select>';

	if (id === "file_content"){
		target.parent().prepend(el);
		$("label[for="+cmSwitch+"]").css({"margin-left":0});
	} else {
		target.parent().append(el);
	}

	$("#"+cmSwitch).change(function(){
		var cmParser = 'htmlmixed';
		switch ($(this).val())
		{
			case "css":
				cmParser = 'css';
			break;

			case "javascript":
				cmParser = 'javascript';
			break;

			case "xml":
				cmParser = 'xml';
			break;
		}

		resetCM(id,true);
		setCM(id,cmParser);
	});
}

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
		if (filtername == 'codemirror') {
			setCM(elem.attr('id'));
			setSwitcher($(this), elem.attr('id'));
		}
	});

	if ($("#file_content").length > 0){
		var cm_url = $("#file_manager-plugin a").attr("href");
		var cm_idx = cm_url.indexOf("file_manager");
		var cm_url = cm_url.substr(0, cm_idx) + "codemirror/cm_integrate";
		$.get(cm_url, function(data){
			if (data === "1") {
				setCM("file_content");
				setSwitcher($("#file_content"),'file_content');
			}
		});
	}

});
