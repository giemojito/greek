<!--Begin -->
<div class="row">
  <div class="col-lg-12">
  	<div class="box">
	    <div id="collapse4" class="body table-responsive">
	      <?php echo $tables ?>
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