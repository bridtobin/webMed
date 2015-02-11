<?php
if(!isset($_SESSION)) {
	session_start();
}


//show all links in linkbar	
echo "<h2>Links</h2>";
$query="SELECT fieldDescription, actualText FROM pagecontent, pagefields 
where pagecontent.fieldid = pagefields.fieldid and
pageid=9 and languageCode = '" . $_SESSION['language'] ."'";
$result = $connection->query($query); 
while ($row = $result->fetch_assoc()) {
	echo "<a href ='" . $row['fieldDescription'] . "' target='_blank'>". $row['actualText'] ."</a><br>"  ;
}
$result->close();
?>