<div class="table-responsive">
    <table id="asset-units-table" class="display no-thead b-t b-b-only no-hover" cellspacing="0" width="100%">         
    </table>
</div>

<script type="text/javascript">
    "use strict";

    $(document).ready(function () {
        $("#asset-units-table").appTable({
            source: '<?php echo_uri("assets_settings/asset_unit_list_data") ?>',
            columns: [
                {title: '<?php echo app_lang("name"); ?>'},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ]
        });
    });
</script>