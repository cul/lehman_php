//////////////////
// PRE-LOAD IMAGES
function PreloadImages()
{

  if (!document.images)return;

  var Arguments = PreloadImages.arguments;
  var ImagePath = "/cu/lweb/images/";
  var Images = new Array();
  var i = 0

  while (i < Arguments.length)
  {
    Arguments[i] = new Image();
    Arguments[i].src = ImagePath + Arguments[i];
    i = i + 1;
  }
}



///////////////////
// GET RANDOM IMAGE
function GetRandomImage(NumOfImages)
{
   var ImagePath = "/cu/lweb/images/sets/cuscenes/";
   var ImageName = 1;
   var ImageExt = ".jpg";

   ImageName = (Math.round(Math.random()*(NumOfImages - 1)) + 1);
   document.write('<img name="cuscenes" src=' + ImagePath + ImageName + ImageExt + ' alt="Random scenes from Columbia">');

}



///////////////
// CHANGE IMAGE
function ChangeImage(Image, ImageFile) {

   var ImagePath = "/cu/lweb/images/";

   document.images[Image].src = ImagePath + ImageFile;

}



/////////////////////
// GO TO SELECTED URL
function GoToSelectedURL(strFormName, strControlName)
{

  var objForm;
  var objControl;
  var intControlNum;

  objForm = document.forms[strFormName];
  for (intControlNum = 0; intControlNum < objForm.elements.length; intControlNum++)
  {
    if (objForm.elements[intControlNum].name == strControlName)
    {
      break;
    }
  }
  objControl = objForm.elements[intControlNum];
  if (GetSelectedValue(objControl) == "")
  {
    return;
  }
  document.location = GetSelectedValue(objControl);
  return;

}



///////////////////////////////////////////
// GET SELECTED VALUE (FROM DROP-DOWN LIST)
function GetSelectedValue(objControl)
{

  intCounter = 0;

  for (intCounter = 0; intCounter < objControl.length; intCounter++)
  {

    if (objControl.selectedIndex == intCounter)
    {
      return objControl.options[intCounter].value;
    }
  }

  return "";

}



///////////////////////////////////////////
// GET SELECTED TEXT (FROM DROP-DOWN LIST)
function GetSelectedText(objControl)
{

  intCounter = 0;

  for (intCounter = 0; intCounter < objControl.length; intCounter++)
  {

    if (objControl.selectedIndex == intCounter)
    {
      return objControl.options[intCounter].text;
    }
  }

  return "";

}



//////////////////////////////////////
// RETURN THE LEFT PORTION OF A STRING
function Left(strString, intLength)
{
  return strString.substr(0, intLength)
}



///////////////////////////////////////
// RETURN THE RIGHT PORTION OF A STRING

function Right(strString, intLength)
{
  return strString.substr((strString.length - intLength), intLength)
}