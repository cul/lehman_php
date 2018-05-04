<?php
        $htmlTitle = "Lehman Special Correspondence Files:: Thank you for your feedback";
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

<div style="float:left;width:190px;padding-bottom:5px;">
<?php include_once("includes/aboutmenu2.php"); ?>
</div>
<div style="float:right;width:520px;">
<?php include_once("includes/draft.php"); ?>
<h2>Contact Us: Thank You!</h2>

      <p>
        Thank you for your feedback regarding the Herbert H. Lehman Special Correspondence Files.  If you have requested a response, someone will email you shortly.</p> 
      </p>
	<p>For more information about the Lehman Special Correspondence Files, contact:</p>
	<?php include_once('includes/contact.php'); ?>
</div>
<br clear="all">
<?php
        include_once('includes/pre_footer.php');
        include_once('includes/footer.php');
?>

