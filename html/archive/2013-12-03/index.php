<?php
	$htmlTitle = "Lehman Special Correspondence Files";
	$addlBody = 'onload="checkDate();"';
	include_once('includes/header.php');
	include_once('includes/searchSolr.php');

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

<h2>Lehman Special Correspondence Files</h2>
<p>The Special Correspondence Files of the Herbert Lehman Papers contain correspondence with nearly 1,000 individuals from 1864 through 1982. Beginning with letters from Lehman's family in the late nineteenth century, the series documents the range and scope of Lehman's long career in public service. In addition to family letters, the Special Correspondence Files contain letters from every President of the U. S. from Franklin Roosevelt to Lyndon Johnson, as well as from notables such as Dean Acheson, Benjamin Cardozo, Paul Douglas, Felix Frankfurter, W. Averill Harriman, Harold Ickes, Robert F. Kennedy, Fiorello LaGuardia, Henry Morgenthau, Alfred E. Smith, Adlai Stevenson, and Robert Wagner, among many others.</p>

<p style="font-weight:bold"><a href="/lehman/about/">More about the collection&#160;&#187;</a></p>
</div>
</div>
<br clear="all" />
<div style="clear:all; padding:3px; margin:3px;background-color:#eee;border-top:1px solid #ccc;" />
<h3 class="searchTitle">Search the collection</h3>
<?php
	include_once('includes/searchform.php');
?>
</div>
<?php
	 print '<p style="font-size:10px;text-align:center;"><a href="http://www.columbia.edu/cgi-bin/cul/resolve?lweb0107" class="noUnderline">Bookmark as: http://www.columbia.edu/cgi-bin/cul/resolve?lweb0107</a></p>';

        // if you want a sidebar, put it here
        include_once('includes/pre_footer.php');
        include_once('includes/footer.php');

?>
