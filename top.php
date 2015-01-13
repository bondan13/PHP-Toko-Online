<div class="top">
	<div id="logo"><a href="index.php"><img src="icon/logo.png" align="middle" width="100%"></a></div>
	<div style="width:80.7%; float:left;">
		<div class="topkiri">
			<form method="get" action="index.php">
			<input type="text" name="cari" class="search" 
			value="Cari" onfocus="if(this.value==this.defaultValue)this.value='';" 
			onblur="if(this.value=='')this.value=this.defaultValue;" />
			<input type="submit" value="  " class="searchicon">
			 </form>
		</div>
		
		<div class="topkanan">
			<?php 
			if ($login=='true'){  ?>
				<a class='createuser' href='profile.php' ><?php echo $_SESSION['d_nama'];?></a>
				 <a class='createuser' href="logout.php">logout</a>
				<?php }
			else { ?>
				<button class='create-user' style="background:#FFFFFF; color:#000000;">Login</button >
				<a class='createuser' href="daftar.php" style="color:#000000;">Registrasi</a></div>
				<div id="dialog-form" title="login" class="login">
				<p class="validateTips"></p>
				<form action="vlogin.php" method="post" id="formlogin">
				<label for="name">Nomor Handphone</label><br />
				<input type="text" name="notelp" id="name" class="text ui-widget-content ui-corner-all" maxlength="12"><br />
				<label for="password">Password</label><br />
				<input type="password" name="password" id="password" value="" class="text ui-widget-content ui-corner-all">
				</form>
				</div>
			<?php }?>
		</div>
	<?php if ($login=='true'){  ?>
		<a href="user-transaksi.php"><img src="icon/basket.png"  style="float:right; margin-top:3px; margin-right:5px;"></a> 
	<?php }?>
	</div>
</div>
