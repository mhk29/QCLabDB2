<?php

function dateToAge($stringDate){
	$mydate = date("Y-m-d",strtotime($stringDate));
	$date = new DateTime($mydate);
	$now = new DateTime();
	$interval = $now->diff($date);
	return $interval->m+12*$interval->y;
}

$msg = "No csv file uploaded";
$db = mysqli_connect("127.0.0.1", "root", "Kefalonia1!", "brainwiz");

if (isset($_POST['upload'])){

	$fp = fopen($_FILES["fileToUpload"]["name"],"r");
	// $fp = fopen("testcsv1.csv","r");
	$post1 = fopen("toimages.csv","w");
	$post2 = fopen("totags.csv","w");

	$image_tags=array('Animal ID','Nifti Path','Label Path','Notes','Long Notes');
	$special_tags = array('Animal','Date','DOB','Brunno','Weight','Sex','Genotype','DWI','GRE','Study');

	$line = fgetcsv($fp);
	foreach ($image_tags as $tag) {
		$image_cols[$tag] = array_search($tag, $line);
	}
	foreach ($special_tags as $tag) {
		$special_cols[$tag] = array_search($tag, $line);
	}
	$tag_row = array_search('Tags', $line);

	while(!feof($fp)) {
		$line = fgetcsv($fp);

		foreach ($image_tags as $tag) {
			$myput = $myput . $line[$image_cols[$tag]] . ",";
		}
		$myfile = pathinfo($line[$image_cols['Nifti Path']])['filename'];
		$myput = $myput . $myfile . "_x.jpg" . ",";
		$myput = $myput . $myfile . "_y.jpg" . ",";
		$myput = $myput . $myfile . "_z.jpg" . "\n";
		fwrite($post1, $myput);

        $m = explode(',', $myput);
		$sql = "INSERT INTO images (image_id,nifti_path,mask_path,notes,long_notes,x_path,y_path,z_path) VALUES ('".$m[0]."','".$m[1]."','".$m[2]."','".$m[3]."','".$m[4]."','".$m[5]."','".$m[6]."','".$m[7]."');";
		mysqli_query($db,$sql) 
		or die ('Unable to execute query. '. mysqli_error($db));
		$myput = NULL;

		foreach ($special_tags as $tag) {
			if ($special_cols[$tag] == 0) {
				continue;
			} else {
				fputcsv($post2, array($line[0],$tag,$line[$special_cols[$tag]]));
				$sql = "INSERT INTO tags (image_id,attribute,value) VALUES ('".$line[0]."','".strtolower($tag)."','".$line[$special_cols[$tag]]."');";
				mysqli_query($db,$sql) 
				or die ('Unable to execute query. '. mysqli_error($db));
			}
		}

        $k = explode(';', $line[$tag_row]);
        foreach ($k as $tag) {
        	$l = explode(':', $tag);
	        if($l[0] != ''){
				if (count($l) == 1){
					fputcsv($post2, array($line[0],$l[0],''));
					$sql = "INSERT INTO tags (image_id,attribute,value) VALUES ('".$line[0]."','".$l[0]."','"."');";
					mysqli_query($db,$sql) 
					or die ('Unable to execute query. '. mysqli_error($db));
				} else {
					fputcsv($post2, array($line[0],$l[0],$l[1]));
					$sql = "INSERT INTO tags (image_id,attribute,value) VALUES ('".$line[0]."','".$l[0]."','".$l[1]."');";
					mysqli_query($db,$sql) 
					or die ('Unable to execute query. '. mysqli_error($db));
				}
			}	
        }

	}

	fclose($post2);
	fclose($post1);
   	fclose($fp);

}

?>

<html>
<script type="text/javascript" src="./plupload/js/plupload.full.min.js"></script>
    <div id=content>
    <h1>Upload CSV File</h1>
    <form action="csv_convert.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
        <div>
        	Upload CSV File: 
        	<input type="file" name="fileToUpload" value="fileToUpload">
         </div>
         <br>
         <div>
            <input type="submit" name="upload" value="upload">
         </div>

    </form>
    </div>
    <div>
		<div id="filelist">Your browser doesn't have HTML5 support.</div>
		<br />

		<div id="container">
		<a id="pickfiles" href="javascript:;"><button>Select files</button></a> 
		<a id="uploadfiles" href="javascript:;"><button>Upload files</button></a>
		</div>
		<br />

		<pre id="console"></pre>
	</div>

<script type="text/javascript">
var uploader = new plupload.Uploader({
  runtimes : 'html5,html4',
  browse_button : 'pickfiles', // you can pass an id...
  container: document.getElementById('container'), // ... or DOM Element itself
  url : 'upload_plup.php',
  filters : {
    max_file_size : '100mb',
    mime_types: [
      {title : "Image files", extensions : "jpg,gif,png,nii"},
      {title : "Zip files", extensions : "zip,nii.gz"}
    ]
  },
  init: {
    PostInit: function() {
      document.getElementById('filelist').innerHTML = '';

      document.getElementById('uploadfiles').onclick = function() {
        uploader.start();
        return false;
      };
    },
    FilesAdded: function(up, files) {
      plupload.each(files, function(file) {
        document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
      });
    },
    UploadProgress: function(up, file) {
      document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
    },
    Error: function(up, err) {
      document.getElementById('console').appendChild(document.createTextNode("\nError #" + err.code + ": " + err.message));
    }
  }
});
uploader.init();
</script>

</html>