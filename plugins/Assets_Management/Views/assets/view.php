<div id="page-content" class="clearfix">
    <div style="max-width: 1000px; margin: auto;">
        <div class="page-title clearfix mt15">
            <h1><?php echo app_lang("asset") . " #" . $asset_info->id; ?></h1>
            <div class="title-button-group">
                <span class="dropdown inline-block mt15">
                    <button class="btn btn-info text-white dropdown-toggle caret mt0 mb0" type="button" data-bs-toggle="dropdown" aria-expanded="true">
                        <i data-feather="tool" class="icon-16"></i> <?php echo app_lang('actions'); ?>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li role="presentation"><?php echo modal_anchor(get_uri("assets_management/action_modal_form"), "<i data-feather='divide-circle' class='icon-16'></i> " . app_lang('assets_allocation'), array("title" => app_lang('assets_allocation'), "class" => "dropdown-item", "data-post-asset_id" => $asset_info->id, "data-post-action_type" => "allocation")); ?> </li>
                        <li role="presentation"><?php echo modal_anchor(get_uri("assets_management/action_modal_form"), "<i data-feather='minus-circle' class='icon-16'></i> " . app_lang('assets_revoke'), array("title" => app_lang('assets_revoke'), "class" => "dropdown-item", "data-post-asset_id" => $asset_info->id, "data-post-action_type" => "revoke")); ?> </li>
                        <li role="presentation"><?php echo modal_anchor(get_uri("assets_management/action_modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('assets_additional'), array("title" => app_lang('assets_additional'), "class" => "dropdown-item", "data-post-asset_id" => $asset_info->id, "data-post-action_type" => "additional")); ?> </li>
                        <li role="presentation"><?php echo modal_anchor(get_uri("assets_management/action_modal_form"), "<i data-feather='x-circle' class='icon-16'></i> " . app_lang('assets_report_lost'), array("title" => app_lang('assets_report_lost'), "class" => "dropdown-item", "data-post-asset_id" => $asset_info->id, "data-post-action_type" => "report_lost")); ?></li>
                        <li role="presentation"><?php echo modal_anchor(get_uri("assets_management/action_modal_form"), "<i data-feather='zap-off' class='icon-16'></i> " . app_lang('assets_broken'), array("title" => app_lang('assets_broken'), "class" => "dropdown-item", "data-post-asset_id" => $asset_info->id, "data-post-action_type" => "broken")); ?> </li>
                        <li role="presentation"><?php echo modal_anchor(get_uri("assets_management/action_modal_form"), "<i data-feather='minus-square' class='icon-16'></i> " . app_lang('assets_liquidation'), array("title" => app_lang('assets_liquidation'), "class" => "dropdown-item", "data-post-asset_id" => $asset_info->id, "data-post-action_type" => "liquidation")); ?> </li>
                        <li role="presentation"><?php echo modal_anchor(get_uri("assets_management/action_modal_form"), "<i data-feather='settings' class='icon-16'></i> " . app_lang('assets_warranty'), array("title" => app_lang('assets_warranty'), "class" => "dropdown-item", "data-post-asset_id" => $asset_info->id, "data-post-action_type" => "warranty")); ?> </li>

                        <li role="presentation" class="dropdown-divider"></li>

                        <li role="presentation"><?php echo modal_anchor(get_uri("assets_management/modal_form/"), "<i data-feather='edit' class='icon-16'></i> " . app_lang('assets_edit_asset'), array("title" => app_lang("assets_edit_asset"), "data-post-id" => $asset_info->id, "class" => "dropdown-item")); ?> </li>
                    </ul>
                </span>
            </div>
        </div>
        <div class="mt15">
            <div class="card no-border clearfix ">
                <ul data-bs-toggle="ajax-tab" class="nav nav-tabs bg-white title" role="tablist">
                    <li><a role="presentation" data-bs-toggle="tab" href="javascript:;" data-bs-target="#asset-info"><?php echo app_lang("asset_info"); ?></a></li>
                    <li><a role="presentation" data-bs-toggle="tab" href="<?php echo_uri("assets_management/inventory_history/" . $asset_info->id); ?>" data-bs-target="#inventory-history"><?php echo app_lang("assets_inventory_history"); ?></a></li>
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade" id="asset-info">

                        <div class="p15 b-t mb15">
                            <div class="clearfix">
                                <h4 data-bs-toggle="collapse" href="#asset-information" aria-expanded="true" aria-controls="asset-information" class="ms-3 clickable"><?php echo app_lang("asset_info"); ?></h4>

                                <div class="collapse multi-collapse show" id="asset-information">
                                    <table class="table dataTable display b-t" style="margin-bottom: -1px;">
                                        <tr class="w50p" style="border-bottom-color: transparent !important;">
                                            <td class="w150 strong"> <?php echo app_lang('asset_name'); ?></td>
                                            <td><?php echo $asset_info->asset_name; ?></td>
                                        </tr>
                                    </table>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="table-responsive mb15">
                                                <table class="table dataTable display b-t">
                                                    <tr class="w50p">
                                                        <td class="w150 strong"> <?php echo app_lang('asset_group'); ?></td>
                                                        <td><?php echo $asset_info->asset_group_name; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="strong"> <?php echo app_lang('assets_supplier_name'); ?></td>
                                                        <td><?php echo $asset_info->supplier_name; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="strong"> <?php echo app_lang('assets_supplier_phone'); ?></td>
                                                        <td><?php echo $asset_info->supplier_phone; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="strong"> <?php echo app_lang('assets_warranty_period'); ?></td>
                                                        <td><?php echo $asset_info->warranty_period . " " . app_lang("month"); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="strong"> <?php echo app_lang('asset_location'); ?></td>
                                                        <td><?php echo $asset_info->asset_location_name; ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="table-responsive mb15">
                                                <table class="table dataTable display b-t">
                                                    <tr class="w50p">
                                                        <td class="w150 strong"> <?php echo app_lang('asset_code'); ?></td>
                                                        <td><?php echo $asset_info->asset_code; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="strong"> <?php echo app_lang('assets_supplier_address'); ?></td>
                                                        <td><?php echo $asset_info->supplier_address; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="strong"> <?php echo app_lang('assets_date_of_purchase'); ?></td>
                                                        <td><?php echo $asset_info->purchase_date; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="strong"> <?php echo app_lang('assets_series'); ?></td>
                                                        <td><?php echo $asset_info->series; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="strong"> <?php echo app_lang('assets_depreciation'); ?></td>
                                                        <td><?php echo $asset_info->depreciation . " " . app_lang("month"); ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h4 data-bs-toggle="collapse" href="#asset-value" aria-expanded="true" aria-controls="asset-value" class="ms-3 clickable"><?php echo app_lang("asset_value"); ?></h4>

                            <div class="collapse multi-collapse show" id="asset-value">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="table-responsive mb15">
                                            <table class="table dataTable display b-t">
                                                <tr class="w50p">
                                                    <td class="w150 strong"> <?php echo app_lang('quantity'); ?></td>
                                                    <td><?php echo $asset_info->quantity; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="strong"> <?php echo app_lang('asset_unit'); ?></td>
                                                    <td><?php echo $asset_info->asset_unit_name; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="strong"> <?php echo app_lang('assets_original_price'); ?></td>
                                                    <td><?php echo to_currency($asset_info->quantity * $asset_info->unit_price); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="strong"> <?php echo app_lang('assets_depreciation_value'); ?></td>
                                                    <td><?php echo $depreciation_value; ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="table-responsive mb15">
                                            <table class="table dataTable display b-t">
                                                <tr class="w50p">
                                                    <td class="w150 strong"> <?php echo app_lang('assets_quantity_allocated'); ?></td>
                                                    <td><?php echo $asset_info->total_allocation; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="strong"> <?php echo app_lang('assets_unit_price'); ?></td>
                                                    <td><?php echo to_currency($asset_info->unit_price); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="strong"> <?php echo app_lang('assets_inventory'); ?></td>
                                                    <td><?php echo $asset_info->quantity - $asset_info->total_allocation; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="strong"> <?php echo app_lang('assets_residual_value'); ?></td>
                                                    <td><?php echo $residual_value; ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                            $files = @unserialize($asset_info->files);
                            if ($files && is_array($files) && count($files)) {
                                ?>
                                <div class="clearfix">
                                    <div class="col-md-12 m15">
                                        <p class="b-t"></p>
                                        <div class="mb5 strong"><?php echo app_lang("files"); ?></div>
                                        <?php
                                        foreach ($files as $key => $value) {
                                            $file_name = get_array_value($value, "file_name");
                                            echo "<div>";
                                            echo js_anchor(remove_file_prefix($file_name), array("data-toggle" => "app-modal", "data-sidebar" => "0", "data-url" => get_uri("assets_management/file_preview/" . $asset_info->id . "/" . $key)));
                                            echo "</div>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php } ?>

                            <p class="b-t b-info pt10 m15"><?php echo nl2br($asset_info->description ? $asset_info->description : ""); ?></p>

                        </div>

                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="inventory-history"></div>
                </div>
            </div>
        </div>

    </div>
</div>