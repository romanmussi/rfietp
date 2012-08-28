/*
 * ActiveSpell
 * Copyright (C) 2006 ActiveCampaign, Inc.
 *
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 * 
 * About:
 *		General Information: http://www.activecampaign.com/activespell
 * 		Forum: http://www.activecampaign.com/support/forum/forumdisplay.php?f=40
 *		ActiveSpell 1.0 was based on ajax-spell (http://www.broken-notebook.com/spell_checker)
 * Editado por Pablo Alpha
 */
 
var cp = new cpaint();
cp.set_transfer_mode('post');
cp.set_response_type('text');
//cp.set_debug(1);

var currObj; //the current spell checker being used
var spellingSuggestionsDiv = null;  // Auto-generated suggestions div


/*
 * Cross-browser attempt at supporting the regular function,
 * document.getElementById().  That function is a DOM-2 level function,
 * which is something that IE -- even at version 6 -- does not yet fully
 * support.
 */

function get_id(id) {
    if (document.getElementById)
        return document.getElementById(id);
    else
        return document.all[id];        /* probably IE */
}

// If there are already any onclick handlers loaded in the page, we'll add
// our onclick handler first and then call the old one, rather than completely
// overriding it.  The checkClickLocation is used to hide the suggestions div
// when the user clicks outside it.
if(document.onclick)
{
	var old_onclick = document.onclick;
	document.onclick = function(e)
	{
		checkClickLocation(e);
		old_onclick(e);
	}
}
else
{
	document.onclick = checkClickLocation;
}


// If there are already any onload handlers loaded in the page, we'll add our onload
// handler first and then call the old one, rather than completely overriding it.
if(window.onload)
{
	var old_onload = window.onload;
	window.onload = function(e)
	{            
		setupSpellCheckers(e);
		old_onload(e);
	}
}
else
{
	window.onload = setupSpellCheckers;
}



/*************************************************************
 * function setupSpellCheckers()
 *
 * This function goes through the page and finds all the 
 * textareas.  It then checks the title attribute for either
 * spellcheck or spellcheck_icons to determine whether or not
 * it should add a spellchecker to that textarea.
 *************************************************************/
function setupSpellCheckers()
{
	var textareas = document.getElementsByTagName('input');
	var numSpellCheckers = 0;
	var tempSpellCheckers = Array();
        
	for(var i=0; i < textareas.length; i++)
	{ 
		if(textareas[i].getAttribute("type") == "text" && (textareas[i].getAttribute("title") == "spellcheck" || textareas[i].getAttribute("title") == "spellcheck_icons"))
		{
			tempSpellCheckers[numSpellCheckers] = textareas[i];
			
			//create a new spellchecker for this textarea
			var tempWidth = tempSpellCheckers[numSpellCheckers].offsetWidth + 'px';
			var tempHeight = tempSpellCheckers[numSpellCheckers].offsetHeight + 'px';
			eval('spellCheckers' + numSpellCheckers + '= new activeSpell("spellCheckers' + numSpellCheckers + '", tempWidth, tempHeight, tempSpellCheckers[' + numSpellCheckers + '].getAttribute("accesskey"), "spellCheckDiv' + numSpellCheckers + '", tempSpellCheckers[' + numSpellCheckers + '].getAttribute("name"), tempSpellCheckers[' + numSpellCheckers + '].id, tempSpellCheckers[' + numSpellCheckers + '].title, tempSpellCheckers[' + numSpellCheckers + '].value);');

                        // que chequée ortografia si contiene algun value inicial (edit)
                        if (textareas[i].getAttribute("value")) {
                             eval("setTimeout('setCurrentObject(spellCheckers" + numSpellCheckers + "); spellCheckers" + numSpellCheckers + ".spellCheck(); " +
                                  "',800*"+numSpellCheckers+");");
                             /*eval("setTimeout('if(jQuery(\"#spellCheckDiv" + numSpellCheckers +"\").find(\"img\").hasClass(\"js-correcto\")){ " +
                                  "spellCheckers" + numSpellCheckers  +".resumeEditing();" +
                                  "}" +
                                  "',1500*"+numSpellCheckers + 1 +");");*/
                        }

                        
			numSpellCheckers++;
		}
	}

	var textareas = document.getElementsByTagName('textarea');

	for(var i=0; i < textareas.length; i++)
	{ 
		if(textareas[i].getAttribute("title") == "spellcheck" || textareas[i].getAttribute("title") == "spellcheck_icons")
		{
			tempSpellCheckers[numSpellCheckers] = textareas[i];
			
			//create a new spellchecker for this textarea
			var tempWidth = tempSpellCheckers[numSpellCheckers].offsetWidth + 'px';
			var tempHeight = tempSpellCheckers[numSpellCheckers].offsetHeight + 'px';
			eval('spellCheckers' + numSpellCheckers + '= new activeSpell("spellCheckers' + numSpellCheckers + '", tempWidth, tempHeight, tempSpellCheckers[' + numSpellCheckers + '].getAttribute("accesskey"), "spellCheckDiv' + numSpellCheckers + '", tempSpellCheckers[' + numSpellCheckers + '].getAttribute("name"), tempSpellCheckers[' + numSpellCheckers + '].id, tempSpellCheckers[' + numSpellCheckers + '].title, tempSpellCheckers[' + numSpellCheckers + '].value);');

                        // que chequée ortografia si contiene algun value inicial (edit)
                        if (textareas[i].getAttribute("value")) {
                             eval("setTimeout('setCurrentObject(spellCheckers" + numSpellCheckers + "); spellCheckers" + numSpellCheckers + ".spellCheck();', 800*"+numSpellCheckers+");");
                             /*eval("setTimeout('if(jQuery(\"#spellCheckDiv" + numSpellCheckers +"\").find(\"img\").hasClass(\"js-correcto\")){ " +
                                  "spellCheckers" + numSpellCheckers  +".resumeEditing();" +
                                  "}" +
                                  "',1500*"+numSpellCheckers + 1 +");");*/
                        }
                        
			numSpellCheckers++;
		}
	}
	
}; // end setInit


