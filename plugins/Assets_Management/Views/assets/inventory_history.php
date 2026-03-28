<div class="table-responsive">
    <table id="inventory-history-table" class="display" cellspacing="0" width="100%">            
    </table>
</div>

<script type="text/javascript">
    "use strict";

    $(document).ready(function () {
        $("#inventory-history-table").appTable({
            source: '<?php echo_uri("assets_management/inventory_history_list_data/" . $asset_id) ?>',
            order: [[6, "asc"]],
            columns: [
                {title: "<?php echo app_lang("assets_action_code") ?>"},
                {title: "<?php echo app_lang("assets_action_type") ?>"},
                {title: "<?php echo app_lang("quantity") ?>"},
                {title: "<?php echo app_lang("assets_opening_stock") ?>"},
                {title: "<?php echo app_lang("assets_closing_stock") ?>"},
                {title: "<?php echo app_lang("assets_cost"); ?>"},
                {title: "<?php echo app_lang("time"); ?>"}
            ],
            printColumns: [0, 1, 2, 3, 4, 5, 6],
            xlsColumns: [0, 1, 2, 3, 4, 5, 6]
        });
    }
    );
</script>