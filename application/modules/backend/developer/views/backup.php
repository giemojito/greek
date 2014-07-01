<!--Begin -->
<div class="row">
	<div class="col-lg-12">
		<div class="box">
			<div id="div-1" class="body">
			<?php echo form_open('/developer/databases/backup', 'class="form-horizontal"'); ?>
				<?php if (isset($tables) && is_array($tables) && count($tables) > 0) : ?>
					<?php foreach ($tables as $table) : ?>
						<input type="hidden" name="tables[]" value="<?php echo $table ?>" />
					<?php endforeach; ?>
				<?php endif; ?>

				<div class="alert alert-info">
					<p><?php echo lang('db_backup_warning'); ?></p>
				</div>

				<div class="form-group <?php echo form_error('file_name') ? 'error' : '' ?>">
					<label for="file_name" class="control-label col-lg-4"><?php echo lang('db_filename'); ?></label>
					<div class="col-lg-4">
						<input type="text" name="file_name" id="file_name" value="<?php echo set_value('file_name', isset($file) && ! empty($file) ? $file : ''); ?>" class="form-control"/>
						<?php if (form_error('file_name')) echo '<span class="help-inline">'. form_error('file_name') .'</span>'; ?>
					</div>
				</div>

				<div class="form-group <?php echo form_error('drop_tables') ? 'error' : '' ?>">
					<label for="drop_tables" class="control-label col-lg-4"><?php echo lang('db_drop_question') ?></label>
					<div class="col-lg-2">
						<select name="drop_tables" id="drop_tables" class="form-control">
							<option value="0">No</option>
							<option value="1">Yes</option>
						</select>
						<?php if (form_error('drop_tables')) echo '<span class="help-inline">'. form_error('drop_tables') .'</span>'; ?>
					</div>
				</div>

				<div class="form-group <?php echo form_error('add_inserts') ? 'error' : '' ?>">
					<label for="add_inserts" class="control-label col-lg-4"><?php echo lang('db_insert_question'); ?></label>
					<div class="col-lg-2">
						<select name="add_inserts" id="add_inserts" class="form-control">
							<option value="0">No</option>
							<option value="1" selected="selected">Yes</option>
						</select>
						<?php if (form_error('add_inserts')) echo '<span class="help-inline">'. form_error('add_inserts') .'</span>'; ?>
					</div>
				</div>

				<div class="form-group <?php echo form_error('file_type') ? 'error' : '' ?>">
					<label for="file_type" class="control-label col-lg-4"><?php echo lang('db_compress_question'); ?></label>
					<div class="col-lg-2">
						<select name="file_type" id="file_type" class="form-control">
							<option value="txt" <?php echo set_select('file_type', 'txt', TRUE); ?>>None</option>
							<option value="gzip" <?php echo set_select('file_type', 'gzip'); ?>><?php echo lang('db_gzip'); ?></option>
							<option value="zip" <?php echo set_select('file_type', 'zip'); ?>><?php echo lang('db_zip'); ?></option>
						</select>
						<?php if (form_error('file_type')) echo '<span class="help-inline">'. form_error('file_type') .'</span>'; ?>
					</div>
				</div>

				<div class="alert alert-warning">
					<?php echo lang('db_restore_note'); ?>
				</div>

				<div style="padding: 20px" class="small">
					<p><strong><?php echo lang('db_backup') .' '. lang('db_tables'); ?>: &nbsp;&nbsp;</strong>
						<?php foreach ($tables as $table) : ?>
							<?php echo $table; ?>&nbsp;&nbsp;&nbsp;&nbsp;
						<?php endforeach; ?>
					</p>
				</div>

				<div class="form-actions">
					<button type="submit" name="backup" class="btn btn-primary" ><?php echo lang('db_backup'); ?></button> OR
					<?php echo anchor('/developer/databases', 'Cancel'); ?>
				</div>
				
			<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<!--End -->
