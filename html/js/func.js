function writePages(pages, start, dlo, document_id, element_id) {
	start = parseInt(start);
	pages = parseInt(pages);
	innerH = "";

	// this is set to 890 b/c IE is behaving badly
	innerH = '<table width="880" align="left" style="font-size:10px;"><tr>';
	innerH += '<td valign="top" width="340" align="left" style="font-size:10px;">&#160;</td>';
	innerH += '<td valign="top" width="50" align="right" style="font-size:10px;">';	
        if ( (start-1) > 0) {
                innerH += '<a style="cursor:pointer" onclick="javascript:incrementPage(\'' + pages + '\',\'' + (start-1) + '\',\'' + dlo + '\',\'' + document_id + '\')"><img src="http://www.columbia.edu/cu/lweb/digital/collections/cul/texts/images/arrow_lft-t.gif" alt="Prev page (' + (start-1) + ')" title="Prev page (' + (start-1) + ')" /></a>';

        }
        else {
                innerH += '<img src="http://www.columbia.edu/cu/lweb/digital/collections/cul/texts/images/arrow_lft-off-t.gif" alt="No prev page" title="No prev page" />';
	}

        innerH += '</td><td valign="top" width="100" align="center" style="font-size:10px;">';
        innerH += 'Page ' + start + ' of ' + pages; // + '</td>';
        innerH += '<td valign="top" align="left" width="50" style="font-size:10px;">';
        if ( (start + 1) <= pages) {
                innerH += '<a style="cursor:pointer;" onclick="javascript:incrementPage(\'' + pages + '\',\'' + (start+1) + '\',\'' + dlo + '\',\'' + document_id + '\')"><img src="http://www.columbia.edu/cu/lweb/digital/collections/cul/texts/images/arrow_rt-t.gif" alt="Next page (' + (start+1) + ')" title="Next page (' + (start+1) + ')" /></a>';
        }
        else {
                innerH += '<img src="http://www.columbia.edu/cu/lweb/digital/collections/cul/texts/images/arrow_rt-off-t.gif" alt="No next page" title="No next page" />';
	}
	
        innerH += '</td>';
	innerH += '<td valign="top" align="right" width="340" style="font-size:10px;">&#160;</td>';
        innerH += '</tr></table>';
 
	document.getElementById(element_id).innerHTML = innerH;
	//document.getElementById('pagination2').innerHTML = innerH;

} // end FUNCTION writePages

function incrementPage(pages, start, dlo, document_id) {
	size = "900";
      	newImgSrc = document.getElementById('imgBookImage').src;

	if (newImgSrc.search(1200) > -1) 
		size = "1200";

	document.getElementById('imgBookImage').src = dlo + '?obj=' + document_id + '_' + padleft(start, "0", 3) + "&size=" + size;
	//document.getElementById('pagination').innerHTML = 
	writePages(pages,start,dlo,document_id,'pagination');
	writePages(pages,start,dlo,document_id,'pagination2');
	//alert(document.getElementById('pagination').innerHTML);
}

// from http://lawrence.ecorp.net/inet/samples/regexp-format.php
        function padleft(val, ch, num) {
            var re = new RegExp(".{" + num + "}$");
            var pad = "";
            if (!ch) ch = " ";
            do  {
                pad += ch;
            }while(pad.length < num);
            return re.exec(pad + val);
        }

/***************************************************************
 * function toggle(id, msgOff, msgOn)
 *
 * Takes the id of a <div> and sets the style display
 * equal to "block" or "none"
 *
 * If L does not exist, display should be set to "none;"
 * some browsers may issue a warning.
 ***************************************************************/

function toggle(id, msgOff, msgOn) {
        var L = document.getElementById("L"+id);
        var I = document.getElementById("I"+id);
        if (L.style.display == "" || L.style.display == "none") {
                L.style.display = "block";
                I.src = "http://www.columbia.edu/cu/lweb/images/icons/left-on.gif";
                document.getElementById("spanblurb"+id).innerHTML = msgOn;
        } // end IF
        else {
                L.style.display = "none";
                I.src = "http://www.columbia.edu/cu/lweb/images/icons/left-off.gif";
                document.getElementById("spanblurb"+id).innerHTML = msgOff;
        } // end ELSE
} // end FUNCTION toggle(id)