/*************************************************************
 * activeSpell(varName, width, height, spellUrl, divId, name, id)
 *
 * This is the constructor that creates a new activeSpell object.
 * All of it is dynamically generated so the user doesn't have
 * to add a bunch of crap to their site.
 *
 * @param varName The name of the variable that the object is
 *                assigned to (must be unique and the same as the variable)
 * @param width The width of the spell checker
 * @param height The height of the spell checker
 * @param spellUrl The url of the spell_checker.php code
 * @param divId The id of the div that the spell checker is 
 *              contained in (must be unique)
 * @param name The name of the textarea form element
 * @param id The id of the spell checker textarea (must be unique)
 *************************************************************/
function activeSpell(varName, width, height, spellUrl, divId, name, id, title, value)
{
	currObj = this;

	currObj.config               = new Array();         //the array of configuration options
	currObj.config['varName']    = varName;             //the name of the variable that this instance is stored in
	currObj.config['width']      = width;               //the width of the textarea
	currObj.config['height']     = height;              //the height of the textarea
	currObj.config['spellUrl']   = spellUrl;            //url to spell checker php code (spell_checker.php by default);
	currObj.config['divId']      = divId;               //the id of the div that the spell checker element is in
	currObj.config['name']       = name;                //what you want the form element's name to be
	currObj.config['id']         = id;                  //the unique id of the spell_checker textarea
	currObj.config['title']      = title;               //the title (specifies whether to use icons or not);
	currObj.config['value']      = value;               //the value of the text box when the page was loaded

	currObj.config['imagePath'] = spellUrl.substring(0, spellUrl.lastIndexOf("/")+1);
	
	currObj.config['value']      = currObj.config['value'].replace(/<br *\/?>/gi, "\n");
	
	currObj.config['useIcons'] = false;
	
	if(currObj.config['title'] == "spellcheck_icons")
	{
		currObj.config['useIcons'] = true;
	}
	
	spellContainer = document.createElement('DIV');
	spellContainer.id = currObj.config['divId'];
	spellContainer.className = 'spell_container';
	spellContainer.style.width = currObj.config['width'];

	oldElement = document.getElementById(currObj.config['id']);

	oldElement.parentNode.replaceChild(spellContainer, oldElement);
	
	//generate the div to hold the spell checker controls
	currObj.controlPanelDiv = document.createElement('DIV');
	currObj.controlPanelDiv.className = 'control_panel';
	document.getElementById(currObj.config['divId']).appendChild(currObj.controlPanelDiv);

	//the span that toggles between spell checking and editing
	currObj.actionSpan = document.createElement('SPAN');
	currObj.actionSpan.className = "action";
	currObj.actionSpan.id = "action";
	if(currObj.config['useIcons'])
	{
		currObj.actionSpan.innerHTML = "<a class=\"check_spelling\" onclick=\"setCurrentObject(" + currObj.config['varName'] + "); " + currObj.config['varName'] + ".spellCheck();\"><img src=\"" + currObj.config['imagePath'] + "images/spellcheck.png\" width=\"16\" height=\"16\" title=\"Corregir ortografía\" alt=\"Corregir ortografía\" border=\"0\" /></a>";
	}
	else
	{
		currObj.actionSpan.innerHTML = "<a class=\"check_spelling\" onclick=\"setCurrentObject(" + currObj.config['varName'] + "); " + currObj.config['varName'] + ".spellCheck();\">Corregir ortografía</a>";
	}
	currObj.controlPanelDiv.appendChild(currObj.actionSpan);

	//the span that lets the user know of the status of the spell checker
	currObj.statusSpan = document.createElement('SPAN');
	currObj.statusSpan.className = "status";
	currObj.statusSpan.id = "status";
	currObj.statusSpan.innerHTML = "";
	currObj.controlPanelDiv.appendChild(currObj.statusSpan);
	
	//the textarea to be spell checked
	oldElement.value = currObj.config['value'];
	document.getElementById(currObj.config['divId']).appendChild(oldElement);

        // que chequée ortografia al dejar el campo
        document.getElementById(currObj.config['id']).setAttribute("onBlur", "setCurrentObject(" + currObj.config['varName'] + "); " + currObj.config['varName'] + ".spellCheck();");
        /*jQuery('#'+currObj.config['id']).focusout(function() {
            eval("setCurrentObject(" + currObj.config['varName'] + "); " + currObj.config['varName'] + ".spellCheck();");
        });*/

        /*var inputs = document.getElementsByTagName('input');
        for(var i=0; i < inputs.length; i++)	{
            if(inputs[i].getAttribute("title") != "spellcheck" && inputs[i].getAttribute("title") != "spellcheck_icons") {
                inputs[i].setAttribute("onFocus", "setCurrentObject(" + currObj.config['varName'] + "); " + currObj.config['varName'] + ".resumeEditing();");
            }
        }*/
	
	currObj.objToCheck              = document.getElementById(currObj.config['id']);      //the actual object we're spell checking
	currObj.spellingResultsDiv      = null;                                               // Auto-generated results div

        // prototypes for the activeSpell objects
	activeSpell.prototype.spellCheck           = spellCheck;
	activeSpell.prototype.spellCheck_cb        = spellCheck_cb;
	activeSpell.prototype.showSuggestions      = showSuggestions;
	activeSpell.prototype.showSuggestions_cb   = showSuggestions_cb;
	activeSpell.prototype.replaceWord          = replaceWord;
	activeSpell.prototype.switchText           = switchText;
	activeSpell.prototype.switchText_cb        = switchText_cb;
        activeSpell.prototype.switchTextNoResume   = switchTextNoResume;
	activeSpell.prototype.switchTextNoResume_cb= switchTextNoResume_cb;
	activeSpell.prototype.resumeEditing        = resumeEditing;
	activeSpell.prototype.resetSpellChecker    = resetSpellChecker;
	activeSpell.prototype.resetAction          = resetAction;
}; // end activeSpell


