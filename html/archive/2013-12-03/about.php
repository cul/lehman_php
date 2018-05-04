<?php
	$htmlTitle = "Lehman Special Correspondence Files::About the Lehma Special Correspondence Files";
	//$addlBody = 'onload="checkDate();"';
	include_once('includes/header.php');


	$appUrl = "UNKNOWN";

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
<!-- img src="/lehman/images/image3.jpg" alt="Sample telegram from the Lehman Special Correspondence Files Online" width="185" /-->
<?php 
	$fontStyle = "font-size:10px;";
	//include_once("includes/contact.php"); 
?>
</div>
<div style="float:right;width:520px;">
<?php include_once("includes/draft.php"); ?>
<?php 
// 1/6/2011 - to aid Day migration, don't SSI from FileNet into LAMP
//include('/www/data/cu/lweb/indiv/lehsuite/includes/about.html'); 
?>

<h2>About the Lehman Special Correspondence Files</h2>
<p>
The Columbia University Libraries has scanned and made available here electronically the Special Correspondence Files of Herbert Lehman. More than 37,000 documents are included. Typed documents have also been OCRed, permitting full-text searching.
</p>
<p>
The Special Correspondence Files of the Herbert Lehman Papers contain correspondence with nearly 1,000 individuals from 1895 through 1963. Beginning with letters from Lehman's family in the late nineteenth century, the series documents the range and scope of Lehman's long career in public service. Lehman started the series in an attempt to isolate materials he wanted for his own personal use. The series expanded over the years to include exchanges with the many of the most important people of his day. Thus, in addition to family letters, the Special Correspondence Files contain letters from every President of the U. S. from Franklin Roosevelt to Lyndon Johnson, as well as from notables such as Dean Acheson, Benjamin Cardozo, Paul Douglas, Felix Frankfurter, W. Averill Harriman, Harold Ickes, Robert F. Kennedy, Fiorello LaGuardia, Henry Morgenthau, Alfred E. Smith, Adlai Stevenson, and Robert Wagner, among many others.
</p>
<a name="citation"></a>
<p><strong>Note on citing documents in the Lehman Special Correspondence Files</strong></p>
<p>The Lehman Special Correspondence Files provides a citation on each document page.  This citation follows the <em>Chicago Manual of Style</em>. The <em>Manual</em> recommends citation of this archive in the following format:</p>
<p style="border:1px solid #eee;padding:5px;">Identification of specific item, Item type, Date of specific item, Document ID, Herbert H. Lehman Papers, Special Correspondence Files, Rare Book and Manuscript Library, Columbia University Library, URL (date accessed).</p>

</div>
<br clear="all" />
<?php
        // if you want a sidebar, put it here
        // include_once('includes/sidebar.php');
        include_once('includes/pre_footer.php');
        include_once('includes/footer.php');

?>
