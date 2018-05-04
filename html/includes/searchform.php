<form method="get" action="/lehman/search/" id="searchForm">
  <p>
    <label for="file_unittitle_t">Correspondent:&#160;&#160;</label>
    <select name="file_unittitle_t"><!--style="width:300px;" -->
      <option value="">[Correspondent]</option>

      <?php
	$result = searchSolr("q=subseries:Correspondence&rows=0&facet=true&facet.field=file_unittitle&facet.sort=false&facet.limit=10000&wt=phps", $appUrl, "");
        extract($result);
        extract($responseHeader);
        extract($params);
	
        if($facet_counts)
        {
          extract($facet_counts);
          foreach($facet_fields as $facet)
          {
            foreach(array_keys($facet) as $key)
            {
              print '<option value="' . htmlentities($key, ENT_QUOTES, 'UTF-8') . '"';
              // strip out front and back quotes to get match with correspondent
              if (isset($_GET['file_unittitle_t']))
              {
                $correspondent = urldecode($_GET['file_unittitle_t']);
                $corrArray = explode(' AND ',$correspondent);
                // just take one correspondent, or the whole thign
                $correspondent = $corrArray[0];
                //print "\n<pre>$correspondent</pre>\n";
                if (substr($correspondent,0,1) == '"')
                {
                  $correspondent = substr($correspondent, 1, strlen($correspondent));
                }
                if (substr($correspondent,-1) == '"')
                {
                  $correspondent = substr($correspondent,0,-1);
                }
                //print "\n<pre>$correspondent</pre>\n";
                if  ($correspondent == $key)
                {
                  print " selected=\"selected\"";
                }
              } // end IF isset ($_GET['file_unittitle_t'])
              print '>' . $key . "</option>\n";
            }
          } // end FOREACH facet_field
        } // IF facet_counts
      ?>
    </select>

<input type="submit" value=" Go " />&#160;<input type="button" value="Clear" onClick="resetMe()"/>
<?php
        $dupArr = array();
        $result = searchSolr("q=subseries:Correspondence&rows=0&facet=true&facet.field=file_unitdate&facet.sort=false&facet.limit=10000&wt=phps&facet.mincount=1",$appUrl,"");
        extract($result);
        extract($responseHeader);
        extract($params);
        extract($response);
        if($facet_counts) {
                extract($facet_counts);
                foreach($facet_fields as $facet) {
			ksort($facet);
                        foreach(array_keys($facet) as $date) {
 				$dateArr = explode("-", $date);
                                if (!in_array($dateArr[0], $dupArr) && $dateArr[0] != "") {
                                        array_push($dupArr, $dateArr[0]);
                                }
                        }
                } // end FOREACH facet_field

        } // IF facet_counts
	
	sort($dupArr);

			$month = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
		?>

                <p>Words in Documents (<a href="/lehman/text/">about this option</a>): &#160;&#160;
		<input type="text" size="30" name="freetext" value="<?php 
				$queryFields = array("file_unittitle", "file_unittitle_t", "file_unitdate_display", "file_unitdate_display_t", "freetext", "year", "month", "day", "ocr", "document_id", "genreform1_t", "file_unitdate", "sort", "asc", "desc", "subject_name_t", "unitdate_iso", "_t", "fromYear", "fromMonth", "fromDay", "toYear", "toMonth", "toDay", "subject_terms_t");

				if(isset($_GET['freetext'])) {
					$freetext = strip_tags($_GET['freetext']);
					if (substr($freetext,0,1) == "*")
						$freetext = substr($freetext,1);
					else
						$freetext = $freetext;
					foreach($queryFields as $q) {
						$freetext = str_replace($q . ":", "", $freetext);
					}
					echo $freetext;
				}
			?>" />
                &#160;<input type="checkbox" name="ocr">Search only text</ocr></p> 
<p><label for="dateRange">Date</label> (<a href="/lehman/text/#date">about this option</a>):&#160;From <select name="fromYear" id="fromYear">
<option value="">[year]</option>
<?php
        foreach($dupArr as $date) {
                print '<option value="' . $date . '"';
                if (isset($_GET['fromYear']) && ($_GET['fromYear'] == $date))
                        print " selected=\"selected\"";
                print '>'. $date . "</option>\n";
        }