/*************************************************************
 * setCurrentObject
 *
 * This sets the current object to be the spell checker that
 * the user is currently using.
 *
 * @param obj The spell checker currently being used
 *************************************************************/
function setCurrentObject(obj)
{
	currObj = obj;
}; // end setCurrentObject


/*************************************************************
 * spellCheck_cb
 *
 * This is the callback function that the spellCheck php function
 * returns the spell checked data to.  It sets the results div
 * to contain the markedup misspelled data and changes the status
 * message.  It also sets the width and height of the results
 * div to match the element that's being checked.
 * If there are no misspellings then new_data is the empty 
 * string and the status is set to "Todo correcto".
 *
 * @param new_data The marked up misspelled data returned from php.
 *************************************************************/
function spellCheck_cb(new_data)
{
	with(currObj);
	new_data = new_data.toString();
	var isThereAMisspelling = new_data.charAt(0);
	new_data = new_data.substring(1);
		
	if(currObj.spellingResultsDiv)
	{
		currObj.spellingResultsDiv.parentNode.removeChild(spellingResultsDiv);
	}
	
	currObj.spellingResultsDiv = document.createElement('DIV');
	currObj.spellingResultsDiv.className = 'edit_box';
	currObj.spellingResultsDiv.style.width = currObj.objToCheck.style.width;
	currObj.spellingResultsDiv.style.height = currObj.objToCheck.style.height;
	currObj.spellingResultsDiv.innerHTML = new_data;
	
	currObj.objToCheck.style.display = "none";
	currObj.objToCheck.parentNode.insertBefore(currObj.spellingResultsDiv,currObj.objToCheck);
	currObj.statusSpan.innerHTML = "";
	
	if(currObj.config['useIcons'])
	{
		currObj.actionSpan.innerHTML = "<a class=\"resume_editing\" onclick=\"setCurrentObject(" + currObj.config['varName'] + "); " + currObj.config['varName'] + ".resumeEditing();\"><img src=\"" + currObj.config['imagePath'] + "images/page_white_edit.png\" width=\"16\" height=\"16\" title=\"Continuar escribiendo\" alt=\"Continuar escribiendo\" border=\"0\" /></a>";
	}
	else
	{
		currObj.actionSpan.innerHTML = "<a class=\"resume_editing\" onclick=\"setCurrentObject(" + currObj.config['varName'] + "); " + currObj.config['varName'] + ".resumeEditing();\">Continuar escribiendo</a>";
	}
		
	if(isThereAMisspelling != "1")
	{
		if(currObj.config['useIcons'])
		{
			currObj.statusSpan.innerHTML = "<img src=\"" + currObj.config['imagePath'] + "images/accept.png\" width=\"16\" height=\"16\" class=\"js-correcto\" title=\"Todo correcto\" alt=\"Todo correcto\" border=\"0\" />";
		}
		else
		{
			currObj.statusSpan.innerHTML = "Todo correcto";
		}
		currObj.objToCheck.disabled = false;
	}
	
}; // end spellCheck_cb


