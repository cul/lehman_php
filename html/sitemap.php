<?php
	include_once('includes/searchSolr.php');
        header ("Content-Type: text/xml; charset=ISO-8859-1");

        echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
        echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

	echo "\t<url>\n<loc>http://lehman.cul.columbia.edu/</loc>\n<lastmod>2008-04-29</lastmod>\n<changefreq>monthly</changefreq>\n<priority>1.0</priority>\n\t</url>\n";

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

	$result = searchSolr("q=subseries:Correspondence&rows=0&facet=true&facet.field=file_unittitle&facet.sort=false&facet.limit=10000&wt=phps", $appUrl, "");
	
        extract($result);
        extract($responseHeader);
        extract($params);

        if($facet_counts) {
                extract($facet_counts);
                foreach($facet_fields as $facet) {
                        foreach(array_keys($facet) as $key) {
                                print "<url>\n";
                                //print "<loc>http://ldpd.lamp" . $env . ".columbia.edu/lehman/search/?wt=phps&amp;file_unittitle_t=&#34;". urlencode($key) . "&#34;&amp;rows=20</loc>\n"; 
                                print "<loc>http://lehman.cul.columbia.edu/search/?wt=phps&amp;file_unittitle_t=&#34;". urlencode($key) . "&#34;&amp;rows=20</loc>\n"; 
//htmlentities($key, ENT_QUOTES, 'UTF-8') . "&#34;&amp;rows=20</loc>\n";
                                print "<lastmod>2008-04-29</lastmod>\n";
                                print "<changefreq>monthly</changefreq>\n";
                                print "<priority>0.8</priority>\n";
                                print "</url>\n";
                        }
                } // end FOREACH facet_field
        } // IF facet_counts

        print "</urlset>\n";
?>

