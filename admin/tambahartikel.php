<?php
require "ceksesion.php";
require 'db.php';
$query1= mysql_query('select * from katagori where id_kepala IS NULL');
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
.inputs{width:100%; 
height:30px; 
border-radius:5px; 
border:1px solid #000000;
margin-bottom:5px;
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
require 'a_top.php'; 
require 'a_menu.php'; 
?>
<form method="post" action="eu-artikel.php" style="margin:0px;">
<div class="isi" style="width:50%;" >
	<b>Nama Barang</b>
	<p><input type="text" name="namabarang" maxlength="100" style="width:100%; height:30px; 
	border-radius:5px; border:1px solid #000000; padding-left:10px; margin-bottom:20px;"></p>
	<b>Deskripsi</b> 
	<textarea name="deskripsi" style="height:380px;width:101%;"></textarea>
</div >

<div class="isi" style="width:18%;">

				<p>Berat / KG <br> <input type="text" name="berat" maxlength="5" class="inputs"></p
				><p>Harga<br> <input type="text" name="harga" maxlength="10" class="inputs"></p>
				<p>Komisi<br> <input type="text" name="komisi" maxlength="10" class="inputs"></p>
				<p>Stok <br> <input type="text" name="stok" maxlength="10" class="inputs"></p>
				<p>Katagori<br>
 					<select name="id_katagori" class="inputs" style="padding-top:5px;" >
						<?php 
						while ($baris =mysql_fetch_array($query1)){	
						$query2= mysql_query("SELECT * FROM `katagori` where id_kepala='$baris[0]'");
							echo "<option value='".$baris[0]."'><b>".$baris[2]."</b></option>";
							while ($baris2 =mysql_fetch_array($query2)){
								echo "<option value='".$baris2[0]."'>&nbsp;&nbsp;".$baris2[2]."</option>";
							}
						}
						?>
					</select></p>
				<input type="hidden" name="pengaturan" value="insert">
				<p><input type="checkbox" value="y" name="asuransi" c> Asuransi</p>
				<p><input type="checkbox" value="y" name="packing" id="packing" style="margin-bottom:10px;"> Packing Kayu</p>
				<p class="volume">
				Panjang (cm) <input type="text" name="panjang" maxlength="3" class="inputs" style="width:30px;"><br>
				Lebar (cm) &nbsp;&nbsp;&nbsp; <input type="text" name="lebar" maxlength="3" 
				class="inputs" style="width:30px; "><br>
				Tinggi (cm) &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="tinggi" maxlength="3" 
				class="inputs" style="width:30px; ">
				</p>
				<p><input type="submit" value="Simpan" /></p>	
	</form>
</div>
</body>
</html>







