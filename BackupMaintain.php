<?php
include_Once("Include/incMaintHeader.php"); 

if(isset($_REQUEST['pageName'])) {
	$_SESSION['pageName'] = $_REQUEST['pageName'] ;
}
?>
<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" type="text/css" href="/gdmedstyle.css"  >

	<title>GD Med Maintenance</title>
</head>
<body>
<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

if(!isset($_SESSION['logged'])) {
echo 'Session logged: '.$_SESSION['logged'] ;
	$_SESSION['logged']=0;
}
if($_SESSION['logged']==1) {
?>
<div id="menubar">
    <form method="post">
    	<input type="submit" name="submitButton" value="Home" />
		<input type="submit" name="submitButton" value="Opening Hours" />
   		<input type="submit" name="submitButton" value="Services" />
   		<input type="submit" name="submitButton" value="Prescriptions" />
   		<input type="submit" name="submitButton" value="New Patient" />
   		<input type="submit" name="submitButton" value="Our Team" />
  		<input type="submit" name="submitButton" value="Fees" />
   		<input type="submit" name="submitButton" value="Contact Us" />
	</form>
</div>
<?php
 	if($_SERVER['REQUEST_METHOD']=='POST') {
		 // If a button has been pressed to indicate which page content is to be updated
	 	// then we update the session variable $_SESSION['pageToUpdate'] with that page name.
			if (!empty($_POST['submitButton'])) {
				$_SESSION['pageToUpdate'] = $_REQUEST[("submitButton")];
				switch ($_SESSION['pageToUpdate']) {
  				case 'Home':
 					$_SESSION['pageToUpdate']='home';
  		 			break;
  				case 'Opening Hours' :
  					$_SESSION['pageToUpdate']='times' ;
  					break;
  				case 'Services' :
  					$_SESSION['pageToUpdate']='services' ;
  					break;
  				case 'Prescriptions' :
  					$_SESSION['pageToUpdate']='prescriptions' ;
  					break;
  				case 'New Patient' :
  					$_SESSION['pageToUpdate']='newPatient' ;
  					break;
  				case 'Our Team' :
  					$_SESSION['pageToUpdate']='team' ;
  					break;
  				case 'Fees' :
  					$_SESSION['pageToUpdate']='fees' ;
  					break;
				case 'Contact Us' :
  					$_SESSION['pageToUpdate']='contact' ;
  					break;
				default:
					echo "Unknown Page";
					break;
				} // switch 
			} // if (!empty($_POST['submitButton'])) 

    // the fields relating to the current page being edited (i.e. $_SESSION['pageToUpdate']) are displayed as buttons on the left side
			if (isset($_SESSION['pageToUpdate']) and $_SESSION['logged']==1) {
				$query ="SELECT  " .
				"fieldName, " .
				"fieldDescription " .
				"FROM pagefields " .
				"WHERE page= '" .
				$_SESSION['pageToUpdate'] .
				"'" ;
				$result = $connection->query($query); 
				echo "<div id='leftbar'>" ;
				echo "<h4>Please select a field to update</h4>" ;
				while ($row = $result->fetch_assoc()) {
					 echo "<form method='post'>" ;
					 echo "<input type='hidden' name= 'hidden' value='" .
	        		 $row['fieldName'] . "'/>" ;
			 		 echo "<input type='submit' name='fieldButton' value='" .
    	    		 $row['fieldDescription'] . "'/>" ;
					 echo"</form>";
				} // while
				//close the crecordset
				$result->close();
				echo "</div>" ;
			} // isset(


	// If a field has been selected to be updated, then we display the text relating to that field in all languages
			if (!empty($_POST['fieldButton'])) {
 				$field = $_POST['hidden'];
 				echo "<div id='mainarea'>" ;

		 		$query ="SELECT  " .
					"fieldName, " .
					"actualText, " .
					"languageCode " .
					"FROM pagecontent " .
					"WHERE fieldname= '" .
					$field .
					"'" ;
				$result = $connection->query($query); 

         	 echo "<form method='post'>" ;
      		 while ($row = $result->fetch_assoc()) {
				 echo "<input type='hidden' name= 'hiddenField' value='" .
			     $row['fieldName'] . "'/>" ;
				 echo "<input type='hidden' name = 'languageCode[]' value='" .
				 $row['languageCode'] . "'/>" ;
 				 echo $row['languageCode'] ;

				 echo "<textarea name='textForPage[]' cols='80' rows='12'>" ;
				 echo $row['actualText'] ;
				 echo "</textarea> <br>" ;  
 			}
			echo "<input type='submit' name='save' value='Save'>" ;
			echo "<br>" ;
  			echo"</form>";
	
			//close the crecordset
			$result->close();
			echo "</div>" ;
		} // if (!empty($_POST['fieldButton'])) 

	// this is where we actually update the tables with the values.  If the save button is selected, the new information is written to the database
		if (!empty($_POST['save'])) {
//		include("/Include/incConnectDB.php") ;
	
			for($x=0; $x<count($_POST['textForPage']); $x++) {
    // now you can use $_POST['cl'][$x] and $_POST['ingredients'][$x]
				$query = "update pagecontent set actualText = '" .
				($_POST['textForPage'][$x]) . "' where languageCode = '" .
				($_POST['languageCode'][$x]) . "' and fieldName = '" .
				($_POST['hiddenField']) . "'" ;
				$result = $connection->query($query); 
			} // for

 		} //  if (!empty($_POST['save'])) 
	} // if($_SERVER['REQUEST_METHOD']=='POST') 
} else {
	echo 'Is login set? '. isset($_POST['login']);
	echo 'Login is set to: '.($_POST['login']);
    if (isset($_POST['login'])) {
		echo 'doing this line';
		$query="SELECT count(adminID) as CountAdmin FROM admin WHERE username='" .
		$_POST['username'] . "' and  password = '" .
		md5($_POST['password']) . "'" ;
		echo $query ;

		$result = $connection->query($query); 

 		while ($row = $result->fetch_assoc()) {
			echo "Returned from admin " . $row['CountAdmin'] ;
			if ($row['CountAdmin'] > 0) {
				$_SESSION['logged']=1 ;
			}
			else {
				$_SESSION['logged']=0 ;
			}
		}
			if ($_SESSION['logged']==1) {
				
		?>
  
	      	<div id='mainarea'>
            <p>We are here</p>
			<form method="post">
        			<h3>Successful login. Press OK to continue</h3>
					<input type="submit" name="login" value="Ok">
			</form>
			</div>
    	<?php
		} else {
		?>
        	<div id='mainarea'>
			<form method="post">
            	<h3>Unsuccessful Login</h3>
                <br>
                <br>
				Username: <input type="text" name="username"><br>
				Password: <input type="password" name="password"><br><br>
				<input type="submit" name="login" value="login">
			</form>
            </div>
   		<?php

		}
			
	} // (isset($_POST[['login']))
	else {
		?>
        <div id='mainarea'>
		<form method="post">
        <h3>Please login to use the Administration Section</h3>
        		<br>
                <br>
				Username: <input type="text" name="username"><br>
				Password: <input type="password" name="password"><br><br>
				<input type="submit" name="login" value="login">
		</form>
        </div>
		<?php
	} // else...isset($_POST['login']))
} // else...($_SESSION['logged']==1)
	
?>
 		<div id='footer'>&nbsp;</div> 







	



