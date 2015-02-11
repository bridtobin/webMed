<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');

$_SESSION['currentPage']="/home" ;
$_SESSION['pageid']=3;

if(!isset($_SESSION['language'])) {
	$_SESSION['language']="en";
}
?>
<!DOCTYPE html>
<?php 
echo "<html lang='". $_SESSION['language'] . "'>" ;
?>
<head>
<!--Use the same stylesheet for all pages gdmedstyle.css-->
<link href="gdmedstyle.css" rel="stylesheet" type="text/css"/>
<title>XYZ Medical Centre</title>
<!--Had to use the following character set to display the accent in the Irish language-->
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<meta name="description" content="XYZ Medical Centre">
</head>
<body>
<div id="wrapper">
<!--Header, menubar, link and footer are common to all pages.  The incExtractData.php is common to most pages-->
		<div id="header">
  			<?php include_once "Include/incHeader.php";?>
       </div> 
  		<div id="menubar" lang="$lang">
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

