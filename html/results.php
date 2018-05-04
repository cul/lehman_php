<html>

<head>

<?php
  $htmlTitle = "Lehman Correspondence Files::Document";
  $addlHeader = '<script language="JavaScript" src="http://www.columbia.edu/cu/lweb/digital/collections/cul/texts/js/bancha.js"></script>';
  $addlHeader .= "\n" . '<script language="JavaScript" src="js/func.js"></script>';
  $addlBody = 'onload="startup();"';
  include_once('includes/head.php');
  include_once('includes/iprestriction.php');
  include_once('includes/cite.php');
  include_once('includes/searchSolr.php');
  include_once('includes/makeQuery.php');

  $MAXFROMYEAR = 1864;
  $MAXTOYEAR = 1982;

  // handy var                                                                                                                                                               
  $monthArrShort = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
  $monthArr = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

  // draw form                                                                                                                                                               
  $isIpRestricted = isRestricted();
?>

  <?php if (isset($addlHeader)) echo $addlHeader; ?>

  <link type="text/css" href="/lehman/css/document.css" rel="stylesheet"></link>

</head>

<body <?php if (isset($addlBody)) echo $addlBody; ?> leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<div align="center" style="margin:0px;">

  <div style="position:relative; width:100%; z-index:0;">

    <table width="100%" cellpadding="0" cellspacing="0" style="margin:0px; border-width:1px; border-top:0px; border-bottom:0px; padding:0px; border-style:solid; border-color:#cccccc; background-color:#ffffff;">
      <tr>
        <td valign="top">

          <?php include_once('includes/banner.php'); ?>

          <?php include_once('includes/environment.php'); ?>

          <?php include_once('includes/breadcrumb.php'); ?>

          <?php include_once('content/results.php'); ?>

          <?php include_once('includes/pre_footer.php'); ?>

        </td>
      </tr>
    </table>

    <?php include_once('includes/footer.php'); ?>

  </div>

</div>

<?php include_once('includes/before_close_body.php'); ?>

</body>

</html>