<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div id="payment"></div>
<div class="buttons">
    <div class="left">
        <?php echo $payment_description; ?>
    </div>
    <div class="right">
        <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="button"/>
    </div>
</div>
<script type="text/javascript">
    var confirmUrl = '<?php echo $confirm; ?>';

    $('#button-confirm').bind('click', function () {
        $.ajax({
            url: confirmUrl,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#button-confirm').attr('disabled', true);
                $('.warning, .error').remove();
                $('#payment').before('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" />');
            },
            complete: function () {
                $('#button-confirm').attr('disabled', false);
                $('.attention').remove();
            },
            success: function (response) {
                if (response['error']) {
                    $('#payment').before('<div class="warning">' + response['error'] + '</div>');
                }

                if (response['redirect']) {
                    location = response['redirect'];
                }
            }
        });
    });
</script>