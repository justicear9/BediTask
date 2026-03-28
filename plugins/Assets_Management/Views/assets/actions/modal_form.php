<?php echo form_open(get_uri("assets_management/save_action"), array("id" => "asset-action-form", "class" => "general-form", "role" => "form")); ?>
<div id="assets-dropzone" class="post-dropzone">
    <div class="modal-body clearfix">
        <div class="container-fluid">
            <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
            <input type="hidden" name="asset_id" value="<?php echo $asset_id; ?>" />
            <input type="hidden" name="action_type" value="<?php echo $action_type; ?>" />
            <input type="hidden" name="opening_stock" value="<?php echo $last_asset_action_info->closing_stock; ?>" />

            <div class="form-group">
                <div class="row">
                    <label for="action_code" class="col-md-3"><?php echo app_lang('assets_action_code'); ?>
                        <span class="help" data-bs-toggle="tooltip" title="<?php echo app_lang('assets_action_code_help_text'); ?>"><i data-feather="help-circle" class="icon-16"></i></span>
                    </label>
                    <div class="col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "action_code",
                            "name" => "action_code",
                            "value" => $model_info->action_code,
                            "class" => "form-control",
                            "placeholder" => app_lang('assets_action_code'),
                            "autofocus" => true,
                            "data-rule-required" => true,
                            "data-msg-required" => app_lang("field_required"),
                        ));
                        ?>
                    </div>
                </div>
            </div>

            <?php if ($action_type == "allocation" || $action_type == "revoke") { ?>
                <?php
                $reveiver_lang = app_lang('assets_receiver');
                $provider_lang = app_lang('assets_provider');
                if ($action_type == "revoke") {
                    $reveiver_lang = app_lang('assets_revoke_from');
                    $provider_lang = app_lang('assets_who_revoke');
                }
                ?>

                <div class="form-group">
                    <div class="row">
                        <label for="receiver_id" class="col-md-3"><?php echo $reveiver_lang; ?></label>
                        <div class="col-md-9">
                            <?php
                            echo form_dropdown("receiver_id", $user_dropdown, $model_info->receiver_id, "class='select2 validate-hidden' id='receiver_id' data-rule-required='true', data-msg-required='" . app_lang('field_required') . "'");
                            ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label for="provider_id" class="col-md-3"><?php echo $provider_lang; ?></label>
                        <div class="col-md-9">
                            <?php
                            echo form_dropdown("provider_id", $user_dropdown, $model_info->provider_id, "class='select2 validate-hidden' data-rule-required='true', data-msg-required='" . app_lang('field_required') . "'");
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if ($action_type == "revoke") { ?>
                <div class="form-group">
                    <div class="row">
                        <label for="revoke_quantity" class="col-md-3"><?php echo app_lang('quantity'); ?></label>
                        <div class="col-md-9">
                            <?php
                            echo form_input(array(
                                "id" => "revoke_quantity",
                                "name" => "quantity",
                                "value" => $model_info->quantity ? $model_info->quantity : "",
                                "class" => "form-control",
                                "placeholder" => app_lang('quantity'),
                                "type" => "number",
                                "min" => 0,
                                "data-rule-required" => true,
                                "data-msg-required" => app_lang("field_required")
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            <?php } else if ($action_type == "allocation") { ?>
                <div class="form-group">
                    <div class="row">
                        <label for="quantity" class="col-md-3"><?php echo app_lang('quantity'); ?></label>
                        <div class="col-md-9">
                            <?php
                            echo form_input(array(
                                "id" => "quantity",
                                "name" => "quantity",
                                "value" => $model_info->quantity ? $model_info->quantity : "",
                                "class" => "form-control",
                                "placeholder" => app_lang('quantity'),
                                "type" => "number",
                                "min" => 0,
                                "max" => $asset_info->quantity - $asset_info->total_allocation,
                                "data-rule-required" => true,
                                "data-msg-required" => app_lang("field_required"),
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            <?php } else if ($action_type == "warranty") { ?>
                <div class="form-group">
                    <div class="row">
                        <label for="quantity" class="col-md-3"><?php echo app_lang('quantity'); ?></label>
                        <div class="col-md-9">
                            <?php
                            echo form_input(array(
                                "id" => "quantity",
                                "name" => "quantity",
                                "value" => $model_info->quantity ? $model_info->quantity : "",
                                "class" => "form-control",
                                "placeholder" => app_lang('quantity'),
                                "type" => "number",
                                "min" => 0,
                                "max" => $broken_asset_amonut,
                                "data-rule-required" => true,
                                "data-msg-required" => app_lang("field_required"),
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="form-group">
                    <div class="row">
                        <label for="quantity" class="col-md-3"><?php echo app_lang('quantity'); ?></label>
                        <div class="col-md-9">
                            <?php
                            echo form_input(array(
                                "id" => "quantity",
                                "name" => "quantity",
                                "value" => $model_info->quantity ? $model_info->quantity : "",
                                "class" => "form-control",
                                "placeholder" => app_lang('quantity'),
                                "type" => "number",
                                "min" => 0,
                                "data-rule-required" => true,
                                "data-msg-required" => app_lang("field_required"),
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if ($action_type == "allocation") { ?>
                <div class="form-group">
                    <div class="row">
                        <label for="rest" class="col-md-3"><?php echo app_lang('assets_rest'); ?></label>
                        <div class="col-md-9" id="rest" name="rest" value="<?php echo $asset_info->quantity - $asset_info->total_allocation; ?>"><?php echo $asset_info->quantity - $asset_info->total_allocation; ?>/<?php echo $asset_info->quantity; ?></div>
                    </div>
                </div>
            <?php } else if ($action_type == "revoke") { ?>
                <div class="form-group">
                    <div class="row">
                        <label for="has_been_allocated" class="col-md-3"><?php echo app_lang('assets_has_been_allocated'); ?></label>
                        <div class="col-md-9" id="has_been_allocated" name="has_been_allocated" value="">0</div>
                    </div>
                </div>
            <?php } else if ($action_type == "warranty") { ?>
                <div class="form-group">
                    <div class="row">
                        <label for="assets_broken_amount" class="col-md-3"><?php echo app_lang('assets_broken_amount'); ?></label>
                        <div class="col-md-9" value="<?php echo $broken_asset_amonut; ?>"><?php echo $broken_asset_amonut; ?></div>
                    </div>
                </div>
            <?php } ?>

            <?php if ($action_type == "allocation" || $action_type == "revoke") { ?>
                <div class="form-group">
                    <div class="row">
                        <label for="handover_location" class="col-md-3"><?php echo app_lang('assets_handover_location'); ?></label>
                        <div class="col-md-9">
                            <?php
                            echo form_input(array(
                                "id" => "handover_location",
                                "name" => "handover_location",
                                "value" => $model_info->action_location ? $model_info->action_location : "",
                                "class" => "form-control",
                                "placeholder" => app_lang('assets_handover_location'),
                                "data-rule-required" => true,
                                "data-msg-required" => app_lang("field_required"),
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if ($action_type == "liquidation" || $action_type == "warranty") { ?>
                <div class="form-group">
                    <div class="row">
                        <?php
                        if ($action_type == "liquidation") {
                            $cost = app_lang('assets_liquidation_amount');
                        } else {
                            $cost = app_lang('assets_repair_cost');
                        }
                        ?>
                        <label for="cost" class="col-md-3"><?php echo $cost; ?></label>
                        <div class="col-md-9">
                            <?php
                            echo form_input(array(
                                "id" => "cost",
                                "name" => "cost",
                                "value" => $model_info->cost ? $model_info->cost : "",
                                "class" => "form-control",
                                "placeholder" => $cost,
                                "data-rule-required" => true,
                                "data-msg-required" => app_lang("field_required"),
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <div class="row">
                    <?php
                    if ($action_type == "allocation" || $action_type == "revoke") {
                        $desc = app_lang('reason');
                    } else {
                        $desc = app_lang('description');
                    }
                    ?>
                    <label for="description" class="col-md-3"><?php echo $desc; ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_textarea(array(
                            "id" => "description",
                            "name" => "description",
                            "value" => $model_info->description ? $model_info->description : "",
                            "class" => "form-control",
                            "placeholder" => $desc,
                            "data-rich-text-editor" => true
                        ));
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
        <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save'); ?></button>
    </div>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    "use strict";

    $(document).ready(function () {
        $("#asset-action-form").appForm({
            onSuccess: function (result) {
                $("#inventory-history-table").appTable({newData: result.data, dataId: result.id});
                location.reload();
            }
        });

        setTimeout(function () {
            $("#action_code").focus();
        }, 200);

        $("#asset-action-form .select2").select2();

<?php if ($action_type == "revoke") { ?>
            //load allocation value of selected user
            $("#receiver_id").select2().on("change", function () {
                var user_id = $(this).val();
                if ($(this).val()) {
                    $.ajax({
                        url: "<?php echo get_uri("assets_management/get_selected_user_allocation_value"); ?>",
                        data: {user_id: user_id, asset_id: <?php echo $asset_id; ?>},
                        type: 'POST',
                        dataType: "json",
                        success: function (response) {
                            if (response && response.success) {
                                $("#has_been_allocated").val(response.info);
                                $("#has_been_allocated").html(response.info);
                                $("#revoke_quantity").attr('max', response.info);
                            }
                        }

                    });
                }
            });
<?php } ?>

        $('[data-bs-toggle="tooltip"]').tooltip();

    });
</script>