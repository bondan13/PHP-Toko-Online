<?php
if (isset($_GET['reff'])){
	$reff=trim($_GET['reff']);
	if (is_numeric($reff)){
   	 	setcookie('creff', $reff, time()+(60*60*24*30*12), '/');
		$ling=str_replace('design/'.$reff.'/','',$_SERVER['REQUEST_URI']);
		header ("location:..".$ling);}
	else { header ("location:../index.php");}
	}
else {				
	require 'ceksesion.php';
	require 'db.php';
//=====================================================================halaman
	$itemperpage=5;
	if (isset($_GET['h'])){
		$hal=$_GET['h'];
		$posisi=($hal-1)*$itemperpage;}
	else if (empty($_GET['h'])){
		$hal=1;
		$posisi=0;}
//=====================================================================halaman
	$idb=$_GET['idb'];
	$query= @mysql_query("select * from barang where id_barang = '$idb' LIMIT 1");
		$nama=@mysql_result($query,0,1);
		$link=@mysql_result($query,0,2);
		$deskripsi=@mysql_result($query,0,3);
		$harga=@mysql_result($query,0,5);
		$komisi=@mysql_result($query,0,6);
		$stok=@mysql_result($query,0,7);
	$query4=mysql_query("Select user.nama, komentar.komentar, komentar.tanggal From komentar 
	Inner Join user On komentar.id_user = user.id_user Where komentar.id_barang = '$idb' 
	And komentar.status = 'p' ORDER BY komentar.id_komentar desc LIMIT $posisi,$itemperpage" );
//=====================================================================halaman
	$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_komentar FROM komentar WHERE id_barang=$idb")); 
	$jumlahhalaman=ceil($jumlahdata/$itemperpage);
//=====================================================================halaman	
	?>
	<html>
	<head>
		<title>
			<?php echo $nama; ?>
		</title>
	<?php require "head.php";  ?>
	<link rel="stylesheet" type="text/css" href="jquery/fancyboxcss.css" media="screen">
		<script>
		$(document).ready(function() {
			$(".fancybox-effects-d").fancybox({
				padding: 0,

				openEffect : 'elastic',
				openSpeed  : 150,

				closeEffect : 'elastic',
				closeSpeed  : 150,

				closeClick : true,

				helpers : {
					overlay : null
				}
			});
		});
	</script>
	<script src="jquery/jquery.fancybox.js"></script>
	<style>
		.komen-box{
			background:url(icon/header-bg.jpg) repeat;
			border:0px solid #0000FF;
			border-radius:10px;
			padding:1%;
			width:99%;}
			
		.c{
			margin-top:0px;
			float:right;
			margin-right:1%;
			
			}
		
		.sidebar{
			box-shadow: 0px 0px 5px 0px #CCCCCC;
			border-radius:5px;
			margin-bottom:10px;
			padding-top:10px;
			padding-bottom:10px;
			width:23%;
			float:left;
			text-align:center;}
		
		#buy{
			margin:0px; padding:0px; 
			border:0px solid #FFFFFF; 
			font-size:22px; 
			font-weight:bold;  
			background:#0033CC; 
			color:#FFFFFF; 
			width:63%;
			height:50px;
			float:left;}
		
		#qty{
			width:37%;
			border:0px solid #FFFFFF;
			height:40px;
			float:left;}
	</style>
	
	</head>
	<body>
	<?php 
		require "top.php"; 
		require "menu.php"; 
	?>
	<div class="isi">
	<h1><?php echo $nama; ?></h1>
		<div class="deskripsi">
		<?php 
		$query= @mysql_query("select * from foto where id_barang = '$idb' LIMIT 3");
		while ($baris =@mysql_fetch_array($query)){
			echo "<a class='fancybox-effects-d' href='gambar/".$baris[2]."'>
			<img class='gambar' src='http://localhost/design/gambar/".$baris[3]."' width='100%'/></a>";}
		?>
		</div>
		<div class='sidebar' align="center" style="margin-top:10px;">
			<font size="4" face="Courier New, Courier, monospace" color="#0033FF">
			<b><?php echo "Rp ".number_format($harga,0,',','.');?></b></font>
			<form name="pesan" style="margin:0px;" action="pesan.php" method="post">
				<input type="hidden" value="<?php echo $idb; ?>" name="idb">
				<input type="image" src="icon/beli2.jpg" id="buy">
				<div id="qty">
					<img src="icon/kuantiti.jpg" width="100%" height="50" > 
					<input type="text" value="1" name="jumlah" maxlength="2" style="width:25px; position:relative; top:-32px;">
				</div>
			</form>
		</div>
		
		<div class='sidebar' align="center">
			<img src="icon/bni.jpg"><img src="icon/bca.jpg">
		</div>
	</div>
	<?php 
		if($s_pangkat=='affiliasi'){
			echo "<div class='isi' style='margin-top:10px;'>";
			echo "url affiliasi <input type='text' onclick='this.select();' 
			value='".$_SERVER['HTTP_HOST']."/design/".$s_uid."/".$link."-".$idb.".html' style='width:62%'>";
			echo "<div class='c'><img src='icon/c.png' width=17px height=15 style='top:3px;'>";
			echo "&nbsp;&nbsp;Rp ".number_format($komisi,0,',','.')."</div>";
			echo "</div>";}
	?>
	<div class="isi" style="margin-top:10px;">
		<?php echo $deskripsi;?>
			<hr />
			<font size="2">Komentar</font><br>
			<?php 
			if ($login=='true'){ ?>
				<form method="post" action="verifikasi.php">
				<input type="hidden" value="komentar" name="pengaturan">
				<textarea name="komentar" class="komen-box"></textarea>
				<input type="hidden" name="idb" value="<?php echo $idb; ?>">
				<input type="submit" value="Kirim" style="float:right; position:relative; top:-25px; right:5px;">
				</form><?php 
				}
			else {
				echo "<font size='2'>Silahkan <font color='#0099FF'><a class='logintext'>Login</a>
				</font> untuk berkomentar</font>";}
				
			while ($baris =@mysql_fetch_array($query4)){
					echo "<div class='komentar'><font color='#000000' face='Courier New, Courier, monospace'>
					".$baris[0]."&nbsp;</font>".$baris[1]."</div>";}
					
//=====================================================================halaman				
				echo "<div align='center' style='width:100%; float:inherit;'>";
				if ($hal<=3){
					$blockhal=1;}
					else if ($hal==$jumlahhalaman-1 && $jumlahhalaman>5){
					$blockhal=$hal-3;}
					else if ($hal==$jumlahhalaman && $jumlahhalaman>5){
					$blockhal=$hal-4;}
					else {
					$blockhal=$hal-2;}
					
					
				if ($jumlahhalaman<=3){
					$itemblok=$jumlahhalaman;}
					else if ($hal==$jumlahhalaman-1){
					$itemblok=$hal+1;}
					else if ($hal==$jumlahhalaman){
					$itemblok=$hal;}
					else if ($jumlahhalaman==4){
					$itemblok=4;}
					else if ($hal <=3 && $jumlahhalaman>4){
					$itemblok=5;}
					else{
					$itemblok=$hal+2;}
					
				echo "<div class='paging'>";
				
				if ($hal>3){
					echo "<a href='".$_SERVER['HTTP_SERVER']."/design/".$link."-".$idb.".html-halaman1'>first</a>";}
					
				if ($jumlahhalaman>1){
					for ($i=$blockhal; $i<=$itemblok; $i++){
						echo "<a class='paging' href='".$_SERVER['HTTP_SERVER'].
						"/design/".$link."-".$idb.".html-halaman".$i."'>".$i."</a>";}
					}
						
				if ($jumlahhalaman>5 && $jumlahhalaman-2 > $hal){
					echo "<a href='".$_SERVER['HTTP_SERVER']."/design/".$link."-".$idb.
					".html-halaman".$jumlahhalaman."'>last</a>";}	
					
				echo "</div></div>";	
//=====================================================================halaman
				?>
	</div>
	<?php include 'footer.php'; ?>
</body>
</html>
<?php }?>