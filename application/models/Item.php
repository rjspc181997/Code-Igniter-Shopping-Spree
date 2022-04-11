<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Model {

    function get_all_products()
    {
        return $this->db->query("SELECT * FROM customers.products")->result_array();
    }
    function get_product_by_id($product_id)
    {
        return $this->db->query("SELECT * FROM products WHERE id = ?", array($product_id))->row_array();
    }
    function get_all_users()
    {
        return $this->db->query("SELECT * FROM customers.user")->result_array();
    }
    function add_user($adduser)
    {   
        date_default_timezone_set("Asia/Manila");
        $query = "INSERT INTO customers.user(total_order,name, address, card_number,created_at, updated_at) VALUES (?,?,?,?,?,?)";
        $values = array($adduser['amount'],$adduser['bill']['name'], $adduser['bill']['address'],$adduser['bill']['card_number'], date("Y-m-d, H:i:s"),date("Y-m-d, H:i:s")); 
        return $this->db->query($query, $values);
    }
    function add_order($addorder)
    {   
        date_default_timezone_set("Asia/Manila");
        $query = "INSERT INTO customers.orders(user_id, product_id, quantity, total_amount, created_at, updated_at) VALUES (?,?,?,?,?,?)";
        $values = array($addorder['user_id'], $addorder['product_id'],$addorder['quantity'], $addorder['total_amount'],date("Y-m-d, H:i:s"), date("Y-m-d, H:i:s")); 
        return $this->db->query($query, $values);
    }
    function get_last_id(){
        return $this->db->insert_id();
    }

}

?>
