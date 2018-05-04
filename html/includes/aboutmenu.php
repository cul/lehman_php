<?php 
	$linkText = array("About the Collection", "Lehman Collection Finding Aid", "About text searching", "Contact Us");
	$linkLink = array("/about/", "http://findingaids.cul.columbia.edu/ead/nnc-rb/ldpd_4078518\" target=\"_blank\"", "/text/", "/feedback/");
	$linkList = "";

	for ($i=0; $i < count($linkText); $i++) {
		$linkCompare = substr($linkLink[$i], 0, -1) . ".php";
		if (!stristr($linkCompare, $_SERVER['PHP_SELF']))
			$linkList .= '&#160;<a href="' . $linkLink[$i] . '">'. $linkText[$i] . '</a>&#160;';
		else
			$linkList .=  "&#160" . $linkText[$i] . "&#160";
	
		$linkList .= "|"; 
	}

	if (substr($linkList, -1) == "|")
		$linkList = substr($linkList, 0, -1);


	print '<div align="center" style="padding:5px;margin-top:50px;border-bottom:1px solid #eee;border-top:1px solid #eee;"><strong>More information</strong>:' . $linkList . "</div>\n";
?>
