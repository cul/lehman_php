<?php
	$htmlTitle = "Lehman Correspondence Document::Printable Document";
        // FOR CITATION
        include_once('includes/cite.php');
	include_once('includes/searchSolr.php');

/*
        Need to set cookie:
                setcookie(name, value, expire, path, domain)

        if (cookie named lehman exists)
                renew cookie another 1/2 hour;
        else
                send up the menu; ask for agreement
                if agreement
                        set cookie 1/2 hour
                else
                        exit; don't serve up page
*/

        if (isset($_COOKIE["lehman"])) {
                // renew for another 1/2 hour
                setcookie("lehman", "agreed", time()+1800);
        } // end IF cookie "lehman" is set

        else {
                if (isset($_POST['agreed']) && $_POST['agreed'] == "yes") {
                        setcookie("lehman", "agreed", time()+1800);
                }
                elseif (isset($_POST['agreed']) && $_POST['agreed'] == "no") {
                        writeCookieError();
                        exit;
                }
                else {
                        isUserInAgreement();
                        exit;
                }

        } // end ELSE cookie lehman not set

function writeCookieError() {
        header("Location: /lehman/aboutrestriction.php");
}

function isUserInAgreement() {
        header("Location: /lehman/restricted.php?" . $_SERVER['QUERY_STRING']);
}

	include_once('includes/iprestriction.php');

	$isIpRestricted = isRestricted();

	$appUrl = "UNKNOWN";
	$env = "UNKNOWN";

        if (stristr($_SERVER['SERVER_NAME'], '-test')) {
		$appUrl = "http://ldpd-solr-test1.cul.columbia.edu:8983/solr/lehman"
;
		$env = "test";
	}
        else if (stristr($_SERVER['SERVER_NAME'], 'lehman.cul')) {
		$appUrl = "http://ldpd-solr-prod1.cul.columbia.edu:8983/solr/lehman";
		$env = "";
	}
	else {
		$appUrl = "http://ldpd-solr-dev1.cul.columbia.edu:8983/solr/lehman";
		$env = "dev";
	}

	// no document id > error
	
	$pattern = "/ldpd_leh_\d{4}_\d{4}/";

	if (!isset($_GET['document_id'])) {
		writeError();
	}

	$page = 1;
	if (isset($_GET['page']) && $_GET['page'] != NULL && $_GET['page'] != "")
		$page = $_GET['page'];

	// document id not "ldpd_leh_nnnn_nnnn" > error
	else if ( isset($_GET['document_id']) && !preg_match($pattern, $_GET['document_id']) ){
		writeError();
	}

	// otherwise, document is ready for search and retrieval 
	else {
		$searchUrl = "http://" . $appUrl . ".cul.columbia.edu:8080/lehman/select?wt=phps&q=document_id:" . $_GET['document_id'] . "&rows=1";

                if (isset($_GET['debug']))
                        print "URL:<br /><a href='" . str_replace("phps", "php", $searchUrl) . "' target='_blank'>$searchUrl</a>\n";

		$qUrl = "wt=phps&q=document_id:" . $_GET['document_id'] . "&rows=1";
		$result = searchSolr($qUrl, $appUrl, "");

                //DEBUG
                if (isset($_GET['debug'])) {
                        print "\n<pre>\n";
                        print_r($result);
                        print "\n</pre>\n";
			print "<pre>Session:";
			print_r($_SESSION);
			print "</pre>";
		}

		extract($result);
		extract($responseHeader);
		extract($params);		
		

		extract($response);
		$pagination = "";

		$start = $rows = 20;

		extract($params);

		// for prev/next
		$myDocs = $docs;

                // restrictions not implemented - all images are public
		$isImageRestricted = "public"; 

		writeHeader();

                // DLO example: http://www.columbia.edu/cgi-bin/cul/dev/dlo?obj=ldpd_leh_0001_0001_001&size=200
                $dlo = "http://www.columbia.edu/cgi-bin/";
                if ($env == "dev" || $env == "test")
                        $dlo .= "cul/$env/dlo";
                else
                        $dlo .= "dlo";
	
		foreach($myDocs as $doc) {
			extract($doc);
                        print "<h2 style='padding:5px 0 0 0;margin:0px;'>" ;
                        print ucfirst($genreform1) . ": $file_unittitle";
                        if ( ! isset($file_unitdate_display))
                          $file_unitdate_display = 'n.d.';
                        if ($file_unitdate_display)
                                echo ' (' . $file_unitdate_display . ')';
                        else
                                echo '(n.d.)';
                        print "</h2>\n";
                        print "<p style='margin-top:1px;'>";

                        writeCitation($file_unittitle, $genreform1, $file_unitdate_display, $document_id, "Herbert H. Lehman Papers, Special Correspondence Files, Rare Book and Manuscript Library, Columbia University Library", $env);

			print "</p>";

			if ( ($isImageRestricted == "campus" && $isIpRestricted <= 0) || $isImageRestricted == "public") {
                        	print "<div>\n";

				for ($i = 1; $i <= $pages; $i++) {
					//print "<p>Page $i</p>";
					print '<img id="imgBookImage" src="' . $dlo . '?obj=' . $document_id . '_' . str_pad($i, 3, "0", STR_PAD_LEFT) . '&size=900" alt="' . $genreform1 . '">';
				} // end FOR $i
			} // if no image restriction

			else {
				print '<div style="width:500px;height:500;border:1px solid #ccc;overflow:auto;text-align:left;background:#eee;padding:5px;margin:5px">';
				print '<p>This item is restricted for web use.  For more information, contact RBML.</p>';
				print '</div>';
				
			} // end else image restriction
			print "<div>\n";
			print "</div>\n";

			if (isset($_GET['debug'])) {	
			   print "<ul>";
			   foreach(array_keys($doc) as $key) {
				if ($key != "ocr")
					print "<li>$key: $doc[$key]</li>";
				else
					print "<li>$key: " . substr($doc[$key], 0, 50) . "</li>";
			   } // end FOREACH
			   print "</ul>";
			} // end IF debug
		
		} // end FOREACH $docs

	} // end IF $_GET['q']

                        print "<br clear=all><p><strong>Document information:</strong><br />";
                        print "Correspondent: $file_unittitle<br />";
                        print "Document type: " . ucfirst($genreform1) . "<br />";
                        print "Date: ";
                        if ($file_unitdate_display)
                                print $file_unitdate_display;
                        else
                                print "n.d.";
                        print "<br />";
                        print "Number of pages: $pages<br />";
                        print "Folder number: $folder_num<br />";
                        print "Document ID: $document_id</p>";
                        print "</div>\n";

	writeFooter();
	exit;
