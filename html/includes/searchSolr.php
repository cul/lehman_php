<?php
function searchSolr($query, $appUrl, $facetAddOn) {
                $searchUrl = $appUrl . "/select?" . $query . $facetAddOn;
		preg_match('/phps/',$searchUrl,$matches);
		if (count($matches) < 1) {
			$searchUrl .= "&wt=phps";
		}

                if (isset($_GET['debug']))
                        print "URL:<br /><a href='" . str_replace("phps", "php", $searchUrl) . "&indent=on' target='_blank'>$query</a>\n";

                if (isset($_GET['wt']) && $_GET['wt'] != "phps") {
                        // php assoc array
                        $code = array(file_get_contents($searchUrl));
                        eval("$result = " . $code . ";");
                }

		else if (stristr($searchUrl, "phps")) {
                        // serialized array
                        try {
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, $searchUrl);
				curl_setopt($curl, CURLOPT_HEADER, 0);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				$serializedResult = curl_exec($curl);
				curl_close($curl);
                                $result = unserialize($serializedResult);
				
                        }
                        catch (Exception $e){
                                print "<p>There was an error in your search: ". $e->getMessage(). ".  Please report this.</p>";
                                exit;
                        }
		}

                else {
                        // serialized array
                        try {
                                $serializedResult = file_get_contents($searchUrl);
                                $result = unserialize($serializedResult);
                        }
                        catch (Exception $e){
                                print "<p>There was an error in your search: ". $e->getMessage(). ".  Please report this.</p>";
                                exit;
                        }
                }

                return $result;

} // end FUNCTION searchSolr

?>
