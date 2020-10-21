<!-- <script type="text/javascript">
     window.location = "gallery/gallery.php"
</script>
 -->
<?php
	$db = mysqli_connect("127.0.0.1", "root", "Kefalonia1!", "brainwiz");
	$sql="SELECT * FROM tags";
	$result = mysqli_query($db,$sql);
	foreach ($result as $att) {
		if ($att[0] == "genotype") {
			$genotypes[$att[0]] = $att[1];
		}
	}

?>

<html>
<div style="padding-left:16px">
  <h2>MRI Image Database</h2>
  <p>Welcome to the QClab MRI image database!</p>
</div>
<table>
	Organize by Genotype:
	<tr>
		<?php 
			foreach ($genotypes as $gt) {
				echo '<td><a href="./gallery-new.php.php?genotype='.$gt.'"><button>'.$gt.'</button></a></td>';
			}
		?>
	</tr>
</table>
<table>
	Organize by Gender:
	<tr>
		<td><a href="./gallery-new.php?gender=0"><button>male</button></a></td>
		<td><a href="./gallery-new.php?gender=1"><button>male</button></a></td>
	</tr>
</table>


</html>