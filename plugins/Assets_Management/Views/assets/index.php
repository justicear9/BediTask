<div id="page-content" class="page-wrapper clearfix">

    <ul class="nav nav-tabs bg-white title" role="tablist">
        <li class="title-tab"><h4 class="pl15 pt10 pr15"><?php echo app_lang('assets'); ?></h4></li>

        <div class="tab-title clearfix no-border">
            <div class="title-button-group">
                <?php
                echo modal_anchor(get_uri("assets_management/modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('assets_add_asset'), array("class" => "btn btn-default", "title" => app_lang('assets_add_asset')));
                ?>
            </div>
        </div>

    </ul>

    <div class="card no-border-top-radius">
        <div class="table-responsive pb50">
            <table id="asset-table" class="display" cellspacing="0" width="100%">            
            </table>
        </div>
    </div>

</div>

<script type="text/javascript">
    "use strict";

    $(document).ready(function () {
        $("#asset-table").appTable({
            source: '<?php echo_uri("assets_management/list_data") ?>',
            order: [[6, "desc"]],
            columns: [
                {title: '<?php echo app_lang("asset_id") ?>', "class": "w10p all"},
                {title: '<?php echo app_lang("asset_code") ?>', "class": "w10p all"},
                {title: '<?php echo app_lang("asset_name") ?>', order_by: "asset_name"},
                {title: '<?php echo app_lang("assets_group") ?>', "class": "w10p"},
                {title: '<?php echo app_lang("assets_unit") ?>', "class": "w10p"},
                {title: '<?php echo app_lang("assets_date_of_purchase") ?>', "class": "w10p"},
                {title: '<?php echo app_lang("assets_quantity_allocated") ?>', "class": "w10p"},
                {title: '<?php echo app_lang("assets_inventory") ?>', "class": "w10p"},
                {title: '<?php echo app_lang("assets_original_price") ?>', "class": "w10p"},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w10p"}
            ],
            printColumns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
            xlsColumns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
        });

    });
</script>