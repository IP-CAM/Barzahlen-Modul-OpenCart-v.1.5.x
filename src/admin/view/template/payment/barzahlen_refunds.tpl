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
            <h1><img src="view/image/order.png" alt="" /> <?php echo $heading_list_refunds; ?></h1>
        </div>
        <div class="content">
            <table class="form">
                <tr>
                    <td>
                        <?php echo $column_order_id; ?>
                    </td>
                    <td>
                        <?php echo $order_id; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo $column_transaction_id; ?>
                    </td>
                    <td>
                        <?php echo $transaction_id; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo $column_order_total_amount; ?>
                    </td>
                    <td>
                        <?php echo $order_total_amount; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo $column_total_refund_amount; ?>
                    </td>
                    <td>
                        <?php echo $total_refund_amount; ?>
                    </td>
                </tr>
            </table>
            <table class="list">
                <thead>
                <tr>
                    <td class="right"><?php echo $column_refund_transaction_id; ?></td>
                    <td class="right"><?php echo $column_amount; ?></td>
                    <td class="left"><?php echo $column_date_added; ?></td>
                    <td class="left"><?php echo $column_date_modified; ?></td>
                </tr>
                </thead>
                <tbody>
                <?php if ($refunds) { ?>
                <?php foreach ($refunds as $refund) { ?>
                <tr>
                    <td class="right"><?php echo $refund['barzahlen_refund_transaction_id']; ?></td>
                    <td class="right"><?php echo $refund['amount']; ?></td>
                    <td class="left"><?php echo $refund['date_added']; ?></td>
                    <td class="left"><?php echo $refund['date_modified']; ?></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                    <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
            <h2>Create new refund</h2>
            <?php if ($maxRefundAmountReached) { ?>
            <p><?php echo $text_no_more_refunds_possible; ?></p>
            <?php } else { ?>
            <form action="<?php echo $action_create_refund; ?>" method="post" enctype="multipart/form-data" id="form">
                <div id="tab-customer" class="vtabs-content">
                    <table class="form">
                        <tr>
                            <td class="left">Amount (max. <?php echo $maxRefundAmount; ?>)</td>
                            <td class="left"><input name="amount" type="text" ></td>
                        </tr>
                        <tr>
                            <td class="left"></td>
                            <td class="left"><button>Create</button></td>
                        </tr>
                    </table>
                </div>
            </form>
            <?php } ?>
        </div>
    </div>
</div>