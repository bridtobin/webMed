<?php
//In each page, the page name is stored in the session variable currentPage.  This is so that when somebody changes language, they
//remain in the page they were in but in the new language.  If the session variable has not yet been set the default is the home page.  
if (!isset($_SESSION['currentPage'])) {
	$_SESSION['currentPage']="home";
}


//If language hasn't been selected, we default to english
if (isset ($_REQUEST['language'])) {
	$_SESSION['language']=$_REQUEST['language'];
}

if(!isset($_SESSION['language'])) {
	$_SESSION['language']="en";
}


 ?>
<!--<!DOCTYPE html>
<html>
<head>
<title>XYZ Medical</title>
</head>
<body>
<div id="header">-->
			<div id="languagebar">
            <!--Open the connection to the database.  This is closed in the infFooter.php file-->
            <?php include "Include/incConnectDB.php"; 
			// List available languages at top of screen.  Get languages from language table on database 
				$query = "SELECT languageDescription, languageCode FROM language " ;
				$result = $connection->query($query); 
				
	 			 while ($row = $result->fetch_assoc()) {
	 					echo "<a href='" ;
						echo $_SESSION['currentPage'] ; 
						echo ".php?language=" ; 
						echo $row['languageCode'];
						echo "' >" ;
						echo $row['languageDescription'];
						echo "</a>" ;
					}
				 
					//close the crecordset
					$result->close();
				?>
			</div>
       		<br /><img src="/Images/MedicalSymbol.jpg" alt="Greek Medical Symbol" style="float:left" /><div class='pagename'>XYZ Medical Centre</div>
       	<!--</div>
</body>
</html>-->