?>
</select>

<select name="fromMonth" id="fromMonth" onBlur="checkDate('fromDay')">
<option value="">[month]</option>
<?php
                        for ($i=0; $i < 12; $i++) {
                                print '<option value="' . str_pad($i+1,2,"0", STR_PAD_LEFT) . '"';
                                if( isset($_GET['fromMonth']) && ($_GET['fromMonth'] == (str_pad($i+1,2,"0", STR_PAD_LEFT))) )
                                        print ' selected="selected"';
                                print ">" . $month[$i]. "</option>\n";
			}
?>
</select>

<select name="fromDay" id="fromDay"><!-- disabled="true" onBlur="checkDate('fromDay')" -->
<option value="" style="color:#999">[day]</option>
<?php
                for ($i=1; $i < 32; $i++) {
                        print '<option value="'. str_pad($i,2,"0", STR_PAD_LEFT) . '"';
                        if(isset($_GET['fromDay']) && ($_GET['fromDay'] == $i))
                                print ' selected="selected"';
                        print '>' . $i . "</option>\n";
                }
?>
</select>

&#160;&#160;To 
<select name="toYear" id="toYear"> <!-- onBlur="checkDate('toDay')"> -->
<option value="">[year]</option>
<?php
        foreach($dupArr as $date) {
                print '<option value="' . $date . '"';
                if (isset($_GET['toYear']) && ($_GET['toYear'] == $date))
                        print " selected=\"selected\"";
                print '>'. $date . "</option>\n";
        }
?>
</select>

<select name="toMonth" id="toMonth" onBlur="checkDate('toDay')">
<option value="">[month]</option>
<?php
                        for ($i=0; $i < 12; $i++) {
                                print '<option value="' . str_pad($i+1,2,"0", STR_PAD_LEFT) . '"';
                                if( isset($_GET['toMonth']) && ($_GET['toMonth'] == (str_pad($i+1,2,"0", STR_PAD_LEFT))) )
                                        print ' selected="selected"';
                                print ">" . $month[$i]. "</option>\n";
			}
?>
</select>

<select name="toDay" id="toDay"> <!--  disabled="true" onBlur="checkDate('toDay')" -->
<option value="">[day]</option>
<?php
                for ($i=1; $i < 32; $i++) {
                        print '<option value="'. str_pad($i,2,"0", STR_PAD_LEFT) . '"';
                        if(isset($_GET['toDay']) && ($_GET['toDay'] == $i))
                                print ' selected="selected"';
                        print '>' . $i . "</option>\n";
                }
?>
</select>
</p>

                <p>Doc. type: <select name="genreform1_t">
                <label for="genreform1_t">Document Type</label>
                <option selected="selected" value="">[type]</option>

<?php

	$result = searchSolr("q=subseries:Correspondence&rows=0&facet=true&facet.field=genreform1&facet.sort=false&facet.limit=10000&wt=phps", $appUrl, "");
        extract($result);
        extract($responseHeader);
        extract($params);

        if($facet_counts) {
                extract($facet_counts);
                foreach($facet_fields as $facet) {
                        ksort($facet);
                        foreach(array_keys($facet) as $key) {
                                if ($key != "" && $key != "sm") {
                                        if (isset($_GET['genreform1_t']) && ($_GET['genreform1_t'] == $key))
                                                print '<option value="' . $key . '" selected="selected">'. $key . "</option>\n";
                                        else
                                                print '<option value="' . $key . '">'. $key . "</option>\n";
                                }
                        }
                } // end FOREACH facet_field
        } // IF facet_counts

?>
        </select>
&#160;&#160;<label for="document_id">Doc. ID:</label> <input size="15" type="text" name="document_id" value="<?php if(isset($_GET['document_id'])) echo strip_tags($_GET['document_id']);?>" /> 

                &#160;&#160;
               Show 
                <select name="rows">
		<option value="10">10</option>
		<option value="20" selected="selected">20</option>
		<option value="50">50</option>
                </select>
                results per page</p>
		<input type="hidden" name="sort" value="file_unittitle asc" />
		<input type="hidden" name="operator" value="AND" />
<?php
include('formfields.php');
?>

        </form>
