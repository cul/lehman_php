          <table width="100%" border="0" cellpadding="15" cellspacing="0">
            <tr>
              <td>

                <div style="float:left;width:100%;">

                  <table width="100%">
                    <tr>
                      <td valign="top">

                        <h2>Lehman Special Correspondence Files Citation</h2>

                      </td>
                      <td valign="top" style="text-align:right;font-size:10px;">
                        <a href="javascript:window.close()" class="noUnderline">[x] close window</a>
                      </td>
                    </tr>
                  </table>

                  <div style="padding:5px;border:1px solid #ccc;background-color:#f3f8fd">

                    <p>
                      <strong>Chicago Manual of Style citation for this resource:</strong>
                    </p>

                    <?php
                      $pattern = "/ldpd_leh_\d{4}_\d{4}/";
                      // if not document id is provided (error)
                      if (!isset($_GET['document_id']))
                      {
                        writeError();
                      }
                      // if document id not "ldpd_leh_nnnn_nnnn" (error)
                      else if ( isset($_GET['document_id']) && !preg_match($pattern, ($_GET['document_id'])))
                      {
                        writeError();
                      }
                        else
                      {
                        $searchUrl = $serializedResult = $result = $responseHeader = $response = $docs = "";
                        $searchUrl = "http://" . $appUrl . ".cul.columbia.edu:8080/lehman/select?&wt=phps&q=document_id:" . $_GET['document_id'] . "&rows=1";

			$qUrl = "wt=phps&q=document_id:" . $_GET['document_id'];
			$result = searchSolr($qUrl,$appUrl,"");
                        extract($result);
                        extract($responseHeader);
                        extract($response);
                        foreach($docs as $doc)
                        { // should be one doc
                          extract($doc);
                          if (! isset($file_unitdate_display))
                          {
                            $file_unitdate_display = 'n.d.';
                          }
                          writeCitation($file_unittitle, $genreform1, $file_unitdate_display, $document_id, "Herbert H. Lehman Papers, Special Correspondence Files, Rare Book and Manuscript Library, Columbia University Library",$env);
                        }
                      }
                    ?>

                  </div>

                  <p>
                    <strong>Note on citing documents in the Lehman Special Correspondence Files</strong>
                  </p>

                  <p>
                    The Lehman Special Correspondence Files provides a citation for each document.  This citation follows the <em>Chicago Manual of Style</em>. The <em>Manual</em> recommends citation of this archive in the following format:
                  </p>

                  <p style="border:1px solid #eee;padding:5px;">
                    Identification of specific item, Item type, Date of specific item, Document ID, Herbert H. Lehman Papers, Special Correspondence Files, Rare Book and Manuscript Library, Columbia University Library, URL (date accessed).
                  </p>

                </div>

                <?php
                  function writeError()
                  {
                    print "<p>You have reached this page erroneously.  Please try again.</p>";
                  } // end FUNCTION writeError
                ?>

              </td>
            </tr>
          </table>