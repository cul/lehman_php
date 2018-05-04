<?php

        if (!isset($_COOKIE['lehman'])) {
		header("Location: /lehman/aboutrestriction.php");
        }

	$htmlTitle = "Lehman Special Correspondence Files::Agreement to Terms of Use";
	$addlHeader = "<style>BODY { background:#ccc; } LI { padding:5px;margin:5px; }</style>";
	include_once('includes/header.php');


	$appUrl = "UNKNOWN";
	$env = "UNKNOWN";

        if (stristr($_SERVER['SERVER_NAME'], '-test')) {
		$appUrl = "http://katana.cul.columbia.edu:8080/solr/lehman-test"
;
	}
        else if (stristr($_SERVER['SERVER_NAME'], 'lehman.cul')) {
		$appUrl = "http://macana.cul.columbia.edu:8080/solr/lehman";
	}
	else {
		$appUrl = "http://katana.cul.columbia.edu:8080/solr/lehman-dev";
	}

	// draw form
?>
<div style="border:1px solid #eee;padding:10px;">
<?php include_once("includes/draft.php"); ?>
<div>
<h2>Lehman Special Correspondence Files: Agreement to Terms of Use</h2>
<?php
	$myQuery = str_replace("/lehman/" . $_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']);
?>
<form method="post" action="/lehman/<?php echo $_SERVER['QUERY_STRING'] ?>">
<?php include_once('includes/terms.php'); ?>
<p><strong>You may indicate your acceptance of these terms by clicking "I Accept".  You will then be permitted to access the Lehman Collection.</strong></p>
<div style="margin-left:150px;width:300px;border:1px solid #ccc;background:#f3f8fd;text-align:left" align="center">
<p><input type="radio" name="agreed" value="yes">&#160;<strong>I accept</strong> these terms.</input><br />
   <input type="radio" name="agreed" value="no">&#160;<strong>I do not accept</strong> these terms.</input></p>
<p style="text-align:center;"><input type="submit" value="Submit" /></p>
</div>
</form>
</div> 
</div>
<br clear="all" />
</div>
<?php
        include_once('includes/pre_footer.php');
        include_once('includes/footer.php');
?>
