<?php
if(!isset($_SESSION)) {
	session_start();
}
include "Include/incConnectDB.php"; 


echo "<div id='header'>" ;
    echo "<img src='/Images/MedicalSymbol.jpg' alt='Medical Symbol' style='float:left' /><div class='pagename'>XYZ Medical Centre Maintenance - Select Page To update</div>" ;
echo "</div>";
?>

