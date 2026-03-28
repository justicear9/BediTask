<?php

namespace Assets_Management\Controllers;

class Assets_settings extends \App\Controllers\Security_Controller {

    protected $Asset_groups_model;
    protected $Asset_units_model;
    protected $Asset_locations_model;

    function __construct() {
        parent::__construct();
        $this->access_only_admin_or_settings_admin();
        $this->Asset_groups_model = new \Assets_Management\Models\Asset_groups_model();
        $this->Asset_units_model = new \Assets_Management\Models\Asset_units_model();
        $this->Asset_locations_model = new \Assets_Management\Models\Asset_locations_model();
    }

    /* load assets setting view */

    function index() {
        return $this->template->rander("Assets_Management\Views\settings\index");
    }

    /* load asset group add/edit modal */

    function asset_group_modal_form() {
        $this->validate_submitted_data(array(
            "id" => "numeric"
        ));

        $view_data['model_info'] = $this->Asset_groups_model->get_one($this->request->getPost('id'));
        return $this->template->view('Assets_Management\Views\settings\asset_group_modal_form', $view_data);
    }

    /* insert or update an asset group */

    function save_asset_group() {
        $this->validate_submitted_data(array(
            "id" => "numeric",
            "title" => "required"
        ));

        $id = $this->request->getPost('id');
        $data = array(
            "title" => $this->request->getPost('title')
        );
        $save_id = $this->Asset_groups_model->ci_save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_asset_group_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    /* delete an asset group */

    function delete_asset_group() {
        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost('id');
        if ($this->request->getPost('undo')) {
            if ($this->Asset_groups_model->delete($id, true)) {
                echo json_encode(array("success" => true, "data" => $this->_asset_group_row_data($id), "message" => app_lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, app_lang('error_occurred')));
            }
        } else {
            if ($this->Asset_groups_model->delete($id)) {
                echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
            }
        }
    }

    /* list of asset groups, prepared for datatable  */

    function asset_group_list_data() {
        $list_data = $this->Asset_groups_model->get_details()->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_asset_group_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    /* return a row of asset group list table */

    private function _asset_group_row_data($id) {
        $options = array("id" => $id);
        $data = $this->Asset_groups_model->get_details($options)->getRow();
        return $this->_asset_group_make_row($data);
    }

    /* prepare a row of asset group list table */

    private function _asset_group_make_row($data) {
        $action = modal_anchor(get_uri("assets_settings/asset_group_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('assets_edit_asset_group'), "data-post-id" => $data->id))
                . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('assets_delete_asset_group'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("assets_settings/delete_asset_group"), "data-action" => "delete"));

        return array(
            $data->title,
            $action
        );
    }

    /* load asset unit view */

    function asset_units() {
        return $this->template->view("Assets_Management\Views\settings\asset_units");
    }

    /* load asset unit add/edit modal */

    function asset_unit_modal_form() {

        $this->validate_submitted_data(array(
            "id" => "numeric"
        ));

        $view_data['model_info'] = $this->Asset_units_model->get_one($this->request->getPost('id'));
        return $this->template->view('Assets_Management\Views\settings\asset_unit_modal_form', $view_data);
    }

    /* insert or update an asset unit */

    function save_asset_unit() {
        $this->validate_submitted_data(array(
            "id" => "numeric",
            "title" => "required"
        ));

        $id = $this->request->getPost('id');
        $data = array(
            "title" => $this->request->getPost('title')
        );
        $save_id = $this->Asset_units_model->ci_save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_asset_unit_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    /* delete an asset unit */

    function delete_asset_unit() {
        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost('id');
        if ($this->request->getPost('undo')) {
            if ($this->Asset_units_model->delete($id, true)) {
                echo json_encode(array("success" => true, "data" => $this->_asset_unit_row_data($id), "message" => app_lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, app_lang('error_occurred')));
            }
        } else {
            if ($this->Asset_units_model->delete($id)) {
                echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
            }
        }
    }

    /* list of asset units, prepared for datatable  */

    function asset_unit_list_data() {
        $list_data = $this->Asset_units_model->get_details()->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_asset_unit_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    /* return a row of asset unit list table */

    private function _asset_unit_row_data($id) {
        $options = array("id" => $id);
        $data = $this->Asset_units_model->get_details($options)->getRow();
        return $this->_asset_unit_make_row($data);
    }

    /* prepare a row of asset unit list table */

    private function _asset_unit_make_row($data) {
        $action = modal_anchor(get_uri("assets_settings/asset_unit_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('assets_edit_asset_unit'), "data-post-id" => $data->id))
                . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('assets_delete_asset_unit'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("assets_settings/delete_asset_unit"), "data-action" => "delete"));

        return array(
            $data->title,
            $action
        );
    }

    /* load asset location view */

    function asset_locations() {
        return $this->template->view("Assets_Management\Views\settings\asset_locations");
    }

    /* load asset location add/edit modal */

    function asset_location_modal_form() {

        $this->validate_submitted_data(array(
            "id" => "numeric"
        ));

        $view_data['model_info'] = $this->Asset_locations_model->get_one($this->request->getPost('id'));
        return $this->template->view('Assets_Management\Views\settings\asset_location_modal_form', $view_data);
    }

    /* insert or update an asset location */

    function save_asset_location() {
        $this->validate_submitted_data(array(
            "id" => "numeric",
            "title" => "required"
        ));

        $id = $this->request->getPost('id');
        $data = array(
            "title" => $this->request->getPost('title')
        );
        $save_id = $this->Asset_locations_model->ci_save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_asset_location_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    /* delete an asset location */

    function delete_asset_location() {
        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost('id');
        if ($this->request->getPost('undo')) {
            if ($this->Asset_locations_model->delete($id, true)) {
                echo json_encode(array("success" => true, "data" => $this->_asset_location_row_data($id), "message" => app_lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, app_lang('error_occurred')));
            }
        } else {
            if ($this->Asset_locations_model->delete($id)) {
                echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
            }
        }
    }

    /* list of asset locations, prepared for datatable  */

    function asset_location_list_data() {
        $list_data = $this->Asset_locations_model->get_details()->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_asset_location_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    /* return a row of asset location list table */

    private function _asset_location_row_data($id) {
        $options = array("id" => $id);
        $data = $this->Asset_locations_model->get_details($options)->getRow();
        return $this->_asset_location_make_row($data);
    }

    /* prepare a row of asset location list table */

    private function _asset_location_make_row($data) {
        $action = modal_anchor(get_uri("assets_settings/asset_location_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('assets_edit_asset_location'), "data-post-id" => $data->id))
                . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('assets_delete_asset_location'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("assets_settings/delete_asset_location"), "data-action" => "delete"));

        return array(
            $data->title,
            $action
        );
    }

}

/* End of file Assets_settings.php */
/* Location: ./plugins/Assets_Management/controllers/Assets_settings.php */