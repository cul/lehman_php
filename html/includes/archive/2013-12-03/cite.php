<?php 
function writeCitation($file_unittitle, $genreform1, $file_unitdate_display, $document_id, $repository, $env) { 
	print "<p>\n";

	print "$file_unittitle, $genreform1, ";

	if ($file_unitdate_display)
		print $file_unitdate_display; 
	else
		print "n.d.";

	print ", $document_id, $repository,  ";
//Herbert H. Lehman Papers, Special Correspondence Files; Rare Book and Manuscript Library, Columbia University Library.";

	$today = date("j F Y");
	print "http://lehman.cul.columbia.edu/$document_id (accessed $today).";

	print "</p>";
} // end FUNCTION writeCitation
?>
