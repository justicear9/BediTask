<?php
if (isset($login_user->id) && $login_user->id) {
    if ($login_user->is_admin) {
        ?>
        <script type="text/javascript">
            "use strict";

            $(document).ready(function () {

                //show a button on topbar to show the client contacts list modal to login as client on admin only
                var loginAsAdminDom = '<li class="nav-item"><?php echo modal_anchor(get_uri("login_as_client/login_as_client_modal_form"), '<i data-feather="log-out" class="icon"></i>', array("class" => "nav-link", "data-modal-title" => app_lang('login_as_client'))); ?></li>';
                $("#default-navbar").find(".w-auto").find(".navbar-nav").prepend(loginAsAdminDom);
            });
        </script>
        <?php
    }

    //show return to admin button
    $session = \Config\Services::session();
    $login_as_client_hash = $session->has("login_as_client_hash") ? $session->get("login_as_client_hash") : "";
    if ($login_as_client_hash && $login_user->user_type === "client") {
        ?>
        <style> .mt11 { margin-top: 11px; }</style>
        <script type="text/javascript">
            "use strict";

            $(document).ready(function () {
                console.log($("#default-navbar").find(".navbar-nav:first-child").attr("class"))
                $("#default-navbar").find("ul.navbar-nav").first().append("<span><a class='btn btn-primary btn-sm ml15 mt11' href='<?php echo get_uri("login_as_client/login_back_to_admin/$login_as_client_hash"); ?>'><i class='icon-14' data-feather='log-in'></i> <span class='hidden-sm'><?php echo app_lang("login_as_client_login_back_to_admin"); ?></span></a></span>");
            });
        </script>
        <?php
    }
}
?>