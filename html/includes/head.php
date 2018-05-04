  <?php
    $page = $_SERVER['PHP_SELF'];
    $page = str_replace('/lehman/', '', $page);
    $page = str_replace('.php', '', $page);

    $appUrl = "UNKNOWN";
    $env = "UNKNOWN";

    if (stristr($_SERVER['SERVER_NAME'], '-dev'))
    {
      $appUrl = "http://katana.cul.columbia.edu:8080/solr/lehman-dev";
      $env = "dev";
    }
    else if (stristr($_SERVER['SERVER_NAME'], '-test'))
    {
      $appUrl = "http://katana.cul.columbia.edu:8080/solr/lehman-test";
      $env = "test";
    }
    else
    {
      $appUrl = "http://macana.cul.columbia.edu:8080/solr/lehman";
      $env = "prod";
    }
  ?>

  <title><?php echo $htmlTitle; ?></title>

  <script type="text/javascript">
    var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
    document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
  </script>

  <script type="text/javascript">
    var pageTracker = _gat._getTracker("UA-796949-10");
    pageTracker._initData();
    pageTracker._trackPageview();
  </script>

  <script type="text/javascript" language="JavaScript" src="/lehman/js/lweb.general.js"></script>
  <script type="text/javascript" language="JavaScript" src="/lehman/js/func.js"></script>

  <link type="text/css" href="/lehman/css/lweb.css" rel="stylesheet"></link>
  <link type="text/css" href="/lehman/css/general.css" rel="stylesheet"></link>
  <link type="text/css" href="/lehman/css/lehman.css" rel="stylesheet"></link>

  <?php if (isset($addlHeader)) echo $addlHeader; ?>