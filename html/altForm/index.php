<?php
	$htmlTitle = "Lehman Special Correspondence Files";
	$addlBody = 'onload="checkDate();"';
	include_once('../includes/header.php');
	print '<script language="javascript" type="text/javascript" src="dmsAutoComplete.js"></script>';
	include_once('dmsAutoComplete.php');

?>
	<style>
#acDiv{ border: 1px solid #9F9F9F; background-color:#F3F3F3; padding: 3px; font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif; color:#000000; display:none; position:absolute; z-index:999;}
#acDiv UL{ list-style:none; margin: 0; padding: 0; }
#acDiv UL LI{ display:block;}
#acDiv A{ color:#000000; text-decoration:none; }
#acDiv A:hover{ color:#000000; }
#acDiv LI.selected{ background-color:#7d95ae; color:#000000; }

<?php
    for ($i = 1; $i <= 2; $i++) {
        print "#acDiv$i {border: 1px solid #9F9F9F; background-color:#F3F3F3; padding: 3px; font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif
; color:#000000; display:none; position:absolute; z-index:999;}\n";
        print "#acDiv$i UL { list-style:none; margin:0; padding: 0; }\n";
        print "#acDiv$i UL LI { display:block;}\n";
        print "#acDiv$i A { color:#000000; text-decoration:none; }\n";
        print "#acDiv$i A:hover { color:#000000; }\n";
        print "#acDiv$i LI.selected { background-color:#a896c7; color:#000000; list-style-type:none;}\n";
    }
?>
	</style>

<?php
	$appUrl = "appdev";

        if (stristr($_SERVER['SERVER_NAME'], '-test')) {
                $appUrl = "apptest";
        }
        else if (stristr($_SERVER['SERVER_NAME'], 'lehman.cul')) {
                $appUrl = "app";
        }
        else {
                $appUrl = "appdev";
        }

	// draw form
?>

<div style="float:left;width:190px;">
<img src="../images/image3.jpg" alt="Sample telegram from the Lehman Special Correspondence Files Online" width="185" />
<!-- 
<h3>More information...</h3>
<ul>
<li>About the Project</li>
<li>Lehman Collection Finding Aid</li>
</ul>
-->
</div>
<div style="float:right;width:525px">

<h2>Lehman Special Correspondence Files</h2>
<!-- 
<p>
The Columbia University Libraries has scanned and made available here electronically the Special Correspondence Files of Herbert Lehman. More than 37,000 documents are included. Typed documents have also been OCRed, permitting full-text searching.
</p>
-->
<!-- 
<div style="border:1px solid #369;width:350px"  onMouseOver="this.style.background='#f3f8fd';this.style.color='#69c'" onMouseOut="this.style.background='#fff';this.style.color='#fff'"><a href="#search" style="cursor:pointer;text-decoration:none;"><span style="padding:0 2px 0 2px;background:#369;text-align:center;color:#fff;">&raquo;</span>&#160;Search the Lehman Special Correspondence Files</a>
</div>
-->
<p>
The Special Correspondence Files of the Herbert Lehman Papers contain correspondence with nearly 1,000 individuals from 1895 through 1963. Beginning with letters from Lehman's family in the late nineteenth century, the series documents the range and scope of Lehman's long career in public service. <!-- Lehman started the series in an attempt to isolate materials he wanted for his own personal use. The series expanded over the years to include exchanges with the many of the most important people of his day. Thus, i--> In addition to family letters, the Special Correspondence Files contain letters from every President of the U. S. from Franklin Roosevelt to Lyndon Johnson, as well as from notables such as Dean Acheson, Benjamin Cardozo, Paul Douglas, Felix Frankfurter, W. Averill Harriman, Harold Ickes, Robert F. Kennedy, Fiorello LaGuardia, Henry Morgenthau, Alfred E. Smith, Adlai Stevenson, and Robert Wagner, among many others.
</p>
<p>More information: <a href="#">About the project</a> | <a href="#">Lehman Collection Finding Aid</a></p> 
</div>
</div>
<br clear="all" />
<!--
<div style="clear:all; padding:3px; margin:3px;background-color:#eee;border-top:1px solid #ccc;" />
-->
<div style="clear:all; padding:3px; margin:3px;text-align:center" />
<a name="search"></a>
<h2>Search collection</h2>
<?php
	include_once('../includes/searchform2.php');
        // if you want a sidebar, put it here
        // include_once('../includes/sidebar.php');
        include_once('../includes/pre_footer.php');
        include_once('../includes/footer.php');

?>
