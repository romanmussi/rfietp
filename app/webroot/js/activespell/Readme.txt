

	
	,---.     |    o           ,---.          |    |    
	|---|,---.|--- ..    ,,---.`---.,---.,---.|    |    
	|   ||    |    | \  / |---'    ||   ||---'|    |    
	`   '`---'`---'`  `'  `---'`---'|---'`---'`---'`---'
	                                |                   

			ActiveSpell 1.0


---------------------------------------------------------------------------

1) Requirements
2) Installing
3) Sample Code
4) License & Credits


---------------------------------------------------------------------------
1 | Requirements
---------------------------------------------------------------------------

	PHP 4.3+
	PSPELL (ASPELL support built-in but not suggested)
	
---------------------------------------------------------------------------
2 | Installing
---------------------------------------------------------------------------

	Unzip all the contents to the same directory
	Chmod the personal_dictionary.txt file in the personal_dictionary 
		directory to 646.
	Include cpaint2.inc.compressed.js, spell_checker.js, 
		and spell_checker.css in the head of your page.

	The spell checker can be added to any text area on the page. 
	Just add the title attribute to your text area and make it equal 
	to either "spellcheck" or "spellcheck_icons". Set the accesskey 
	attribute equal to the location of the spell_checker.php file. 
	Make sure you include a width, a height, as well as a name and an 
	id. Name and id should be unique.

---------------------------------------------------------------------------
3 | Sample Code
---------------------------------------------------------------------------

	Sample Text Area:

	<textarea title="spellcheck_icons" accesskey="spell_checker.php" 
		id="spell_checker1" type="text" name="comment1" 
		style="width: 400px; height: 200px;">Text to spell check
		</textarea>


	Sample Full Page:

	<html>
  	 <head>
     	 <link rel="stylesheet" type="text/css" href="css/spell_checker.css">
     	 <script src="cpaint/cpaint2.inc.compressed.js" type="text/javascript"></script>
     	 <script src="js/spell_checker_compressed.js" type="text/javascript"></script>
  	 </head>
  	 <body>
     	 <form action="#">
		<textarea title="spellcheck_icons" accesskey="spell_checker.php" 
		id="spell_checker1" type="text" name="comment1" 
		style="width: 400px; height: 200px;">Text to spell check
		</textarea>
     	 </form>
   	</body>
	</html>

---------------------------------------------------------------------------
4 | License & Credits
---------------------------------------------------------------------------

	Licensed under the terms of the GNU Lesser General Public License:
  		http://www.opensource.org/licenses/lgpl-license.php
  
	About:
 		General Information: http://www.activecampaign.com/activespell
 		Forum: http://www.activecampaign.com/support/forum/forumdisplay.php?f=40
		ActiveSpell 1.0 was based on ajax-spell 
			(http://www.broken-notebook.com/spell_checker)

