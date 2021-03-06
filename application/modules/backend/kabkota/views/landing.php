<!--Begin -->
<div class="row">
  <div class="col-lg-12">
    
    <?php echo $toolbar ?>
    
    <div class="box">
      <header>
        <div class="toolbar-search col-lg-12">
          <form class="form-horizontal" name="searchForm" id="searchForm" method="get" action="<?php echo base_url('kabkota'); ?>">
            <div class="form-group">
              <label class="control-label col-lg-2">Provinsi :</label>
              <div class="col-lg-3">
                <?php echo $formdropdown ?>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-lg-2">Nama :</label>
              <div class="col-lg-5">
                <input class="form-control" name="nama" type="text" id="nama" placeholder="Search .." value="<?php echo isset($get_nama) ? $get_nama : ''; ?>" onChange="document.searchForm.submit();">
              </div>
            </div>
          </form>
        </div>
      </header>
    </div>

    <div class="box">
      <header>
        <h5><?php echo $header ?></h5>
      </header>

      <div id="collapse4" class="body table-responsive">
        <?php echo $tables ?>
      </div>
    </div>
  </div>
</div>
<!--End -->

<script language="JavaScript">
  function checkAll () {
    var stat = document.getElementById('dati2id').checked;
    for (i = 1; i < <?php echo $numOfRow?>; i++) {
      document.getElementById('dati2id'+i).checked = stat;
    }
  }

  function delFromList () {
    var isSelected = false;
    var i = 1;
    while (i < <?php echo $numOfRow?> && !isSelected) {
      if (document.getElementById('dati2id'+i).checked) {
        isSelected = true;
      }
      else {
        i++;
      }
    }
    if (!isSelected) {
      alert("Choose minimum one user to delete!");
    }
    else if (confirm("Are you sure to delete selected kabupaten / kota ?")) {
      document.theForm.action = ARRJS.BASE_URL + "kabkota/delFromList";
      document.theForm.submit();
    }
  }
</script>