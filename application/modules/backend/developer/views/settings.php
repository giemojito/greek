<!--Begin -->
<div class="row">
	<div class="col-lg-12">
		<div class="box">
			<div id="div-1" class="body">
			<?php if ($log_threshold == 0) : ?>
				<div class="alert alert-warning fade in">
					<a class="close" data-dismiss="alert">&times;</a>
					<?php echo lang('log_not_enabled'); ?>
				</div>
			<?php endif; ?>

			<?php echo form_open(site_url('/developer/logs/enable'), 'class="form-horizontal"'); ?>

			<fieldset>

				<div class="form-group">
					<label for="log_threshold" class="control-label col-lg-2"><?php echo lang('log_the_following'); ?></label>
					<div class="col-lg-4">
						<select name="log_threshold" id="log_threshold" class="form-control">
							<option value="0" <?php echo ($log_threshold == 0) ? 'selected="selected"' : ''; ?>><?php echo lang('log_what_0'); ?></option>
							<option value="1" <?php echo ($log_threshold == 1) ? 'selected="selected"' : ''; ?>><?php echo lang('log_what_1'); ?></option>
							<option value="2" <?php echo ($log_threshold == 2) ? 'selected="selected"' : ''; ?>><?php echo lang('log_what_2'); ?></option>
							<option value="3" <?php echo ($log_threshold == 3) ? 'selected="selected"' : ''; ?>><?php echo lang('log_what_3'); ?></option>
							<option value="4" <?php echo ($log_threshold == 4) ? 'selected="selected"' : ''; ?>><?php echo lang('log_what_4'); ?></option>
						</select>
					</div>
				</div>

			</fieldset>

			<div class="well well-small">
				<p class="help-block"><?php echo lang('log_what_note'); ?></p>
			</div>

			<div class="alert alert-info fade in">
				<!-- <a class="close" data-dismiss="alert">&times;</a> -->
				<?php echo lang('log_big_file_note'); ?>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('log_save_button'); ?>" />
			</div>

			<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>