function breakFrame(id, caller) {

        if (caller == 1) {
                document.getElementById(id).style.width = "900px"
                document.getElementById('ocrText').style.width="900px"
		document.getElementById('ocrWindow').style.fontSize="12px";
		document.getElementById('pageMenu').style.width = "900px";
		document.getElementById('pageMenu2').style.width = "900px";
                newImgSrc = document.getElementById('imgBookImage').src;
                newImgSrc = newImgSrc.replace(/1200/g,'900');
                document.getElementById('imgBookImage').src = newImgSrc;
		document.getElementById('controller1').style.color = "#ccc";
		document.getElementById('controller1').style.border = "1px solid #ccc";
                document.getElementById('controller2').style.color = "#369";
                document.getElementById('controller2').style.border = "1px solid #369";
        }

        else { // (caller == 2)
                document.getElementById(id).style.width = "1200px";
                document.getElementById('ocrText').style.width="1200px";
		document.getElementById('ocrWindow').style.fontSize="16px";
		document.getElementById('pageMenu').style.width = "1200px";
		document.getElementById('pageMenu2').style.width = "1200px";
                newImgSrc = document.getElementById('imgBookImage').src;
                newImgSrc = newImgSrc.replace(/900/g,'1200');
                document.getElementById('imgBookImage').src = newImgSrc;
                document.getElementById('controller1').style.color = "#369";
                document.getElementById('controller1').style.border = "1px solid #369";
                document.getElementById('controller2').style.color = "#ccc";
                document.getElementById('controller2').style.border = "1px solid #ccc";


        }
        document.getElementById('controller' + caller).style.color == "#ccc";
}

function openCitation(docID){
	defWindow=window.open('/citation?document_id='+docID, 'defWin', 'width=800,height=500,scrollbars=yes,resize=yes,menubar=yes');
} // end FUNCTION openCitation
/*function openCitation(func) {
	if (func == "open") {
		document.getElementById("citation").style.display = "block";
		document.getElementById("citLink").innerHTML = "<strong><a href=\"javascript:openCitation('close')\" class=\"noUnderline\"><img src=\"http://www.columbia.edu/cu/lweb/digital/collections/cul/texts/images/bookcitation-sm.gif\" alt=\"citation\" height=\"8\" />&#160;Close citation&#160;&#187;</a></strong>"; 
	}
	else {
		document.getElementById("citation").style.display = "none";
		document.getElementById("citLink").innerHTML = "<strong><a href=\"javascript:openCitation('open')\" class=\"noUnderline\"><img src=\"http://www.columbia.edu/cu/lweb/digital/collections/cul/texts/images/bookcitation-sm.gif\" alt=\"citation\" height=\"8\" />&#160;View citation&#160;&#187;</a></strong>";
	}
} // end FUNCTION openCitation() */

function checkDate(id) {

    if (id == "day") {
	if (document.getElementById("month").value != "" || document.getElementById("year").value != "") {
		document.getElementById("day").disabled = false;
	}
	else {
		document.getElementById("day").options[0].selected = true;
		document.getElementById("day").disabled = true;
	}
   }

  if (id == "fromDay") {
        if (document.getElementById("fromMonth").value != "" || document.getElementById("fromYear").value != "") {
                document.getElementById("fromDay").disabled = false;
        }
        else {
                document.getElementById("fromDay").options[0].selected = true;
                document.getElementById("fromDay").disabled = true;
        }

  }

  if (id == "toDay") {
        if (document.getElementById("toMonth").value != "" || document.getElementById("toYear").value != "") {
                document.getElementById("toDay").disabled = false;
        }
        else {
                document.getElementById("toDay").options[0].selected = true;
                document.getElementById("toDay").disabled = true;
        }

  }
} // end FUNCTION checkDate()

function resetMe() {
	document.getElementById('searchForm').reset();	
	var myForm = document.getElementById('searchForm');
	var mySel;
	
	for (var i = 0; i < myForm.file_unittitle_t.length; i++) {
		if (myForm.file_unittitle_t.options[i].selected == true) {
			//alert(myForm.file_unittitle_t.options[i].selected);
			//myForm.file_unittitle_t.options[i].selected = false;
			//alert(myForm.file_unittitle_t.options[i].selected)
			mySel = i;
		}
	}	
		
	myForm.file_unittitle_t.options[mySel].selected = false;

	myForm.file_unittitle_t.options[0].selected = true;
	myForm.freetext.value = "";
	myForm.document_id.value = "";
	myForm.ocr.checked = false;
	myForm.genreform1_t.options[0].selected = true;
	/*myForm.year.options[0].selected = true;
	myForm.month.options[0].selected = true;*/

        myForm.fromYear.options[0].selected = true;
        myForm.fromMonth.options[0].selected = true;
        myForm.fromDay.options[0].selected = true;

        myForm.toYear.options[0].selected = true;
        myForm.toMonth.options[0].selected = true;
        myForm.toDay.options[0].selected = true;

	/*if (document.getElementById("day").disabled = false)	
		myForm.day.options[0].selected = true;*/

	checkDate();
}
