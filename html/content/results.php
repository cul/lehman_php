          <table width="100%" border="0" cellpadding="15" cellspacing="0">
            <tr>
              <td>

<?php
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

	$myQuery = str_replace("/lehman/", '', $_SERVER['REQUEST_URI']);

	if (isset($_COOKIE["lehman"]) && ( !isset($_POST['agreed']) || $_POST['agreed'] != "no")) {
		// renew for another 1/2 hour
		// don't assume browser will still accept cookies!
		if (setcookie("lehman", "agreed", time()+1800) && !isset($_COOKIE["lehman"])) {
			writeCookieError();
			exit;
		}
		else {
			setcookie("lehman", "agreed", time()+1800);
		}
	} // end IF cookie "lehman" is set

	else {
		if (isset($_POST['agreed']) && $_POST['agreed'] == "yes") {
			if(setcookie("lehman", "agreed", time()+1800) && isset($_COOKIE["lehman"])) {
				writeCookieError();
				exit;
			}
			else {
				setcookie("lehman", "agreed", time()+1800);
			}
		}
		elseif (isset($_POST['agreed']) && $_POST['agreed'] == "no") {
			writeCookieError();
			exit;
		}
		else {
			setcookie("lehman", "agreed", time()+1800);
			isUserInAgreement($myQuery);
			exit;
		}	

	} // end ELSE cookie lehman not set

function writeCookieError() {
	header("Location: /lehman/aboutrestriction.php");
}

function isUserInAgreement($myQuery) {
	//header("Location: /lehman/restricted.php" . $_SERVER['QUERY_STRING']);
	header("Location: /lehman/restricted.php?" . $myQuery);
}

