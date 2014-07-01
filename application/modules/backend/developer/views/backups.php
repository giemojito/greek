<!--Begin -->
<div class="row">
	<div class="col-lg-12">
		<div class="box">
			<div id="collapse4" class="body table-responsive">
				<?php if (isset($backups) && is_array($backups) && sizeof($backups) > 0) : ?>
				<?php echo form_open($this->uri->uri_string()); ?>
					<table class="table table-striped">
						<thead>
							<tr>
								<th id="cb" class="column-check"><input class="check-all" type="checkbox" /></th>
								<th>File Name</th>
								<th id='db_size_column'>Size</th>
							</tr>
						</thead>
						
						<tbody>
							<?php foreach ($backups as $file => $atts) : ?>
							<tr class="hover-toggle">
								<td class="column-check"><input type="checkbox" value="<?php echo $file; ?>" name="checked[]" /></td>
								<td>
									<?php echo $file ?>
									<div class="hover-item small">
										<a href="<?php echo site_url('/developer/databases/get_backup/' .  $file); ?>" title="Download this file">Download</a> |
										<a href="<?php echo site_url('/developer/databases/restore/' . $file); ?>" title="Restore this file">Restore</a>
									</div>
								</td>
								<td><?php echo round($atts['size'] / 1024 , 3); ?> KB</td>
							</tr>
							<?php endforeach; ?>
						</tbody>

						<tfoot>
							<tr>
								<td colspan="3">
									Delete selected backup files:
									<button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Really delete the following backup files?')">Delete</button>
								</td>
							</tr>
						</tfoot>
					</table>
				<?php echo form_close(); ?>
				<?php else : ?>
				<div class="notification attention">
					No data found for table.
				</div>
				<?php endif; ?>
			</div>
		</div>
  </div>
</div>
<!--End -->

<script type="text/javascript">

/**
* Check All Feature
**/
$(".check-all").click(function() {
  $("table input[type=checkbox]").prop('checked', $(this).is(':checked'));
});

</script>