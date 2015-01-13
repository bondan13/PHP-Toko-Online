<?php
require 'ceksesion.php';
require 'db.php';
$idt=$_GET['idt'];
$query=mysql_query("Select
			  transaksi.id_transaksi,
			  transaksi.tanggal,
			  transaksi.id_barang,
			  transaksi.harga,
			  transaksi.jumlah,
			  transaksi.id_unik,
			  transaksi.ongkir,
			  transaksi.asuransi,
			  transaksi.packing,
			  transaksi.total_harga,
			  transaksi.tanggal_bayar,
			  transaksi.tanggal_kirim,
			  transaksi.nomor_resi,
			  transaksi.lama_pengiriman,
			  transaksi.status,
			  transaksi.tujuan,
			  barang.nm_barang
			From
			  transaksi Inner Join
			  barang On barang.id_barang = transaksi.id_barang
			Where
			  transaksi.id_transaksi = '$idt' AND transaksi.id_user='$s_uid' LIMIT 1");
			  
		while ($baris =mysql_fetch_array($query)){
			$db_idt=$baris[0];
			$t_tanggal=date("j F Y", strtotime($baris[1]));
			$idb=$baris[2];
			$harga=$baris[3];
			$jumlah=$baris[4];
			$id_unik=$baris[5];
			$ongkir=$baris[6];
			$asuransi=$baris[7];
			$packing=$baris[8];
			$total=$baris[9];
			$tgl_bayar=date("j F Y", strtotime($baris[10]));
			$tgl_kirim=date("j F Y", strtotime($baris[11]));
			$resi=$baris[12];
			$lama_krm=$baris[13];
			$status=$baris[14];
			$tujuan=$baris[15];
			$nama_barang=$baris[16];}
			
		if ($db_idt==NULL){header ("location:index.php");}
		
		$hargatotal=$harga*$jumlah;
?>
<html>
	<head>
		<title>
			Faktur pembelian
		</title>
	<?php require 'head.php'; ?>
	<link rel="stylesheet" type="text/css" href="tampilan/style-table.css">
	<style>
		.ket{
			margin-bottom:30px;
			float:left;}
		.konfirm{
			background-color:#0066ff;
			border:1px solid #666666;
			margin-right:5px;
			margin-bottom:5px;
			font-size: large;
			height:28px;
			border-radius: 5px;
			width:100%;
			color:#FFFFFF; 
			cursor:pointer;}
	</style>
	<script>

	$( document ).ready(function() {
	$('.konfirm').on('click', function () {
			return confirm('Verifikasi : \nSaya telah melakukan transfer ke salah satu rekening yang dipilih');
		});
	});

	</script>
	</head>
	<body>
	<?php
	require "top.php"; 
	require "menu.php"; 
	?>
	<div class="isi" style="padding-bottom:10px; background:url(icon/whitex.jpeg) repeat; 
	border:1px solid #666666; font-size:14px;">
	<div style="width:35%; float:left; margin-bottom:40px;">
	
	<img src="icon/logo.png"><br>
	<p>Jl Kelapa Nias Raya No.62 <br>Kelapa Gading - Jakarta timur
	<br> Kode Pos (14240) <br>Telp : 021-51128266</p><hr>
	Tanggal : <?php	echo $t_tanggal;?><br>
	Faktur No : <?php echo $idt; ?>
	</div>
	<div style="width:45%; float:right; margin-bottom:40px; border:1px solid #666666; padding:5px; border-radius:5px;">
	<p>Kepada</p><p align="justify"><?php echo $tujuan; ?> </p>
	</div>
		<table width="100%" border="0" cellspacing="0" style="font-size:14px;">
			<thead>
				<tr>
					<th align="left">Nama Barang</th>
					<th width="50" align='center'>Kuantiti</th>
					<th width="120" align='right'>Harga Satuan</th>
					<th width="120" align='right'>Jumlah</th>
				</tr>
			</thead>			
				<tbody>
		<?php 
				echo "<tr>";
					echo "<td>".$nama_barang."</td>";
					echo "<td align='center'>".$jumlah."</td>";
					echo "<td align='right'>Rp ".number_format($harga,0,',','.')."</td>";
					echo "<td align='right'>Rp ".number_format($hargatotal,0,',','.')."</td>";
				echo "</tr>";
		?>
			</tbody>
		</table>
	<hr>
		<table width="100%" border="0" cellspacing="0" style="font-size:14px;">
			<tr>
				<td align="right">id unik</td>
				<td width="120" align="right">Rp <?php echo $id_unik; ?></td>
			</tr>
			<tr>
				<td align="right">Biaya kirim</td>
				<td width="120"  align="right"><?php echo "Rp ".number_format($ongkir,0,',','.'); ?></td>
			</tr>
			<?php if ($asuransi!=0){ ?>
			<tr>
				<td align="right">Asuransi</td>
				<td width="120"  align="right"><?php echo "Rp ".number_format($asuransi,0,',','.'); ?></td>
			</tr>
			<?php } if ($packing!=0){ ?>
			<tr>
				<td align="right">Packing kayu</td>
				<td width="120"  align="right"><?php echo "Rp ".number_format($packing,0,',','.'); ?></td>
			</tr>
			<?php }?>
			<tr style="font-size:16px;">
				<td align="right"><b>Total</b> </td>
				<td width="120" align="right"><b><?php echo "Rp ".number_format($total,0,',','.'); ?></b></td>
			</tr>
		</table>
	</div>
	
	<?php if($status=='pesan'){ ?>
		<div class="isi" style="width:39.5%; margin-top:20px; height:240px;" align="justify">
		<?php
		if ($ongkir==NULL or $ongkir==0){
		echo "Ongkos kirim belum diketahui.<br> hubungi 083815838586 <br>atau 021-51128266 <br>untuk mengetahui ongkos kirim";
		}
		else { ?>
		<h4 style="margin:0px; padding:0px; background:#3399FF; color:#FFFFFF;" align="center">Pembayaran</h4>
		<font size="2" color="#666666">
			<p>Lakukan pembayaran <?php echo "Rp ".number_format($total,0,',','.'); ?> ke salah satu rekening dibawah ini</p>
			<br><img src="icon/bni.jpg"> 0192 1606 98 a/n P.T. Valiant technology<br>
			<img src="icon/bca.jpg"> 230 196 9009 a/n P.T. Valiant technology<br><br>
			Untuk mempermudah verifikasi, anda harus transfer <?php echo "Rp ".number_format($total,0,',','.'); ?>. 
			tidak kurang dan tidak lebih.<br><br>
			<p>Konfirmasikan pembayaran anda melalui menu konfirmasi atau melalui SMS<br>
			Jika dalam waktu 2x24jam tidak melakukan pembayaran dan konfirmasi, maka orderan ini akan dihapus
			</p>
		</font>
		 
		</div>
		<div class="isi" style="width:15%; margin-top:20px; float:left; height:240px;">
		<h4 style="margin:0px; padding:0px; background:#3399FF; color:#FFFFFF;" align="center">Menu Konfirmasi</h4>
		<br>
			<font size="2" color="#666666">Saya telah transfer ke salah satu rekening dibawah ini</font>
		<br><br>
		<form method="post" action="verifikasi.php">
		<input type="hidden" value="<?php echo $db_idt; ?>" name="idt">
		<input type="hidden" value="konfirmasi" name="pengaturan">
		<input type="radio" name="bank" value='BNI' ><img src="icon/bni.jpg"><br>
		<input type="radio" name="bank" value='BCA' ><img src="icon/bca.jpg"><br>
		<br>
		<input type="submit" value="Konfirmasi" class="konfirm" 
			onmouseover="this.style.background='#FFFFFF';this.style.color='#3399FF';" 
			onmouseout="this.style.background='#0066ff';this.style.color='#FFFFFF';"/>
		</form>
		</div>
		<div class="isi" style="width:14%; margin-top:20px; float:left; height:240px;">
		<h4 style="margin:0px; padding:0px; background:#3399FF; color:#FFFFFF;" align="center">Contoh SMS</h4>
		<div style="width:92%; border:1px solid #333333; border-radius:5px; margin-top:5px; padding:5px; font-size:12px;" > 
		<b>ke</b> 083815838586</div>
		<b style="font-size:12px;">&nbsp;&nbsp;pesan</b>
		<div style=" font-size:12px; width:92%; height:40px; border:1px solid #333333; border-radius:5px; padding:5px;"> 
			BNI <?php echo $total; ?></div> 
			<font size="2" color="#666666">
				ketik <br>[nama bank tujuan]<br>
				spasi <br>[jumlah transfer]<br>kirim ke<br>083815838586
			</font>
		<?php }?>
		</div>
	<?php }
		else if ($status=='konfirmasi'){	?>
		<div class="isi" style="margin-top:10px; font-size:14px;">
	
				<table id="rounded-corner">
				<thead>
					<tr>
						<th>	Terimakasih anda telah melakukan konfirmasi pembayaran. 
						<br>kami akan verifikasi dalam waktu maksimal 1x24 jam.
						<br>kami akan memberi info status pemesanan melalui halaman ini dan melalui SMS.</th>
					</tr>
				</thead>
				</table>
		</div>
		
	<?php } 
		else if ($status=='lunas'){	?>
		<div class="isi" style="margin-top:10px;">
			<table id="rounded-corner">
				<thead>
					<tr>
						<th colspan="2">Status Pembayaran</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
					<td colspan="2">
						Kami akan segera mengkonfirmasikan nomor resi pengiriman melalui halaman ini.
					</td>
					</tr>
				</tfoot>
				<tbody>
					<tr>
					<td width="150">Pembayaran</td>
					<td>Pesanan anda telah dibayar Lunas</td>
					</tr>
					<tr>
					<td width="150">Tanggal pembayaran</td>
					<td><?php echo $tgl_bayar; ?></td>
					</tr>
					<tr>
					<td width="150">Pengiriman</td>
					<td>Kami sedang melakukan proses packing. terima kasih atas kesabaran anda.</td>
					</tr>
				</tbody>
			</table>	
		</div>
	
	<?php } 
		else if ($status=='terkirim'){	?>
		<div class="isi" style="margin-top:10px;">
			<table id="rounded-corner">
				<thead>
					<tr>
						<th colspan="2">Status Pengiriman</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
					<td colspan="2">
					Terima kasih atas kesediaan anda berbelanja di Valiant Technology - Computer center and accesories
					</td>
					</tr>
				</tfoot>
				<tbody>
					<tr>
					<td width="150">Status pesanan</td>
					<td>Pesanan anda telah kami kirim</td>
					</tr>
					<tr>
					<td width="150">Nomor Resi</td>
					<td><?php echo $resi; ?> Tracking via <a href="http://www.jne.co.id" target="_blank">jne.co.id</a></td>
					</tr>
					<tr>
					<td width="150">Tanggal Pengiriman</td>
					<td><?php echo $tgl_kirim; ?></td>
					</tr>
					<tr>
					<td width="150">Perkiraan waktu tiba </td>
					<td>Pesanan anda diperkirakan akan tiba antara <?php echo $lama_krm; ?> hari.</td>
					</tr>
				</tbody>
			</table>
	
		</div>
	
	<?php }
	include 'footer.php'; ?>
	</body>
</html>