/*************************************************************
 * spellCheck()
 *
 * The spellCheck javascript function sends the text entered by
 * the user in the text box to php to be spell checked.  It also
 * sets the status message to "Checking..." because it's currently
 * checking the spelling.
 *************************************************************/
function spellCheck() {
	with(currObj);
	var query;
	
	if(currObj.spellingResultsDiv)
	{
		currObj.spellingResultsDiv.parentNode.removeChild(currObj.spellingResultsDiv);
		currObj.spellingResultsDiv = null;
	}
	
	if(currObj.config['useIcons'])
	{
		currObj.actionSpan.innerHTML = "<img src=\"" + currObj.config['imagePath'] + "images/spellcheck.png\" width=\"16\" height=\"16\" title=\"Corregir ortografía\" alt=\"Corregir ortografía\" border=\"0\" />";
	}
	else
	{
		currObj.actionSpan.innerHTML = "<a class=\"check_spelling\">Corregir ortografía</a>";
	}
	
	if(currObj.config['useIcons'])
	{
		currObj.statusSpan.innerHTML = "<img src=\"" + currObj.config['imagePath'] + "images/working.gif\" width=\"16\" height=\"16\" title=\"Checking...\" alt=\"Checking...\" border=\"0\" />";
	}
	else
	{
		currObj.statusSpan.innerHTML = "Checking...";
	}
	query = currObj.objToCheck.value;
        
	query = query.replace(/\r?\n/gi, "<br />");
	
	cp.call(currObj.config['spellUrl'], 'spellCheck', spellCheck_cb, query, currObj.config['varName']);

}; // end spellcheck



