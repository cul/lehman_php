<html>

<head>

<?php
  $htmlTitle = "Lehman Special Correspondence Files::Terms of Use";
  $addlHeader = "<style>LI { padding:5px;margin:5px; }</style>";

  include_once('includes/head.php');
  include_once('includes/searchSolr.php');
?>

</head>

<body <?php if (isset($addlBody)) echo $addlBody; ?> leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<div align="center" style="margin:0px;">

  <div style="position:relative; width:760px; z-index:0;">

    <table width="760" cellpadding="0" cellspacing="0" style="margin:0px; border-width:1px; border-top:0px; border-bottom:0px; padding:0px; border-style:solid; border-color:#cccccc; background-color:#ffffff;">
      <tr>
        <td valign="top">

          <?php include_once('includes/banner.php'); ?>

          <?php include_once('includes/environment.php'); ?>

          <?php include_once('includes/breadcrumb.php'); ?>

          <?php include_once('content/rights.php'); ?>

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