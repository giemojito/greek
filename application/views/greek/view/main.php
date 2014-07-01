<?php echo $basejs?>

<div id="wrap">
	<?php echo $header ?>

	<div id="content">
		<div class="outer">
			<?php // echo isset($message) ? $message : '' ?>
			<?php if ($this->session->flashdata('alert')) echo $this->session->flashdata('alert') ?>
  			<div class="inner">
				<?php echo $content_body ?>
			</div>
			<!-- end .inner -->
		</div>
		<!-- end .outer -->
	</div>
	<!-- end #content -->

</div>

<!-- put footer conditional by css -->
<?php echo $footer ?>

<!-- put modal end of page -->
<?php echo $modal ?>