/*************************************************************
 * addWord
 *
 * The addWord function adds a word to the custom dictionary
 * file.
 *
 * @param id The id of the span that contains the word to be added
 *************************************************************/
function addWord(id)
{
	//var wordToAdd = document.getElementById(id).innerHTML;
	
	with(currObj);
	
	if(spellingSuggestionsDiv)
	{
		spellingSuggestionsDiv.parentNode.removeChild(spellingSuggestionsDiv);
		spellingSuggestionsDiv = null;
	}
	
	if(currObj.config['useIcons'])
	{
		currObj.statusSpan.innerHTML = "<img src=\"" + currObj.config['imagePath'] + "images/working.gif\" width=\"16\" height=\"16\" title=\"Adding Word...\" alt=\"Adding Word...\" border=\"0\" />";
	}
	else
	{
		currObj.statusSpan.innerHTML = "Adding Word...";
	}
	
	cp.call(currObj.config['spellUrl'], 'addWord', addWord_cb, wordToAdd);

}; // end addWord

/*************************************************************
 * addWord_cb
 *
 * The addWord_cb function is a callback function that
 * PHP's addWord function returns to.  It recieves the
 * return status of the add to word to personal dictionary call.
 * It hides the status item.
 *
 * @param returnedData The return code from PHP.
 *************************************************************/
function addWord_cb(returnedData)
{
	alert(returnedData);
	with(currObj);
	currObj.statusSpan.innerHTML = "";
	resumeEditing();
	spellCheck();
}; // end addWord_cb



/*************************************************************
 * checkClickLocation(e)
 *
 * This function is called by the event listener when the user
 * clicks on anything.  It is used to close the suggestion div
 * if the user clicks anywhere that's not inside the suggestion
 * div.  It just checks to see if the name of what the user clicks
 * on is not "suggestions" then hides the div if it's not.
 *
 * @param e The event, in this case the user clicking somewhere on
 *          the page.
 *************************************************************/
function checkClickLocation(e)
{
	if(spellingSuggestionsDiv)
	{
		// Bah.  There's got to be a better way to deal with this, but the click
		// on a word to get suggestions starts up a race condition between
		// showing and hiding the suggestion box, so we'll ignore the first
		// click.
		if(spellingSuggestionsDiv.ignoreNextClick){
			spellingSuggestionsDiv.ignoreNextClick = false;
		}
		else
		{
			var theTarget = getTarget(e);
			
			if(theTarget != spellingSuggestionsDiv)
			{
				spellingSuggestionsDiv.parentNode.removeChild(spellingSuggestionsDiv);
				spellingSuggestionsDiv = null;
			}
		}
	}
	
	return true; // Allow other handlers to continue.
}; //end checkClickLocation


/*************************************************************
 * getTarget
 *
 * The get target function gets the correct target of the event.
 * This function is required because IE handles the events in
 * a different (wrong) manner than the rest of the browsers.
 *
 * @param e The target, in this case the user clicking somewhere on
 *     the page.
 *
 *************************************************************/
function getTarget(e)
{
	var value;
	if(checkBrowser() == "ie")
	{
		value = window.event.srcElement;
	}
	else
	{
		value = e.target;
	}
	return value;
}; //end getTarget


/*************************************************************
 * checkBrowser()
 *
 * The checkBrowser function simply checks to see what browser
 * the user is using and returns a string containing the browser
 * type.
 *
 * @return string The browser type
 *************************************************************/
function checkBrowser()
{
	var theAgent = navigator.userAgent.toLowerCase();
	if(theAgent.indexOf("msie") != -1)
	{
		if(theAgent.indexOf("opera") != -1)
		{
			return "opera";
		}
		else
		{
			return "ie";
		}
	}
	else if(theAgent.indexOf("netscape") != -1)
	{
		return "netscape";
	}
	else if(theAgent.indexOf("firefox") != -1)
	{
		return "firefox";
	}
	else if(theAgent.indexOf("mozilla/5.0") != -1)
	{
		return "mozilla";
	}
	else if(theAgent.indexOf("\/") != -1)
	{
		if(theAgent.substr(0,theAgent.indexOf('\/')) != 'mozilla')
		{
			return navigator.userAgent.substr(0,theAgent.indexOf('\/'));
		}
		else
		{
			return "netscape";
		} 
	}
	else if(theAgent.indexOf(' ') != -1)
	{
		return navigator.userAgent.substr(0,theAgent.indexOf(' '));
	}
	else
	{ 
		return navigator.userAgent;
	}
}; // end checkBrowser


