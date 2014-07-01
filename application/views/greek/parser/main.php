<?php echo $basejs?>

<div id="wrap">
	{header}

	<div id="content">
		<div class="outer">
				<?php echo isset($message) ? $message : '' ?>
  			<div class="inner">
				{content_body}
			</div>
			<!-- end .inner -->
		<div>
		<!-- end .outer -->
	</div>
	<!-- end #content -->

</div>

<!-- put footer conditional by css -->
{footer}

<!-- put modal end of page -->
{modal}
