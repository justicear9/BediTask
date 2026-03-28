<div class="table-responsive">
    <table id="asset-locations-table" class="display no-thead b-t b-b-only no-hover" cellspacing="0" width="100%">         
    </table>
</div>

<script type="text/javascript">
    "use strict";

    $(document).ready(function () {
        $("#asset-locations-table").appTable({
            source: '<?php echo_uri("assets_settings/asset_location_list_data") ?>',
            columns: [
                {title: '<?php echo app_lang("name"); ?>'},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ]
        });
    });
</script>