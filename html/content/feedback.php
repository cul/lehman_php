          <table width="100%" border="0" cellpadding="15" cellspacing="0">
            <tr>
              <td>

                <div style="float:left;width:190px;padding-bottom:5px;">

                  <?php include_once("includes/menu.php"); ?>

                </div>

                <div style="float:right;width:520px;">

                  <?php include_once("includes/draft.php"); ?>

                  <h2>Contact Us</h2>

                  <p>
                    The Herbert S. Lehman Papers may be accessed through the Rare Book and Manuscript Library (RBML), located on the 6th floor of Butler Library.  To reserve materials for research, please contact the RBML reference desk <span style="color:#ff6437">at least 36 hours</span> before you plan to visit.
                  </p>

                  <p>
                    For questions, comments, and suggestions, or to make an appoitment to view the collection, please contact us at:
                  </p>

                  <p>
                    <strong>Mailing address, telephone, and email:</strong>
                  </p>

                  <div style="padding-left:10px;">

                    <?php include("includes/contact.php"); ?>

                  </div>

                  <p>
                    Or, contact us using our form below:
                  </p>

                  <a name="send"></a>

                  <form name="frmFeedback" action="http://www.columbia.edu/cgi-bin/generic-inbox.pl" method="post" class="forminput" style="margin:0px;" onsubmit="blnReturn = ValidateInput(document.frmFeedback); return blnReturn;">
                    <input name="subject" value="" type="hidden">
                    <input name="ack_link" value="http://lehman.cul.columbia.edu/thankyou" type="hidden">
                    <input name="mail_dest" value="rbml@libraries.cul.columbia.edu" type="hidden">

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

              </td>
            </tr>
          </table>