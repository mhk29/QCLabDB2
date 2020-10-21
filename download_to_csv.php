<?php
    $db = mysqli_connect("127.0.0.1", "root", "Kefalonia1!", "brainwiz"); 

	// create a file pointer connected to the output stream
	$fp = fopen('./mycsv.csv', 'w');

	// output the column headings
	fputcsv($fp, array('im_path', 'notes', 'uploader', 'x_path', 'y_path', 'z_path', 'nifti_path', 'etc', 'long_notes', 'image_id', 'mask_path'));

	// fetch the data
	$rows = mysqli_query($db,'SELECT * FROM images');

	// loop over the rows, outputting them
	while ($row = mysqli_fetch_assoc($rows)) fputcsv($fp, $row);	

	fclose($fp);
	
	// header('Content-Type: text/csv; charset=utf-8');
	// header('Content-Disposition: attachment; filename=mycsv.csv');

?>