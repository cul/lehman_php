<div class="sidemenu" style="background:#eee;;border:1px solid #ddd;padding:5px;margin-top:20px;">

  <h2 style="padding:2px;margin:2px;">About</h2>

  <?php
    $linkText = array("About the Collection", "Lehman Collection<br />Finding Aid <img src=\"http://www.columbia.edu/cu/lweb/digital/collections/cul/texts/images/newW.png\" title=\"Opens new window\" alt=\"Opens new window\" />", "About Searching", "Contact Us");
    $linkLink = array("/about/", "http://www.columbia.edu/cu/lweb/eresources/archives/rbml/Lehman,H/\" target=\"_blank\"", "/text/", "/feedback/");
    $linkList = "";

    for ($i=0; $i < count($linkText); $i++)
    {
      $linkCompare = substr($linkLink[$i], 0, -1) . ".php";
      if (!stristr($linkCompare, $_SERVER['PHP_SELF']))
      {
        $linkList .= '<p class="on"><a href="' . $linkLink[$i] . '" class="noUnderline">'. $linkText[$i] . '</a></p>';
      }
      else
      {
        $linkList .=  "<p class='off'>" . $linkText[$i] . "</p>";
      }
    }
    print $linkList . "\n";
  ?>

</div>
