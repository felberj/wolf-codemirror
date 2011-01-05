<?php
header('Content-Type: application/x-javascript');
$pluginDir = dirname($_SERVER['PHP_SELF']).'/codemirror';
?>

var cmDir = "<?php echo $pluginDir; ?>";
var cmEditor = {};

var CodeMirrorConfig = {	
	tabMode: 'spaces',
	lineNumbers: true,	
	textWrapping: false,
	path: cmDir + "/js/"	
};

var dummyParser = {
	parserfile: ["parsedummy.js"]
	//stylesheet: [cmDir + "/css/dummy.css"]
};	

var htmlxmlParser = {
	parserfile: ["parsexml.js"],
	stylesheet: [cmDir + "/css/xmlcolors.css"]
};

var cssParser = {
	parserfile: ["parsecss.js"],
	stylesheet: [cmDir + "/css/csscolors.css"]
};	
	
var jsParser = {
	parserfile: ["tokenizejavascript.js", "parsejavascript.js"],
	stylesheet: [cmDir + "/css/jscolors.css"]
};	

var htmlmixedParser = {
	parserfile: ["parsehtmlmixed.js"]
};
	
var htmlphpmixedParser = {
	parserfile: [
		"../contrib/php/js/tokenizephp.js",
		"../contrib/php/js/parsephp.js",
		"../contrib/php/js/parsephphtmlmixed.js"
	],
	stylesheet: [cmDir + "/contrib/php/css/phpcolors.css"]
};
	
function _mixandbake() {
	var target = {parserfile:[],stylesheet:[]}, options, context;
	
	for ( var i = 0; i < arguments.length; i++ )
	{
		if ( (options = arguments[i]) != null )
		{
			for ( var name in options )
			{
				context = options[name];
					
				if (Object.prototype.toString.call(context) === "[object Array]")
				{						
					for (var val in context)
					{						
						target[name].push(context[val]);
					}
				}
				else
				{
					target[name] = context;
				}
			}
		}
	}
		
	return target;
}

var defaultCfg = _mixandbake(dummyParser, htmlxmlParser, cssParser, jsParser, htmlmixedParser, htmlphpmixedParser);

// @todo check codemirror instance not getting bound twice
function setCM(el,modeParser){
	if (typeof cmEditor[el] !== 'undefined') return false; 
	
	var cmMode = defaultCfg;
		
	if (modeParser != null) { cmMode = modeParser; }
	
	cmEditor[el] = CodeMirror.fromTextArea(el, _mixandbake(cmMode, {content:$("#"+el).val()}));
}

function resetCM(el,stay){
	if (typeof cmEditor[el] !== 'undefined'){		
		$("#"+el).html(cmEditor[el].getCode());
		cmEditor[el].toTextArea();
		delete cmEditor[el];
		
		// switcher
		if (stay != null) return false;
		var cmSwitch = "codemirror-" + el;
		$("label[for="+cmSwitch+"]").remove();
		$("#"+cmSwitch).remove();

	}
}

function setSwitcher(target,id){	
	var cmSwitch = 'codemirror-' + id;
	
	if ($("#"+cmSwitch).length > 0) return false;
	
	var el = '<label for="'+cmSwitch+'" style="margin: 0 4px 0 50px;">Highlight</label>'+
		'<select id="'+cmSwitch+'">'+
		'<option value="dummyParser">&#8212; none &#8212;</option>'+				
		'<option value="cssParser">CSS</option>'+
		'<option value="jsParser">Javascript</option>'+				
		'<option value="htmlmixedParser">HTML mixed-mode</option>'+
		'<option value="htmlphpmixedParser" selected="selected">HTML+PHP mixed-mode</option>'+				
		'</select>';
	
	target.parent().append(el);
		
	$("#"+cmSwitch).change(function(){
		var cmParser = defaultCfg;
		switch ($(this).val())
		{
			case "dummyParser":				
				cmParser = dummyParser;
			break;
			
			case "cssParser":
				cmParser = cssParser;
			break;
			
			case "jsParser":
				cmParser = jsParser;
			break;
			
			case "htmlmixedParser":
				cmParser = _mixandbake(htmlxmlParser,cssParser,jsParser,htmlmixedParser);
			break;
		}
		
		resetCM(id,true);
		setCM(id,cmParser);
	});
}

// @todo what should I do if other plugin set this function first ?
// hope next wolfcms release will remove this function
if(typeof window.setTextAreaToolbar !== 'function') {
	function setTextAreaToolbar(el,filter){
		resetCM(el);
		if (filter === 'codemirror') {			
			setCM(el);
			setSwitcher($("#snippet_filter_id"),el);
		}
	}
}

$(function(){
	if ($("#layout_content").length > 0) setCM("layout_content");

    $('.filter-selector').bind('wolfSwitchFilterOut', function(event, filtername, elem) {
        if (filtername == 'codemirror') {			
			resetCM(elem.attr('id'));
		}
    });
    
    $('.filter-selector').bind('wolfSwitchFilterIn', function(event, filtername, elem) {
        if (filtername == 'codemirror') {
			var el = elem.attr('id');			
			setCM(el);
			setSwitcher($(this), el);
        }
    });	
});