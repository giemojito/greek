<!--Begin -->
<div class="row">
  <div class="col-lg-12">
    
    <?php echo $toolbar ?>

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
    var stat = document.getElementById('usergroupid').checked;
    for (i = 1; i < <?php echo $numOfRow?>; i++) {
      document.getElementById('usergroupid'+i).checked = stat;
    }
  }

  function delFromList () {
    var isSelected = false;
    var i = 1;
    while (i < <?php echo $numOfRow?> && !isSelected) {
      if (document.getElementById('usergroupid'+i).checked) {
        isSelected = true;
      }
      else {
        i++;
      }
    }
    if (!isSelected) {
      alert("Choose minimum one user to delete!");
    }
    else if (confirm("Are you sure to delete selected group ?")) {
      document.theForm.action = ARRJS.BASE_URL + "group/delFromList";
      document.theForm.submit();
    }
  }
</script>