/*************************************************************
 * showSuggestions_cb
 *
 * The showSuggestions_cb function is a callback function that
 * php's showSuggestions function returns to.  It sets the 
 * suggestions table to contain the new data and then displays
 * the suggestions div.  It also clears the status message.
 *
 * @param new_data The suggestions table returned from php.
 *************************************************************/
function showSuggestions_cb(new_data)
{
	with(currObj);
	spellingSuggestionsDiv.innerHTML = new_data;
	spellingSuggestionsDiv.style.display = 'block';
	currObj.statusSpan.innerHTML = "";
}; //end showSuggestions_cb


/*************************************************************
 * showSuggestions
 *
 * The showSuggestions function calls the showSuggestions php
 * function to get suggestions for the misspelled word that the
 * user has clicked on.  It sets the status to "Searching...",
 * hides the suggestions div, finds the x and y position of the
 * span containing the misspelled word that user clicked on so 
 * the div can be displayed in the correct location, and then
 * calls the showSuggestions php function with the misspelled word
 * and the id of the span containing it.
 *
 * @param word The misspelled word that the user clicked on
 * @param id The id of the span that contains the misspelled word
 *************************************************************/
function showSuggestions(word, id)
{
	with(currObj);
	if(currObj.config['useIcons'])
	{
		currObj.statusSpan.innerHTML = "<img src=\"" + currObj.config['imagePath'] + "images/working.gif\" width=\"16\" height=\"16\" title=\"Searching...\" alt=\"Searching...\" border=\"0\" />";
	}
	else
	{
		currObj.statusSpan.innerHTML = "Searching...";
	}
	var x = findPosXById(id);
	var y = findPosYById(id);
	
	var scrollPos = 0;
	if(checkBrowser() != "ie")
	{
		scrollPos = currObj.spellingResultsDiv.scrollTop;
	}

	if(spellingSuggestionsDiv)
	{
		spellingSuggestionsDiv.parentNode.removeChild(spellingSuggestionsDiv);
	}
	spellingSuggestionsDiv = document.createElement('DIV');
	spellingSuggestionsDiv.style.display = "none";
	spellingSuggestionsDiv.className = 'suggestion_box';
	spellingSuggestionsDiv.style.position = 'absolute';
	spellingSuggestionsDiv.style.left = x + 'px';
	spellingSuggestionsDiv.style.top = (y+16-scrollPos) + 'px';
	
	// Bah. There's got to be a better way to deal with this, but the click
	// on a word to get suggestions starts up a race condition between
	// showing and hiding the suggestion box, so we'll ignore the first
	// click.
	spellingSuggestionsDiv.ignoreNextClick = true;
	
	document.body.appendChild(spellingSuggestionsDiv);
	
	cp.call(currObj.config['spellUrl'], 'showSuggestions', showSuggestions_cb, word, id);
}; // end showSuggestions


/*************************************************************
 * replaceWord
 *
 * The replaceWord function takes the id of the misspelled word
 * that the user clicked on and replaces the innerHTML of that
 * span with the new word that the user selects from the suggestion
 * div.  It hides the suggestions div and changes the color of
 * the previously misspelled word to green to let the user know
 * it has been changed.  It then calls the switchText php function
 * with the innerHTML of the div to update the text of the text box.
 *
 * @param id The id of the span that contains the word to be replaced
 * @param newWord The word the user selected from the suggestions div
 *                to replace the misspelled word.
 *************************************************************/
function replaceWord(id, newWord)
{
        with(currObj);
	document.getElementById(id).innerHTML = trim(newWord);
	if(spellingSuggestionsDiv)
	{
		spellingSuggestionsDiv.parentNode.removeChild(spellingSuggestionsDiv);
		spellingSuggestionsDiv = null;
	}
	document.getElementById(id).className = "corrected_word";

        currObj.switchTextNoResume()
}; // end replaceWord


