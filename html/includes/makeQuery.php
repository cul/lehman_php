<?php
function makeQuery($query) {
        //print "In makeQuery, query=[$query]<br />";

        // these are the searchable fields that form q=
        $formKeys = array(      "file_unittitle_t"=>"",
                                "freetext"=>"",
                                "ocr"=>"",
                                "document_id"=>"",
                                "genreform1_t"=>"",
                                "unitdate_iso"=>"",
				"file_unitdate_display_t"=>"",
                        );

                                /* searchable fields also include dates */


        // example query looks like this: q=file_unittitle_t:example+AND+ocr:birthday;file_unittitle+asc

        // first, get sort
        $sort = "file_unittitle_t asc";
        $sortSlice = explode(";", $query);
        $year = $month = $day = $fromYear = $fromMonth = $fromDay = $toYear = $toMonth = $toDay = "";

	$operator = "AND";

        // now, get queries
        if ($sortSlice[0]) {
                $queryArray1 = explode(" AND ",$sortSlice[0]);

		$queryArray3 = array();

		foreach($queryArray1 as $q) {
			$qA = explode(" OR ", $q);
			if ((int)count($qA) > 1)
				$operator = "AND"; // changed from OR
			foreach($qA as $qB)
				array_push($queryArray3,$qB);

		}

		$queryArray = $queryArray3;

                foreach($queryArray as $qSlice) {
                     if (stristr($qSlice, "unitdate_iso")) {
                        $qSlice = str_replace('[', '', $qSlice);
                        $qSlice = str_replace(']', '', $qSlice);
                        //$qSlice = str_replace('-01-01T23:59:59Z', '', $qSlice);
                        $qSlice = str_replace('T23:59:59Z', '', $qSlice);
                        $dateRange = explode(" TO ", substr($qSlice, 13, strlen($qSlice)));
                        $from = $dateRange[0];
                        $to = $dateRange[1];

                        $fromArr = explode("-", $from);
                        $fromYear = $fromArr[0];
			if (!stristr($fromYear, "*")) {
                        	$fromMonth = $fromArr[1];
                        	$fromDay = $fromArr[2];
				if ($fromDay) { 	
					if (!preg_match('/T23:59:59Z/',$fromDay))
						$fromDay .=  "T23:59:59Z";
				}
			}

                        $toArr = explode("-", $to);
                        $toYear = $toArr[0];
			if (!stristr($toYear, "*")) {
                        	$toMonth = $toArr[1];
                        	$toDay = $toArr[2];
				if ($toDay) {
					if (!preg_match('/T23:59:59Z/',$fromDay))
						$toDay .= "T23:59:59Z";
				}
			}
			else if ($toYear == "*")
				$toYear = "";

                     } // end if QSlice 
                     else {
                        $qSlice = explode(":", $qSlice);
			$isFromYear = false;

                        if ( isset($qSlice[0]) && isset($qSlice[1]) ) {
                                if (!stristr($qSlice[0],"file_unitdate_display_t")) {
					if ($formKeys[$qSlice[0]] != "") {
						$formKeys[$qSlice[0]] .= " $operator " . $qSlice[1];
					}
					else {
                                        	$formKeys[$qSlice[0]] = $qSlice[1];
					}
                                }
                                else { 
                                        // deal with date
                                        $dateArr = explode("-",$qSlice[1]);
					if (count($dateArr) > 1) {
                                        	// need to replace asterisks, since initial dates are NOT wildcarded
                                        	if($dateArr[0])
                                                	$year = str_replace('*', '', $dateArr[0]);
                                        	if ($dateArr[1])
                                                	$month = str_replace('*', '', $dateArr[1]);
                                        	if ($dateArr[2])
                                                	$day = str_replace('*', '', $dateArr[2]);
					}
					else {
						// take query as-is; stuff it into freetext
						if ($formKeys['freetext'] != "") {
							if(preg_match('/unitdate/',$formKeys['freetext']))
								$formKeys['freetext'] .= " OR ";
							else
								$formKeys['freetext'] .= " AND ";
						}

						$formKeys['freetext'] .= $qSlice[0] . ":" . $qSlice[1];
					}	
                                } // date
                        }// if qSlice [0] and [1]
                        else if ($qSlice[0] != "" && $qSlice[0] != " ") {
				if (preg_match('/ OR /', $qSlice[0])) {
                                	$isOr = false;
                                        $monthA = explode(" OR ", $qSlice[0]);
                                       	if ($formKeys['freetext'] != "") {
                                        	$formKeys['freetext'] .= " AND ";
                                       	} 
                                        foreach($monthA as $m) {
                                                if (!$isOr)
                                                        $isOr = true;
                                                else {
                                                        if(preg_match('/unitdate/',$formKeys['freetext']))
                                                                $formKeys['freetext'] .= " OR ";
                                                        else
                                                                $formKeys['freetext'] .= " AND ";

						}

						$formKeys['freetext'] .= $qSlice[0] . ":" . $m;

                                        } // end FOREACH monthArr
                                } // end IF preg_match " OR "
				else
                                	$formKeys['freetext'] .= $qSlice[0] . " ";
				}
                     } // ELSE if not unitdateISO

                } // end FOREACH $queryArray
        } // end IF sortSlice[0]

        $newQ = "";

	if (! isset($formKeys['rows']) || $formKeys['rows'] == "")
		$formKeys['rows'] = "20";

        foreach(array_keys($formKeys) as $key) {
                if ($formKeys[$key])
                        $newQ .= $key . "=" . urlencode($formKeys[$key]) . "&";
        }


        $newQ .= "fromYear=$fromYear&fromMonth=$fromMonth&fromDay=$fromDay&toYear=$toYear&toMonth=$toMonth&toDay=$toDay&year=$year&month=$month&day=$day&sort
=" . urlencode($sort) . "&operator=$operator";

	if ( isset($_GET['debug']) )
        	print "new Q = $newQ";

	$newQ = str_replace("++","+",$newQ);	

        return $newQ;

} // end FUNCTION makeQuery


?>
