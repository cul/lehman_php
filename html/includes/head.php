  <?php
    $page = $_SERVER['PHP_SELF'];
    $page = preg_replace('/^\/(lehman\/)?/', '', $page);
    $page = str_replace('.php', '', $page);

    $appUrl = "UNKNOWN";
    $env = "UNKNOWN";

    if (stristr($_SERVER['SERVER_NAME'], '-dev'))
    {
      $appUrl = "http://ldpd-solr-dev1.cul.columbia.edu:8983/solr/lehman";
      $env = "dev";
    }
    else if (stristr($_SERVER['SERVER_NAME'], '-test'))
    {
      $appUrl = "http://ldpd-solr-test1.cul.columbia.edu:8983/solr/lehman";
      $env = "test";
    }
    else
    {
      $appUrl = "http://ldpd-solr-prod1.cul.columbia.edu:8983/solr/lehman";
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

  <script type="text/javascript" language="JavaScript" src="/js/lweb.general.js"></script>
  <script type="text/javascript" language="JavaScript" src="/js/func.js"></script>

  <link type="text/css" href="/css/lweb.css" rel="stylesheet"></link>
  <link type="text/css" href="/css/general.css" rel="stylesheet"></link>
  <link type="text/css" href="/css/lehman.css" rel="stylesheet"></link>

  <?php if (isset($addlHeader)) echo $addlHeader; ?>