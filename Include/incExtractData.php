        <?php 
		 $query = "SELECT actualText FROM pagecontent INNER JOIN pagefields " . 
		 		  "ON pagecontent.fieldid = pagefields.fieldid " .
				  "where pagefields.pageid = " .
				  $_SESSION['pageid'] .
				  " and languageCode = '" . 
		          $_SESSION['language'] . 
				  "' ORDER BY pagecontent.fieldid";
				$result = $connection->query($query); 
				while ($row = $result->fetch_assoc()) {
				//		echo "<p>" ;
						echo $row['actualText'];
				//		echo "</p>" ;
					}
				//close the crecordset
				$result->close();
 		?>