?>

<?php
  function writeHeader() {
    print '<html>'."\n";
    print "\n";
    print '<head>'."\n";
    print '  <title>Printable document</title>'."\n";
    print '  <script src="/lehman/js/func.js"></script>'."\n";
    print '  <style>'."\n";
    print '    * { font-family:verdana, arial; font-size:10px;}'."\n";
    print '    BODY { margin-top:0px; padding-top:0px; }'."\n";
    print '    .content { font-size:10px; }'."\n";
    print '    .headb3 { margin-top:0px; font-weight:bold; font-size:16px; color:#000000; font-family:Verdana,Arial,Geneva,sans-serif; }'."\n";
    print '    .headb4 { margin-top:0px; font-weight:normal; font-size:12px; color:#000000; font-family:Verdana,Arial,Geneva,sans-serif; }'."\n";
    print '    @media print {'."\n";
    print '      .control_element { display:none; }'."\n";
    print '    }'."\n";
    print '  </style>'."\n";
    print '</head>'."\n";
    print "\n";
    print '<body>'."\n";
    print "\n";
    print '<div class="control_element" style="margin-bottom:6px; text-align:right;"><a href="javascript:window.close()" style="text-decoration:none;font-size:10px;color:#369">[x] close window</a></div>'."\n";
    print "\n";
    print '<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:4px; border-bottom:1px solid #ccc;">'."\n";
    print '  <tr>'."\n";
    print '    <td>'."\n";
    print "\n";
    print '      <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:8px; line-height:18px;">'."\n";
    print '        <tr>'."\n";
    print '          <td align="left" valign="top">'."\n";
    print '            <span class="headb3">The Lehman Special Correspondence Files</span><br />'."\n";
    print '            <span class="headb4">from the Herbert H. Lehman Collections</span><br />'."\n";
    print '            <span class="headb4">Presented by the Rare Book and Manuscript Library</span><br />'."\n";
    print '            <a href="http://library.columbia.edu/locations/rbml/units/lehman.html">http://library.columbia.edu/indiv/rbml/units/lehman.html</a>'."\n";
    print '          </td>'."\n";
    print '          <td class="footer" align="right" valign="top">'."\n";
    print '            6th Fl. E, Butler Library / 535 W 114th St.<br />'."\n";
    print '            Columbia University / New York, NY 10027<br />'."\n";
    print '            (212) 854-5590 (P) / (212) 854-1365 (F)<br />'."\n";
    print '            <a href="mailto:rbml@libraries.cul.columbia.edu">rbml@libraries.cul.columbia.edu</a>'."\n";
    print '          </td>'."\n";
    print '        </tr>'."\n";
    print '      </table>'."\n";
    print "\n";
    print '    </td>'."\n";
    print '  </tr>'."\n";
    print '</table>'."\n";
    print "\n";
    print '<div class=\"content\">'."\n";
  }

  function writeFooter() {
    print "<br clear=all /><div style='border-top:1px solid #ccc;'>&copy; Columbia University Libraries</div>\n";
    print "</div>\n";
    print "</body></html>\n";

  }

       function writeError() {
                print "You have followed an incorrect link.  Please <a href=\"\">try again</a>.";
    writeFooter();
    exit;
        }

?>
