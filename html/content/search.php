<table width="100%" border="0" cellpadding="15" cellspacing="0">
            <tr>
              <td>

                <h2 style="text-align:center;">Search Results</h2>

                <div style="float:right;width:100px;">
                  <a href="/lehman/">New search</a>
                </div>

                <div id="searchBox" style="padding:0; margin:0;">

                  <p>
                    <a href="javascript:toggle('searchForm', 'Refine search', 'Hide refine search')" class="toggle"><img id="IsearchForm" border="0" src="http://www.columbia.edu/cu/lweb/images/icons/left-off.gif"><span id="spanblurbsearchForm">Refine search</span></a>
                  </p>

                  <div class="expand" id="LsearchForm" style="padding:5px;margin:5px;border:1px solid #ddd;background:#eee;display:none;">

                    <h3 class="searchTitle">Search the Collection</h3>

                    <?php include("includes/searchform.php"); ?>

                  </div>

                </div>

<?php
  // IF A QUERY EXISTS, PARSE IT
  $queryFields = array("file_unittitle", "file_unittitle_t", "file_unitdate_display", "file_unitdate_display_t", "freetext", "year", "month", "day", "ocr", "document_id", "genreform1_t", "file_unitdate", "sort", "asc", "desc", "subject_name_t", "unitdate_iso", "_t", "fromYear", "fromMonth", "fromDay", "toYear", "toMonth", "toDay", "subject_terms_t");
  $query = "";
  $date = "";
  $template = "list";
  $and = false;
  $sort = "file_unittitle asc";
  $operator = "AND";
  if (! isset($file_unitdate_display))
  {
    $file_unitdate_display = 'n.d.';
  }
  if (isset($_GET['operator']) && ($_GET['operator']) != NULL && ($_GET['operator']) != "")
  {
    $operator = ($_GET['operator']);
  }
  $urland = urlencode(" $operator ");

  if ($_GET)
  {
    foreach(array_keys($_GET) as $k)
    {
      // make sure no scripting
      if (preg_match('/</', $_GET[$k]) || preg_match('/%3C/', $_GET[$k]) || preg_match('/>/', $_GET[$k]) || preg_match('/%3E/',$_GET[$k]))
      {
	writeError($appUrl);
	exit;
      }
    }

    // BEGIN SORT
    if (isset($_GET['sort']) && $_GET['sort'] != NULL && $_GET['sort'] != "")
    {
      $sort = $_GET['sort'];
    } // END SORT

    // BEGIN UNITTITLE
    if (isset($_GET['file_unittitle_t']) && $_GET['file_unittitle_t'] != NULL && $_GET['file_unittitle_t'] != "")
    {
      // solr really doesn't like "query "nickname" is this" pattern...
      $unittitle = "";
      if (preg_match('/AND/',$_GET['file_unittitle_t']))
      {
        $unittitle = urlencode($_GET['file_unittitle_t']);
      }
      else
      {
        $unittitle = urlencode(str_replace('"','',$_GET['file_unittitle_t'])); //, ENT_QUOTES, 'UTF-8');
      }
      if ($and)
      {
        $query .= $urland;
      }
      else
      {
        $and = true;
      }
      if (preg_match('/"/',$unittitle) || preg_match('/%22/',$unittitle))
      {
        $query .= 'file_unittitle_t:' . $unittitle;
      }
      else
      {
        $query .= 'file_unittitle_t:"' . $unittitle . '"';
      }
    } // END UNITTITLE

    // rules for date searches:
		// if ONLY year -- wildcard
		// if ONLY month -- wildcard
		// if ONLY day -- krap??

		if (isset($_GET['year']) && $_GET['year'] != NULL && $_GET['year'] != "") {
			$year = urlencode(htmlentities($_GET['year'], ENT_QUOTES, 'UTF-8'));
			$date .= $year;
			if (($_GET['month'] == NULL || $_GET['month'] == "") && ($_GET['day'] == NULL && $_GET['day'] == "")) {
				$date .= "*";
			}
		}

		if (isset($_GET['month']) && $_GET['month'] != NULL && $_GET['month'] != "") {
			$month = urlencode(htmlentities($_GET['month'], ENT_QUOTES, 'UTF-8'));
			if ($date != "") { // if year is not blank
				//$date .= "-";
				$date .= " ";
			}
			$date .= strtolower($monthArr[(intval($month-1))]);
			if ( !(isset($_GET['day']) || $_GET['day'] != NULL || $_GET['day'] != "") ) 
				$date .= "*";
		}

		if (isset($_GET['day']) && $_GET['day'] != NULL && $_GET['day'] != "") {
			$day = intval($_GET['day']);
			if ($date != "") {
				$date .= " ";
			}
			$date .= $day;
		}

		// DATE RANGE

		$dateRange = "";
		$isfromYear = false;
		$istoYear = false;
		$isfromMonth = false;
		$istoMonth = false;

		//FROM
		if (isset($_GET['fromYear']) && $_GET['fromYear'] != NULL && $_GET['fromYear'] != "")  {
			$isfromYear = true;
			$dateRange .= $_GET['fromYear'];

 			if  ( ($_GET['fromMonth'] == NULL || $_GET['fromMonth'] == "") && (!isset($_GET['fromDay']) || ( isset($_GET['fromDay']) && ( $_GET['fromDay'] == NULL || $_GET['fromDay'] == "")) ) ) {

				$dateRange .= "-01-01T23:59:59Z";
			}
		}


		if (isset($_GET['fromMonth']) && $_GET['fromMonth'] != NULL && $_GET['fromMonth'] != "") {
			$isfromMonth = true;
			if ($dateRange != "") {
				$dateRange .= "-";
			}
			else {
				$dateRange .= "*-";
			}
			$dateRange .= $_GET['fromMonth'];
			
			if ( !isset($_GET['fromDay']) || isset($_GET['fromDay']) && ($_GET['fromDay'] == NULL || $_GET['fromDay'] == "") )
				$dateRange .= "-01T23:59:59Z";
		}


		if (isset($_GET['fromDay']) && ($_GET['fromDay'] != NULL || $_GET['fromDay'] != "") ) {
			if ($dateRange != "") 
				$dateRange .= "-";

			if ( isset($_GET['fromMonth']) && ( $_GET['fromMonth'] == NULL || $_GET['fromMonth'] == "") ) {
				$dateRange .= "-01-01T23:59:59Z"; 
			}
			else {
				$dateRange .= $_GET['fromDay'];
				if (!preg_match('/T23:59:59Z/',$_GET['fromDay']))
 					$dateRange .= "T23:59:59Z";
			}
		}



		if ($dateRange == "")
			$dateRange .= "*";

		$dateRange .= " TO ";
		$toRange = "";

		// TO
		if (isset($_GET['toYear']) && $_GET['toYear'] != NULL && $_GET['toYear'] != "") {
			$istoYear = true;
			$toRange .= $_GET['toYear'];
 			if  ( ($_GET['toMonth'] == NULL || $_GET['toMonth'] == "") && (!isset($_GET['toDay']) || ( isset($_GET['toDay']) && ( $_GET['toDay'] == NULL || $_GET['toDay'] == "")) ) ) {
				$toRange .= "-12-31T23:59:59Z";	
			}
		}


                if (isset($_GET['toMonth']) && $_GET['toMonth'] != NULL && $_GET['toMonth'] != "") {
			$istoMonth = true;
                        if ($toRange != "") {
                                $toRange .= "-";
                        }
                        else {
                                $toRange .= "*-";
                        }
                        $toRange .= $_GET['toMonth'];

			if ( !isset($_GET['toDay']) || isset($_GET['toDay']) && ($_GET['toDay'] == NULL || $_GET['toDay'] == "") )
                                $toRange .= "-31T23:59:59Z";
                }

                if (isset($_GET['toDay']) && $_GET['toDay'] != NULL && $_GET['toDay'] != "") {
                        if ($toRange != "" && $toRange != "* TO ")
                                $toRange .= "-";

                        if ( (isset($_GET['toMonth']) && ($_GET['toMonth'] == NULL || $_GET['toMonth'] == "")) )
				$toRange .= "12-31T23:59:59Z";
			else {
                        	$toRange .= $_GET['toDay'];
				if (!preg_match('/T23:59:59Z/',$_GET['toDay']))
 					$toRange .= "T23:59:59Z";
			}
                }

		if ($toRange == "")
			$toRange .= "*";
		$dateRange .= $toRange;

	   if ($isfromYear || $istoYear) {
		if ($dateRange != "" && $dateRange != "* TO " && $dateRange != "* TO *") {
			if ($and)
				$query .= $urland;
			else
				$and = true;

			$query .= urlencode("unitdate_iso:[$dateRange]");
			if (isset($_GET['sort']) && ($_GET['sort'] == NULL || $_GET['sort'] == ""))
				$sort = "unitdate_iso asc";
		}
	  } // end IF fromYear or toYear are filled in
	 else {
		if ($isfromMonth || $istoMonth) {
			// get ranges
			$monthQuery = "(";
			$urlor = " OR ";
			$or = false;

			$fromMonth = 0;
			$toMonth = 0;

			if ($isfromMonth)	
				$fromMonth = intval($_GET['fromMonth']);
			if ($istoMonth)
				$toMonth = intval($_GET['toMonth']);

			if ($toMonth < $fromMonth && ($fromMonth > 0 && $toMonth > 0)) {
				// wrapper
				for ($i = $fromMonth; $i <= ($toMonth + 12); $i++) {
					if ($or) 
						$monthQuery .= $urlor;
					else
						$or = true;

					$myMonth = (int)($i % 12);
					$monthQuery .= "file_unitdate_display_t:" . getMonth($myMonth,$monthArr);
				} // end FOR 
			} // end IF to < from

			else if (($fromMonth > 0 && $toMonth > 0)){
				//print "$toMonth > $fromMonth<br />";
				$parens = true;
				for ($i = $fromMonth; $i <= $toMonth; $i++) {
					if ($or)
						$monthQuery .= $urlor;
					else
						$or = true;
					$monthQuery .=  "file_unitdate_display_t:" . getMonth($i,$monthArr);
				} // end FOR  
			} // end ELSE from > to

			else {
				if ($fromMonth > 0)
					$monthQuery .= "file_unitdate_display_t:" . getMonth($fromMonth,$monthArr);
				if ($toMonth > 0)
					$monthQuery .= "file_unitdate_display_t:" . getMonth($toMonth,$monthArr);	
			}

				$monthQuery .= ")";


                        if ($and)
                                $query .= $urland;
                        else
                                $and = true;

			$query .= urlencode($monthQuery);

                       	if (isset($_GET['sort']) && ($_GET['sort'] == NULL || $_GET['sort'] == ""))
                       		$sort = "unitdate_iso asc";

		} // end IF from or to months
	
	 } // end ELSE from or to years aren't filled in

		if ($date != "") {
			if ($and)
				$query .= $urland;
			else
				$and = true;

			//$query .= "file_unitdate:$date";
			$query .= "file_unitdate_display_t:";
			if ($_GET['day'] && $_GET['month'] && $_GET['year'])
				$date = '"'.$date.'"';

		 	$query .= urlencode($date);
		}
		// end DATE


		// check on freetext -- if it starts with an asterisk, get rid of the first asterisk 

		if (isset($_GET['subject_terms_t']) && $_GET['subject_terms_t'] != NULL && $_GET['subject_terms_t'] !== "") {
			if ($and)
				$query .= $urland;
			else
				$and = true;

			$query .= "subject_terms_t:{$_GET['subject_terms_t']}";
		}

		if (isset($_GET['ocr']) && $_GET['ocr'] != NULL && $_GET['ocr'] != "") {
			$ocr = $_GET['ocr'];
			//print "$ocr<br />";
			if (isset($_GET['freetext']) && $_GET['freetext'] != NULL && $_GET['freetext'] != "") {

				$ft = $_GET['freetext'];
				$ft = str_replace("+or+", "+OR+", $ft);
				$ft = str_replace(" and", " AND ", $ft);

				if (substr($ft, 0, 1) == "*") {
					$ft = substr($ft, 1);
					writeMessage("Please note: search terms cannot begin with an asterisk.");
				}

				if ($ocr == "on") {
					$template = "search";
					if ($and) 
						$query .= $urland; 
					else
						$and = true;

					$query .= "ocr:" . urlencode($ft);
				} // ocr on 
				
				else {
					if ($and) {
						$query = $ocr . $urland . $ft . $urland . $query;
					}
					else {
						$query = $ocr . $urland . $ft . $query; // query should be empty until now ??
						$and = true;
					}
				} // ocr off or is set to a freetext mode
			} // ft 
			else if ($ocr != "on") { // freetext came through OCR (during facet), but there isn't additional free text 
				if ($and) {
					$query = "ocr:". urlencode($ocr) . $urland . $query;
				}
				else {
					$query = "ocr:" . urlencode($ocr) . $urland . $query;
					$and = true;
				}
			}
		} // end OCR

		else { // OCR not set
			if (isset($_GET['freetext']) && $_GET['freetext'] != NULL && $_GET['freetext'] != "") {
                                $ft = $_GET['freetext'];
				$ft = str_replace(" or ", " OR ", $ft);
				$ft = str_replace(" and", " AND ", $ft);
                                if (substr($ft, 0, 1) == "*") {
                                        $ft = substr($ft, 1);
                                        writeMessage("Please note: search terms cannot begin with an asterisk.");
                                }

                                $ft = urlencode($ft);

                                if ($and) {
                                        $query = $ft . $urland . $query;
                                }
                                else {
                                        $query = $ft . $query; // query should be empty until now ??
					$and = true;
                                }
                        } // q

		} // end OCR not set

		if (isset($_GET['document_id']) && $_GET['document_id'] != NULL && $_GET['document_id'] != "") {
			$id = urlencode(htmlentities($_GET['document_id'], ENT_QUOTES, 'UTF-8'));
			if ($and)
				$query .= $urland;
			else
				$and = true;

			$pattern = "/\d{4}.\d{4}/";
			if (preg_match($pattern,$id)) {
				$id = substr($id,-9,9);
				$id = substr($id,0,4) . "_" . substr($id,-4,4);
				if (!stristr($id, "ldpd_leh_")) {
					$id = "ldpd_leh_" . $id;
				}
			}
			// else, just pass it along and let the query come back badly

			$query .= "document_id:$id";
		} // ID

		if (isset($_GET['genreform1_t']) && $_GET['genreform1_t'] != NULL && $_GET['genreform1_t'] != "") {
			$genreform = urlencode(htmlentities($_GET['genreform1_t'], ENT_QUOTES, 'UTF-8'));
			if ($and)
				$query .= $urland;
			else
				$and = true;

			$query .= "genreform1_t:$genreform";	
		}

		if (isset($_GET['q']) && $_GET['q'] != NULL && $_GET['q'] != "") {
			// allow override??
			$query = "q=" . urlencode($_GET['q']) . "&start=0&rows=20&wt=phps&indent=true";
			$sortArr = explode(';', $query);
			if ($sortArr[1])
				$sort = $sortArr[1];
		}

                if ($query == NULL || $query == "") {
                        writeError($appUrl);
                        exit;
                }

		if (!isset($_GET['q'])) { 	
			$query = str_replace(';file_unittitle+asc', '', $query);
			if ( stristr($query, $sort) === FALSE &&
                             stristr($query, urlencode($sort)) === FALSE ) {
				//$query .= ";" . urlencode($sort);
				$query .= "&sort=" . urlencode($sort);
			}
		}

		foreach(array_keys($_GET) as $key) {
		     if (!isset($_GET['q'])) {
			if (!in_array($key, $queryFields) && $key!="rows") {
				$rkey = $key;
				if (stristr($key,"facet_field") || ($key == "facet_mincount") ) {
					$rkey = str_replace("_", ".", $key);
					if (stristr($key,"facet_field") && substr($rkey, -1) != "d") {
						$rkey = substr($rkey, 0, -1);
					}
				}
				else if ( $key == "f_file_unittitle_facet_limit" ) {
					$rkey = "f.file_unittitle.facet.limit";
				}
				$query .= "&$rkey=" . $_GET[$key];
			}
			else if ($key == "rows") {
				if (!isset($_GET[$key]))
					 $query .= "&$key=20";
				else if ($_GET[$key] == NULL || $_GET[$key] == "") {
					$query .= "&$key=20";
				}
				else
					$query .= "&$key=" . $_GET[$key];
			} // end ELSE
		    } // if NOT set 'q'
		} // end FOREACH $get
	
	} // if $_GET exists

	if ($query != NULL && $query != "") { 
	
		if (!isset($_GET['q']))  
			$query = "q=$query";

		$facetAddOn = "&facet.date.start=1880-01-01T00:00:00.000Z&facet.date.end=1990-01-01T00:00:00.000Z&facet.date.gap=%2B10YEAR&facet.date=unitdate_iso";

		
                if ( ( isset($_GET['rows']) && $_GET['rows'] == "") 
                     || ! isset($_GET['rows'] ) )
                        $facetAddOn .= "&rows=20";


		if ( stristr($query, 'facet=true') === FALSE )
			$facetAddOn .= "&facet=true&facet.mincount=1&facet.field=file_unittitle&facet.field=genreform1&f.file_unittitle.facet.limit=-1";
		
		$result = searchSolr($query, $appUrl, $facetAddOn);
		extract($result);
		extract($responseHeader);
		extract($params);		

		extract($response);
		$pagination = "";

		$start = 0; $rows = 20;

		extract($params);

		// clean up
	        //if ($_GET['q']) {
		if (isset($_GET['q']) && $_GET['q']) {
			// Solr 1.4 -- may not be necessary
                        $q = str_replace($sort, '', $q);
			$q = str_replace(';', '', $q);
                }

		$qRevised = $q;
		$qRevised = str_replace($sort, '', $q);
		$qRevised = str_replace('T23:59:59Z', '', $qRevised);
		$qRevised = str_replace('[','', $qRevised);
		$qRevised = str_replace(']', '', $qRevised);
                $qRevised = str_replace("-01-01", '', $qRevised);
                $qRevised = str_replace("-12-31", '', $qRevised);
		$qRevised = str_ireplace("* TO", 'before', $qRevised);
		$qRevised = str_replace("TO *", " - ", $qRevised);
		$qRevised = str_replace("TO ", " - ", $qRevised);
		$qRevised = str_replace("*", '', $qRevised);
		$qRevised = str_replace("ldpd_leh_","Doc. ID ",$qRevised);
		$qRevised = str_replace("(","",$qRevised);
		$qRevised = str_replace(")","",$qRevised);
		
		foreach($queryFields as $field) {
			$field .= ":";
			if ($field != "file_unittitle" && $field != "file_unittitle_t" && $field != "unitdate_iso" && $field != "ocr:")
				$qRevised = str_replace($field, "", $qRevised);

		}		
		
		// replace file_unittitle_t with $_GET['file_unittitle_t'] to preserve any funk
		$qArr = explode(" $operator ", $qRevised);

		$qRevised = ""; // reuse this var
		$first = true;
		$fromYear = $_GET['fromYear'];
		$fromMonth = $_GET['fromMonth'];
		$fromDay = $_GET['fromDay'];
		$toYear = $_GET['toYear'];
		$toMonth = $_GET['toMonth'];
		$toDay = $_GET['toDay'];

		foreach($qArr as $qa) {
			if (stristr($qa, "ocr:")) {
				$qa = str_replace("ocr:", "", $qa);
				$qa .= " (subject)";
			}
			elseif (stristr($qa, "file_unittitle:")) {
				$qa = $_GET['file_unittitle_t'];
				$qa .= " (correspondent)";
			}
			elseif (stristr($qa, "unitdate_iso")) {
				$date = "";
				if ($fromYear)
					$date .= $fromYear;
				if ($fromMonth) {
					if ($date != "")
						$date .= "-"; 
					$date .= $monthArr[intval($fromMonth-1)];
				}
				if ($fromDay)
					$date .= "-" . $fromDay;
				if ($date != "" && ($toYear || $toMonth || $toDay) )
					$date .= " to ";
				if ($toYear)
                                        $date .= $toYear;
                                if ($toMonth) {
                                        if ($date != "")
                                                $date .= "-";
                                        $date .= $monthArr[intval($toMonth-1)];
				}
                                if ($toDay)
                                        $date .= "-" . $toDay;

				if ($date == $fromYear) {
					$date = substr($fromYear,0,3) . "0-" .  ((((int)substr($fromYear,0,4))*10) + 9);
				}
				$qa = str_replace('T23:59:59Z', '', $date);
				$qa = str_replace('-January-01','',$qa);
				$qa = str_replace('-December-31','',$qa);
				$qa = str_replace('-12-31','',$qa);
			}
			if ($first) {
				$qRevised .= $qa . " ";
				$first = !$first;
			}
			else {
				$qRevised .= " " . strtolower($operator) ." " . $qa;
			}
		}

		$qRevised = urldecode(str_replace(":", "", $qRevised));
		$qRevised = str_replace(';', '', $qRevised);
		$qRevised = str_replace($sort,'',$qRevised);
		
		if (substr($qRevised,-1) == "*")
			$qRevised = substr($qRevised,0,-1);

		foreach($monthArr as $m) {
			$m = strtolower($m);
			$qRevised = str_replace($m, ucfirst($m),$qRevised);
		}


// final round

		$qRevArr = explode(" OR ", $qRevised);
		$qRevised = $qRevArr[0] . " ";
		$dash = true;
		for($i = 1; $i < (count($qRevArr)-1); $i++) {
			if (!in_array($qRevArr[$i],$monthArr)) {	
				$qRevised .= " or " . $qRevArr[$i];
			}
			else {
                                if ($dash) {
                                        $qRevised .= "- ";
                                        $dash = !$dash;
                                }

			}
		} // end FOR

		if (in_array($qRevArr[(count($qRevArr)-1)],$monthArr) && $dash)
			$qRevised .= "- ";

		if (count($qRevArr) > 1)
			$qRevised .= str_replace("OR"," ",$qRevArr[(count($qRevArr)-1)]);
		

		$folders = array();
		$subjects = array();
		$dateRanges = array();
		$correspondents = array();
		$genreform = array();

		if($facet_counts && $numFound > 0) {
			extract($facet_counts);

			foreach(array_keys($facet_fields) as $k) {
				if ($k == "folder_num") {
					$folders = $facet_fields[$k];
				} // end IF folder_num
				else if ($k == "subject_name") {
					$subjects = $facet_fields[$k];
				}
				else if ($k == "file_unittitle") {
					$correspondents = $facet_fields[$k];
				}
				else if ($k = "genreform1") {
					$genreform = $facet_fields[$k];
				}
				else { 
				} // end ELSE
			} // end FOREACH facet_field key 

			foreach(array_keys($facet_dates) as $k) {
			       if ($k == "unitdate_iso") {
                                        $dateRanges = $facet_dates[$k];
                                }

			}
		} // IF facet_counts	

		if (!$start) {
			$start = 0;
		}
	
		if (!$rows) {
			$rows = 20;
		}

		$s = "s";

		if ($numFound == 1)
			$s = "";

		print "<p>Your search for <strong>$qRevised</strong> returned <strong>$numFound</strong> hit" . $s. ".</p>\n";

		if ($numFound > 0) {
		        $pagination = paginate($numFound, $start, $rows);
                	print $pagination;
			printList($docs, $dateRanges, $correspondents, $genreform, $sort, $q, $numFound, $env);

		else {
		writeSearchMenu('Search again',$appUrl);
		}

	} // end IF query 
	else {
		writeError($appUrl);
		exit;
	} // no query

        print '      </td>';
        print '    </tr>';
        print '  </table>';

	// if you want a sidebar, put it here	
	// include_once('includes/sidebar.php');

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

	exit;
?>

<?php

	function printList($docs, $dateRanges, $correspondents, $genreform, $sort, $q, $numFound, $env) {
		$q = urlencode($q);
		$sort = urlencode($sort);
		$url = "/search/?wt=phps&";
		$rows = "";
		if (!stristr("rows=", $q))
			$rows = "&rows=20";

               /* *************************** FACETS ************************************** */

               $isGenre = false;
               $isCorrespondent = false;
               $isDate = false;

		// these will hold the URLs that would correspond to what should be replaced if "all" [date/corr/genre]  is requested 
               $urlAllGenre = $urlAllCorrespondent = $urlAllDate = "";

               	// if genreform has been set
              	if (isset($_GET['genreform1_t']) && $_GET['genreform1_t']!= NULL && $_GET['genreform1_t'] != "") {
                       $isGenre = true;
                       $urlAllGenre = "genreform1_t:";
               	}

                // if correspondent has been set
               	if (isset($_GET['file_unittitle_t']) && $_GET['file_unittitle_t']!= NULL && $_GET['file_unittitle_t'] != "") {
                         $isCorrespondent = true;
                         $urlAllCorrespondent = "file_unittitle_t:";
                }
               
                 // if date has been set
                 if ( ( isset($_GET['fromYear']) && $_GET['fromYear']!= NULL && $_GET['fromYear'] != "" ) ||
                      ( isset($_GET['fromMonth']) && $_GET['fromMonth']!= NULL && $_GET['fromMonth'] != "" ) ||
                      ( isset($_GET['fromDay']) && $_GET['fromDay']!= NULL && $_GET['fromDay'] != "" ) ||
                      ( isset($_GET['toYear']) && $_GET['toYear']!= NULL && $_GET['toYear'] != "" ) ||
                      ( isset($_GET['toMonth']) && $_GET['toMonth']!= NULL && $_GET['toMonth'] != "" ) ||
                      ( isset($_GET['toMonth']) && $_GET['toMonth']!= NULL && $_GET['toMonth'] != "" )
               	     ) {
                      $isDate = true;
                      $urlAllDate = "unitdate_iso:";
                 }

		$qB = urldecode(str_replace($sort,'',$q));
		if (substr($qB,-1) == ";")
			$qB = substr($qB,0,-1);
		$queryArray = explode(" AND ", $qB);


		foreach($queryArray as $qA) {
			if (preg_match("/file_unittitle_t/",$qA)) {
				$urlAllCorrespondent = $qA;
			}
			else if (preg_match("/genreform1_t/",$qA)) {
				$urlAllGenre = $qA;
			}
			else if (preg_match("/unitdate_iso/",$qA)) {
				$urlAllDate = $qA;
			}
		}


		// print all of the facets that are greater than 0 for the date range, but if there are ranges
		// between items that have 0, indicate that as well

		$noZeroes1 = $noZeroes2 = 0;
		foreach(array_keys($dateRanges) as $f) {
			if ($dateRanges[$f] != "0")
				$noZeroes1++;	
		}

                foreach(array_keys($correspondents) as $f) {
                        if ($correspondents[$f] != "0")
                                $noZeroes2++;
                }

		if ($noZeroes1 > 2 || $noZeroes2 > 0) { //0=value? 1=gap 2=end
			print "<div style='float:right;padding:0px;margin-right:5px;width:135px;font-size:12px;background-color:#fff;'>"; //border:1px solid #ccc;'>\n";

			print "<table cellpadding=0 cellspacing=0 class='limitTable'>\n<tr>\n<th style='text-align:center;border-bottom:1px solid #ccc;background-color:#eee;font-size:12px;height:22px'><p><strong>Limit results</strong></p></th>\n</tr>\n";
			print "<tr>\n<td style='padding:3px;font-size:11px;'>\n";

			if ($noZeroes1>2) {
				print "<p><strong>Date:</strong> <br />";
                                $newQ = urldecode($q);
                                $newQ = str_replace($urlAllDate,"",$newQ);
                                $newQ = str_replace("AND  AND","AND",$newQ);

				if ($isDate && ($isCorrespondent || $isGenre)) {
					print "<a class=\"noUnderline\" href=\"$url" . makeQuery($newQ) . "\">All</a>&#160&#187;<br />";
				}

				$facetsValues = array_count_values($dateRanges);
				$printedOnce = false;
				$holdNonZeroes = array();
				foreach(array_keys($dateRanges) as $k) { // assumption -- these come back in order?
					if ($dateRanges[$k] > 0 && $k != "gap" && $k != "end") {
       	                                 	if (count($holdNonZeroes) > 0) {
       	                                         	foreach($holdNonZeroes as $h)
                                                       		print $h . "\n";
                                                	//unset($holdNonZeroes);
                                                	$holdNonZeroes = array();
                                        	}
							$fromYear = (int)substr($k,0,4);
							$toYear = (((int)substr($k,0,4))+9);

						// if info falls out of range of facet, re-range it	
						if (($fromYear <= (int)substr($k,0,4)) || !$isDate) 
							$fromYear = (int)substr($k,0,4);

						if ($toYear <= (((int)substr($k,0,4))+9) || !$isDate)
							$toYear = (((int)substr($k,0,4))+9);

						if (!$isDate || ($isDate && $noZeroes1 > 3)) {
							print "<a class=\"noUnderline\" href=\"$url" . makeQuery("unitdate_iso:[" . $fromYear . "-01-01 TO ". $toYear . "-12-31]" . " AND ". $newQ) . $rows . "\">" . $fromYear . "-" .  $toYear . "</a> (" . $dateRanges[$k] . ")<br />\n";
						} // if isDate 
						else {
							print $fromYear . '-' . $toYear . ' (' . $dateRanges[$k] . ")<br />\n";
						}
						if ($printedOnce == false) {
							$printedOnce = !$printedOnce;
						}
					}
					else if ($k != "gap" && $k != "end" && $printedOnce) {
						array_push($holdNonZeroes, substr($k,0,4) . "-" .  (((int)substr($k,0,4))+9) . " ($dateRanges[$k])<br />"); 
						$printedOnce = !$printedOnce;
					}
				}
				if ($noZeroes2 <= 0)
					print "</p></td></tr></table></div>\n"; //</div>\n";
			} // end IF noZeroes1
		} // subjects facet 1




                if (count($correspondents) > 0 && $noZeroes2 > 0) {
                        print "<p><strong>Corresp. File:</strong> <br />";

                       	if ($isCorrespondent && ($isGenre || $isDate)) {
                              $newQ = urldecode($q);
                              $newQ = str_replace($urlAllCorrespondent,"",$newQ);
                              $newQ = str_replace("AND  AND","AND",$newQ);
                              print "<a class=\"noUnderline\" href=\"$url" . makeQuery($newQ) . "\">All</a>&#160&#187;<br />";
                        }

			$i = 0;
			$VISIBLE = 5;
			$restOfFacet = "";

			if (count($correspondents) <= 5) {
				$VISIBLE = count($correspondents);	
			}
			else
				$restOfFacet = "&#160;<a class=\"noUnderline\" href=\"javascript:toggle('rest','More corresp. (" . (count($correspondents)-5) . " more)','Less corresp.')\" class=\"toggle\"><img id=\"Irest\" border=\"0\" src=\"http://www.columbia.edu/cu/lweb/images/icons/left-off.gif\"><span id=\"spanblurbrest\">More corresp. (" . (count($correspondents)-5) . " more)</span></a>\n";
				$restOfFacet .= '<div class="expand" id="Lrest" style="display:none;">';
                        foreach(array_keys($correspondents) as $k) {
                               	if ($correspondents[$k] > 0 && $k != "gap" && $k != "end") {
					$sortA = $sort . ";";
					$qA = str_replace($sortA, "", $q);	
					$qA = makeQuery('file_unittitle_t:"' . $k . '" AND '. urldecode($qA));
					$qA = str_replace("%253B", ";", $qA);
					if ($i < $VISIBLE) {
						if (!$isCorrespondent)
                                       			print "<a class=\"noUnderline\" href=\"$url" . $qA . $rows . "\">$k</a> ($correspondents[$k])<br />";
						else
							print "$k ($correspondents[$k])<br />";
					}
					else {
						$restOfFacet .= "<a class=\"noUnderline\" href=\"$url" . $qA . $rows . "\">$k</a> ($correspondents[$k])<br />";
					}
					$i++;
                                }
                        }
			if ($VISIBLE >= 5) {
				$restOfFacet .= "</div>\n";
				print $restOfFacet . "\n";
			}

                        if (count($genreform) <= 0)
                                print "</p></td></tr></table></div>\n";
                } // end IF correspondent facets

                if (count($genreform > 0)) {
                        print "<p><strong>Document Type:</strong> <br />";

                        if ($isGenre && ($isCorrespondent || $isDate)) {
                              $newQ = urldecode($q);
                              $newQ = str_replace($urlAllGenre,"",$newQ);
                              $newQ = str_replace("AND  AND","AND",$newQ);
                              print "<a class=\"noUnderline\" href=\"$url" . makeQuery($newQ) . "\">All</a>&#160&#187;<br />";
                        }


                        foreach(array_keys($genreform) as $k) {
                                if ($genreform[$k] > 0) {
                                        $sortA = $sort . ";";
                                        $qA = str_replace($sortA, "", $q);
                                        $qA = makeQuery('genreform1_t:'. $k . ' AND ' . urldecode($qA));
                                        $qA = str_replace("%253B", ";", $qA);
					$genre = ucfirst($k);
					if ($genre == "")
						$genre = "none";
					if (!$isGenre) 
                                        	print "<a class=\"noUnderline\" href=\"$url" . $qA . $rows . "\">" . ucfirst($genre) . "</a> ($genreform[$k])<br />";
					else
						print ucfirst($genre) . " (" . $genreform[$k] . ")<br />";
				} 
			} // end FOREACH genreform
                         print "</p></td></tr></table></div>\n";
                } // end IF genreform facet		
		
		if (count($dateRanges) || count($correspondents))
			 print "<table class=\"resultsList\" style=\"width:580px;\">\n<tr>\n";
		else
		
			print "<table class=\"resultsList\">\n<tr>\n";
	
		$accepted_orders = array("document_id", "file_unittitle", "genreform1", "unitdate_iso");
		$nice_names = array("Doc. ID", "Correspondent File", "Doc. Type", "Date"); 

		for ($i = 0; $i < count($accepted_orders); $i++) {
			$lookFor = urlencode($accepted_orders[$i]) . urlencode(" asc");
			if (stristr($lookFor, "genreform1"))
				$lookFor .= urlencode(",pages asc");
			$opp = urlencode($accepted_orders[$i]) . urlencode(" desc");
			$url = str_replace("search.php", "search/", $_SERVER['PHP_SELF']) . "?" . $_SERVER['QUERY_STRING'];

			if (isset($_GET['sort']) && ($_GET['sort'] == "" || $_GET['sort'] == NULL)) {
				$url = str_replace("&sort=","&sortsort", $url);
			}

			if (isset($_GET['q']) && $_GET['q']) {
				$url = str_replace("search.php", "search/", $_SERVER['PHP_SELF']) . "?q=" . $q; // . ";$sort";
			}

			if ($accepted_orders[$i] == "document_id") {
				print "<th>$nice_names[$i]</th>\n";
			} // end IF document_id

			else {
				print "<th>\n";
				if (stristr($lookFor, $sort)) { // && (stristr($sort, "asc"))) {
					print '<img src="http://www.columbia.edu/cu/lweb/images/icons/az-off.gif" width="8" border="0" alt="" />';
				}
				else { 
					print '<a href="';
					if (str_replace($sort, $lookFor, $url)) {
						print str_replace($sort,$lookFor,$url);
                                	}
					else if (str_replace(urlencode($sort), urlencode($lookFor), $url)) {
						print str_replace(urlencode($sort),urlencode($lookFor),$url);
					}
                                	else
                                        	print $url . '&sort=' . $lookFor;
                                	print '"><img src="http://www.columbia.edu/cu/lweb/images/icons/az-on.gif" width="8" border="0" alt="" /></a>';
				}

				print " $nice_names[$i] ";

                        	$lookFor = urlencode($accepted_orders[$i]) . urlencode(" desc");
				if (stristr($lookFor, "genreform1"))
                                	$lookFor .= urlencode(",pages desc");

                        	$opp = urlencode($accepted_orders[$i]) . urlencode(" asc");

				if ( stristr($lookFor, $sort)) { // && (stristr($sort, "desc")) ) {
                                	print '<img src="http://www.columbia.edu/cu/lweb/images/icons/za-off.gif" width="8" border="0" alt="" />';
                        	}

				else {
					print '<a href="';
					if (str_replace($sort, $lookFor, $url)) {
						print str_replace($sort, $lookFor, $url);
					}
                                        else if (str_replace(urlencode($sort), urlencode($lookFor), $url)) {
                                                print str_replace(urlencode($sort),urlencode($lookFor),$url);
                                        }
					else
						print $url . '&sort=' . $lookFor;
					print '"><img src="http://www.columbia.edu/cu/lweb/images/icons/za-on.gif" width="8" border="0" alt="" /></a>';
				}
				print "</th>";
			} // end ELSE (not ID)	
		} // end FOR i

		print "</tr>";

		$bool = true;
		$i = 0;
		$start = 0;

		if (isset($_GET['start']) && $_GET['start'] != "") 
			$start = $_GET['start'];
		
		foreach($docs as $doc) {
			$q = urldecode($q);
			if (substr($q,-1) == ";")
				$q = substr($q,0,-1);
			$q = urlencode($q);

			$urlAdd = "&q=$q;&items=$numFound&itemNo=" . ($start + $i++);
			extract($doc);
			// f3f8fd style:cursorpointer
			print "<tr onMouseOver=\"this.style.background='#f3f8fd'\" onMouseOut=\"this.style.background='#fff'\">"; 
 			$modifiedID = substr($document_id,9);
			// replaced results.php with /lehman/
			print "<td width=15% valign=top style='font-size:11px;'><a href=\"/lehman/document_id=$document_id?$urlAdd\" class=\"noUnderline\" style='color:#000'>" . $modifiedID . "</a></td>\n";
			print "<td width=35% valign=top style='font-size:11px;'><a href=\"/lehman/document_id=$document_id?$urlAdd\" class=\"noUnderline\" style='color:#000'>$file_unittitle</a></td>\n";
			print "<td width=25% valign=top style='font-size:11px;'><a href=\"/lehman/document_id=$document_id?$urlAdd\" class=\"noUnderline\" style='color:#000'>$genreform1 ($pages page";
				if ($pages > 1) echo 's';
			print ")</a></td>\n";
			print "<td width=25% valign=top style='font-size:11px;'><a href=\"/lehman/document_id=$document_id?$urlAdd\" class=\"noUnderline\" style='color:#000'>";
			if ( isset($file_unitdate_display) )	
				echo $file_unitdate_display;
			else
				echo 'n.d.';
			print "</a></td>\n";
			$img1 = "http://www.columbia.edu/cu/lweb/digital/collections/cul/texts/images/bookcitation-sm.gif";
			$img2 = "https://www1.columbia.edu/sec/cu/libraries/staffweb/img/assets/6635/key_cuid.gif"; //images/restricted.jpg";

			print "</tr>\n";
		} // end FOREACH $doc
                        $img1 = "http://www.columbia.edu/cu/lweb/digital/collections/cul/texts/images/bookcitation-sm.gif";
                        $img2 = "https://www1.columbia.edu/sec/cu/libraries/staffweb/img/assets/6635/key_cuid.gif"; //images/restricted.jpg";
		print "</table>";
		
	} // end FUNCTION printList

	function printSearch($docs, $sort, $dlo, $q, $numFound) {

               if (isset($_GET['start']) && $_GET['start'] != "")
                        $start = $_GET['start'];

                foreach($docs as $doc) {
                        $q = urldecode($q);
                        if (substr($q,-1) == ";")
                                $q = substr($q,0,-1);
                        $q = urlencode($q);

                        $urlAdd = "&q=$q;&items=$numFound&itemNo=" . ($start + $i++);

			extract($doc);
			$r = isRestricted();
			$url = "results.php";

			if (!$r)
				$url = "restricted.php";
		
			$s = "";
			if ($pages != 1)
				$s = "s";

			print "<table><tr><td valign=top>\n";
			print "<td><a href=\"$url?document_id=$document_id&$urlAdd\">";
			print '<img src="' . $dlo . '?obj=' . $document_id . '_001&size=200" alt="' .$genreform1 . '" height="50" border="0" />';
			print "</a></td>\n";
			print "<td valign=top><strong><a href=\"$url?document_id=$document_id&$urlAdd\">$file_unittitle ($genreform1)</a></strong><br />";
			print "$file_unitdate_display<br />";
			print "$pages page$s<br />";
			print "</td></tr></table>";


                } // end FOREACH $docs

	} // end FUNCTION printSearch

	function writeSearchMenu($msg,$appUrl) {
		print "<script>document.getElementById('searchBox').style.display='none';</script>";
                print '<div style="padding:5px;margin:5px;border:1px solid #ddd;background:#eee;">';
                print "<h3>$msg</h3>";
                include("includes/searchform.php");
		print "</div>\n";
	} // end FUNCTION writeSearchMenu

	function writeError($appUrl) {
		//print "\n<p>Please enter a search.</p>\n";
		writeSearchMenu('Please enter a search:',$appUrl);
		include_once('includes/pre_footer.php');
		include_once('includes/footer.php');	
	}

	function paginate($max, $start, $increment) {

		$url = $_SERVER['PHP_SELF'] . "?";
	
		$queryArray = explode("&", $_SERVER['QUERY_STRING']);	
		$ampersand = false;

		foreach($queryArray as $query) {
			$nameVal = explode("=", $query);
			if ($nameVal[0] != "start" && (count($nameVal) > 0) ) {
				if ($ampersand) {
					$url .= "&" . $nameVal[0] . "=" . $nameVal[1];
				}
				else {
					$ampersand = !$ampersand;
					$url .= $nameVal[0] . "=" . $nameVal[1];
				}
			}	
		} // end FOREACH query_string key


		$max = (int)$max;
		$start = (int)$start;
		$increment = (int)$increment;

		$pagination = '<table class="optionsBar" width="100%" style="border-bottom:1px solid #ccc;margin-bottom:5px;"><tr><td align="left" style="font-size:11px;">';

		$min = 0;
		$prev = $next = "";
		$prevPage = "&lt;";
		$nextPage = "&gt;";
		$prevSec = "<span style='letter-spacing:-3px;'>&lt;&lt;</span>";
		$nextSec = "<span style='letter-spacing:-3px;'>&gt;&gt;</span>";

		$pagination .= "Displaying hits " . ($start + 1) . "-";

                // get current page
                $curPage = (int)($start/$increment) + 1;

		if (($start + $increment) <= $max) {
			$pagination .= ($start + $increment);			
		}

		else {
			$pagination .= $max;
		}

		$pagination .= " of " . $max . "</td>";
		$pagination .= "<td align=\"right\" style=\"font-size:11px;\">";

		// does prev exist?
		if ( ($start - $increment) >= $min) {
			$prev .= '<a title="Previous page (page ' . ($curPage-1). ')" class="noUnderline" href="' . $url . '&start=' . ($start - $increment) . '">' . $prevPage . '</a>';
		}
		else {
			$prev .= "<span style='color:#ccc'>" . $prevPage . "</span>\n";
		}

		// does next exist?
		if (($start + $increment) < $max) {
			$next .= '<a title="Next page (page ' . ($curPage+1) . ')" class="noUnderline" href="' . $url . '&start=' . ($start + $increment) . '">' . $nextPage . '</a>';
		}
		else {
			$next .= '<span style="color:#ccc">' . $nextPage . '</span>' . "\n";
		}	
		
	
        	// pagination <<1, 2, 3, 4, 5, 6, 7, 8, 9, 10>>

       	 	// get incremental
        	$y = (int)(($curPage - 1)/10) * 10;

        	$i = 1;
        	$maxPage = (int)($max/$increment) + 1;

        	if ($max%10 == 0) {
                	$maxPage = (int)($max/$increment) + 1; // added +1
	        } // adjust for edge divisible by clock value

        	$maxIterations = 10;
        	$maxJumpMenu = $y + $maxIterations;

        	if ($maxPage < $maxJumpMenu) {
                	$maxIterations = (int)($maxPage%10);
        	}

        	if ($maxPage <= 1) {
                	$pagination .= '<span style="color: #ccc;">';
        	}

        	$pagination .= "<strong>Jump to page:</strong>&#160;"; //. $prev . "&#160;";
		
        	if ($y <= 0) {
			$pagination .= '<span style="color:#ccc;">' . $prevSec . '</span>';
        	}
        	else {
                	$pagination .= '<a title="Previous 10 pages (pp. ' . ($y-9) . '-' . $y. ')" class="noUnderline" href="' . $url . '&start=' . ($start - ($increment*($curPage - $y)) ). '">' . $prevSec . '</a>';
        	}

		$pagination .= "&#160;" . $prev . "&#160;";

        	for ($i; $i <= $maxIterations; $i++) {
                	if ( ($y+$i) == $curPage )  {
                        	$pagination .= '<strong>' . ($y+$i) . '</strong>';
                	}
                	else if (($y+$i) < $curPage) {
                        	$pagination .= '<a title="Page ' . ($y+$i). '" class="noUnderline" href="'. $url . '&start=' . ($start - ($increment*($curPage-$y-$i))) . '">' . ($y+$i) . '</a>';
                	}
                	else {
                        	$pagination .= '<a title="Page ' . ($y+$i) . '" class="noUnderline" href="' . $url . '&start=' . ($start + ($increment*($i-($curPage-$y)))) . '">' . ($y+$i) . '</a>';
                	}

                	$pagination .= '&#160;';

        	} // end FOR $i

		$pagination .=  $next . '&#160;';

        	if ( $y+11 > $maxPage ) {
                	// do nothing
			$pagination .= '<span style="color:#ccc;">' . $nextSec . '</span>';
        	}

        	else {
$pagination .= '<a title="Next 10 pages (pp. ' . ($y+11) . '-' .  ($y+$increment) . ')" class="noUnderline" href="' . $url . '&start=' . ($start + ($increment*($i-($curPage-$y)))) . '">' . $nextSec . '</a>';

		}

        	if ($maxPage <= 1) {
                	$pagination .= '</span>';
        	}

	$pagination .= '</td></tr></table>';

	return $pagination;	

} // end FUNCTION paginate

function writeMessage($msg) {
	print "<p style=\"font-size:11px;color:red;\">$msg</p>\n";
}

function getMonth($mo, $monthArr) {
	if ($mo == 0)
		$mo = 12;

	return $monthArr[$mo-1];
}

?>
