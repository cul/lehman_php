        <form method="get" action="index.php">
                <p>Search for: <input type="text" name="q" value="<?php if ($_GET['q']) echo $_GET['q']; ?>" />&nbsp;<input type="submit" value="Go" />
                <br />Display
                <select name="rows">
                <?php
                        $dispArr = array("10", "20", "50");
                        foreach($dispArr as $disp) {
                        if ($_GET['rows'] && $_GET['rows'] == $disp) {
                                echo '<option selected="selected" value="' . $disp . '">' . $disp . '</option>' . "\n";
                        }
                        else
                                echo '<option value="' . $disp . '">' . $disp . '</option>';
                        } // end FOREACH $dispArr
                ?>
                </select>
                results per page</p>

                <input type="hidden" name="version" value="2.2" />
                <input type="hidden" name="start" value="0" />
                <input type="hidden" name="qt" value="standard" />
                <input type="hidden" name="wt" value="phps" />
                <input type="hidden" name="indent" value="on" />
                <input type="hidden" name="facet" value="true" />
                <input type="hidden" name="facet.field" value="genreform" />
                <input type="hidden" name="facet.mincount" value="1" />
                <input type="hidden" name="h1" value="on" />
                <input type="hidden" name="h1.f1" value="ocr" />
<!--            
		<input type="hidden" name="fragsize" value="50" /> 
-->
                <input type="hidden" name="f1" value="*,score" />
<!--
                <input type="hidden" name="snippets" value="5" />
                <input type="hidden" name="h1.simple.pre" value="%3Cspan%20class%3Dhighlight%3E">
                <input type="hidden" name="h1.simple.post" value="%3C/span%3E">
-->
        </form>


