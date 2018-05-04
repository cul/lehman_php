<?php 
	$page = $_SERVER['PHP_SELF'];
	$page = str_replace('/lehman/', '', $page);
	$page = str_replace('.php', '', $page);

	$appUrl = "UNKNOWN";
	$env = "UNKNOWN";

        if (stristr($_SERVER['SERVER_NAME'], '-test')) {
		$appUrl = "http://katana.cul.columbia.edu:8080/solr/lehman-test"
;
		$env = "test";
	}
        else if (stristr($_SERVER['SERVER_NAME'], 'lehman.cul')) {
		$appUrl = "http://app.cul.columbia.edu:8080/lehman";
		$env = "";
	}
	else {
		$appUrl = "http://katana.cul.columbia.edu:8080/solr/lehman-dev";
		$env = "dev";
	}

        if ($env == "test" || $env == "dev")
                print "<p style=\"text-align:right;color:red;font-weight:bold;\">$env</p>\n";


	if ($page != "index") {
		print '<div style="padding:5px;"><span style="font-size:10px;"><a href="/lehman/">Lehman Special Correspondence Files</a> &gt; <span style="color:#222;">';
		switch($page) {
			case "about":
				print "About the Collection";
				break;
			case "aboutrestriction":
				print "Agreement to Terms of Use";
				break;
			case "restricted":
				print "Agreement to Terms of Use";	
				break;
			case "search":
				print "Search Results";
				break;
			case "rights":
				print "Terms of Use";
				break;
			case "results":
				print "Lehman Special Correspondence Files Document";
				break;
                        case "feedback":
                                print "<a href=\"/lehman/about/\">About the Collection</a> &gt; Contact Us";
                                break;
			case "submitted.feedback":
				print "<a href=\"/lehman/about/\">About the Collection</a> &gt; <a href=\"feedback.php\">Contact us</a> &gt; Thank You";
				break;
			case "text":
				print "<a href=\"/lehman/about/\">About the Collection</a> &gt; About Searching";
				break;
			case "citation":
				print "Citation";
				break;
			default:
				print "&#160;";
				break;
		} // end SWITCH
		print "</span></div>";
	} // end IF page not index
?>
