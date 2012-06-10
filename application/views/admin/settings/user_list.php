<div id="site">
  <div id="content_2_column">
    <?php $this->load->view('admin/settings/sub_menu'); ?>
    <div id="channel_full">
      <div id="manager_header">
        <h1 id="lblPageName">User List</h1>
      </div>

      <?php $this->load->view('admin/settings/left'); ?>

      <div id="ManagerWorkArea">
        <div style="overflow: hidden;" id="mgrFullChannel">
          <div>
            <table cellspacing="0" border="0" style="border-collapse: collapse;" id="gvItemList" class="GridView">
              <tbody>
                <tr>
                  <td colspan="5"><a href="settings/user_add?height=250&width=400&modal=true" class="thickbox" title="User Entry"><img src="images/btn_add.gif" border="0" /></a></td>
                </tr>
                <tr align="left" style="font-family: Arial; text-decoration: none;">
                  <th align="center" width="20" scope="col">&nbsp;</th>
                  <th align="left" scope="col">Full Name</th>
                  <th align="left" scope="col">Email Address</th>
                  <th align="left" scope="col">Status</th>
                </tr>
                <?php
                $i = 1;
                foreach ($users as $key => $value) {
                  ?>
                  <tr <?php if ($i == 1) { ?>class="RowStyle"<?php } else { ?>class="AlternatingRowStyle"<?php } ?>>
                    <td align="center" style="height: 22px;">
                      <a href="settings/user_privileges/<?php echo $value['id']; ?>" title="User Privileges"><img src="images/icon_settings.gif" border="0" /></a>
                      <a href="settings/user_edit/<?php echo $value['id']; ?>?height=250&width=400&modal=true" class="thickbox" title="User Edit"><img src="images/icon_edit.gif" border="0" /></a>
                      <a href="settings/user_delete/<?php echo $value['id']; ?>" title="User Delete"><img src="images/icon_delete.gif" border="0" /></a>
                    </td>
                    <td align="left"><?php echo $value['full_name']; ?></td>
                    <td align="left"><?php echo $value['email']; ?></td>
                    <td align="left"><?php echo $value['status']; ?></td>
                  </tr>
                  <?php
                  if ($i == 1) {
                    $i = 0;
                  } else {
                    $i = 1;
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>