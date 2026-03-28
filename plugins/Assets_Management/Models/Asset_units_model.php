<?php

namespace Assets_Management\Models;

class Asset_units_model extends \App\Models\Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'asset_units';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $asset_units_table = $this->db->prefixTable('asset_units');
        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where = " AND $asset_units_table.id=$id";
        }

        $sql = "SELECT $asset_units_table.*
        FROM $asset_units_table
        WHERE $asset_units_table.deleted=0 $where";
        return $this->db->query($sql);
    }

}
