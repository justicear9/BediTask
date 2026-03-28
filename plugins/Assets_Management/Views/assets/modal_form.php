<?php echo form_open(get_uri("assets_management/save"), array("id" => "asset-form", "class" => "general-form", "role" => "form")); ?>
<div id="assets-dropzone" class="post-dropzone">
    <div class="modal-body clearfix">
        <div class="container-fluid">
            <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />

            <div class="form-group">
                <div class="row">
                    <label for="asset_code" class=" col-md-3"><?php echo app_lang('asset_code'); ?>
                        <span class="help" data-bs-toggle="tooltip" title="<?php echo app_lang('asset_code_help_text'); ?>"><i data-feather="help-circle" class="icon-16"></i></span>
                    </label>
                    <div class="col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "asset_code",
                            "name" => "asset_code",
                            "value" => $model_info->asset_code,
                            "class" => "form-control",
                            "placeholder" => app_lang('asset_code'),
                            "autofocus" => true,
                            "data-rule-required" => true,
                            "data-msg-required" => app_lang("field_required"),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="asset_name" class=" col-md-3"><?php echo app_lang('asset_name'); ?></label>
                    <div class="col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "asset_name",
                            "name" => "asset_name",
                            "value" => $model_info->asset_name,
                            "class" => "form-control validate-hidden",
                            "placeholder" => app_lang('asset_name'),
                            "data-rule-required" => true,
                            "data-msg-required" => app_lang("field_required"),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="quantity" class=" col-md-3"><?php echo app_lang('quantity'); ?></label>
                    <div class="col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "quantity",
                            "name" => "quantity",
                            "value" => $model_info->quantity ? $model_info->quantity : "",
                            "class" => "form-control",
                            "placeholder" => app_lang('quantity'),
                            "type" => "number",
                            "data-rule-required" => true,
                            "data-msg-required" => app_lang("field_required"),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="unit_id" class=" col-md-3"><?php echo app_lang('assets_unit'); ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_dropdown("unit_id", $units_dropdown, $model_info->unit_id, "class='select2 validate-hidden' id='unit_id' data-rule-required='true', data-msg-required='" . app_lang('field_required') . "'");
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="group_id" class=" col-md-3"><?php echo app_lang('assets_group'); ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_dropdown("group_id", $groups_dropdown, $model_info->group_id, "class='select2 validate-hidden' id='group_id' data-rule-required='true', data-msg-required='" . app_lang('field_required') . "'");
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="location_id" class=" col-md-3"><?php echo app_lang('location'); ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_dropdown("location_id", $locations_dropdown, $model_info->location_id, "class='select2 validate-hidden' id='location_id' data-rule-required='true', data-msg-required='" . app_lang('field_required') . "'");
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="series" class=" col-md-3"><?php echo app_lang('assets_series'); ?></label>
                    <div class="col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "series",
                            "name" => "series",
                            "value" => $model_info->series ? $model_info->series : "",
                            "class" => "form-control",
                            "placeholder" => app_lang('assets_series')
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="purchase_date" class=" col-md-3"><?php echo app_lang('assets_date_of_purchase'); ?></label>
                    <div class="col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "purchase_date",
                            "name" => "purchase_date",
                            "value" => $model_info->purchase_date ? $model_info->purchase_date : "",
                            "class" => "form-control recurring_element",
                            "placeholder" => app_lang('assets_date_of_purchase'),
                            "autocomplete" => "off",
                            "data-rule-required" => true,
                            "data-msg-required" => app_lang("field_required"),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="warranty_period" class=" col-md-3"><?php echo app_lang('assets_warranty_period_month'); ?></label>
                    <div class="col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "warranty_period",
                            "name" => "warranty_period",
                            "value" => $model_info->warranty_period ? $model_info->warranty_period : "",
                            "class" => "form-control",
                            "placeholder" => app_lang('assets_warranty_period_month'),
                            "type" => "number",
                            "data-rule-required" => true,
                            "data-msg-required" => app_lang("field_required"),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="unit_price" class=" col-md-3"><?php echo app_lang('assets_unit_price'); ?></label>
                    <div class="col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "unit_price",
                            "name" => "unit_price",
                            "value" => $model_info->unit_price ? $model_info->unit_price : "",
                            "class" => "form-control",
                            "placeholder" => app_lang('assets_unit_price'),
                            "data-rule-required" => true,
                            "data-msg-required" => app_lang("field_required"),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="depreciation" class=" col-md-3"><?php echo app_lang('assets_depreciation_month'); ?></label>
                    <div class="col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "depreciation",
                            "name" => "depreciation",
                            "value" => $model_info->depreciation ? $model_info->depreciation : "",
                            "class" => "form-control",
                            "placeholder" => app_lang('assets_depreciation_month'),
                            "type" => "number",
                            "data-rule-required" => true,
                            "data-msg-required" => app_lang("field_required"),
                        ));
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label for="supplier_name" class=" col-md-3"><?php echo app_lang('assets_supplier_name'); ?></label>
                    <div class="col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "supplier_name",
                            "name" => "supplier_name",
                            "value" => $model_info->supplier_name,
                            "class" => "form-control",
                            "placeholder" => app_lang('assets_supplier_name'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="supplier_phone" class=" col-md-3"><?php echo app_lang('assets_supplier_phone'); ?></label>
                    <div class="col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "supplier_phone",
                            "name" => "supplier_phone",
                            "value" => $model_info->supplier_phone,
                            "class" => "form-control",
                            "placeholder" => app_lang('assets_supplier_phone'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="supplier_address" class=" col-md-3"><?php echo app_lang('assets_supplier_address'); ?></label>
                    <div class="col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "supplier_address",
                            "name" => "supplier_address",
                            "value" => $model_info->supplier_address,
                            "class" => "form-control",
                            "placeholder" => app_lang('assets_supplier_address'),
                        ));
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label for="description" class="col-md-3"><?php echo app_lang('description'); ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_textarea(array(
                            "id" => "description",
                            "name" => "description",
                            "value" => $model_info->description ? $model_info->description : "",
                            "class" => "form-control",
                            "placeholder" => app_lang('description'),
                            "data-rich-text-editor" => true
                        ));
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-12 row pr0">
                        <?php
                        echo view("includes/file_list", array("files" => $model_info->files, "image_only" => true));
                        ?>
                    </div>
                </div>
            </div>

            <?php echo view("includes/dropzone_preview"); ?>

        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-default upload-file-button float-start btn-sm round me-auto" type="button" style="color:#7988a2"><i data-feather="camera" class="icon-16"></i> <?php echo app_lang("upload_image"); ?></button>
        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
        <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save'); ?></button>
    </div>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    "use strict";

    $(document).ready(function () {
        var uploadUrl = "<?php echo get_uri("assets_management/upload_file"); ?>";
        var validationUri = "<?php echo get_uri("assets_management/validate_assets_file"); ?>";

        var dropzone = attachDropzoneWithForm("#assets-dropzone", uploadUrl, validationUri);

        $("#asset-form").appForm({
            onSuccess: function (result) {
                $("#asset-table").appTable({newData: result.data, dataId: result.id});
                location.reload();
            }
        });

        setTimeout(function () {
            $("#asset_code").focus();
        }, 200);

        $("#asset-form .select2").select2();

        setDatePicker("#purchase_date");

        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>