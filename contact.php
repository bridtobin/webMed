<?php
session_start();

  $_SESSION['currentPage']="contact" ;
  $_SESSION['pageid']=1;

if(!isset($_SESSION['language'])) {
	$_SESSION['language']="en";
}
?>
<!DOCTYPE html>
<?php 
echo "<html lang='". $_SESSION['language'] . "'>" ;
?>
<head>
	<link rel="stylesheet" type="text/css" href="gdmedstyle.css"  >
    <title>XYZ Medical Centre</title>
<!--Had to use the following character set to display the accent in the Irish language-->
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
	<meta name="description" content="XYZ Medical Centre">
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
        <?php
/*extract all information from the field table except those fields that are used in the contact form below.  This will be handled in a more
structured way in the next version*/


		 $query = "SELECT actualText FROM pagecontent INNER JOIN pagefields " . 
		 		  "ON pagecontent.fieldid = pagefields.fieldid " .
				  "where pagefields.pageid = " .
				  $_SESSION['pageid'] .
				  " and languageCode = '" . 
		          $_SESSION['language'] . 
				  "' AND pagecontent.fieldid NOT BETWEEN 20 AND 27" ;
				$result = $connection->query($query); 
				while ($row = $result->fetch_assoc()) {
						echo $row['actualText'];
					}
				//close the crecordset
				$result->close();
		  		  
	//this function is used to check the field to make sure there is no code injected 
	function spamcheck($field) {
  // Sanitize e-mail address
  		$field=filter_var($field, FILTER_SANITIZE_EMAIL);
  // Validate e-mail address
 		 if(filter_var($field, FILTER_VALIDATE_EMAIL)) {
    		return TRUE;
  		} else {
    		return FALSE;
  		}
	}  // function spamCheck
?>

		<?php
		// display form if user has not clicked submit
		if($_SERVER['REQUEST_METHOD']=='POST') {
  			// Check if the "from" input field is filled out
 			 if (!empty($_POST["from"])) {
 			 // Check if "from" email address is valid
  				  $mailcheck = spamcheck($_POST["from"]);
 				   if ($mailcheck==FALSE) {
	  					$invalid=1;
    			   } else {
				        $invalid=0;
  						$from = $_POST["from"]; // sender
      	 				$subject = $_POST["subject"];
      	 				$message = $_POST["message"];
      					// message lines should not exceed 70 characters (PHP rule), so wrap it
      	 				$message = wordwrap($message, 70);
      					// send mail
      	  				mail("briddelap@gmail.com",$subject,$message,"From: $from\n");
    				} // if $mailcheck
  			 } // if isset($_POST[
			 else {
				 $invalid=1;
			 }
		} // if $_SERVER

		if (!isset($invalid)) {
			$invalid=2;
		}

// 		<iframe //src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d9139.198682017744!2d-8.300013!3d55.064245!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2//zNTXCsDAzJzUxLjMiTiA4wrAxOCcwMC4xIlc!5e0!3m2!1sen!2sie!4v1400453856038" width="600" height="450" style="border:0"></iframe>

		//Show the contact form again if the data was invalid or if we are showing it for the first time
//		if (empty($_POST["submit"]) or $invalid==1) {
			?>
			<form method='post' class='basic-grey'> 

			    <?php
				$query = "SELECT actualText, pagecontent.fieldid FROM pagecontent INNER JOIN pagefields " . 
				"ON pagecontent.fieldid = pagefields.fieldid " .
				"where pagefields.pageid = " .
				$_SESSION['pageid'] .
				" and languageCode = '" . 
		   		$_SESSION['language'] . 
			 	"'" ;
				$result = $connection->query($query); 
				$row_cnt = $result->num_rows;
				// store values in these variables in case there is a problem with database.  Don't want to get unindexed error messages
				// These values are hard coded in to the contact form and this way of handling fixed fields will have to be handled in the next
				// version
				$nameTag="Name";
				$emailTag="Email Address";
				$phoneTag = "Phone:";
				$messageTag="Message";
				$subjectTag="Subject";
				$errorTag="Invalid input.  Make sure email address is valid";
				$titleTag="Contact Form";
				// These fields relate to the headings in the contact form.
				while ($row = $result->fetch_assoc()) {
					switch ($row['fieldid']) {
    				case 20:
        				$nameTag = $row['actualText'] ;
	      				break;
 					case 22:
        				$phoneTag = $row['actualText'] ;
	      				break;
					case 21:
        				$emailTag = $row['actualText'] ;
	      				break;
	  				case 23:
        				$messageTag = $row['actualText'] ;
		   				break;
					case 24:
        				$subjectTag = $row['actualText'] ;
		   				break;
					case 26:
						$titleTag = $row['actualText'] ;
						break;
					case 27:
						$errorTag = $row['actualText'] ;
						break;
					}
				}
				//close the crecordset
				$result->close();
	
				echo "<h1>" . $titleTag .  "</h1>";
				if($invalid==1) {
					echo "<div class='error'>" ;
					echo $errorTag ;
					echo "</div>";
				}
				else {
					if($invalid==0) {
						echo "<div class='error'>";
						echo "Your email was sent successfully" ;
						echo "</div>" ;
					}
				}
  				?>
          	<!--code for contact form. If form is reshown because of errors, fill the fields with the already entered data-->
            <label>
  		  	 <span><?php echo $nameTag?></span> <input type='text' name='name' 
 		  	 <?php if ($invalid==1) 
	 		 echo "value='" . $_POST['name'] . "'" ; 
	  	  	 ?>/></label>
  		  	 <label>
  		  	 <span><?php echo $phoneTag?></span> <input type='text' name='phone' 
   		  	<?php if ($invalid==1) 
	  	  	echo "value='" . $_POST['phone'] . "'" ; 
	  	  	?>/> </label>
   		  	<label>
  		  	<span><?php echo $emailTag?></span> <input type="text" name="from"
   		  	<?php if ($invalid==1) 
	  	  	echo "value='" . $_POST['from'] . "'" ; 
	  	  	?>/> </label>
          	<label>    
  		  	<span><?php echo $subjectTag?></span> <input type="text" name="subject"
   		  	<?php if ($invalid==1) 
	 	  	echo "value='" . $_POST['subject'] . "'" ; 
	  	  	?>/> </label>
 		  	<label>
  		  	<span><?php echo $messageTag?></span> <textarea rows="8" cols="40" name="message">
   		  	<?php if ($invalid==1) 
	  	  	echo $_POST['message'] . "'" ; 
			$invalid=2;
	  	  	?></textarea> </label>
   		  	<label>
   		  	<span></span>
   		  	<input type="submit" name="submit" class="button" value="Send email">
   		  	</label>

  		</form>
    </div>             
    <div id='linkbar'>
    	<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d9139.198682017744!2d-8.300013!3d55.064245!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNTXCsDAzJzUxLjMiTiA4wrAxOCcwMC4xIlc!5e0!3m2!1sen!2sie!4v1400453856038" width="300" height="225" style="border:0"></iframe>
</div>

  <?php 
   
   echo "<div id='footer'>" ;
   include "Include/incFooter.php"; ?>
   
   </div>
   </div>
</body>
</html>