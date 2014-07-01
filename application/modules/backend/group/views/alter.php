<!-- BEGIN -->
<div class="row">
  <div class="col-lg-12">
  	<?php echo $toolbar ?>
    <div class="box">
      <header>
        <h5>Form Data</h5>
        <!-- .toolbar -->
        <div class="toolbar">
          <nav style="padding: 8px;">
            <a href="javascript:;" class="btn btn-default btn-xs collapse-box">
              <i class="fa fa-minus"></i>
            </a> 
            <a href="javascript:;" class="btn btn-default btn-xs full-box">
              <i class="fa fa-expand"></i>
            </a> 
          </nav>
        </div>
      </header>

  		<div id="div-1" class="body">
      	<form class="form-horizontal" name="theForm" method="post" action="<?php echo base_url() ?>group/cgi">
          <input name="action" type="hidden" value="<?php echo $action ?>">
	    		<input name="usergroupid" type="hidden" value="<?php echo isset($obj) ? $obj->usergroupid : ''; ?>">
			  	<div class="form-group">
			    	<label for="text1" class="control-label col-lg-4">Group Name</label>
		    		<div class="col-lg-8">
		      		<input type="text" placeholder="Group Name" class="form-control" name="groupname" id="groupname" value="<?php echo isset($obj) ? $obj->name : ''; ?>">
		    		</div>
			  	</div>

			  	<div class="form-group">
			    	<label for="text1" class="control-label col-lg-4">Group Description</label>
		    		<div class="col-lg-8">
		      		<input type="text" placeholder="Group Description" class="form-control" name="groupdesc" id="groupdesc" value="<?php echo isset($obj) ? $obj->description : ''; ?>">
		    		</div>
			  	</div>

			  	<div class="form-group">
			    	<label class="control-label col-lg-4">Group Level</label>
			    	<div class="col-lg-8">
		      		<input type="text" value="<?php echo isset($obj) ? $obj->grouplevel : $level; ?>" readonly class="form-control" name="grouplevel">
			    	</div>
			  	</div>
        </form>
    	</div>

    </div>
  </div>
</div>
<!-- END -->

<script language="JavaScript">
    function submitForm() {
        if (document.getElementById("groupname").value == "") {
            alert("Group Name empty!");
        }
        else if (document.getElementById("groupdesc").value == "") {
            alert("Group Description empty!");
        }
        else {
            document.theForm.submit();
        }
    }
</script>