        <form method="get" action="/search.php" id="searchForm">

	<table class="searchTable">
		<tr>
			<td class="optionTitle">Search by keyword</td>
			<td class="option">
			<input size="30" type="text" name="freetext" value="<?php if(isset($_GET['freetext'])) echo $_GET['freetext'];?>" />
                	&#160;<input type="checkbox" name="ocr">Search only text [<a href="#">?</a>]
			<span style="margin-left:10px;"><input class="btn" type="submit" value="Search" />&#160;&#160;<input class="btn" type="button" value="Clear" onClick="resetMe()"/></span>
			</p>
</td>
</tr>
<tr>
<td class="optionTitle">Search or limit by</td>
<td class="option">
	Free-text correspondent:
	<input name="string" type="text" id="string" />
	<div id="acDiv"></div>
	<select name="select" style="width:0px;visibilty:hidden;"></select>
		

<p>
<label for="file_unittitle_t">Correspondent:</label>
                                <select name="file_unittitle_t" style="width:300px;">
                                <option value="">[Correspondent]</option>
<?php
        print "\n";
       $searchUrl = "http://" . $appUrl . ".cul.columbia.edu:8080/lehman/select?q=subseries:Correspondence&rows=0&facet=true&facet.field=file_unittitle&facet.sort=false&facet.limit=10000&wt=phps";
        $serializedResult = file_get_contents($searchUrl);
        $result = unserialize($serializedResult);
        extract($result);
        extract($responseHeader);
        extract($params);

        if($facet_counts) {
                extract($facet_counts);
                foreach($facet_fields as $facet) {
                        foreach(array_keys($facet) as $key) {
                                print '<option value="' . htmlentities($key, ENT_QUOTES, 'UTF-8') . '"';
                                if (isset($_GET['file_unittitle_t']) && ($_GET['file_unittitle_t'] == $key))
                                        print " selected=\"selected\"";
                                print '>' . $key . "</option>\n";
                        }
                } // end FOREACH facet_field
        } // IF facet_counts
?>
                </select>
</p>
                <p>
                <label for="year">Date: </label>
                <select name="year" id="year" onBlur="checkDate()">
                <option value="">[year]</option>

<?php
        $dupArr = array();
      	$searchUrl = "http://" . $appUrl . ".cul.columbia.edu:8080/lehman/select?q=subseries:Correspondence&rows=0&facet=true&facet.field=file_unitdate&facet.sort=false&facet.limit=10000&wt=phps&facet.mincount=1";
        $serializedResult = file_get_contents($searchUrl);

        $result = unserialize($serializedResult);
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
        foreach($dupArr as $date) {
                //sort($date);
                print '<option value="' . $date . '"';
                if (isset($_GET['year']) && ($_GET['year'] == $date))
                        print " selected=\"selected\"";

                print '>'. $date . "</option>\n";
        }

?>
                </select>&#160;

                <select name="month" id="month" onBlur="checkDate()">
                <option value="">[month]</option>
                <?php
                        $month = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
                        for ($i=0; $i < 12; $i++) {
                                print '<option value="' . str_pad($i+1,2,"0", STR_PAD_LEFT) . '"';
                                if( isset($_GET['month']) && ($_GET['month'] == (str_pad($i+1,2,"0", STR_PAD_LEFT))) )
                                        print ' selected="selected"';
                                print ">" . $month[$i]. "</option>\n";
                        }
                ?>
                </select>

                <select name="day" id="day" disabled="true" onBlur="checkDate()">
                <option selected value="">[day]</option>
<?php
                for ($i=1; $i < 32; $i++) {
                        print '<option value="'. str_pad($i,2,"0", STR_PAD_LEFT) . '"';
                        print '>' . $i . "</option>\n";
                }
?>
                </select>
<!-- end date -->
<!-- </p>
 <p> --><label for="genreform1_t">Document type:</label>
                <select name="genreform1_t">
                <option selected="selected" value="">[type]</option>

<?php

        $searchUrl = "http://" . $appUrl . ".cul.columbia.edu:8080/lehman/select?q=subseries:Correspondence&rows=0&facet=true&facet.field=genreform1&facet.so
rt=false&facet.limit=10000&wt=phps";
        $serializedResult = file_get_contents($searchUrl);
        $result = unserialize($serializedResult);
        extract($result);
        extract($responseHeader);
        extract($params);

        if($facet_counts) {
                extract($facet_counts);
                foreach($facet_fields as $facet) {
                        ksort($facet);
                        foreach(array_keys($facet) as $key) {
                                if ($key != "") {
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
</p>


                <p><label for="document_id">Document number:</label> <input type="text" size="20" name="document_id" value="<?php if(isset($_GET['document_id'])) echo $_GET['document_id'];?>" />&#160;<em style="font-size:10px;">E.g., ldpd_leh_0001_0001 or 0002_0001</em></p>
</td>
</tr>
<tr>
<td class="optionTitle">Options</td>
<td class="option">
                <p><label for="rows">Display</label>
                <select name="rows">
		<option value="10">10</option>
		<option value="20" selected="selected">20</option>
		<option value="50">50</option>

                </select>
                results per page <!-- </p>
		<p>-->&#160;<label for="sort">Sort by:</label>&#160;
		<select name="sort">
			<!-- <option value="">[sort]</option> -->
			<option value="file_unittitle_t asc">Correspondent</option>
			<option value="unitdate_iso asc">Date</option>
			<option value="genreform1 asc, pages asc">Document type</option>
		</select>
		</p>
<?php
                include_once('../includes/formfields.php');
?>
	</td></tr>
	<tr><td colspan="2" align="center">
	</td></tr></table>
        </form>
<script>
var AC = new dmsAutoComplete('string','acDiv');
AC.clearField = false;
AC.chooseFunc = function(id,label) {
	alert(id+'-'+label);
}  // end chooseFunc


</script>
