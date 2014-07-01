<div class="col-lg-12">
	<h3><?php echo 'Delete'; ?> <?php echo lang('db_database'); ?> <?php echo lang('db_tables'); ?></h3>

	<?php echo form_open('/developer/databases/drop'); ?>

		<?php if (isset($tables) && is_array($tables) && count($tables) > 0) : ?>
			<?php foreach ($tables as $table) : ?>
				<input type="hidden" name="tables[]" value="<?php echo $table; ?>" />
			<?php endforeach; ?>


			<h3><?php echo lang('db_drop_confirm'); ?></h3>

			<div class="alert alert-info">
				<ul>
				<?php foreach($tables as $file) : ?>
					<li><?php echo $file; ?></li>
				<?php endforeach; ?>
				</ul>
			</div>

			<div class="alert alert-warning">
				<?php echo lang('db_drop_attention'); ?>
			</div>

			<div class="actions">
				<button type="submit" name="drop" class="btn btn-danger"><?php echo 'Delete'; ?> <?php echo lang('db_tables'); ?></button> OR
				<?php echo anchor('/developer/databases', 'Cancel'); ?>
			</div>

		<?php endif; ?>

	<?php echo form_close(); ?>

	<br/>
</div>
