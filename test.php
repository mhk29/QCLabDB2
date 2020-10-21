<?php
session_start();
$db = mysqli_connect("127.0.0.1", "root", "Kefalonia1!", "brainwiz");
// $db = new mysqli("127.0.0.1", "root", "Kefalonia1!", "brainwiz");

if (!$db) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

echo "Success: A proper connection to MySQL was made! The brainwiz database is great." . PHP_EOL;
echo "Host information: " . mysqli_get_host_info($db) . PHP_EOL;

$uploader = "5";
$long_notes = "hi";

$sql = "INSERT INTO images (im_path,notes) VALUES ('".$uploader."','".$long_notes."');";
// $db->query($sql);
mysqli_query($db, $sql) or die ('Error updating database: ' . mysql_error());

mysqli_close($db);

?>
