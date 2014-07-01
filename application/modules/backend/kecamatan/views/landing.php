<!--Begin -->
<div class="row">
  <div class="col-lg-12">
    
    <?php echo $toolbar ?>
    
    <div class="box">
      <header>
        <form class="form-horizontal" name="searchForm" id="searchForm" method="get" action="<?php echo base_url('kecamatan'); ?>">
        <div class="toolbar-search col-lg-6">
            <div class="form-group">
              <label class="control-label col-lg-3">Provinsi :</label>
              <div class="col-lg-6">
                <?php echo $formdropdownd1 ?>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-lg-3">Kabupaten / Kota :</label>
              <div class="col-lg-6">
                <select id="d2" class="form-control" onchange="document.searchForm.submit();" name="d2">
                  <?php echo isset($formdropdownd2) ? $formdropdownd2 : ''; ?>
                </select>
              </div>
            </div>
        </div>
        <div class="toolbar-search col-lg-6">
            <div class="form-group">
              <label class="control-label col-lg-3">Nama :</label>
              <div class="col-lg-6">
                <input class="form-control" name="nama" type="text" id="nama" placeholder="Search .." value="<?php echo isset($get_nama) ? $get_nama : ''; ?>" onChange="document.searchForm.submit();">
              </div>
            </div>
        </div>
        </form>
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