<?php echo $header; ?>
<div id="content">
<div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a
            href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
</div>
<?php if ($attention) { ?>
<div class="attention"><?php echo $attention; ?></div>
<?php } ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
<div class="heading">
    <h1><img src="view/image/payment.png" alt=""/> <?php echo $heading_title; ?></h1>

    <div class="buttons">
        <a href="<?php echo $list_orders; ?>" class="button"><?php echo $button_list_orders; ?></a>
        <a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
        <a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a>
    </div>
</div>
<div class="content">
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
<table class="form">
<tr>
    <td>
        <span class="required">*</span><label for="barzahlen_status"><?php echo $entry_status; ?></label>
    </td>
    <td>
        <select id="barzahlen_status" name="barzahlen_status">
            <?php if ($barzahlen_status) { ?>
            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
            <option value="0"><?php echo $text_disabled; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_enabled; ?></option>
            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
            <?php } ?>
        </select>
    </td>
</tr>

<tr>
    <td>
        <span class="required">*</span><label
                for="barzahlen_shop_id"><?php echo $entry_shop_id; ?></label>
        <br/>
        <span class="help"><?php echo $entry_shop_id_help?></span>
    </td>
    <td>
        <input type="text" id="barzahlen_shop_id" name="barzahlen_shop_id"
               value="<?php echo $barzahlen_shop_id; ?>"/>
        <?php if ($error_shop_id) { ?>
        <span class="error"><?php echo $error_shop_id; ?></span>
        <?php } ?>
    </td>
</tr>

<tr>
    <td>
        <span class="required">*</span><label
                for="barzahlen_payment_key"><?php echo $entry_payment_key; ?></label>
        <br/>
        <span class="help"><?php echo $entry_payment_key_help?></span>
    </td>
    <td>
        <input type="text" id="barzahlen_payment_key" name="barzahlen_payment_key"
               value="<?php echo $barzahlen_payment_key; ?>"/>
        <?php if ($error_payment_key) { ?>
        <span class="error"><?php echo $error_payment_key; ?></span>
        <?php } ?>
    </td>
</tr>

<tr>
    <td>
        <span class="required">*</span><label
                for="barzahlen_notification_key"><?php echo $entry_notification_key; ?></label>
        <br/>
        <span class="help"><?php echo $entry_notification_key_help?></span>
    </td>
    <td>
        <input type="text" id="barzahlen_notification_key" name="barzahlen_notification_key"
               value="<?php echo $barzahlen_notification_key; ?>"/>
        <?php if ($error_notification_key) { ?>
        <span class="error"><?php echo $error_notification_key; ?></span>
        <?php } ?>
    </td>
</tr>

<tr>
    <td>
        <label for="barzahlen_minimum_amount"><?php echo $entry_minimum_amount; ?></label>
        <br/>
        <span class="help"><?php echo $entry_minimum_amount_help?></span>
    </td>
    <td>
        <input type="text" id="barzahlen_minimum_amount" name="barzahlen_minimum_amount"
               value="<?php echo $barzahlen_minimum_amount; ?>"/>
        <?php if ($error_minimum_amount) { ?>
        <span class="error"><?php echo $error_minimum_amount; ?></span>
        <?php } ?>
    </td>
</tr>

<tr>
    <td>
        <label for="barzahlen_maximum_amount"><?php echo $entry_maximum_amount; ?></label>
        <br/>
        <span class="help"><?php echo $entry_maximum_amount_help?></span>
    </td>
    <td>
        <input type="text" id="barzahlen_maximum_amount" name="barzahlen_maximum_amount"
               value="<?php echo $barzahlen_maximum_amount; ?>"/>
        <?php if ($error_maximum_amount) { ?>
        <span class="error"><?php echo $error_maximum_amount; ?></span>
        <?php } ?>
    </td>
</tr>

<tr>
    <td>
        <?php echo $entry_sandbox; ?>
        <br/>
        <span class="help"><?php echo $entry_sandbox_help?></span>
    </td>
    <td>
        <?php if ($barzahlen_sandbox) { ?>
        <input type="radio" id="barzahlen_sandbox_yes" name="barzahlen_sandbox" value="1"
               checked="checked"/>
        <label for="barzahlen_sandbox_yes"><?php echo $text_yes; ?></label>
        <input type="radio" id="barzahlen_sandbox_no" name="barzahlen_sandbox" value="0"/>
        <label for="barzahlen_sandbox_no"><?php echo $text_no; ?></label>
        <?php } else { ?>
        <input type="radio" id="barzahlen_sandbox_yes" name="barzahlen_sandbox" value="1"/>
        <label for="barzahlen_sandbox_yes"><?php echo $text_yes; ?></label>
        <input type="radio" id="barzahlen_sandbox_no" name="barzahlen_sandbox" value="0"
               checked="checked"/>
        <label for="barzahlen_sandbox_no"><?php echo $text_no; ?></label>
        <?php } ?>
    </td>
