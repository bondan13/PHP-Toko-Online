<link rel="stylesheet" type="text/css" href="../tampilan/style.css">
<link rel="stylesheet" type="text/css" href="../jquery/jqcss.css">
<script src="../jquery/jquery-1.10.1.min.js"></script>
<script src="../jquery/jquery-ui-1.10.3.custom.js"></script>

<script>
	$(function() {
		var name = $( "#name" ),
		password = $( "#password" ),
		allFields = $( [] ).add( name ).add( password ),
		tips = $( ".validateTips" );
		
		function updateTips( t ) {
			tips
			.text( t )
			.addClass( "ui-state-highlight" );
			setTimeout(function() {
				tips.removeClass( "ui-state-highlight", 1500 );
				}, 500 );
		}
		
		function checkLength( o, n, min, max ) {
			if ( o.val().length > max || o.val().length < min ) {
				o.addClass( "ui-state-error" );
				updateTips( "Gagal login!" );
				return false;
			} else {
				return true;
			}
		}
		
		function checkRegexp( o, regexp, n ) {
			if ( !( regexp.test( o.val() ) ) ) {
				o.addClass( "ui-state-error" );
				updateTips( n );
				return false;
			} else {
				return true;
			}
		}
		
		$( "#dialog-form" ).dialog({
			autoOpen: false,
			height: 280,
			width: 350,
			modal: true,
			buttons: {
				"Login": function() {
				var bValid = true;
				allFields.removeClass( "ui-state-error" );
				bValid = bValid && checkLength( name, "username", 10, 12 );
				bValid = bValid && checkLength( password, "password", 4, 32);
				bValid = bValid && checkRegexp( name, /^[0]([0-9])+$/i, "No handphone salah." );
					if ( bValid ) {
					document.getElementById("formlogin").submit();
					}
				},
			},
		
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});
		
		$( ".create-user" )
		.button()
		
		.click(function() {
			$( "#dialog-form" ).dialog( "open" );
		});
		
		$( ".createuser" )
		.button()
		
		.click(function() {
			$( "#dialog-form" ).dialog( "close" );
		});
		
		$( ".logintext" )
		.click(function() {
			$( "#dialog-form" ).dialog( "open" );
		});
	
	});
	
	$(function() {
	$( "#menu1" ).menu();
	});
	
	$(function() {
	$( "#menu2" ).menu();
	});
	
	$(function() {
	$( ".paging" ).buttonset();
	});
	
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

</script>
<style>
	.login {
		font-size:14px; 
		background:#0000CC;}
	input.text { 
		width:100%; 
		padding: .4em;}
	.ui-dialog-titlebar {
		background:#3399FF; 
		color:#FFFFFF;}
	.ui-menu {
		background:#0099FF; 
		border:0px;}
	.ui-button {
		background-image:url(icon/header-bg.jpg);}
</style>
