<?php
require "ceksesion.php";
require "db.php";
if (isset ($_GET['idb']) && is_numeric($_GET['idb'])){
	$idb = $_GET['idb'];
	$query1= mysql_query("select * from katagori where id_kepala IS NULL");
	$query3= mysql_query("Select  barang.id_barang,
								  barang.nm_barang,
								  barang.link,
								  barang.deskripsi,
								  barang.harga,
								  barang.komisi,
								  barang.stok,
								  barang.berat,
								  barang.panjang,
								  barang.lebar,
								  barang.tinggi,
								  barang.asuransi,
								  barang.packing_kayu,
								  katagori.id_katagori,
								  katagori.nama
								From
								  barang Inner Join
								  katagori On katagori.id_katagori =
									barang.id_katagori
								Where
								  barang.id_barang = '$idb'
								Limit 1"
						);
	$id_barang=@mysql_result($query3,0,0);
	$nama=@mysql_result($query3,0,1);
	$link=@mysql_result($query3,0,2);
	$desc=@mysql_result($query3,0,3);
	$harga=@mysql_result($query3,0,4);
	$komisi=@mysql_result($query3,0,5);
	$stok=@mysql_result($query3,0,6);
	$berat=@mysql_result($query3,0,7);
	$panjang=@mysql_result($query3,0,8);
	$lebar=@mysql_result($query3,0,9);
	$tinggi=@mysql_result($query3,0,10);
	$asur=@mysql_result($query3,0,11);
	$pack=@mysql_result($query3,0,12);
	$id_k=@mysql_result($query3,0,13);
	$nama_k=@mysql_result($query3,0,14);
	}	

if ($asur=='y'){
	$asuransi='checked';}	
if ($pack=='y'){
	$packing='checked';}				
?>

<html>
<head>
<?php require'a_head.php'; ?>
<!-- tampilan SCeditor + source script-->
<link rel="stylesheet" href="jform/minified/themes/modern.min.css" type="text/css" media="all" />
<script src="jform/minified/jquery.sceditor.min.js"></script>
<script>
	$(document).ready(function() {
		$("textarea:first").sceditor({
		toolbar: "bold,italic,underline|font,size,color,left,center,right,justify,removeformat|image,link,unlink,quote,bulletlist,orderedlist,table|source",
		resizeEnabled: false
		});
	});
</script>

<script type="text/javascript">
    $(document).ready(function() {
 	if($('#packing').is(':checked')) { 
                $('.volume').show();}
	else {
			$('.volume').hide();}
			
	$( "#packing" ).click(function() {
		 	if($('#packing').is(':checked')) { 
                $('.volume').show("fold", 1000);}
			else {
			$('.volume').hide("fold", 1000);}
		});
    });
</script>
<style>
.inputs{
width:100%; 
height:30px; 
border-radius:5px; 
border:1px solid #000000;
margin-bottom:10px;
padding-left:5px;}

.volume{
width:auto;
padding-left:8px;
padding-top:8px;
height:auto; 
border-radius:5px; 
margin-bottom:10px;
background:url(../icon/header-bg.jpg);
border:1px solid #666666;
display:none;}
</style>
</head>
<body>
<?php 
require'a_top.php';
require'a_menu.php'; ?>
<!-- Form Artikel -->		
<form method="post" action="eu-artikel.php" >
<input type="hidden" name="idb" value="<?php echo $idb; ?>" />
<input type="hidden" name="pengaturan" value="update">
<div class="isi" style="width:50%;" >
	<b>Nama Barang</b>
	<p><input type="text" name="namabarang" maxlength="100" value="<?php echo $nama; ?>" style="width:100%; height:30px; 
	border-radius:5px; border:1px solid #000000; padding-left:10px; margin-bottom:20px;"></p>
	<b>Deskripsi</b> 
	<textarea name="deskripsi" style="height:400px;width:101%;"><?php echo $desc; ?></textarea>
</div >			
			
<div class="isi" style="width:18%;">
	<p>Berat /Kg <br> <input type="text" name="berat" maxlength="5" class="inputs" value="<?php echo $berat; ?>"></p>
	<p>harga<br> <input type="text" name="harga" maxlength="10" class="inputs" value="<?php echo $harga; ?>"></p>
	<p>Komisi<br> <input type="text" name="komisi" maxlength="10" class="inputs" value="<?php echo $komisi; ?>"></p>
	<p>Stok <br> <input type="text" name="stok" maxlength="10" class="inputs" value="<?php echo $stok; ?>"></p>
	<p>Katagori<br>
		<select name="id_katagori" class="inputs" style="padding-top:5px;">
			<?php 
			while ($baris1 =mysql_fetch_array($query1)){	
				if ($id_k ==  $baris1[0]){
					echo "<option selected value='".$baris1[0]."'>".$baris1[2]."</option>";}
				else {echo "<option value='".$baris1[0]."'>".$baris1[2]."</option>";}
							$query2= mysql_query("SELECT * FROM `katagori` where id_kepala='$baris1[0]'");
							while ($baris2 =mysql_fetch_array($query2)){
								if ($id_k ==  $baris2[0]){
									echo "<option selected value='".$baris2[0]."'>&nbsp;&nbsp;".$baris2[2]."</option>"
									;}
								else {echo "<option value='".$baris2[0]."'>&nbsp;&nbsp;".$baris2[2]."</option>";}
							}
			}
			?>
		</select>
	</p>
	<p><input type="checkbox" value="y" name="asuransi" <?php echo $asuransi; ?> > Asuransi</p>
	<p><input type="checkbox" value="y" name="packing" id="packing" style="margin-bottom:10px;" <?php echo $packing; ?> > 
	Packing Kayu
	</p>
	<p class="volume">
		Panjang (cm)
		<input type="text" name="panjang" maxlength="3" class="inputs" value="<?php echo $panjang ?>" style="width:30px;"><br>
		Lebar (cm) &nbsp;&nbsp;&nbsp; 
		<input type="text" name="lebar" maxlength="3" class="inputs" value="<?php echo $lebar ?>" style="width:30px; "><br>
		Tinggi (cm) &nbsp;&nbsp;&nbsp;
		<input type="text" name="tinggi" maxlength="3" class="inputs" value="<?php echo $tinggi ?>" style="width:30px; ">
	</p>
	<p><input type="submit" value="Simpan" /></p>
</form>
</div>
</body>
</html>




