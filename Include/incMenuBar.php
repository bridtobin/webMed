<!--This is an include file for menubar which is used on all pages --> 
			<?php
		// select the menu titles in the language selected from the menuTitle table in database.  
 			 $query = "SELECT menuTitle, pagePath, page.pageid AS pageid FROM menutitles INNER JOIN page" . 
  		              " ON menutitles.pageid = page.pageid ".
			          " WHERE menutitles.languageCode = '".
			          $_SESSION['language'] .
			          "' order by page.orderForListing" ;

				$result = $connection->query($query); 
				echo "<ul>";
				while ($row = $result->fetch_assoc()) {
						echo "<li><a href='" ; 
						echo $row['pagePath'] ;
						echo "?pageid=" ;
						echo $row['pageid'];
						echo "'>" ;
						echo $row['menuTitle'] ;
						echo "</a></li>" ;
 					}
				echo "</ul>" ;
				//close the crecordset
				$result->close();
 			?>
