<div style="width: 100%; font-size: 15px; font-weight: bold; text-align: center; padding-bottom: 10px;">
  User Edit
</div>
<?php echo form_open('settings/user_edit'); ?>
<table cellpadding="2" cellspacing="2">
  <tr>
    <td width="120"><strong>Full Name</strong></td>
    <td><input type="text" name="full_name" value="<?php echo $user['full_name']; ?>" style="width: 250px;" /></td>
  </tr>
  <tr>
    <td><strong>Email Address</strong></td>
    <td><input type="text" name="email" value="<?php echo $user['email']; ?>" style="width: 250px;" /></td>
  </tr>
  <tr>
    <td width="120"><strong>Password</strong></td>
    <td><input type="text" name="password" autocomplete="off" style="width: 250px;" /></td>
  </tr>
  <tr>
    <td><strong>Re-enter Password</strong></td>
    <td><input type="password" name="repassword" autocomplete="off" style="width: 250px;" /></td>
  </tr>
  <?php $width = 'style="width: 254px;"'; ?>
  <tr>
    <td><strong>Status</strong></td>
    <td>
      <?php
      $options = array('active' => 'active', 'inactive' => 'inactive');
      echo form_dropdown('status', $options, $user['status'], $width);
      ?>
    </td>
  </tr>
  <input type="hidden" name="id" value="<?php echo $user['id']; ?>" />
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center">
      <input type="submit" name="submit" value="Submit" />&nbsp;<input type="button" value="Cancel" onclick="tb_remove()" />
    </td>
  </tr>
</table>
<?php echo form_close(); ?>