/*************************************************************
 * switchText
 *
 * The switchText function is a funtion is called when the user
 * clicks on Continuar escribiendo (or submits the form).  It calls the
 * php function to switchText and uncomments the html and replaces
 * breaks and everything.  Here all the breaks that the user has
 * typed are replaced with %u2026.  Firefox does this goofy thing
 * where it cleans up the display of your html, which adds in \n's
 * where you don't want them.  So I replace the user-entered returns
 * with something unique so that I can rip out all the breaks that
 * the browser might add and we don't want.
 *************************************************************/
function switchText()
{
	with(currObj);
        if (currObj.spellingResultsDiv) {
            var text = currObj.spellingResultsDiv.innerHTML;
            text = text.replace(/<br *\/?>/gi, "~~~");
            // Work around a cpaint/safari bug by prefixing an asterisk to the text so that the text is never completely empty
            text = '*' + text;
            
            cp.call(currObj.config['spellUrl'], 'switchText', switchText_cb, text);
        }
}; // end switchText


function switchTextNoResume()
{
	with(currObj);
        if (currObj.spellingResultsDiv) {
            var text = currObj.spellingResultsDiv.innerHTML;
            text = text.replace(/<br *\/?>/gi, "~~~");
            // Work around a cpaint/safari bug by prefixing an asterisk to the text so that the text is never completely empty
            text = '*' + text;
            
            cp.call(currObj.config['spellUrl'], 'switchText', switchTextNoResume_cb, text);
        }
}; // end switchTextNoResume


/*************************************************************
 * switchText_cb
 *
 * The switchText_cb function is a call back funtion that the
 * switchText php function returns to.  I replace all the %u2026's
 * with returns.  It then replaces the text in the text box with 
 * the corrected text from the div.
 *
 * @param new_string The corrected text from the div.
 *
 *************************************************************/
function switchText_cb(new_string)
{
	with(currObj);
	new_string = new_string.replace(/~~~/gi, "\n");

	// Remove the prefixed asterisk that was added in switchText().
	new_string = new_string.substr(1);
	currObj.objToCheck.style.display = "none";
	currObj.objToCheck.value = new_string;
	currObj.objToCheck.disabled = false;
	if(currObj.spellingResultsDiv)
	{
		currObj.spellingResultsDiv.parentNode.removeChild(currObj.spellingResultsDiv);
		currObj.spellingResultsDiv = null;
	}
	currObj.objToCheck.style.display = "block";
	currObj.resetAction();
}; // end switchText_cb

function switchTextNoResume_cb(new_string)
{
	with(currObj);
	new_string = new_string.replace(/~~~/gi, "\n");

	// Remove the prefixed asterisk that was added in switchTextNoResume().
	new_string = new_string.substr(1);
	currObj.objToCheck.style.display = "none";
	currObj.objToCheck.value = new_string;
}; // end switchTextNoResume_cb


/*************************************************************
 * resumeEditing
 *
 * The resumeEditing function is called when the user is in the
 * correction mode and wants to return to the editing mode.  It
 * hides the results div and the suggestions div, then enables
 * the text box and unhides the text box.  It also calls
 * resetAction() to reset the status message.
 *************************************************************/
function resumeEditing()
{
	with(currObj);
        if (currObj.spellingResultsDiv) {
            if(currObj.config['useIcons'])
            {
                    currObj.actionSpan.innerHTML = "<a class=\"resume_editing\"><img src=\"" + currObj.config['imagePath'] + "images/page_white_edit.png\" width=\"16\" height=\"16\" title=\"Continuar escribiendo\" alt=\"Continuar escribiendo\" border=\"0\" /></a>";
            }
            else
            {
                    currObj.actionSpan.innerHTML = "<a class=\"resume_editing\">Continuar escribiendo</a>";
            }
            if(currObj.config['useIcons'])
            {
                    currObj.statusSpan.innerHTML = "<img src=\"" + currObj.config['imagePath'] + "images/working.gif\" width=\"16\" height=\"16\" title=\"Working...\" alt=\"Working...\" border=\"0\" />";
            }
            else
            {
                    currObj.statusSpan.innerHTML = "Working...";
            }

            if(spellingSuggestionsDiv)
            {
                    spellingSuggestionsDiv.parentNode.removeChild(spellingSuggestionsDiv);
                    spellingSuggestionsDiv = null;
            }

            currObj.switchText();

        }
}; // end resumeEditing


