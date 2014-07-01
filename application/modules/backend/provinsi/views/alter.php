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
      	<form class="form-horizontal" name="theForm" method="post" action="<?php echo base_url() ?>provinsi/cgi">
          <input name="action" type="hidden" value="<?php echo $action ?>">
	    		<input name="dati1id" type="hidden" value="<?php echo isset($obj) ? $obj->dati1id : ''; ?>">
			  	<div class="form-group">
			    	<label for="text1" class="control-label col-lg-2">Kode</label>
		    		<div class="col-lg-4">
		      		<input type="text" class="form-control" name="fullcode" id="fullcode" value="<?php echo isset($obj) ? $obj->fullcode : ''; ?>">
		    		</div>
			  	</div>

			  	<div class="form-group">
			    	<label for="text1" class="control-label col-lg-2">Nama</label>
		    		<div class="col-lg-6">
		      		<input type="text" class="form-control" name="nama" id="nama" value="<?php echo isset($obj) ? $obj->nama : ''; ?>">
		    		</div>
			  	</div>

          <div class="form-group">
            <label for="text1" class="control-label col-lg-2">Singkatan</label>
            <div class="col-lg-6">
              <input type="text" class="form-control" name="singkatan" id="singkatan" value="<?php echo isset($obj) ? $obj->singkatan : ''; ?>">
            </div>
          </div>

          <div class="form-group">
            <label for="text1" class="control-label col-lg-2">Luar Negeri?</label>
            <div class="col-lg-6">
              <div class="col-lg-3">
                <div class="checkbox">
                  <label>
                    <input class="uniform" type="radio" name="isln" value="1" <?php echo isset($obj) ? ($obj->isln == '1' ? 'checked' : '') : ''; ?>> Ya
                  </label>
                </div>
              </div>
              <div class="col-lg-3">
                <div class="checkbox">
                  <label>
                    <input class="uniform" type="radio" name="isln" value="0" <?php echo isset($obj) ? (($obj->isln == '0') ? 'checked' : '') : ''; ?>> Tidak
                  </label>
                </div>
              </div>
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
        if (document.getElementById("fullcode").value == "") {
            alert("Kode Dati1 empty!");
        }
        else if (document.getElementById("nama").value == "") {
            alert("Nama Dati1 empty!");
        }
        else {
            document.theForm.submit();
        }
    }
</script>