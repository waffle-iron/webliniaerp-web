<html>
	<head>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="css/font-awesome.min.css" rel="stylesheet">
		<link href="css/pace.css" rel="stylesheet">
		<link href="css/endless.min.css" rel="stylesheet">
		<link href="css/endless-skin.css" rel="stylesheet">

		<style type="text/css" media="print">
			@page { size: landscape; padding: 10px; }
		</style><style type="text/css">

		body{  padding-top: 20px;padding-bottom: 20px; }</style>
	</head>
	<body>
		<?php echo $_POST['content_print'] ?>
	</body>
	<script type="text/javascript">
		setTimeout(function(){window.print()}, 3000);	
	</script>
</html>
