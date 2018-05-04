<html>
<head>
	<title><?php echo $htmlTitle; ?></title>
<script type="text/javascript" language="JavaScript" src="/lehman/includes/lweb.general.js"></script>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-796949-10");
pageTracker._initData();
pageTracker._trackPageview();
</script>
  	<link href="/lehman/includes/lweb.css" rel="stylesheet" type="text/css"></link>
	<script type="text/javascript" language="JavaScript" src="/lehman/includes/func.js"></script>

  	<link rel="stylesheet" type="text/css" href="/lehman/includes/general.css">
	<style type="text/css">

	FORM P {padding:3px; margin:3px; }

	.noUnderline {
		text-decoration:none;
		font-family:inherit;
	}
	.noUnderline:hover {
		text-decoration:none;
		font-family:inherit;
		color:#7bb6d4;
	}
	#a {padding:5px;width:130px;left:70;top:50px;border:1px solid #dddddd;position:absolute;background-color:#f3f8fd;}
	#b {height:50px;width:50px;left:70px;top:50px;border:1px solid pink;position:absolute;background-color:#FFEFFE;}
	#menu { background:transparent;padding:0px; margin:0px;display:block;}
	#min { display:block; }
	#max { display:none; }

	FORM#searchForm {
		padding:0px;
		margin:0px;
	}

	H3.searchTitle {
		margin:0;padding:0;
		color:#336699;
		font-size:14px;
	}

	TABLE.searchTable {
		border-collapse:collapse;
	}

	.searchTable label {
		font-weight:normal;
	}

	.btn {
		background:#336699;
		border:1px solid #f3f8fd;
		color:#f3f8fd;
		font-family:Verdana, Arial, "Sans-Serif";
		font-size:12px;
		border-top:1px solid #ccc;
		border-left:1px solid #ccc;
	}

	TD.optionTitle {
		font-weight:bold;
		color:#336699;
		vertical-align:top;
		border-top:1px solid #999;
		padding:10px;
	}

	TD.option {
		background:#f3f8fd;
		border-top:1px solid #999;
		padding:10px;
	}	

	TD.toolsMenu {
		background-color:#eee;
		color:#2d2a62;
		padding:5px;
		font-weight:bold;
		border:1px solid #ccc;
	}
	#menu P {
		border-bottom:1px solid #ccc;
	}

	.sidemenu P.on {
		border-top:1px solid #ddd;
		padding:5px;
		margin:0px;
	}

	.sidemenu P.off {
		border-top:1px solid #ddd;
		font-weight:bold;
		color:#2d2a62;
		padding:5px;	
		margin:0px;
	}

	TABLE.resultsList {
		border:1px solid #ddd;
		border-collapse:collapse;
		/*width:620px;*/
		width:725px;
		font-size:12px;
	}
	TABLE.limitTable {
		border:1px solid #ccc;
		width:140px;
	}

	.resultsList TH {
		text-align:left;
		font-size:12px;
		font-weight:bold;
		background:#eee;
		border-bottom:1px solid #ddd;
		padding:3px;
	}

	.resultsList TD {
		border-bottom:1px solid #ddd;
		padding:3px;
	}
	img {
		border:0px;
	}
	</style>
<?php if (isset($addlHeader)) echo $addlHeader; ?>
</head>
<body <?php if (isset($addlBody)) echo $addlBody; ?> leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div align="center" style="margin:0px;">

<div style="margin: 0px; background-color: rgb(45, 42, 98); color: rgb(255, 255, 255); font-size: 10px; border: 1px solid rgb(45, 42, 98);width:758px" align="left">

<a href="http://library.columbia.edu"><img src="http://library.columbia.edu/etc/designs/libraryweb/default/images/crown.w18h14.white.gif" alt="crown" border="0" height="14" width="18"></a>&nbsp;
<a href="http://www.columbia.edu/cu/" style="color: rgb(255, 255, 255); text-decoration: none;">CU Home</a>&nbsp;&gt;&nbsp;
<a href="http://library.columbia.edu/" style="color: rgb(255, 255, 255); text-decoration: none;">Libraries Home</a>
</div>

<span>

<table cellpadding="0" cellspacing="0" border="0" width="760" style="border-bottom:2px solid #336699;background:#fff">
<tr>
<td bgcolor="#cccccc" width="1">
<img src="/lehman/images/spacer1px.gif" width="1" height="1" alt="" border="0">
</td>
<td valign="top">
<a href="http://library.columbia.edu/indiv/rbml.html" title="Columbia University Libraries Rare Book and Manuscript Library" alt="Columbia University Libraries Rare Book and Manuscript Library"><img src="http://library.columbia.edu/content/dam/libraryweb/general/images/banners/banner.rbml.gif" width="340" height="90" alt="Columbia University Libraries Rare Book and Manuscript Library" title="Columbia University Libraries Rare Book and Manuscript Library" border="0"></a>
</td>

<td valign="middle" align="right" style="background:#fff;color:#336699;font-family:Georgia, Times, Serif; font-size:28px;padding-right:10px;margin-right:10px;">
<a href="http://library.columbia.edu/indiv/rbml/units/lehman.html" class="noUnderline" style="color:#336699;font-family:Georgia, Times, Serif; font-size:28px;">The Lehman Collections</a>
</td>

<td bgcolor="#cccccc" width="1">
<img src="/lehman/images/spacer1px.gif" width="1" height="1" alt="" border="0">
</td>

</tr>
</table>
</span>


<div style="position:relative; width:760px; z-index:0;">
<table width="760" cellpadding="0" cellspacing="0" style="margin:0px; border-width:1px; border-top:0px; border-bottom:0px; padding:0px; border-style:solid; border-color:#cccccc; background-color:#ffffff;">
<tr>
<td valign="top">

<?php include_once('post_header.php'); ?>

<!-- Begin Layout -->
<table width="100%" border="0" cellpadding="15" cellspacing="0">
<tr>
<td>
