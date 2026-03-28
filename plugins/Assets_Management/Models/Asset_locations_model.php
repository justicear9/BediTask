<?php

namespace Assets_Management\Models;

class Asset_locations_model extends \App\Models\Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'asset_locations';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $asset_location_table = $this->db->prefixTable('asset_locations');
        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where = " AND $asset_location_table.id=$id";
        }

        $sql = "SELECT $asset_location_table.*
        FROM $asset_location_table
        WHERE $asset_location_table.deleted=0 $where";
        return $this->db->query($sql);
    }

}
