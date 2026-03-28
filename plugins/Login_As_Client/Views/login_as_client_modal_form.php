<?php echo form_open(get_uri("login_as_client/login_as_client"), array("id" => "login-as-client-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <br />
        <div class="form-group mb15">
            <div class="row">
                <div class=" col-md-9 mb15">
                    <?php
                    echo form_dropdown("contact_id", $contacts_dropdown, array(), "class='select2 validate-hidden' id='contact_id' data-rule-required='true', data-msg-required='" . app_lang('field_required') . "'");
                    ?>
                </div>
                <div class=" col-md-3">
                    <button type="submit" class="btn btn-primary w100p"><span data-feather="log-out" class="icon-16"></span> <?php echo app_lang('login_as_client_login'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    "use strict";

    $(document).ready(function () {

        $('#login-as-client-form .select2').select2();
        $("#login-as-client-form").appForm({
            onSuccess: function (result) {
                if (result.success) {
                    window.location.href = result.redirect_to;
                } else {
                    appAlert.error(result.message);
                }
            }
        });

    });
</script>