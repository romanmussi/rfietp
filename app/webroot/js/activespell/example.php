<!--
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
 */
-->
<html>
<head>
<title>ActiveSpell</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="css/spell_checker.css">
<script src="cpaint/cpaint2.inc.compressed.js" type="text/javascript"></script>
<!-- You can use either one of the files below, but the compressed one
     will be faster and a lot smaller to download -->
<!--<script src="js/spell_checker_compressed.js" type="text/javascript"></script>-->
<script src="js/spell_checker.js" type="text/javascript"></script>

</head>
<body>
<form action="#">
<textarea title="spellcheck_icons" accesskey="spell_checker.php" id="spell_checker1" name="comment1" style="width: 400px; height: 150px;" />This is a t�st of non-ascii characters<br /><br />andd a testt of the spelll checker. Javascript was an unregonized wordd but it's now in the custom dictionary!!</textarea>
<br />
<textarea id="spell_checker2" name="comment2" style="width: 400px; height: 150px;" />This text area does not have a spell checker.</textarea>
<br />
<textarea title="spellcheck" accesskey="spell_checker.php" id="spell_checker3" name="comment3" style="width: 400px; height: 150px;" />This is anotherr testt wiht anoother spell checkker!!</textarea>
</form>
</body>
</html>