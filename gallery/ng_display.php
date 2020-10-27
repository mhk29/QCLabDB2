<!DOCTYPE html>
<html>
<head>
	<title>Neuroglancer Instance</title>
	<script>
		function goBack() {
		  window.history.back();
		}
	</script>
</head>
<body>
<?php
$db = mysqli_connect("127.0.0.1", "root", "Kefalonia1!", "brainwiz");
$p = urlencode(file_get_contents("./useful.json"));

// $myname = $_GET["name"];
echo 
'<div id="left" style="float:left; width=800px; margin:50px;">
    <iframe id="myframe" src="http://localhost:8888/brainwhiz/gallery/neuroglancer/src/neuroglancer/#!'.$p.'" width="800" height="600" style="border:1px solid lightgrey;"></iframe> 
</div>';

?>
<button onclick="./index.html">Go Home</button>
<button onclick="goBack()">Go Back</button>
<?php
$db = mysqli_connect("127.0.0.1", "root", "Kefalonia1!", "brainwiz");

$myname = $_GET["name"];
echo "<a href='".$myname.".nii' download><button>Download Nifti</button></a>";
echo "<a href='".$myname.".jpg' download><button>Download Center Slices</button></a>";

?>
</body>
</html>