</tr>

<tr>
    <td>
        <?php echo $entry_debug; ?>
        <br/>
        <span class="help"><?php echo $entry_debug_help?></span>
    </td>
    <td>
        <?php if ($barzahlen_debug) { ?>
        <input type="radio" id="barzahlen_debug_yes" name="barzahlen_debug"
               value="1" checked="checked"/>
        <label for="barzahlen_debug_yes"><?php echo $text_yes; ?></label>
        <input type="radio" id="barzahlen_debug_no" name="barzahlen_debug"
               value="0"/>
        <label for="barzahlen_debug_no"><?php echo $text_no; ?></label>
        <?php } else { ?>
        <input type="radio" id="barzahlen_debug_yes" name="barzahlen_debug"
               value="1"/>
        <label for="barzahlen_debug_yes"><?php echo $text_yes; ?></label>
        <input type="radio" id="barzahlen_debug_no" name="barzahlen_debug"
               value="0" checked="checked"/>
        <label for="barzahlen_debug_no"><?php echo $text_no; ?></label>
        <?php } ?>
    </td>
</tr>

<tr>
    <td>
        <span class="required">*</span><label
                for="barzahlen_failed_status_id"><?php echo $entry_failed_status_id; ?></label>
        <br/>
        <span class="help"><?php echo $entry_failed_status_id_help?></span>
    </td>
    <td>
        <select id="barzahlen_failed_status_id" name="barzahlen_failed_status_id">
            <?php foreach ($order_statuses as $order_status) { ?>
            <?php if ($order_status['order_status_id'] == $barzahlen_failed_status_id) { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>"
                    selected="selected"><?php echo $order_status['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
            <?php } ?>
            <?php } ?>
        </select>
    </td>
</tr>

<tr>
    <td>
        <span class="required">*</span><label
                for="barzahlen_pending_status_id"><?php echo $entry_pending_status_id; ?></label>
        <br/>
        <span class="help"><?php echo $entry_pending_status_id_help?></span>
    </td>
    <td>
        <select id="barzahlen_pending_status_id" name="barzahlen_pending_status_id">
            <?php foreach ($order_statuses as $order_status) { ?>
            <?php if ($order_status['order_status_id'] == $barzahlen_pending_status_id) { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>"
                    selected="selected"><?php echo $order_status['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
            <?php } ?>
            <?php } ?>
        </select>
    </td>
</tr>

<tr>
    <td>
        <span class="required">*</span><label
                for="barzahlen_paid_status_id"><?php echo $entry_paid_status_id; ?></label>
        <br/>
        <span class="help"><?php echo $entry_paid_status_id_help?></span>
    </td>
    <td>
        <select id="barzahlen_paid_status_id" name="barzahlen_paid_status_id">
            <?php foreach ($order_statuses as $order_status) { ?>
            <?php if ($order_status['order_status_id'] == $barzahlen_paid_status_id) { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>"
                    selected="selected"><?php echo $order_status['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
            <?php } ?>
            <?php } ?>
        </select>
    </td>
</tr>

<tr>
    <td>
        <span class="required">*</span><label
                for="barzahlen_expired_status_id"><?php echo $entry_expired_status_id; ?></label>
        <br/>
        <span class="help"><?php echo $entry_expired_status_id_help?></span>
    </td>
    <td>
        <select id="barzahlen_expired_status_id" name="barzahlen_expired_status_id">
            <?php foreach ($order_statuses as $order_status) { ?>
            <?php if ($order_status['order_status_id'] == $barzahlen_expired_status_id) { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>"
                    selected="selected"><?php echo $order_status['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
            <?php } ?>
            <?php } ?>
        </select>
    </td>
</tr>

<tr>
    <td>
        <label for="barzahlen_sort_order"><?php echo $entry_sort_order; ?></label>
    </td>
    <td>
        <input type="text" id="barzahlen_sort_order" name="barzahlen_sort_order"
               value="<?php echo $barzahlen_sort_order; ?>" size="1"/>
    </td>
</tr>
</table>
</form>
</div>
</div>
</div>
<?php echo $footer; ?> 