<?php

namespace Assets_Management\Models;

class Asset_actions_model extends \App\Models\Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'asset_actions';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $asset_actions_table = $this->db->prefixTable('asset_actions');
        $assets_table = $this->db->prefixTable('assets');

        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where = " AND $asset_actions_table.id=$id";
        }

        $asset_id = get_array_value($options, "asset_id");
        if ($asset_id) {
            $where = " AND $asset_actions_table.asset_id=$asset_id";
        }

        $sql = "SELECT $asset_actions_table.*
        FROM $asset_actions_table
        LEFT JOIN $assets_table ON $asset_actions_table.asset_id = $assets_table.id
        WHERE $asset_actions_table.deleted=0 $where";
        return $this->db->query($sql);
    }

    function get_asset_action_last_id($options = array()) {
        $asset_actions_table = $this->db->prefixTable('asset_actions');
        $assets_table = $this->db->prefixTable('assets');

        $where = "";
        $asset_id = get_array_value($options, "asset_id");
        if ($asset_id) {
            $where = " AND $asset_actions_table.asset_id=$asset_id";
        }

        $sql = "SELECT MAX($asset_actions_table.id) AS last_id
        FROM $asset_actions_table
        LEFT JOIN $assets_table ON $asset_actions_table.asset_id = $assets_table.id
        WHERE $asset_actions_table.deleted=0 $where";

        return $this->db->query($sql)->getRow()->last_id;
    }

    function get_allocation_value($options = array()) {
        $asset_actions_table = $this->db->prefixTable('asset_actions');

        $where = "";
        $user_id = get_array_value($options, "user_id");
        if ($user_id) {
            $where .= " AND $asset_actions_table.receiver_id=$user_id";
        }

        $asset_id = get_array_value($options, "asset_id");
        if ($asset_id) {
            $where .= " AND $asset_actions_table.asset_id=$asset_id";
        }

        $allocation_sql = "SELECT SUM($asset_actions_table.quantity) AS total
        FROM $asset_actions_table
        WHERE $asset_actions_table.deleted=0 AND $asset_actions_table.action_type='allocation' $where";
        $allocation_value = $this->db->query($allocation_sql)->getRow()->total;

        $revoke_sql = "SELECT SUM($asset_actions_table.quantity) AS total
        FROM $asset_actions_table
        WHERE $asset_actions_table.deleted=0 AND $asset_actions_table.action_type='revoke' $where";
        $revok_value = $this->db->query($revoke_sql)->getRow()->total;

        return $allocation_value - $revok_value;
    }

    function get_broken_asset_amonut($options = array()) {
        $asset_actions_table = $this->db->prefixTable('asset_actions');

        $where = "";

        $asset_id = get_array_value($options, "asset_id");
        if ($asset_id) {
            $where .= " AND $asset_actions_table.asset_id=$asset_id";
        }

        $broken_sql = "SELECT SUM($asset_actions_table.quantity) AS total
        FROM $asset_actions_table
        WHERE $asset_actions_table.deleted=0 AND $asset_actions_table.action_type='broken' $where";
        $broken_value = $this->db->query($broken_sql)->getRow()->total;

        $warranty_sql = "SELECT SUM($asset_actions_table.quantity) AS total
        FROM $asset_actions_table
        WHERE $asset_actions_table.deleted=0 AND $asset_actions_table.action_type='warranty' $where";
        $warranty_value = $this->db->query($warranty_sql)->getRow()->total;

        return $broken_value - $warranty_value;
    }

    function is_action_code_exists($action_code, $id = 0) {
        $asset_actions_table = $this->db->prefixTable('asset_actions');
        $id = $id ? $this->db->escapeString($id) : $id;

        $sql = "SELECT $asset_actions_table.* FROM $asset_actions_table   
        WHERE $asset_actions_table.deleted=0 AND $asset_actions_table.action_code='$action_code'";

        $result = $this->db->query($sql);

        if ($result->resultID->num_rows && $result->getRow()->id != $id) {
            return $result->getRow();
        } else {
            return false;
        }
    }

}
