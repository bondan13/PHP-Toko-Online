<?php
require "ceksesion.php";
include 'db.php';
$idb=$_GET['idb'];
$path = "../gambar/";
?>
<link rel="stylesheet" type="text/css" href="../tampilan/style.css">
<!-- tampilan IMG Cropping + source script-->
<link rel="stylesheet" type="text/css" href="jcrop/css/imgareaselect-default.css" />
<script type="text/javascript" src="jcrop/scripts/jquery.min.js"></script>
<script type="text/javascript" src="jcrop/scripts/jquery.imgareaselect.pack.js"></script>
<script type="text/javascript">
function getSizes(im,obj)
	{
		var x_axis = obj.x1;
		var x2_axis = obj.x2;
		var y_axis = obj.y1;
		var y2_axis = obj.y2;
		var thumb_width = obj.width;
		var thumb_height = obj.height;
		if(thumb_width > 0)
			{
				if(confirm("Do you want to save image..!"))
					{window.location.href = "ajax.php?t=ajax&img="+$("#image_name").val()+"&w="+thumb_width+"&h="+thumb_height+		"&x1="+x_axis+"&y1="+y_axis;}
			}
		else
			alert("Please select portion..!");
	}

$(document).ready(function () {
    $('img#photo').imgAreaSelect({
        aspectRatio: '1.16:1',
        onSelectEnd: getSizes
    });
});
</script>
<!-- Form Gambar -->	
<div class="isi" style="width:560px; margin-top:10px; margin-left:15%">
<h1 align="center">Tabah gambar</h1><hr />

<?php
$valid_formats = array("jpg", "png", "gif", "bmp");
if(isset($_POST['submit'])){
	$name = $_FILES['photoimg']['name'];
	$size = $_FILES['photoimg']['size'];
	if(strlen($name)){
		list($txt, $ext) = explode(".", $name);
		if(in_array($ext,$valid_formats) && $size<(250*1024)){
			mysql_query("INSERT INTO  foto values ('NULL','$idb','$actual_image_name','NULL')");
			$id_image=mysql_insert_id();
			$actual_image_name = $id_image.".".$ext;
			$tmp = $_FILES['photoimg']['tmp_name'];
				if(move_uploaded_file($tmp, $path.$actual_image_name)){
					mysql_query("UPDATE foto SET foto='$actual_image_name' WHERE id_foto='$id_image'");
					$image="<p>Potong Gambar 1</p><img src='../gambar/".$actual_image_name."' id=\"photo\" >";
				}
				else
				echo "failed";
				}
		else
		echo "Invalid file formats..!";
		}
	else
	echo "Please select image..!";
	}
?>
<?php 
if ($_GET['idb'] !=NULL){?> 

	

	<?php 
	$query= mysql_query("select * from barang where id_barang = '$idb'");
	
	$nama=@mysql_result($query,0,1);
	$deskripsi=@mysql_result($query,0,3);
	$harga_jual=@mysql_result($query,0,6);
	$stok=@mysql_result($query,0,7);
	
	?>
	
<div id="artikel" style="width:550px;"> 
		<div class="isiartikel">
		<h1><?php echo $nama; ?></h1>
			<div id="deskripsi">
				<?php echo $deskripsi;?>

			</div>
			<div id="gambar" align="center">
			<?php 
				$query= mysql_query("select * from foto where id_barang = '$idb' LIMIT 3");
				while ($baris =mysql_fetch_array($query)){
					echo "<img src='http://localhost/design/gambar/".$baris[3]."' /><br /><a href='hapus.php?id_img=".$baris[0]."'><img src='../icon/del.png' /></a><br /><br />";
				}
				$query2= mysql_query("select * from foto where id_barang = '$idb' LIMIT 3,4");
				while ($baris =mysql_fetch_array($query2)){
					echo "<img src='http://localhost/design/gambar/".$baris[3]."' width='88' height='75' /> <br /><a href='hapus.php?id_img=".$baris[0]."'><img src='../icon/del.png' /></a><br /><br />";
				}
			?>
			</div>
		</div>
	</div>
	<h2>Crop Gambar</h2>
	<hr />pilih dan crop gambar
	<?php echo $image; ?>
	<br />
	<form id="cropimage" method="post" enctype="multipart/form-data">
		<input type="file" name="photoimg" id="photoimg" />
		<input type="hidden" name="image_name" id="image_name" value="<?php echo($actual_image_name)?>" />
		<input type="submit" name="submit" value="Submit" /> 
	</form>
	<div align="right"><a href="artikel.php">selesai</a></div>
	</div>
<?php } ?>