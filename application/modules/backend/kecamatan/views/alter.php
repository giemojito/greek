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
      	<form class="form-horizontal" name="theForm" method="post" action="<?php echo base_url() ?>kabkota/cgi">
          <input name="action" type="hidden" value="<?php echo $action ?>">
	    		<input name="dati2id" type="hidden" value="<?php echo isset($obj) ? $obj->dati2id : ''; ?>">
          <div class="form-group">
            <label class="control-label col-lg-2">Provinsi</label>
            <div class="col-lg-4">
              <?php echo $formdropdown ?>
            </div>
          </div>
			  	<div class="form-group">
			    	<label for="text1" class="control-label col-lg-2">Nama</label>
		    		<div class="col-lg-6">
		      		<input type="text" class="form-control" name="nama" id="nama" value="<?php echo isset($obj) ? $obj->nama : ''; ?>">
		    		</div>
			  	</div>
          <div class="row form-group">
            <label for="text1" class="control-label col-lg-2">Kode</label>
            <div class="col-lg-2">
              <input class="form-control" type="text" size="5" maxlength="2" readonly="true" id="d1" name="d1" value="<?php echo isset($d1) ? $d1 : ''; ?>">
            </div>
            <div class="col-xs-1">-</div>
            <div class="col-lg-2">
              <input class="form-control" type="text" size="5" maxlength="2" id="d2" name="d2" value="<?php echo isset($d2) ? $d2 : ''; ?>">
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
        if (document.getElementById("nama").value == "") {
          alert("Nama Kabkota harus diisi");
        }
        else if (document.getElementById("d2").value == "") {
          alert("Kode Kabkota harus diisi");
        }
        else {
          document.theForm.submit();
        }
    }

    function d1change(){
      d1 = document.getElementById('dati1id').value;
      document.getElementById('d1').value = d1;
    };

</script>