<?php
	$htmlTitle = "Lehman Special Correspondence Files::Citation";
	include_once('includes/header.php');
	include_once('includes/searchSolr.php');
	include_once('includes/cite.php');
	$appUrl = "UNKNOWN";
	$env = "UNKNOWN";

        if (stristr($_SERVER['SERVER_NAME'], '-test')) {
		$appUrl = "http://katana.cul.columbia.edu:8080/solr/lehman-test"
;
		$env = "test";
	}
        else if (stristr($_SERVER['SERVER_NAME'], 'lehman.cul')) {
		$appUrl = "http://macana.cul.columbia.edu:8080/solr/lehman";
		$env = "";
	}
	else {
		$appUrl = "http://katana.cul.columbia.edu:8080/solr/lehman-dev";
		$env = "dev";
	}


	// draw form
?>
<div style="float:left;width:100%;">
<table width="100%">
<tr><td valign="top">
<h2>Lehman Special Correspondence Files Citation</h2>
</td>
<td valign="top" style="text-align:right;font-size:10px;"><a href="javascript:window.close()" class="noUnderline">[x] close window</a></td>
</tr>
</table>
<br clear="all" />
<div style="padding:5px;border:1px solid #ccc;background-color:#f3f8fd">
<p><strong>Chicago Manual of Style citation for this resource:</strong></p>
<?php 
        $pattern = "/ldpd_leh_\d{4}_\d{4}/";

        if (!isset($_GET['document_id'])) {
                writeError();
        }

        // document id not "ldpd_leh_nnnn_nnnn" > error
        else if ( isset($_GET['document_id']) && !preg_match($pattern, $_GET['document_id']) ){
                writeError();
        }
	else {
                        $searchUrl = $serializedResult = $result = $responseHeader = $response = $docs = "";
                        $searchUrl = "http://" . $appUrl . ".cul.columbia.edu:8080/lehman/select?&wt=phps&q=document_id:" . $_GET['document_id'] . "&rows=1";
			/*
                        $serializedResult = file_get_contents($searchUrl);
                        $result = unserialize($serializedResult);
			*/
			$qUrl = "wt=phps&q=document_id:" . $_GET['document_id'];
			$result = searchSolr($qUrl,$appUrl,"");
                        extract($result);
                        extract($responseHeader);
                        extract($response);
                        foreach($docs as $doc)  { // should be one doc
				extract($doc);
				//print "<p>$file_unittitle: $pages</p>";
				if (! isset($file_unitdate_display))
				  $file_unitdate_display = 'n.d.';
				writeCitation($file_unittitle, $genreform1, $file_unitdate_display, $document_id, "Herbert H. Lehman Papers, Special Correspondence Files, Rare Book and Manuscript Library, Columbia University Library",$env);
			}
      }

?>
</div>
<p><strong>Note on citing documents in the Lehman Special Correspondence Files</strong></p>
<p>The Lehman Special Correspondence Files provides a citation for each document.  This citation follows the <em>Chicago Manual of Style</em>. The <em>Manual</em> recommends citation of this archive in the following format:</p>
<p style="border:1px solid #eee;padding:5px;">Identification of specific item, Item type, Date of specific item, Document ID, Herbert H. Lehman Papers, Special Correspondence Files, Rare Book and Manuscript Library, Columbia University Library, URL (date accessed).</p>

</div>
</div>
<br clear="all" />
<!-- 
<div style="clear:all; padding:3px; margin:3px; border:1px solid #ccc;border-right:2px solid #999;border-bottom:2px solid #999; background:#eee" />
<h2>Search collection</h2>
-->
<?php
	//include_once('includes/searchform.php');
        // if you want a sidebar, put it here
        // include_once('includes/sidebar.php');
        include_once('includes/pre_footer.php');
        include_once('includes/footer.php');

function writeError() {
	print "<p>You have reached this page erroneously.  Please try again.</p>";
} // end FUNCTION writeError

?>
