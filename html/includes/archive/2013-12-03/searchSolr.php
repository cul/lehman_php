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
                        //print '<p>assoc array</p>';
                        $code = array(file_get_contents($searchUrl));
                        eval("$result = " . $code . ";");
                }

		else if (stristr($searchUrl, "phps")) {
//print "searchUrl:<br/>$searchUrl";
                        // serialized array
                        try {
                                //$serializedResult = file_get_contents($searchUrl);
				//$serializedResult = http_request(0,$searchUrl);
				$curl = curl_init();
//print "searchUrl<pre>" . print_r($searchUrl) . "</pre>DONE\n";
				curl_setopt($curl, CURLOPT_URL, $searchUrl);
				curl_setopt($curl, CURLOPT_HEADER, 0);
// TURN ON CURL DEBUGGING
//curl_setopt($curl, CURLOPT_HEADER, true); 
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				$serializedResult = curl_exec($curl);
//print "serializedResult<pre>" . print_r($serializedResult) . "</pre>DONE\n";
				curl_close($curl);
                                $result = unserialize($serializedResult);
//print "result:<pre>";print_r($result);print "</pre>DONE\n";
				
                        }
                        catch (Exception $e){
                                print "<p>There was an error in your search: ". $e->getMessage(). ".  Please report this.</p>";
                                exit;
                        }
		}

                else {
                        //print '<p>serialized array</p>';
                        // serialized array
                        try {
                                $serializedResult = file_get_contents($searchUrl);
                                //print "result1: $serializedResult<br />";
                                $result = unserialize($serializedResult);
                        }
                        catch (Exception $e){
                                print "<p>There was an error in your search: ". $e->getMessage(). ".  Please report this.</p>";
                                exit;
                        }
                }

                //DEBUG
                /*if (isset($_GET['debug'])) {
                        print "\n<pre>\n";
                        print_r($result);
                        print "\n</pre>\n";
                }*/

                return $result;

} // end FUNCTION searchSolr

?>