/*************************************************************
 * resetAction
 *
 * The resetAction function just resets the status message to
 * the default action of "Check Spelling".
 *************************************************************/
function resetAction()
{
	with(currObj);
	if(currObj.config['useIcons'])
	{
		currObj.actionSpan.innerHTML = "<a class=\"check_spelling\" onclick=\"setCurrentObject(" + currObj.config['varName'] + "); " + currObj.config['varName'] + ".spellCheck();\"><img src=\"" + currObj.config['imagePath'] + "images/spellcheck.png\" width=\"16\" height=\"16\" title=\"Corregir ortografía\" alt=\"Corregir ortografía\" border=\"0\" /></a>";
	}
	else
	{
		currObj.actionSpan.innerHTML = "<a class=\"check_spelling\" onclick=\"setCurrentObject(" + currObj.config['varName'] + "); " + currObj.config['varName'] + ".spellCheck();\">Corregir ortografía</a>";
	}

	currObj.statusSpan.innerHTML = "";
}; // end resetAction


/*************************************************************
 * resetSpellChecker
 *
 * The resetSpellChecker function resets the entire spell checker
 * to the defaults.
 *************************************************************/
function resetSpellChecker()
{
	with(currObj);
	currObj.resetAction();
	
	currObj.objToCheck.value = "";
	currObj.objToCheck.style.display = "block";
	currObj.objToCheck.disabled = false;
	
	if(currObj.spellingResultsDiv)
	{
		currObj.spellingResultsDiv.parentNode.removeChild(currObj.spellingResultsDiv);
		currObj.spellingResultsDiv = null;
	}
	if(spellingSuggestionsDiv)
	{
		spellingSuggestionsDiv.parentNode.removeChild(spellingSuggestionsDiv);
		spellingSuggestionsDiv = null;
	}
	currObj.statusSpan.style.display = "none";
	
}; // end resetSpellChecker


/*************************************************************
 * findPosX
 *
 * The findPosX function just finds the X offset of the top left
 * corner of the object id it's given.
 *
 * @param object The id of the object that you want to find the 
 *               upper left X coordinate of.
 * @return int The X coordinate of the object
 *************************************************************/
function findPosXById(object)
{
	var curleft = 0;
	var obj = document.getElementById(object);
	if(obj.offsetParent)
	{
		while(obj.offsetParent)
		{
			curleft += obj.offsetLeft - obj.scrollLeft;
			obj = obj.offsetParent;
		}
	}
	else if(obj.x)
	{
		curleft += obj.x;
	}
	return curleft;
}; // end findPosX


/*************************************************************
 * findPosY
 *
 * The findPosY function just finds the Y offset of the top left
 * corner of the object id it's given.
 *
 * @param object The id of the object that you want to find the 
 *               upper left Y coordinate of.
 * @return int The Y coordinate of the object
 *************************************************************/
function findPosYById(object)
{
	var curtop = 0;var curtop = 0;
	var obj = document.getElementById(object);
	if(obj.offsetParent)
	{
		while(obj.offsetParent)
		{
			curtop += obj.offsetTop - obj.scrollTop;
			obj = obj.offsetParent;
		}
	}
	else if(obj.y)
	{
		curtop += obj.y;
	}
	return curtop;
}; // end findPosY


/*************************************************************
 * trim
 *
 * Trims white space from a string.
 *
 * @param s The string you want to trim.
 * @return string The trimmed string.
 *************************************************************/
function trim(s)
{
	while(s.substring(0,1) == ' ')
	{
    	s = s.substring(1,s.length);
	}
	while(s.substring(s.length-1,s.length) == ' ')
	{
    	s = s.substring(0,s.length-1);
	}
	return s;
}; // end trim
