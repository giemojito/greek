  <div class="col-lg-12">
    <h3> System Information </h3>
    <table class="table table-striped">
      <tbody>
        <tr>
          <td>Greek Version</td>
          <td><?php echo GREEK_VERSION ?></td>
        </tr>
        <tr>
          <td>CodeIgniter Version</td>
          <td>
            <?php echo CI_VERSION; ?>
          </td>
        </tr>
        <tr>
          <td>PHP Version</td>
          <td><?php echo phpversion(); ?></td>
        </tr>
        <tr>
          <td>Server Time</td>
          <td><?php echo date('g:i a'); ?></td>
        </tr>
        <tr>
          <td>Database Name</td>
          <td><?php echo $this->db->database; ?></td>
        </tr>
        <tr>
          <td>Database Server</td>
          <td><?php echo $this->db->platform(); ?></td>
        </tr>
        <tr>
          <td>Database Version</td>
          <td><?php echo $this->db->version(); ?></td>
        </tr>
        <tr>
          <td>Database Charset</td>
          <td><?php echo $this->db->char_set; ?></td>
        </tr>
        <tr>
          <td>Database Collation Charset</td>
          <td><?php echo $this->db->dbcollat; ?></td>
        </tr>
        <tr>
          <td>BASE PATH</td>
          <td><?php echo BASEPATH; ?></td>
        </tr>
        <tr>
          <td>APP PATH</td>
          <td><?php echo APPPATH ?></td>
        </tr>
        <tr>
          <td>SITE_URL</td>
          <td><?php echo site_url(); ?></td>
        </tr>
        <tr>
          <td>ENVIRONMENT</td>
          <td><?php echo ENVIRONMENT; ?></td>
        </tr>
      </tbody>
    </table>
  </div>
