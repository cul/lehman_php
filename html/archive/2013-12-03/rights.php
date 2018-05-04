<?php
	$htmlTitle = "Lehman Special Correspondence Files::Terms of Use";
	$addlHeader = "<style>LI { padding:5px;margin:5px; }</style>";
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
<img src="/lehman/images/image3.jpg" alt="Sample telegram from the Lehman Special Correspondence Files Online" width="185" />
</div>
<div style="float:right;width:520px;">
<?php include_once("includes/draft.php"); ?>
<h2>Lehman Special Correspondence Files: <br />Terms of Use</h2>
<?php include('includes/terms.php'); ?>
</div>
</div>
<?php
        // if you want a sidebar, put it here
        // include_once('includes/sidebar.php');
        include_once('includes/pre_footer.php');
        include_once('includes/footer.php');

?>
