<div class="row">
  <div class="col-lg-12">
    <?php echo $toolbar ?>
    
    <div class="box">
    <h3><?php echo $header ?></h3>
      <div id="collapse4" class="body table-responsive">
        <?php echo $tables ?>
      </div>
    </div>
  </div>
</div>

<script language="JavaScript">
  function goErase(uri, info) {
      var sure;
      sure = confirm("Are you sure to delete '" + info + "' ?");
      if (sure) {
        location = uri;
      }
      else {
        return false;
      }
  }

  function ForceLogout(uri, info) {
    if (confirm(info)) {
      location = uri;
    }
    else {
      return false;
    }
  }

  function activateFromList () {
    var isSelected = false;
    var i = 1;
    while (i < <?php echo $numOfRow?> && !isSelected) {
      if (document.getElementById('userid'+i).checked) {
        isSelected = true;
      }
      else {
        i++;
      }
    }

    if (!isSelected) {
      alert("Choose minimum one user to activate!");
    }
    else if (confirm("Are you sure to activate selected user ?")) {
      document.theForm.action = ARRJS.BASE_URL;
      document.theForm.submit();
    }
  }

  function deactivateFromList () {
    var isSelected = false;
    var i = 1;
    while (i < <?php echo $numOfRow?> && !isSelected) {
        if (document.getElementById('userid'+i).checked) {
            isSelected = true;
        }
        else {
            i++;
        }
    }
    if (!isSelected) {
        alert("Choose minimum one user to deactivate!");
    }
    else if (confirm("Are you sure to deactivate selected user ?")) {
        document.theForm.action = ARRJS.BASE_URL;
        document.theForm.submit();
    }
  }

  function delFromList () {
    var isSelected = false;
    var i = 1;
    while (i < <?php echo $numOfRow?> && !isSelected) {
        if (document.getElementById('userid'+i).checked) {
            isSelected = true;
        }
        else {
            i++;
        }
    }
    if (!isSelected) {
        alert("Choose minimum one user to delete!");
    }
    else if (confirm("Are you sure to delete selected user ?")) {
        document.theForm.action = ARRJS.BASE_URL;
        document.theForm.submit();
    }
  }

  function checkAll () {
      var stat = document.getElementById('cuserid').checked;
      for (i = 1; i < <?php echo $numOfRow?>; i++) {
        document.getElementById('userid'+i).checked = stat;
      }
  }
</script>