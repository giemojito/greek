<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Error</title>
    <meta name="msapplication-TileColor" content="#5bc0de" />
    <meta name="msapplication-TileImage" content="assets/img/metis-tile.png" />
    <link rel="stylesheet" href="assets/lib/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/lib/magic/magic.css">
    <link rel="stylesheet" href="assets/lib/Font-Awesome/css/font-awesome.css" />
  </head>
  <body class="error">
    <div class="container">
      <div class="col-lg-8 col-lg-offset-2 text-center">
        <div class="logo">
          <h1>A PHP Error was encountered</h1>
        </div>
        <p class="lead text-muted">
        	Severity: <?php echo $severity; ?>
        	<br/>
			Message:  <?php echo $message; ?>
        	<br/>
			Filename: <?php echo $filepath; ?>
        	<br/>
			Line Number: <?php echo $line; ?>
        </p>
        <div class="clearfix"></div>
        <br>
      </div><!-- /.col-lg-8 col-offset-2 -->
    </div>
  </body>
</html>
