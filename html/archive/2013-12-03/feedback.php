<?php
        $htmlTitle = "Lehman Special Correspondence Files: Contact Us";
        //$addlHeader = '<script language="javascript" type="text/javascript" src="http://www.columbia.edu/cu/lweb/digital/ds/js/mail.js"></script><script language="javascript" type="text/javascript" src="http://www.columbia.edu/cu/lweb/digital/ds/js/ds.js"></script>';
        include_once('includes/header.php');

	$appUrl = "UNKNOWN";
	$env = "UNKNOWN";

        if (stristr($_SERVER['SERVER_NAME'], '-test')) {
		$appUrl = "http://katana.cul.columbia.edu:8080/solr/lehman-test"
;
		$env = "test";
	}
        else if (stristr($_SERVER['SERVER_NAME'], 'lehman.cul')) {
		$appUrl = "http://macana.cul.columbia.edu:8080/solr/lehman";
		$env = "";
	}
	else {
		$appUrl = "http://katana.cul.columbia.edu:8080/solr/lehman-dev";
		$env = "dev";
	}

        // draw form
?>

<div style="float:left;width:190px;padding-bottom:5px;">
<?php include_once("includes/aboutmenu2.php"); ?>
<!-- img src="/lehman/images/image3.jpg" alt="Sample telegram from the Lehman Special Correspondence Files Online" width="185" / -->
</div>
<div style="float:right;width:520px;">
<?php include_once("includes/draft.php"); ?>
<h2>Contact Us</h2>
<p>The Herbert S. Lehman Papers may be accessed through the Rare Book and Manuscript Library (RBML), located on the 6th floor of Butler Library.  To reserve materials for research, please contact the RBML reference desk <span style="color:#ff6437">at least 36 hours</span> before you plan to visit.</p>  
      <p>For questions, comments, and suggestions, or to make an appointment to view the collection, please contact us at:</p>
<p><strong>Mailing address, telephone, and email:</strong></p>
<div style="padding-left:10px;">
<?php include("includes/contact.php"); ?>
</div>

<p>Or, contact us using our form below:</p>

            <a name="send"></a>
            <form name="frmFeedback" action="http://www.columbia.edu/cgi-bin/generic-inbox.pl" method="post" class="forminput" style="margin:0px;" onsubmit="blnReturn = ValidateInput(document.frmFeedback); return blnReturn;">
              <input name="subject" value="" type="hidden">
              <input name="ack_link" value="http://lehman.cul.columbia.edu/thankyou" type="hidden">
              <input name="mail_dest" value="jd2481@columbia.edu" type="hidden">

              <table border="0">
                <tr>
                  <td>
                    Name:
                  </td>
                  <td>
                    <input name="inpUserName__________" size="33" class="forminput" type="text">
                  </td>
                </tr>

                <tr>
                  <td>
                    Email:
                  </td>
                  <td>
                    <input name="inpUserEmail_________" size="33" class="forminput" type="text">
                  </td>
                </tr>
                <tr>

                  <td>
                    Subject:
                  </td>
                  <td>
                    <select name="selSubject___________" onchange="if (IsBlank(GetSelectedValue(document.frmFeedback.selSubject___________))) {alert('Please select a Subject.');} else {document.frmFeedback.subject.value = 'Lehman Special Correspondence: ' + GetSelectedValue(document.frmFeedback.selSubject___________) + ' - Process ID: $$';}">
                      <option value="">[select a subject]</option>
			<option value="Access">Accessing the collection</option>
			<option value="Reference question">Reference question about collection information</a>
                      <option value="Technical Problem">Technical problem</option>
                      <option value="Data Correction">Data correction</option>
                      <option value="Other">Other</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td valign="top">
                    Message:
                  </td>
                  <td colspan="2">

                    <textarea name="texMessage___________" cols="46" rows="8" class="forminput"></textarea>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">

                    Would you like a response? &nbsp;Yes<input name="optResponseRequested_" value="yes" checked="checked" type="radio"> &nbsp;No<input name="optResponseRequested_" value="no" type="radio">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="btnSend" value=" Send " type="submit">
                  </td>
                </tr>
              </table>

            </form>
</div>
<br clear="all" />
<?php //include_once('includes/aboutmenu.php'); ?>
<?php
        // if you want a sidebar, put it here
        // include_once('includes/sidebar.php');
        include_once('includes/pre_footer.php');
        include_once('includes/footer.php');

?>

