<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', '1');

//set up session variables.  Need to know what page and what id when language is changed.  Need to show correct language version of 
//page
$_SESSION['currentPage']="/prescriptions" ;
$_SESSION['pageid']=5;


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
		<div id="header">
  			<?php include_once "Include/incHeader.php"; ?>
        </div> 
  		<div id="menubar">
	    	 <?php include_once "Include/incMenuBar.php" ;  ?>
        </div>
		<div id="mainarea">
			 <?php include_once "Include/incExtractData.php" ;  ?>
		</div>
        <div id="linkbar"> 
			 <?php include_once "Include/incLinkBar.php";  ?>
        </div>
        <div id="footer">
			<?php include_once "Include/incFooter.php";  ?>
 		</div> 
</div>
</body>     
</html>

