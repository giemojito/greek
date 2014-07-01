<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
	<title><?php echo $title ?></title>
	<meta name="description" content="<?php echo $description ?>" />
	<meta name="keywords" content="<?php echo $keywords ?>" />
	<meta name="author" content="<?php echo $author ?>" />

	<!-- LIB CSS -->
<?php foreach($libcss as $lc):?>
	<link rel="stylesheet" href="<?php echo base_url().LIBCSS.$lc.CSS_EXT?>">
<?php endforeach;?>

	<!-- extra fonts-->
<?php foreach($fonts as $f):?>
	<link href="http://fonts.googleapis.com/css?family=<?php echo $f?>" rel="stylesheet" type="text/css">
<?php endforeach;?>

	<!-- CSS -->
<?php foreach($css as $c):?>
	<link rel="stylesheet" href="<?php echo base_url().CSS.$c.CSS_EXT?>">
<?php endforeach;?>
	 
</head>

<?php flush(); ?>

<body>
	<!-- put before content because core -->
	<script src="<?php echo base_url(JS."jquery-2.1.0.min.js");?>"></script>

	<?php echo $body ?>
	
	<!-- lib -->
<?php foreach($libs as $lib):?>
	<script defer src="<?php echo base_url().LIB.$lib.JS_EXT?>"></script>
<?php endforeach;?>

	<!-- js -->
<?php foreach($javascript as $js):?>
	<script defer src="<?php echo base_url().JS.$js.JS_EXT?>"></script>
<?php endforeach;?>


</body>
</html>
