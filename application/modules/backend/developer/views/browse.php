<!--Begin -->
<div class="row">
	<div class="col-lg-12">
		<div class="box">
			<div id="collapse4" class="body table-responsive">
			  	<div class="well well-small">
			  		SQL Query: <br>
			  		<?php echo $query; ?>
				</div>

				<?php if (isset($tables) && is_array($tables) && count($tables)) :?>
				<p><?php echo "Total Results: " . sizeof($tables); ?></p>
				<table class="table table-striped">
					<thead>
						<tr>
							<?php
								$heads = $tables[0];
								foreach ($heads as $field => $value) :
							?>
							<th><?php echo $field; ?></th>
							<?php 
								endforeach;
							?>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($tables as $row) : ?>
						<tr>
							<?php foreach ($row as $key => $value) : ?>
							<td><?php echo $value; ?></td>
							<?php endforeach; ?>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
		    	<?php else: ?>
				<div class="alert alert-danger">
					No data found for table.
				</div>
				<?php endif; ?>
			</div>
		</div>
  </div>
</div>
<!--End -->

