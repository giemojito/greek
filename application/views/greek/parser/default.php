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
	<title>{title}</title>
	<meta name="description" content="{description}" />
	<meta name="keywords" content="{keywords}" />
	<meta name="author" content="{author}" />

	<!-- LIB CSS -->
{libcss}
	<link rel="stylesheet" href="<?php echo base_url().LIBCSS."{libcss}".CSS_EXT ?>">
{/libcss}

	<!-- extra fonts-->
{fonts}
	<link href="http://fonts.googleapis.com/css?family="{fonts} rel="stylesheet" type="text/css">
{/fonts}

	<!-- CSS -->
{css}
	<link rel="stylesheet" href="<?php echo base_url().CSS."{css}".CSS_EXT ?>">
{/css}
	 
</head>

<?php flush(); ?>

<body>
	<!-- put before content because core -->
	<script src="<?php echo base_url(JS."jquery-2.1.0.min.js");?>"></script>

	{body}
	
	<!-- lib -->
{libs}
	<script defer src="<?php echo base_url().LIB."{libs}".JS_EXT?>"></script>
{/libs}

	<!-- js -->
{javascript}
	<script defer src="<?php echo base_url().JS."{javascript}".JS_EXT ?> "></script>
{/javascript}


</body>
</html>
