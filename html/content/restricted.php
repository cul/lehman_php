          <table width="100%" border="0" cellpadding="15" cellspacing="0">
            <tr>
              <td>

                <div style="border:1px solid #eee;padding:10px;">

                  <div>

                    <h2>Lehman Special Correspondence Files: Agreement to Terms of Use</h2>

                    <?php $myQuery = str_replace("/" . $_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']); ?>

                    <form method="post" action="/<?php echo $_SERVER['QUERY_STRING'] ?>">

                      <?php include_once('includes/terms.php'); ?>

                      <p>
                        <strong>You may indicate your acceptance of these terms by clicking "I Accept".  You will then be permitted to access the Lehman Collection.</strong>
                      </p>

                      <div style="margin-left:150px;width:300px;border:1px solid #ccc;background:#f3f8fd;text-align:left" align="center">

                        <p>
                          <input type="radio" name="agreed" value="yes">&#160;<strong>I accept</strong> these terms.</input><br />
                          <input type="radio" name="agreed" value="no">&#160;<strong>I do not accept</strong> these terms.</input>
                        </p>

                        <p style="text-align:center;"><input type="submit" value="Submit" /></p>

                      </div>

                    </form>

                  </div> 

                </div>

              </td>
            </tr>
          </table>