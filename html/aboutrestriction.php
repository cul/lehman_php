<?php
	$htmlTitle = "Lehman Special Correspondence Files::About the Restrictions on the Files";
	//$addlBody = 'onload="checkDate();"';
	include_once('includes/header.php');



	$appUrl = "UNKNOWN";
	$env = "UNKNOWN";

        if (stristr($_SERVER['SERVER_NAME'], '-test')) {
		$appUrl = "http://ldpd-solr-test1.cul.columbia.edu:8983/solr/lehman"
;
	}
        else if (stristr($_SERVER['SERVER_NAME'], 'lehman.cul')) {
		$appUrl = "http://ldpd-solr-prod1.cul.columbia.edu:8983/solr/lehman";
	}
	else {
		$appUrl = "http://ldpd-solr-dev1.cul.columbia.edu:8983/solr/lehman";
	}


	// draw form
?>

<div style="float:left;width:190px;padding-bottom:5px;">
<img src="/lehman/images/image3.jpg" alt="Sample telegram from the Lehman Special Correspondence Files Online" width="185" />
</div>
<div style="float:right;width:520px;">
<?php include_once("includes/draft.php"); ?>
<h2>About the Lehman Special Correspondence Files: Rights and Permissions</h2>
<p>Please note: your browser must be set to accept cookies to use this site.</p>
<?php include('includes/terms.php'); ?>
</div>
<?php
        // if you want a sidebar, put it here
        // include_once('includes/sidebar.php');
        include_once('includes/pre_footer.php');
        include_once('includes/footer.php');

?>
