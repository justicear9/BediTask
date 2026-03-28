<div id="page-content" class="page-wrapper clearfix">
    <div class="row">
        <div class="col-sm-3 col-lg-2">
            <?php
            $tab_view['active_tab'] = "assets_management";
            echo view("settings/tabs", $tab_view);
            ?>
        </div>

        <div class="col-sm-9 col-lg-10">
            <div class="card">

                <ul data-bs-toggle="ajax-tab" class="nav nav-tabs bg-white title" role="tablist">
                    <li><a role="presentation" data-bs-toggle="tab" href="javascript:;" data-bs-target="#asset-groups-tab"> <?php echo app_lang('asset_groups'); ?></a></li>
                    <li><a role="presentation" data-bs-toggle="tab" href="<?php echo_uri("assets_settings/asset_units"); ?>" data-bs-target="#asset-units-tab"><?php echo app_lang('asset_units'); ?></a></li>
                    <li><a role="presentation" data-bs-toggle="tab" href="<?php echo_uri("assets_settings/asset_locations"); ?>" data-bs-target="#asset-locations-tab"><?php echo app_lang('asset_locations'); ?></a></li>

                    <div class="tab-title clearfix no-border">
                        <div class="title-button-group">
                            <?php echo modal_anchor(get_uri("assets_settings/asset_group_modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('assets_add_asset_group'), array("class" => "btn btn-default", "title" => app_lang('assets_add_asset_group'), "id" => "asset-group-button")); ?>
                        </div>
                    </div>
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade" id="asset-groups-tab">
                        <div class="table-responsive">
                            <table id="asset-groups-table" class="display no-thead b-t b-b-only no-hover" cellspacing="0" width="100%">         
                            </table>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="asset-units-tab"></div>
                    <div role="tabpanel" class="tab-pane fade" id="asset-locations-tab"></div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">
    "use strict";

    $(document).ready(function () {
        $("#asset-groups-table").appTable({
            source: '<?php echo_uri("assets_settings/asset_group_list_data") ?>',
            columns: [
                {title: '<?php echo app_lang("name"); ?>'},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ]
        });

        //change the add button attributes on changing tab panel
        var addButton = $("#asset-group-button");
        $(".nav-tabs li").on("click", function () {
            var activeField = $(this).find("a").attr("data-bs-target");

            if (activeField === "#asset-units-tab") {
                addButton.attr("title", "<?php echo app_lang("assets_add_asset_unit"); ?>");
                addButton.attr("data-title", "<?php echo app_lang("assets_add_asset_unit"); ?>");
                addButton.attr("data-action-url", "<?php echo get_uri("assets_settings/asset_unit_modal_form"); ?>");

                addButton.html("<?php echo "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('assets_add_asset_unit'); ?>");
                feather.replace();
            } else if (activeField === "#asset-locations-tab") {
                addButton.attr("title", "<?php echo app_lang("assets_add_asset_location"); ?>");
                addButton.attr("data-title", "<?php echo app_lang("assets_add_asset_location"); ?>");
                addButton.attr("data-action-url", "<?php echo get_uri("assets_settings/asset_location_modal_form"); ?>");

                addButton.html("<?php echo "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('assets_add_asset_location'); ?>");
                feather.replace();
            } else if (activeField === "#asset-groups-tab") {
                addButton.attr("title", "<?php echo app_lang("assets_add_asset_group"); ?>");
                addButton.attr("data-title", "<?php echo app_lang("assets_add_asset_group"); ?>");
                addButton.attr("data-action-url", "<?php echo get_uri("assets_settings/asset_group_modal_form"); ?>");

                addButton.html("<?php echo "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('assets_add_asset_group'); ?>");
                feather.replace();
            }
        });
    });
</script>