/*
 * 	Need to start session
 */
	session_start();

	//if (stristr( $_SERVER["HTTP_REFERER"], "search.php")) {
	if (stristr( $_SERVER["HTTP_REFERER"], "search")) {
	// if (!stristr( $_SERVER["HTTP_REFERER"], "results.php")) {
		unset($_SESSION['query']);
		unset($_SESSION['items']);
		unset($_SESSION['itemNo']);
		//session_destroy();
	} 

	//print $_SERVER["HTTP_REFERER"] . "<br />";

	if (isset($_GET['debug']))
		$_SESSION = array();

        include_once('post_header.php');

	// here we go!

	$isIpRestricted = false; //isRestricted();
	/*if ($isIpRestricted <= 0) {
		print "<script>location.replace(\"restricted.php\");</script>";
		print "<noscript>This item is restricted.</noscript>";
		exit;
	}*/

	$appUrl = "UNKNOWN";
	$env = "UNKNOWN";

        if (stristr($_SERVER['SERVER_NAME'], '-test')) {
                $appUrl = "http://ldpd-solr-test1.cul.columbia.edu:8983/solr/lehman";
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

	// no document id --> error

	//print $_SERVER['PHP_SELF'] . "<br />";
	//print_r($_GET);
	//print_r($_SERVER);

	//print  $_SERVER['REQUEST_URI'] . "<br>";
	//print  $_SERVER['QUERY_STRING'] . "<br>";
	
	$myQuery = str_replace("/lehman/" . $_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']);
	//print $myQuery . " = 1<br />";
	$myQuery = urldecode(str_replace("?&q=",'',$myQuery));
	//print $myQuery . " = 2<br />";
	if ($myQuery == "")
		$myQuery = "document_id:" . $_GET['document_id'];

	//print $myQuery . "= 3<br />";
	
	$pattern = "/ldpd_leh_\d{4}_\d{4}/";

	if (!isset($_GET['document_id'])) {
		writeError();
	}

	// document id not "ldpd_leh_nnnn_nnnn" > error
	else if ( isset($_GET['document_id']) && !preg_match($pattern, $_GET['document_id']) ){
		writeError();
	}

	// otherwise, document is ready for search and retrieval 
	else {
		//default values
		$q = $_GET['document_id'];
		$returnQ = $myQuery;
		$items = 1;

		//if (isset($_GET['q'])) {
		if($returnQ) {
			//$returnQ = makeQuery($_GET['q']);
			$returnQ=$myQuery;
			//$q = $_GET['q'];
			$q = $returnQ;
		}

	        if (!isset($_SESSION['query'])) {
       		         $_SESSION['query'] = $q;
        	}
		else {
			//if($_GET['q'] != $_SESSION['query'])
			if ($returnQ != $_SESSION['query']) {
				//$_SESSION['query'] == $_GET['q'];
				$_SESSION['query'] == $returnQ;
			}
			//$returnQ = makeQuery($_SESSION['query']);
			$returnQ=$myQuery;
		}

		if (preg_match('/\&items\=/',$myQuery)) {
			preg_match('/items=([^`]*?)&/',$myQuery,$itemMatches);
			//print "<pre>";print_r($itemMatches);print "</pre>";
			if ($itemMatches[1] != "") {
				$items = $itemMatches[1];
			}
		}

		$itemNo = 0;
        	$itemQuery = str_replace("/lehman/", '', $_SERVER['REQUEST_URI']);

		if (preg_match('/\&itemNo\=/',$itemQuery)) {
                        preg_match('/itemNo=([^`]*?$)/',$itemQuery,$itemMatches);
                        //print "<pre>";print_r($itemMatches);print "</pre>";
                        if ($itemMatches[1] != "") {
                                $itemNo = intval($itemMatches[1]);
                        }
                }

		
		if (!isset($_SESSION['items'])) {
			$_SESSION['items'] = $items;
		}

		$_SESSION['itemNo'] = $itemNo;

		if ($returnQ == "")
			$returnQ = "document_id=" . $_GET['document_id'];

                if (isset($_GET['debug']))
                        print "<br />return Q = $returnQ<br />";

		$qUrl = "wt=phps&q=document_id:" . $_GET['document_id'] . "&rows=1";
		$result = searchSolr($qUrl, $appUrl, "");

                //DEBUG
                if (isset($_GET['debug'])) {
                        //print "\n<pre>\n";
                        //print_r($result);
                        //print "\n</pre>\n";
			//print "<pre>Session:";
			//print_r($_SESSION);
			//print "</pre>";
		}

		extract($result);
		extract($responseHeader);
		extract($params);		
		
		// $docID = $docs[0]['document_id'];		

		extract($response);
		$pagination = "";

		$start = $rows = 20;

		extract($params);

		// for prev/next
		$myDocs = $docs;

		$isImageRestricted = "public"; //$docs[0]['image_access'];

		$prev = "";
		$next = "";
		$itemNo = $_SESSION['itemNo'];

		preg_match('/([^`]*?)\;/',$_SESSION['query'],$prevnextQA);
		$prevnextQ = urlencode($prevnextQA[0]);
	
		if ($itemNo > 0 && $_SESSION['items'] != 1) {
			//$prev = '&wt=phps&q='. urlencode($_SESSION['query']) . '&rows=1&start=' . ($itemNo-1);
			//$prev = '&wt=phps&q='. $_SESSION['query'] . '&rows=1&start=' . ($itemNo-1);
			$prev = '&wt=phps&q='. $prevnextQ . '&rows=1&start=' . ($itemNo-1);
			//print "prev: $prev<br />";
		}

		if ( ($itemNo + 1) < $_SESSION['items'] && $_SESSION['items'] != 1) {
			//$next = '&wt=phps&indent=true&q='. urlencode($_SESSION['query']) . '&rows=1&start=' . ($itemNo+1);
			//$next = '&wt=phps&indent=true&q='. $_SESSION['query'] . '&rows=1&start=' . intval($itemNo+1);
			$next = '&wt=phps&indent=true&q='. $prevnextQ . '&rows=1&start=' . ($itemNo+1);
			//print "next: $next<br />";
		}

		$prevDocId = "";
		$nextDocId = "";
	
		if ($prev != "") {
			$searchUrl = $serializedResult = $result = $responseHeader = $response = $docs = "";
                	$result = searchSolr($prev, $appUrl, "");
			extract($result);
			extract($responseHeader);
			extract($response);
			extract($docs); // should be one doc
			//$s = $_GET['itemNo']-1;
			if ($docs[0])
				$prevDocId = $docs[0]['document_id'];	
		}

                if ($next != "") {
			$searchUrl = $serializedResult = $result = $responseHeader = $response = $docs = "";
			$result = searchSolr($next, $appUrl, "");
                        extract($result);
                        extract($responseHeader);
                        extract($response);
                        extract($docs); // should be one doc
			if ($docs[0])
                        	$nextDocId = $docs[0]['document_id'];
                }

		$return = "<a style='text-decoration:none;' href=\"/lehman/search/?&wt=phps&". makeQuery($_SESSION['query']) . "&rows=20&start=";
		if($itemNo) 
			$return .= ($itemNo - ($itemNo%20));
		else
			$return .= "0";

		$return .= "\">Return to search results</a>&#160;<span style='color:#ddd'>|</span>&#160;<a href=\"/lehman/\" style='text-decoration:none;'>Start new search</a>"; //</p></div>";

		$prevmsg = "&laquo;&nbsp;previous search result";
		$nextmsg = "next search result&nbsp;&raquo;";
		//$prevmsg = "&laquo;";
		//$nextmsg = "&raquo;";

		// changed from 100%
		$tableprint =  "<table width='900' style='border:1px solid #ddd; background:#f3f8fd;margin-bottom:5px;'><tr>\n";
		//$tableprint .= "<td align=right style='font-size:10px;'>$return</td>";
		$tableprint .= "<td align=left width='450' style='font-size:10px;'>$return</td>";
		$tableprint .= "<td align=right width='315' style='font-size:10px;border-right:1px solid #ddd'>"; // removed width=100;changed to right align
		
		if ($itemNo == 0) {
			$tableprint .= "<span style='color:#ccc;'>" . $prevmsg . "&#160;</span>";
		}
		else {
			// took away ? before document_id
			$tableprint .= '<a href="document_id=' . $prevDocId . '&itemNo=' . ($itemNo - 1) .'" class="noUnderline">' . $prevmsg . '</a>&#160;';
		}

		$tableprint .= "<td align=left style='font-size:10px'>";
		if ( (($itemNo)+1) >= $_SESSION['items'] ) {
                        $tableprint .= "<span style='color:#ccc;'>" . $nextmsg . "</span>";
                }
                else {
			// took away ? before document-id
                        $tableprint .= '&#160;<a href="document_id=' . $nextDocId . '&itemNo=' . ($itemNo+1) . '" class="noUnderline">' . $nextmsg . '</a>';
                }
		$tableprint .= "</td>\n";	
		//$tableprint .= "<td align=right style='font-size:10px;'>$return</td>";

		$tableprint .= "</tr></table>";
		print $tableprint;

		// DLO example: http://www.columbia.edu/cgi-bin/cul/dev/dlo?obj=ldpd_leh_0001_0001_001&size=200 
		$dlo = "http://www.columbia.edu/cgi-bin/";
		if ($env == "dev" || $env == "test")
			$dlo .= "cul/$env/dlo";
                else
                        $dlo .= "dlo";
	
		foreach($myDocs as $doc) {
			extract($doc);
			$pdfArr = explode("_", $pdf);	
			$pdfUrl = "http://www.columbia.edu/cu/lweb/digital/collections/rbml/lehman/pdfs/" . $pdfArr[2] . "/" . $pdf;
			print "<h2 style='padding:10px 0 0 0;margin:0px;'>" ;
			print ucfirst($genreform1) . ": $file_unittitle"; 

                        // marquis
                        // avoid exist/not-exist logic - give it a default
			if ( ! isset($file_unitdate_display) ) 
                          $file_unitdate_display = 'n.d.';

			if ( isset($file_unitdate_display) )
				echo ' (' . $file_unitdate_display . ')';
			else
				echo ' (n.d.)';

			print "</h2>\n";


			printTools($document_id, $pdfUrl);

print '<div style="display:none" id="citation">';
print '<div style="width:898px;margin:1px;padding:1px;border:1px solid #ddd;background:#eee;font-size:12px;">';
print "<span style=\"float:right;\"><a href=\"javascript:openCitation('close')\" style='text-decoration:none;padding:0 2px 2px 2px;margin:2px;border:1px solid #ccc;background:#2d2a62;color:#fff;font-weight:bold;font-size:10px;'>x</a></span>";
print '<h2 style="color:#369;font-size:12px;">Citation (Chicago Manual of Style)</h2>';

//<span style="font-size:10px;">[<a href="/lehman/about/#citation" target="_blank" class="noUnderline">About <img src="http://www.columbia.edu/cu/lweb/digital/collections/cul/texts/images/newW.png" /></a>]</span></h2>';

        $pattern = "/ldpd_leh_\d{4}_\d{4}/";

        if (!isset($_GET['document_id'])) {
                writeError();
        }

        // document id not "ldpd_leh_nnnn_nnnn" --> error
        else if ( isset($_GET['document_id']) && !preg_match($pattern, $_GET['document_id']) ){
                writeError();
        }
        else {
                        $searchUrl = $serializedResult = $result = $responseHeader = $response = $docs = "";
			$qUrl = "wt=phps&q=document_id:" . $_GET['document_id'];
                	$result = searchSolr($qUrl, $appUrl, "");

                        extract($result);
                        extract($responseHeader);
                        extract($response);
                        foreach($docs as $doc)  { // should be one doc
                                extract($doc);
				print "<div style='padding-left:8px;'>";
                                writeCitation($file_unittitle, $genreform1, $file_unitdate_display, $document_id, "Herbert H. Lehman Papers, Special Correspondence Files;Rare Book and Manuscript Library, Columbia University Library.", $env);

				print "<a href=\"/lehman/about/#citation\" target=\"_blank\" class='noUnderline' style='font-size:10px;font-weight:bold'>About this citation <img src=\"http://www.columbia.edu/cu/lweb/digital/collections/cul/texts/images/newW.png\" /></a>";
				print "<br /></div>";
                        }
      }

print '</div></div>';



			//print "</td></tr></table>\n";

			//print $tableprint . "\n";
			//print "<span style='font-size:10px'><br /></span>\n";
			if ( ($isImageRestricted == "campus" && $isIpRestricted <= 0) || $isImageRestricted == "public") {
				//print '&#160;View: <span id="controller1" style="font-size:12px;"><a style="text-decoration:none;border:1px solid #ccc; color:#ccc;padding:1px;" id="controller1" href="javascript:breakFrame(\'divBookImage\', \'1\')">A</a></span>&#160; <span id="controller2" style="font-size:18px"><a style="text-decoration:none;border:1px solid #369; padding:1px;" id="controller2" href="javascript:breakFrame(\'divBookImage\', \'2\')">A</a></span>&#160;&#160;<br />'; 
                              //print '&#160;View: <a style="font-size:12px;text-decoration:none;border:1px solid #ccc; color:#ccc;padding:1px;" id="controller1" href="javascript:breakFrame(\'divBookImage\', \'1\')">A</a>&#160; <a style="font-size:18px;text-decoration:none;border:1px solid #369; padding:1px;" id="controller2" href="javascript:breakFrame(\'divBookImage\', \'2\')">A</a>&#160;&#160;';
				//print "<img src=\"http://www.columbia.edu/cu/lweb/img/assets/4035/printer-friendly_width.gif\" alt=\"\" border=\"0\" width=\"650\">&#160;&#160;<a href=\"print.php?document_id=$document_id\" alt=\"printer-friendly version\" onmouseover=\"document.images['printer'].src='http://www.columbia.edu/cu/lweb/img/assets/4035/printer.on.gif'\" onmouseout=\"document.images['printer'].src='http://www.columbia.edu/cu/lweb/img/assets/4035/printer.off.gif'\" title=\"printer-friendly version\"><img name=\"printer\" src=\"http://www.columbia.edu/cu/lweb/img/assets/4035/printer.off.gif\" alt=\"printable version\" title=\"printer-friendly version\" align=\"middle\" border=\"0\"></a>&#160;<a href=\"print.php?document_id=$document_id\" alt=\"printable version\" style=\"text-decoration: none;font-size:10px\" onmouseover=\"document.images['printer'].src='http://www.columbia.edu/cu/lweb/img/assets/4035/printer.on.gif'\" onmouseout=\"document.images['printer'].src='http://www.columbia.edu/cu/lweb/img/assets/4035/printer.off.gif'\" title=\"printable version\">printer-friendly version</a>\n";
				print '<div style="font-size:3px;padding:0;margin:0"><br /></div>';
			}
			if ( ($isImageRestricted == "campus" && $isIpRestricted <= 0) || $isImageRestricted == "public") {
				//print '<div id="pageMenu" style="float:right;width:900px;height:auto;border:1px solid #ccc;border-bottom:transparent;overflow:auto;text-align:left;background:#eee;padding:0;margin:0">' . "\n";
				print '<div id="pageMenu" style="width:900px;height:auto;border:1px solid #ccc;border-bottom:transparent;overflow:auto;text-align:left;background:#eee;padding:0;margin:0">' . "\n";

				if ($pages > 1) {
					print '<div id="pagination" style="text-align:left;">';
					print "<script>javascript:writePages('" . $pages . "', '1', '$dlo', '$document_id', 'pagination')</script>";
					print "</div>";
				} // end IF pages > 1
				else {
					/// issue w/ie?
					print "<table width='880' style='text-align:center;color:#999;padding:0px'><tr><td style='font-size:10px;'>Page 1 of 1</td></tr></table>\n";
					//print "<table width=900 style='text-align:center;color:#999;padding:0px'><tr><td>Page 1 of 1</td></tr></table>\n";
				}
				print '</div>';
				//print '<div id="divBookImage" style="float:right;width:900px;height:900px;overflow:auto;text-align:center;background:#eee;border:1px solid #ddd;">';
				print '<div id="divBookImage" style="float:left;width:900px;overflow:auto;text-align:left;background:transparent;border:1px solid #ddd;padding-top:2px;padding-bottom:2px;">&#160;';
				print '<img id="imgBookImage" src="' . $dlo . '?obj=' . $document_id . '_' . str_pad(1, 3, "0", STR_PAD_LEFT) . '&size=900" alt="' . $genreform1 . '">';
				print '</div>';
				// took away float:right;
				print '<div id="ocrText" class="ocrText" align="center" style="border:1px solid #ccc;width:900px;height:500px;text-align:center;overflow:auto;display:none;">';
				print "<div id=\"ocrWindow\" style=\"width:500px;float:left;\">";
				print "<div style=\"border:1px solid #ddd; background:#f3f8fd;padding:5px;margin:10px;\">Please note: this text may be incomplete.  For more information about this OCR, view the \"Words in Documents\" section in <a href=\"/lehman/text/\">About Searching</a>.</div>\n";
                        	//print $ocr . '</div>';
                        	print htmlspecialchars($ocr) . '</div>';
				print "</div>\n";
				print "<br clear=all />\n";
                                print '<div id="pageMenu2" style="width:900px;height:auto;border:1px solid #ccc;border-top:transparent;overflow:auto;text-align:left;background:#eee;padding:0;margin:0">' . "\n";
				// do this krap again
                                if ($pages > 1) {
                                        print '<div id="pagination2" style="text-align:left;">';
                                        print "<script>javascript:writePages('" . $pages . "', '1', '$dlo', '$document_id', 'pagination2')</script>";
                                        print "</div>";
                                } // end IF pages > 1
                                else {
                                        /// issue w/ie?
                                        print "<table width='880' style='text-align:center;color:#999;padding:0px'><tr><td style='font-size:10px;'>Page 1 of 1</td></tr></table>\n";
                                        //print "<table width=900 style='text-align:center;color:#999;padding:0px'><tr><td>Page 1 of 1</td></tr></table>\n";
                                }
                                print '</div>';

			} // if no image restriction
			else {
				print '<div style="width:500px;height:500;border:1px solid #ccc;overflow:auto;text-align:left;background:#eee;padding:5px;margin:5px">';
				print '<p>This item is restricted for web use.  For more information, contact RBML.</p>';
				print '</div>';
				
			}
			//print "<p><a href=\"javascript:openCitation()\" class=\"noUnderline\"><img src=\"http://www.columbia.edu/cu/lweb/digital/collections/cul/texts/images/bookcitation-sm.gif\" alt=\"citation\" />&#160;Download citation&#160;&#187;</a></p>";
			print "<div>\n";
			print "<br clear=all><p><strong>Document information:</strong><br />";
			print "Correspondent: $file_unittitle<br />";
			print "Document type: " . ucfirst($genreform1) . "<br />";
			print "Date: ";
                        if (isset($file_unitdate_display))
                                print $file_unitdate_display;
                        else
                                print "n.d.";
                        print "<br />";
                        print "Number of pages: $pages<br />";
                        print "Folder number: $folder_num<br />";
                        print "Document ID: $document_id</p>";
			print "</div>\n";
		print $tableprint . "\n";

?>

 <?php
        if ( ($isImageRestricted == "campus" && $isIpRestricted <= 0) || $isImageRestricted == "public") {
	} // end IF image is restricted
	else {
		print '<div id="a" style="display:none;"></div>';
	}
?>


		</div>

<?php			if (isset($_GET['debug'])) {	
			print "<ul>";
			foreach(array_keys($doc) as $key) {
				if ($key != "ocr")
					print "<li>$key: $doc[$key]</li>";
				else
					print "<li>$key: " . substr($doc[$key], 0, 50) . "</li>";
			}
			print "</ul>";
			} // FOREACH debug
		
		/*
			extract($doc);
			print "<p><a href='$filename'>$correspondent</a> ($genreform)</p>";
		*/
		} // end FOREACH $docs

	} // end IF $_GET['q']

	writeFooter();
	exit;
?>

<?php

        function printToolsText($document_id, $pdfUrl) {
                print '
                <div id="a">
                  <table class="bibcit">
                     <tr>
                        <td align="center" class="toolsMenu">
                           <table width="115" style="color:#336699;font-weight:bold;" cellpadding="0" cellspacing="0">
                              <tr>
                                 <td width="100">Tools</td>
                                 <td width="15" align="right">
                                    <div id="menuControls" style="float:right;width:38px">';
                                print "<a id=\"min\" href=\"javascript:controlMenu('minimize')\"><img src=\"http://www.columbia.edu/cu/lweb/digital/collections/cul/texts/images/min.gif\" alt=\"min\" border=\"0\" /></a><a id=\"max\" href=\"javascript:controlMenu('maximize')\"><img src=\"http://www.columbia.edu/cu/lweb/digital/collections/cul/texts/images/max.gif\" alt=\"max\" border=\"0\"></img></a></div>\n";
                                 print '</td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                     <tr>
                        <td><span style="font-size:5px;"><br></br></span>
                                <div id="menu" style="font-size:10px;">
			';
                       	print '<p class="outlined">&#160;Size: <a style="font-size:10px;text-decoration:none;border:1px solid #ccc; color:#ccc;padding:1px;" id="controller1" href="javascript:breakFrame(\'divBookImage\', \'1\')">A</a>&#160; <a style="font-size:16px;text-decoration:none;border:1px solid #369; padding:1px;" id="controller2" href="javascript:breakFrame(\'divBookImage\', \'2\')">A</a>&#160;&#160;</p>';

			print '<p class="outlined"><a href="javascript:openCitation('; print "'$document_id'" ; print ')" class="noUnderline"><img src="http://www.columbia.edu/cu/lweb/digital/collections/cul/texts/images/bookcitation-sm.gif" alt="citation" />&#160;View citation&#160;<img src="http://www.columbia.edu/cu/lweb/digital/collections/cul/texts/images/newW.png" alt="opens new window"></a></p>';

			print "<p class='outlined'><a href=\"print.php?document_id=$document_id\" alt=\"printer-friendly version\" onmouseover=\"document.images['printer'].src='http://www.columbia.edu/cu/lweb/img/assets/4035/printer.on.gif'\" onmouseout=\"document.images['printer'].src='http://www.columbia.edu/cu/lweb/img/assets/4035/printer.off.gif'\" title=\"printer-friendly version\"><img name=\"printer\" src=\"http://www.columbia.edu/cu/lweb/img/assets/4035/printer.off.gif\" alt=\"printable version\" title=\"printer-friendly version\" align=\"middle\" border=\"0\"></a>&#160;<a href=\"print.php?document_id=$document_id\" alt=\"printable version\" style=\"text-decoration: none;font-size:10px\" onmouseover=\"document.images['printer'].src='http://www.columbia.edu/cu/lweb/img/assets/4035/printer.on.gif'\" onmouseout=\"document.images['printer'].src='http://www.columbia.edu/cu/lweb/img/assets/4035/printer.off.gif'\" title=\"printable version\">printer-friendly</a></p>\n";

			print '<p><a href="' . $pdfUrl . '" target="_blank"><img src="http://www.columbia.edu/cu/lweb/digital/collections/cul/texts/images/pdf_button.gif" alt="PDF" border="0"/></a></p>';

                         print "<p><div id=\"ocrImage\"><a href=\"javascript:toggleLayer('divBookImage','ocrImage','ocrText','bookImage');\"><img src=\"http://www.columbia.edu/cu/lweb/digital/collections/cul/texts/images/ocr_button.gif\" alt=\"OCR - View plain text.\" border=\"0\"/></a></div>\n</p>\n";

			print "<p><div id=\"bookImage\" style=\"display:none;\"><a href=\"javascript:toggleLayer('ocrText', 'bookImage', 'ocrImage','divBookImage')\"><img src=\"http://www.columbia.edu/cu/lweb/digital/collections/cul/texts/images/pageimage.gif\" alt=\"view page image.\" border=\"0\" name=\"bookImage\"/></a></div>";
                              print '</p>

                              <div align="center" style="font-size:9px;color:#999;background:#eee;cursor:pointer;padding:5px">Click here and hold to move tools menu</div>
                           </div>
                        </td>
                     </tr>
                  </table>
                </div>
                ';
        } // end FUNCTION printTools
	

	function printTools($document_id, $pdfUrl) {
                print '
                <div id="a">
                  <table class="bibcit">
                     <tr>
                        <td align="center" class="toolsMenu">
                           <table width="115" style="color:#336699;font-weight:bold;" cellpadding="0" cellspacing="0">
                              <tr>
                                 <td width="100">Tools</td>
                                 <td width="15" align="right">
                                    <div id="menuControls" style="float:right;width:38px">';
                                print "<a id=\"min\" href=\"javascript:controlMenu('minimize')\"><img src=\"http://www.columbia.edu/cu/lweb/digital/collectio
ns/cul/texts/images/min.gif\" alt=\"min\" border=\"0\"></img></a><a id=\"max\" href=\"javascript:controlMenu('maximize')\"><img src=\"http://www.columbia.edu
/cu/lweb/digital/collections/cul/texts/images/max.gif\" alt=\"max\" border=\"0\"></img></a></div>";
                                 print '</td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                     <tr>
                        <td><span style="font-size:5px;"><br></br></span>
                                <div id="menu">
				<div style="padding-left:3px;padding-top:4px;padding-bottom:0px;width:116px;height:30px;background:transparent;border:1px solid transparent;color:#2d2a62;font-weight:bold;font-size:11px"><!-- div style="color:#2d2a62;font-weight:normal;font-size:11px;height:23px;background:url(http://www.columbia.edu/cu/lweb/digital/collections/cul/texts/images/blank.gif) no-repeat;padding-left:35px;padding-top:4px;"-->&#160;view: <a style="font-size:12px;text-decoration:none;border:1px solid #ccc; background:#fff;color:#ccc;padding:1px;" id="controller1" href="javascript:breakFrame(\'divBookImage\', \'1\')" title="shrink image">A</a>&#160; <a style="background:#fff;font-size:18px;text-decoration:none;border:1px solid #369; padding:1px;" id="controller2" href="javascript:breakFrame(\'divBookImage\', \'2\')" title="enlarge image">A</a>&#160;&#160;
				</div>';
			print '
                                <p><a href="javascript:openCitation('; print "'$document_id'" ; print ')" class="noUnderline"><img src="http://www.columbia.edu/cu/lweb/digital/collections/cul/texts/images/viewcitation.gif" alt="View Citation" border="0" /></a></p>
				<!-- <p><img src="http://www.columbia.edu/cu/lweb/digital/collections/cul/texts/images/enlargedoc.gif" /></p> -->
                              <p><a href="print.php?document_id=' . $document_id . '" target="_blank"><img src="http://www.columbia.edu/cu/lweb/digital/collections/cul/texts/images/printer_button.gif" alt="Printer-friendly" border="0" /></a></p>
                              <p><a href="' . $pdfUrl . '" target="_blank"><img src="http://www.columbia.edu/cu/lweb/digital/collections/cul/texts/images/pdf_button.gif" alt="PDF" border="0"/></a></p>';
                              print "<p><div id=\"ocrImage\"><a href=\"javascript:toggleLayer('divBookImage','ocrImage','ocrText','bookImage');\"><img src=\"http://www.columbia.edu/cu/lweb/digital/collections/cul/texts/images/ocr_button.gif\" alt=\"OCR - View plain text.\" border=\"0\"/></a></div>\n</p>\n";
                              print "<p><div id=\"bookImage\" style=\"display:none;\"><a href=\"javascript:toggleLayer('ocrText', 'bookImage', 'ocrImage','divBookImage')\"><img src=\"http://www.columbia.edu/cu/lweb/digital/collections/cul/texts/images/pageimage.gif\" alt=\"view page image.\" border=\"0\" name=\"bookImage\"/></a></div>";
                              print '</p>
                              <div align="center" style="font-size:9px;color:#999;background:#eee;padding:5px;cursor:default;">Click here and hold to move tools menu</div>
                           </div>
                        </td>
                     </tr>
                  </table>
                </div>
                ';
	} // end FUNCTION printTools

	function writeFooter()
        {
	  //include_once('includes/pre_footer.php');
          // if you want a sidebar, put it here
          // include_once('includes/sidebar.php');
          //include_once('includes/footer_flex.php');

	  // dl415: end document in function because outer document is not completing.                                                                                               
          include_once('includes/pre_footer.php');

          print '        </td>';
          print '      </tr>';
          print '    </table>';

          include_once('includes/footer.php');

          print '  </div>';
          print '</div>';

          include_once('includes/before_close_body.php');

          print '</body>';
          print '</html>';

	}

       function writeError() {
                print "You have followed an incorrect link.  Please <a href=\"\">try again</a>.";
		writeFooter();
		exit;
        }


	function paginate($max, $start, $increment) {

		$pagination = '<table class="optionsBar"><tr><td align="left">';

		$min = 0;
		$prev = $next = "";

		$pagination .= "Displaying hits " . ($start + 1) . "-";

		if (($start + $increment) > $max) {
			$pagination .= ($start + $increment);			
		}

		else {
			$pagination .= $max;
		}

		$pagination .= " of " . $max . "</td>";

		// does prev exist?
		if ( ($start - $increment) >= $min) {
			$prev .= '<a href="">[prev]</a>';
		}
		else {
			$prev .= "<span style='color:#ccc'>[prev]</span>\n";
		}

		// does next exist?

		if (($start + $increment) < $max) {
			$next .= '<a href="">[next]</a>';
		}
		else {
			$next .= '<span style="color:#ccc">[next]</span>' . "\n";
		}	
		
	
        	// pagination <<1, 2, 3, 4, 5, 6, 7, 8, 9, 10>>

	        // get current page
       		$curPage = (int)($start/$increment) + 1;

       	 	// get incremental
        	$y = (int)(($curPage - 1)/10) * 10;

        	$i = 1;
        	$maxPage = (int)($max/$increment) + 1;

        	if ($max%10 == 0) {
                	$maxPage = (int)($max/$increment);
	        } // adjust for edge divisible by clock value

        	$maxIterations = 10;
        	$maxJumpMenu = $y + $maxIterations;

        	if ($maxPage < $maxJumpMenu) {
                	$maxIterations = (int)($maxPage%10);
        	}

        	if ($maxPage <= 1) {
                	$pagination .= '<span style="color: #ccc;">';
        	}
        	$pagination .= "<strong>Jump to page:</strong>&#160;" + $prev + "&#160;";

        	if ($y <= 0) {
        	}
        	else {
                	$pagination .= '<a href="&start=' . ($start - ($increment*($curPage - $y)) ) . '&rows=' . $increment . '">&lt;&lt;</a>&#160;';
        	}

        	for ($i; $i <= $maxIterations; $i++) {
                	if ( ($y+$i) == $curPage )  {
                        	$pagination .= '<strong>' . ($y+$i) . '</strong>';
                	}
                	else if (($y+$i) < $curPage) {
                        	$pagination .= '<a href="&start=' . ($start - ($increment*($curPage-$y-$i))) . '&rows=' . $increment . '">' . ($y+$i) . '</a>';
                	}
                	else {
                        	$pagination .= '<a href="&start=' . ($start . ($increment*($i-($curPage-$y)))) + '&rows=' + $increment + '">' + ($y+$i) + '</a>';
                	}

                	$pagination .= '&#160;';

        	} // end FOR $i

        	if ( $y+11 > $maxPage ) {
                	// do nothing
        	}

        	else {
                	$pagination .= '<a href="&start=' . ($start + ($increment*($i-($curPage-$y)))) + '&rows=' + $increment + '">&gt;&gt;</a>';

		}

        	if ($maxPage <= 1) {
                	$pagination .= '</span>';
        	}

        	$pagination .= '&#160;' + $next + '</td></tr></table>';

	return $pagination;	

} // end FUNCTION paginate

function getSimilarDocs($file_unittitle, $appUrl) {
	$qUrl = "file_unittitle_t:%22" . urlencode($file_unittitle) . "%22+OR+ocr:%22" . urlencode($file_unittitle) . "%22;file_unittitle+asc";
	$result = searchSolr("&wt=phps&q=$qUrl", $appUrl, "");
	extract($result);
	extract($response);

	//echo '<br>makeQuery returns:<br /> ' . makeQuery(urldecode($qUrl)) . '<br>';

	if (substr($file_unittitle,-1) == ".")
		$file_unittitle = substr($file_unittitle,0,-1);
	print "There are $numFound documents related to $file_unittitle.&#160;&#160;<strong><a class=\"noUnderline\" href=\"/lehman/search/?wt=phps&" . makeQuery(urldecode($qUrl)) . "\">View documents&#160;&#187;</a></strong>\n";
	//print "<pre>\n"; print_r($result); print "</pre>\n";
} // end FUNCTION getSimilarDocs
?>