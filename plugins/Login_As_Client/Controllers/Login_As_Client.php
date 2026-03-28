<?php

namespace Login_As_Client\Controllers;

use App\Controllers\Security_Controller;

class Login_As_Client extends Security_Controller {

    protected $Login_As_Client_model;

    function __construct() {
        parent::__construct();
        $this->Login_As_Client_model = new \Login_As_Client\Models\Login_As_Client_model();
    }

    function index() {
        show_404();
    }

    function login_as_client() {
        $this->access_only_admin();

        $this->validate_submitted_data(array(
            "contact_id" => "required|numeric",
        ));

        $client_contact_id = $this->request->getPost("contact_id");

        //save data to return back as this admin user
        $hash = make_random_string(20);
        $data = array(
            "admin_id" => $this->login_user->id,
            "client_contact_id" => $client_contact_id,
            "hash" => $hash,
        );

        $save_id = $this->Login_As_Client_model->ci_save($data);
        if ($save_id) {
            //save hash session data to return back to the admin
            $session = \Config\Services::session();

            $session->set('login_as_client_hash', $hash);
            $session->set('user_id', $client_contact_id);
            
            echo json_encode(array("success" => true, "redirect_to" => get_uri("dashboard/view")));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function login_as_client_modal_form() {
        $this->access_only_admin();

        $contacts = $this->Login_As_Client_model->get_contacts_list()->getResult();

        $contacts_dropdown = array();
        foreach ($contacts as $contact) {
            if ($contact->company_name) {
                $contacts_dropdown[$contact->id] = $contact->first_name . " " . $contact->last_name . " (" . app_lang("client") . ": " . $contact->company_name . ")";
            }
        }

        $view_data['contacts_dropdown'] = $contacts_dropdown;

        return $this->template->view("Login_As_Client\Views\login_as_client_modal_form", $view_data);
    }

    function login_back_to_admin($hash = "") {
        $this->access_only_clients();
        if (!$hash) {
            show_404();
        }

        $options = array("hash" => $hash);
        $login_info = $this->Login_As_Client_model->get_one_where($options);
        if (!$login_info->id) {
            show_404();
        }

        $session = \Config\Services::session();

        $session->set('login_as_client_hash', "");
        $session->set('user_id', $login_info->admin_id);

        //delete the login data
        $this->Login_As_Client_model->delete_permanently($login_info->id);

        app_redirect('dashboard/view');
    }

}
