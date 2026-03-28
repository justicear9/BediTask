<?php

namespace Assets_Management\Models;

class Asset_groups_model extends \App\Models\Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'asset_groups';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $asset_groups_table = $this->db->prefixTable('asset_groups');
        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where = " AND $asset_groups_table.id=$id";
        }

        $sql = "SELECT $asset_groups_table.*
        FROM $asset_groups_table
        WHERE $asset_groups_table.deleted=0 $where";
        return $this->db->query($sql);
    }

}
