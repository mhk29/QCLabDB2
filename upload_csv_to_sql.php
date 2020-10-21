<?php
    $db = mysqli_connect("127.0.0.1", "root", "Kefalonia1!", "brainwiz"); 

    if (isset($_POST["csvfile"])) {
		mysqli_query("LOAD DATA INFILE ".." 
					 INTO TABLE images 
					 FIELDS TERMINATED BY ',' 
					 ENCLOSED BY '\"'
					 LINES TERMINATED BY '\n'
					 IGNORE 1 ROWS;");
		}
    }

?>