<?php
header('Content-Type: application/x-javascript');
?>

var cmEditor = {};

function setCM(el, modeParser){
	if (typeof cmEditor[el] !== 'undefined') return false; 

	var cmOption = {lineNumbers: true};

	if (modeParser != null) {
		switch (modeParser)
		{
			case "css":
				cmOption = {mode: "css", lineNumbers: true};
			break;

			case "javascript":
				cmOption = {mode: "javascript", lineNumbers: true};
			break;

			case "xml":
				cmOption = {mode: {name: "xml", alignCDATA: true}, lineNumbers: true};
			break;

			case "htmlmixed":
				cmOption = {mode: "text/html", lineNumbers: true, tabMode: "indent"};
			break;

			case "php":
				cmOption = {
					lineNumbers: true,
					matchBrackets: true,
					mode: "application/x-httpd-php",
					indentWithTabs: true
				};
			break;

			case "markdown":
				cmOption = {mode: 'markdown', lineNumbers: true, matchBrackets: true};
			break;
		}
	}

	var uiOptions = {
		path : <?php echo '"'.dirname($_SERVER["PHP_SELF"]).'/assets/js/",'; ?>
		searchMode: false,
		buttons : ['undo','redo','jump','reindent','about']
	}

	//cmEditor[el] = CodeMirror.fromTextArea(document.getElementById(el), cmOption);
	cmEditor[el] = new CodeMirrorUI(document.getElementById(el),uiOptions,cmOption);
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
		'<option value="htmlmixed">Mixed-mode HTML</option>'+
		'<option value="php" selected="selected">PHP</option>'+
		'<option value="markdown">Markdown</option>'+
		'</select>';

	if (id === "file_content"){
		target.parent().prepend(el);
		$("label[for="+cmSwitch+"]").css({"margin-left":0});
	} else {
		target.parent().append(el);
	}

	$("#"+cmSwitch).change(function(){
		resetCM(id,true);
		setCM(id,$(this).val());
	});
}

// backward
function setTextAreaToolbar(el,filter){
	resetCM(el);
	if (filter === 'codemirror') {
		setCM(el);
		setSwitcher($("#snippet_filter_id"),el);
	}
};

function addCss(css){
	var style = document.createElement('link');
		style.rel = 'stylesheet';
		style.type  = "text/css";
		style.href  = '<?php echo dirname($_SERVER["PHP_SELF"]); ?>/assets/css/'+css+'.css';
	document.getElementsByTagName('head')[0].appendChild(style);
};

$(function(){
	addCss("codemirror");
	addCss("codemirror-ui");

	if ($("#layout_content").length > 0) setCM("layout_content","php");

	$('.filter-selector').live('wolfSwitchFilterOut', function(event, filtername, elem) {
		if (filtername == 'codemirror') resetCM(elem.attr('id'));
	});

	$('.filter-selector').live('wolfSwitchFilterIn', function(event, filtername, elem) {
		if (filtername == 'codemirror') {
			setCM(elem.attr('id'), "php");
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
