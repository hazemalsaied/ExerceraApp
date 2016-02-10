<?php 

require_once __DIR__."/db_instance.php";

class DbWrapper {
    private $db = null;

    private function __construct() { 
    }

    public static function select($table, $selected_fields, $where) {
        self->db = DbInstance->getInstance();
        // self->db.execute
    }

    private function build_select_query($table, $selected_fields, $where = "", $order = "", $limit = "") {
        $sql = "SELECT {$selected_fields}
                FROM `{$table}`
                WHERE 1 {$where}
                {$order}
                {$limit}";
        return $sql;
    }

    private function build_insert_query($table, $data) {
        $sql  = "SELECT {$selected_fields} ";
        $sql .= "FROM `{$table}` ";
        $sql .= "WHERE 1";
        $sql .= $where;
        $sql .= $order;
        $sql .= $limit;
        return $sql;
    }
}
?>