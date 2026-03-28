<?php

namespace Assets_Management\Models;

class Assets_model extends \App\Models\Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'assets';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $assets_table = $this->db->prefixTable('assets');
        $asset_groups_table = $this->db->prefixTable('asset_groups');
        $asset_units_table = $this->db->prefixTable('asset_units');
        $asset_location_table = $this->db->prefixTable('asset_locations');

        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where = " AND $assets_table.id=$id";
        }

        $sql = "SELECT $assets_table.*, $asset_groups_table.title AS asset_group_name, $asset_units_table.title AS asset_unit_name, $asset_location_table.title AS asset_location_name
        FROM $assets_table
        LEFT JOIN $asset_groups_table ON $assets_table.group_id = $asset_groups_table.id
        LEFT JOIN $asset_units_table ON $assets_table.unit_id = $asset_units_table.id
        LEFT JOIN $asset_location_table ON $assets_table.location_id = $asset_location_table.id
        WHERE $assets_table.deleted=0 $where";
        return $this->db->query($sql);
    }

    function is_asset_code_exists($asset_code, $id = 0) {
        $assets_table = $this->db->prefixTable('assets');
        $id = $id ? $this->db->escapeString($id) : $id;

        $sql = "SELECT $assets_table.* FROM $assets_table   
        WHERE $assets_table.deleted=0 AND $assets_table.asset_code='$asset_code'";

        $result = $this->db->query($sql);

        if ($result->resultID->num_rows && $result->getRow()->id != $id) {
            return $result->getRow();
        } else {
            return false;
        }
    }

}
