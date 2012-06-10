<div id="site">
  <div id="content_2_column">
    <?php $this->load->view('admin/reports/sub_menu'); ?>
    <div id="channel_full">
      <div id="manager_header">
        <h1 id="lblPageName">Reports</h1>
      </div>

      <?php $this->load->view('admin/reports/left'); ?>

      <div id="ManagerWorkArea">
        <div id="mgrFullChannel">
          <div>
            <table cellspacing="0" border="0" style="border-collapse: collapse;" id="GridSuplList" causesvalidation="False" allowediting="True" class="GridView">
              <tbody>
                <tr align="left" style="font-family: Arial; text-decoration: none;">
                  <th align="center" scope="col" width="50">SL #</th>
                  <th align="left" scope="col" width="140">Customer Name</th>
                  <th align="left" scope="col" width="80">Order No</th>
                  <th align="left" scope="col" width="100">Item Quantity</th>
                  <th align="left" scope="col" width="100">Total Price</th>
                  <th align="center" scope="col">Sales Date</th>
                </tr>
                <?php
                $i = 1;
                $j = 1;
                $qty = 0;
                $amount = 0;
                foreach ($sales as $key => $value) {
                  ?>
                  <tr <?php if ($i == 1) { ?>class="RowStyle"<?php } else { ?>class="AlternatingRowStyle"<?php } ?>>
                    <td align="center"><?php echo $j; ?></td>
                    <td align="left"><?php echo $value['customer_name']; ?></td>
                    <td align="center"><?php echo $value['id']; ?></td>
                    <td align="right"><?php echo $value['item_qty']; ?></td>
                    <td align="right"><?php echo number_format($value['amount'], 2); ?></td>
                    <td align="center"><?php echo $value['sales_date']; ?></td>
                  </tr>
                  <?php
                  $qty = $qty + $value['item_qty'];
                  $amount = $amount + $value['amount'];
                  $j++;
                  if ($i == 1) {
                    $i = 0;
                  } else {
                    $i = 1;
                  }
                }
                ?>
                <tr <?php if ($i == 1) { ?>class="RowStyle"<?php } else { ?>class="AlternatingRowStyle"<?php } ?>>
                  <td align="center" colspan="3"><b>Grand Total</b></td>
                  <td align="right"><?php echo $qty; ?></td>
                  <td align="right"><?php echo number_format($amount, 2); ?></td>
                  <td align="center">&nbsp;</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>