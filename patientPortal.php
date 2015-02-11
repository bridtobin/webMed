<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');

//set up session variables.  Need to know what page and what id when language is changed.  Need to show correct language version of 
//page
$_SESSION['currentPage']="/portal" ;
$_SESSION['pageid']=4;


?>
<!DOCTYPE html>
<html>
<head>
<!--Use the same stylesheet for all pages gdmedstyle.css-->
<link href="gdmedstyle.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div id="wrapper">
<!--Header, menubar, link and footer are common to all pages.  The incExtractData.php is common to most pages-->
  <?php include "Include/incHeader.php"; 
	    include "Include/incMenuBar.php" ;
		include "Include/incExtractData.php" ;
		include "Include/incLinkBar.php";
		include "Include/incFooter.php"; 
   ?>
</div>
</body>     
</html>

