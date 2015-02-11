<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="gdmedstyle.css"  >
	<title>XYZ Med Maintenance</title>
    <!--Had to use the following character set to display the accent in the Irish language-->
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
    
	<!-- Don't want SEO to find this <meta name="description" content="XYZ Medical Centre">-->
</head>
<body>
<div id="wrapper">
<?php
include_Once("Include/incMaintHeader.php"); 
error_reporting(E_ALL);
ini_set('display_errors', '1');
//Because this is the maintenance page, a user must be logged in before they can use this page.  Check if they are logged
//in.  If not the login form is displayed.
if(!isset($_SESSION['logged'])) {
	$_SESSION['logged']=0;
}
if($_SESSION['logged']==1) {
?>

<div id="menubar">
    <form method="post" class="menuform">
    	<label>
    	<input type="submit" name="submitButton" value="Home" class="button"/>
		<input type="submit" name="submitButton" value="Opening Hours" class="button" />
   		<input type="submit" name="submitButton" value="Services" class="button"/>
   		<input type="submit" name="submitButton" value="Patient Portal" class="button" />
   		<input type="submit" name="submitButton" value="Our Team" class="button" />
  		<input type="submit" name="submitButton" value="Fees" class="button" />
   		<input type="submit" name="submitButton" value="Contact Us" class="button"/>
   		<input type="submit" name="submitButton" value="Links" class="button" />
		</label>
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
 					$_SESSION['pageToUpdate']=3;
					$_SESSION['pageName']='Home';
  		 			break;
  				case 'Opening Hours' :
  					$_SESSION['pageToUpdate']=8 ;
					$_SESSION['pageName']='Opening Hours';
   					break;
  				case 'Services' :
  					$_SESSION['pageToUpdate']=6 ;
					$_SESSION['pageName']='Services';
  					break;
  				case 'Patient Portal' :
  					$_SESSION['pageToUpdate']=4 ;
					$_SESSION['pageName']='Patient Portal';
  					break;
  				case 'Our Team' :
  					$_SESSION['pageToUpdate']=7 ;
					$_SESSION['pageName']='Our Team';
  					break;
  				case 'Fees' :
  					$_SESSION['pageToUpdate']=2 ;
					$_SESSION['pageName']='Fees';
  					break;
				case 'Contact Us' :
  					$_SESSION['pageToUpdate']=1 ;
					$_SESSION['pageName']='Contact Us';
  					break;
				case 'Links' :
  					$_SESSION['pageToUpdate']=9 ;
					$_SESSION['pageName']='Links';
  					break;

				default:
					echo "Unknown Page";
					break;
				} // switch 
			} // if (!empty($_POST['submitButton'])) 

    
	// If the user saves the new field, this field has to be added to the pagefields table.  This needs to stay in this position
	// because the new field needs to be displayed in the section that lists fields within a form.
			if (!empty($_POST['saveNewField'])) {
				$field=$_POST['fieldDescription'] ;
				// insert new field into pagefields.  A trigger exists to create a record for new field in all languages
				// in page content.
				$query="INSERT INTO pagefields(fieldDescription, pageid) values ('" .
				       $field . "', " . $_SESSION['pageToUpdate'] . ")" ;
				$result = $connection->query($query); 

			}
			
		//If the user goes ahead and deletes the field, then a query is sent to the database to delete the field
		//A trigger is also in place that deletes all content related to that field in pagecontent. This needs to stay in this position
	// because the new field needs to be displayed in the section that lists fields within a form.
	
				if (!empty($_POST['saveDelBut'])) {
					$query="DELETE FROM pagefields where fieldid=" .
					$_POST['fieldlist'] ;
					$result = $connection->query($query); 
				}

		
	// the fields relating to the current page being edited (i.e. $_SESSION['pageToUpdate']) are displayed as radio buttons on the left side
				if ((isset($_SESSION['pageToUpdate']) and $_SESSION['logged']==1 and empty($_POST['delfieldbutton']) 
					and empty($_POST['addfieldbutton']) and empty($_POST['fieldButton'])) or (!empty($_POST['saveNewField'])) 
					or (!empty($_POST['saveDelBut']))) {
					$query ="SELECT  " .
					"fieldid, " .
					"fieldDescription " .
					"FROM pagefields " .
					"WHERE pageid= " .
					$_SESSION['pageToUpdate'] ;
					$result = $connection->query($query);
					$row_cnt = $result->num_rows;
					echo "<div id='mainareaMaint'>" ;
					echo "<form method='post' class='basic-grey'>" ;
					echo "<h1>" ;
					echo $_SESSION['pageName'] . " Page - Please select a field to update</h1>" ;
					$count = 0 ;

					while ($row = $result->fetch_assoc()) {
						echo "<input type='radio' name='fieldid' value='" . $row['fieldid'] ;
						if ($count==0) {
							echo "' checked required />" ;
						} else {
							echo "' />" ;
						}
						echo $row['fieldDescription'] . "<br>";
						$count++;
					} // while
					if ($row_cnt > 0){
						echo "<label>";
		 				echo "<br><input type='submit' name='fieldButton' value='Update Content' class='button'>" ;
						echo "</label>";
					} else {
						echo "<br>There are no fields to update. You must add some fields<br>";
					}
					/*echo"</form>"; */

					//close the crecordset
					$result->close();
					
					echo "<br>" ;
					echo "<br>" ;
					echo " <label for='addfieldbutton'><h1>You can also:</h1></label>" ;
					echo "<br>" ;
					echo "<label>" ;
					echo " <input type='submit' name='addfieldbutton' id='addfieldbutton' value='Add New Field' class='button'/>" ;
					echo " <input type='submit' name='delfieldbutton' id='delfieldbutton' value='Delete Field' class='button'/>";
					echo "</label>" ;
					echo "</form>" ; 
					echo "</div>" ;
				} // isset(

	//If the user wishes to add a new field then a form is displayed asking for those details
			if (!empty($_POST['addfieldbutton'])) {
				echo "<div id='mainareaMaint'>" ;
				echo "<form method='post' class='basic-grey'>" ;
				echo "<h1>Add new field to " . $_SESSION['pageName'] . "</h1> " ;
				echo "<br>";
				echo " <label for='fieldDescription'>Field Description:</label>" ;
				echo "<br>";
				echo "<input type='text' name='fieldDescription' id='fieldDescription'/>";
				echo "<br><br>";
				echo "<label>" ;
				echo " <input type='submit' name='saveNewField' value='Save New Field' class='button'/>" ;
				echo " <input type='submit' name='cancel' value='Cancel' class='button'/>" ;
				echo "</label>";
				echo "</form>";
				echo "</div>" ;
			}
			
				//If the user wishes to delete a new field then the fields from the form are listed
			if (!empty($_POST['delfieldbutton'])) {
				echo "<div id='mainareaMaint'>" ;
				echo "<form method='post' class='basic-grey'>" ;
				echo "<h1>Delete field from " . $_SESSION['pageName'] . "</h1>" ;
				echo "<br>";
				echo "<h3>Current page fields</h3>";
				echo "<br>";
				//On all pages, I show all fields and give the user the opportunity to delete those fields.  However, there are 
			    //seven fields in the contact page which cannot be deleted as they are used on the contact page form.  I have hard coded
				//these fields in to my select statement (which is not ideal).  This will be addressed in the next version by setting up 
				//different types of fields and marking those fields as system or user fields (rather than hard coding numbers)
				$query ="SELECT  " .
				"fieldid, " .
				"fieldDescription " .
				"FROM pagefields " .
				"WHERE pageid= " .
				$_SESSION['pageToUpdate'] .
				" AND fieldid NOT BETWEEN 20 AND 27" ;
				$result = $connection->query($query);
				$row_cnt = $result->num_rows;
 
				echo "<select name='fieldlist' >" ;
				while ($row = $result->fetch_assoc()) {
					echo "<option value=" ;
					echo $row['fieldid'] ;
					echo ">" ;
					echo $row['fieldDescription'] ;
					echo "</option>" ;
				}
  				echo "</select>" ;
				echo "<br>";
				echo "<br>";
				echo "<div class='error'>Please be careful.  If you delete this field you delete all content for this field in all languages</div>";
				echo "<br><br><label>";
				if($row_cnt>0) {
					echo " <input type='submit' name='saveDelBut' value='Delete Field' class='button'/>" ;
				}
				echo " <input type='submit' name='cancel' value='Cancel' class='button'/>" ;
				echo "</label>";
				echo "</form>";
				echo "</div>" ;
			}



	// If a field has been selected to be updated, then we display the text relating to that field in all languages. If a field has not 
	// been selected we give an error message
			if (!empty($_POST['fieldButton']))  {
					$field = $_POST['fieldid'];
					echo "<div id='mainareaMaint'>" ;
		 			$query ="SELECT  " .
					"pagecontent.fieldid as fieldid, " .
					"fieldDescription, " .
					"actualText, " .
					"languageCode " .
					"FROM pagecontent, pagefields " .
					"WHERE pagecontent.fieldid=pagefields.fieldid " .
					" and pagecontent.fieldid =" . $field  . " order by languageCode";
					$result = $connection->query($query); 
					$row_cnt = $result->num_rows;
		        	 echo "<form method='post' class='basic-grey'>" ;
					 echo "<h1>" . $_SESSION['pageName'] . " Page</h1>" ;
      				 while ($row = $result->fetch_assoc()) {
					 	echo "</h1>";
				 	 	echo "<input type='hidden' name= 'hiddenField' value='" .
			     	 	$row['fieldid'] . "'/>" ;
				 	 	echo "<input type='hidden' name = 'languageCode[]' value='" .
				 	 	$row['languageCode'] . "'/>" ;
						echo "<label><span>" ;
						echo $row['fieldDescription'] . "[". $row['languageCode'] ."]:  " ;
						echo "</span>";
 					 	echo "<textarea name='textForPage[]' cols='110' rows='7'>" ;
					 	echo $row['actualText'] ;
					 	echo "</textarea> </label><br><br>" ;  
 					}
					if ($row_cnt>0) {
						echo "<label>";
						echo "<input type='submit' name='save' value='Save' class='button'>" ;
						echo "</label>" ;
						echo "<br>" ;
					}
  					echo"</form>";
	
					//close the crecordset
					$result->close();
					echo "</div>" ;
				
		} // if (!empty($_POST['fieldButton'])) 

	// this is where we actually update the tables with the values.  If the save button is selected, the new information is written to the database
		if (!empty($_POST['save'])) {
			for($x=0; $x<count($_POST['textForPage']); $x++) {
    // now you can use $_POST[] - array to update all the page content for that field
				$query = "update pagecontent set actualText = '" .
				($_POST['textForPage'][$x]) . "' where languageCode = '" .
				($_POST['languageCode'][$x]) . "' and fieldid = " .
				($_POST['hiddenField']) ;
				$result = $connection->query($query); 
			} // for

 		} //  if (!empty($_POST['save'])) 
	} // if($_SERVER['REQUEST_METHOD']=='POST') 
} else {
    if (isset($_POST['login'])) {
		$query="SELECT * FROM admin WHERE username='" .
		$_POST['username'] . "' and  password = '" .
		md5($_POST['password']) . "'" ;

		$result = $connection->query($query); 
		$row_cnt = $result->num_rows;
		if ($row_cnt>0){
 			$_SESSION['logged']=1 ;
		}
		else {
			$_SESSION['logged']=0 ;
		}
		
		if ($_SESSION['logged']==1) {
		?>
  	      	<div id='mainareaMaint'>
 			<form method="post" class="basic-grey">
        			<h1>Successful login. Press OK to continue</h1>
                    <label>
					<input type="submit" name="login" value="Ok" class="button">
                    </label>
			</form>
			</div>
    	<?php
		} else {
		?>
        	<div id='mainareaMaint'>
			<form method="post" class="basic-grey">
            	<h1>Unsuccessful Login</h1>
                <br>
                <br>
				Username: <input type="text" name="username"><br>
				Password: <input type="password" name="password"><br><br>
                <label>
				<input type="submit" name="login" value="login" class="basic-grey">
                </label>
			</form>
            </div>
   		<?php

		}
			
	} // (isset($_POST[['login']))
	else {
		?>
        <div id='mainareaMaint'>
		<form method="post" class="basic-grey">
        <h1>Please login to use the Administration Section</h1>
        		<br>
                <br>
				Username: <input type="text" name="username"><br>
				Password: <input type="password" name="password"><br><br>
                <label>
				<input type="submit" name="login" value="login" class="button">
                </label>
		</form>
        </div>
		<?php
	} // else...isset($_POST['login']))
} // else...($_SESSION['logged']==1)
	
?>
 		<div id='footer'>&nbsp;</div> 
</div>
</body>
</html>








	



