<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a
                href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <?php if ($error) { ?>
    <div class="warning"><?php echo $error; ?></div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
    <?php } ?>
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/order.png" alt="" /> <?php echo $heading_list_orders; ?></h1>
        </div>
        <div class="content">
            <table class="list">
                <thead>
                    <tr>
                        <td class="right"><?php echo $column_order_id; ?></td>
                        <td class="right"><?php echo $column_transaction_id; ?></td>
                        <td class="left"><?php echo $column_customer; ?></td>
                        <td class="left"><?php echo $column_status; ?></td>
                        <td class="right"><?php echo $column_total; ?></td>
                        <td class="left"><?php echo $column_date_added; ?></td>
                        <td class="left"><?php echo $column_date_modified; ?></td>
                        <td class="right"><?php echo $column_action; ?></td>
                    </tr>
                </thead>
                <tbody>
                <?php if ($orders) { ?>
                <?php foreach ($orders as $order) { ?>
                <tr>
                    <td class="right"><?php echo $order['order_id']; ?></td>
                    <td class="right"><?php echo $order['barzahlen_transaction_id']; ?></td>
                    <td class="left"><?php echo $order['customer']; ?></td>
                    <td class="left"><?php echo $order['status']; ?></td>
                    <td class="right"><?php echo $order['total']; ?></td>
                    <td class="left"><?php echo $order['date_added']; ?></td>
                    <td class="left"><?php echo $order['date_modified']; ?></td>
                    <td class="right">
                        <?php if(isset($order['action_list_refunds'])) { ?> [ <a href="<?php echo $order['action_list_refunds'] ?>"><?php echo $action_refunds ?></a> ] <?php } ?>
                        <?php if(isset($order['action_cancel'])) { ?> [ <a href="<?php echo $order['action_cancel'] ?>"><?php echo $action_cancel ?></a> ] <?php } ?>
                        <?php if(isset($order['action_resend_payment_slip'])) { ?> [ <a href="<?php echo $order['action_resend_payment_slip'] ?>"><?php echo $action_resend_payment_slip ?></a> ] <?php } ?>
                    </td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                    <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>