<?php

namespace Login_As_Client\Models;

use App\Models\Crud_model;

class Login_As_Client_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'login_as_client';
        parent::__construct($this->table);
    }

    function get_contacts_list() {
        $users_table = $this->db->prefixTable('users');
        $clients_table = $this->db->prefixTable('clients');

        $sql = "SELECT $users_table.id, $users_table.first_name, $users_table.last_name, $clients_table.company_name
        FROM $users_table
        LEFT JOIN $clients_table ON $clients_table.id = $users_table.client_id AND $clients_table.deleted=0
        WHERE $users_table.deleted=0 AND $users_table.status='active' AND $users_table.user_type='client'
        ORDER BY $users_table.first_name ASC";
        
        return $this->db->query($sql);
    }

}
