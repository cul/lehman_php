<h2>List of all correspondents in the Lehman Special Correspondence Files collection</h2>

<?php
	$result = searchSolr("q=subseries:Correspondence&rows=0&facet=true&facet.field=file_unittitle&facet.sort=false&facet.limit=10000&wt=phps", $appUrl, "");
        extract($result);
        extract($responseHeader);
        extract($params);
	
        if($facet_counts) {
		print "<ul>\n";
                extract($facet_counts);
                foreach($facet_fields as $facet) {
                        foreach(array_keys($facet) as $key) {
                                print "<li><a href=\"/lehman/search/?wt=phps&file_unittitle_t=%22" . htmlentities($key, ENT_QUOTES, 'UTF-8') . "%22&rows=20\">$key</a></li>\n";
                        }
                } // end FOREACH facet_field
		print "</ul>";
        } // IF facet_counts
?>
