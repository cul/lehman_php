<?php
	$htmlTitle = "Lehman Special Correspondence Files:: About Words in Documents Searching";
	$addlHeader = "<style>TT {font-size:13px;font-weight:bold;}</style>";
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
<h2>About Searching the Lehman Special Correspondence Files</h2>
<p>
<strong>Words in Documents</strong> searches the following fields: </p>
<ul>
<li>Correspondent</li>
<li>Date</li>
<li>Document type</li>
<li>Document ID</li>
<li>The full text of the correspondence</li>
</ul>
<p>Please note that the accuracy of full text search results may vary.  Full text searching is enabled through the OCR (optical character recognition) process.  The results of this process depend on the characteristics of the original documents, for example the font and paper quality. 
</p>
<p><a name="date"></a><strong>Date</strong> searches for a range of dates or one particular date.  Examples of valid date searches include:</p>
<ul>
<li>From <tt>1865 Feb 19</tt> to <tt>1916 Jan 10</tt><br /><em>searches all correspondence between these dates</em></li>
<li>From <tt>1865</tt> to <tt>1916</tt><br /><em>searches all correspondence dated from 1865 to 1916</em></li>
<li>From <tt>Feb</tt> to <tt>Apr</tt><br /><em>searches all correspondence dated Feb, Mar, or April of any year</em></li>
</ul>
<p>The "day" field searching is not valid for month-only searches.</p>  
<p>Please note that some correspondence is not dated; a date-restriction search will eliminate these materials from your search.</p>

</div>
<br clear="all" />
<?php
        include_once('includes/pre_footer.php');
        include_once('includes/footer.php');
?>
