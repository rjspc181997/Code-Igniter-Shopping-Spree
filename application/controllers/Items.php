<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items extends CI_Controller {

	public function index(){

		$this->load->model('Item');
		$products = $this->Item->get_all_products();
		//initialization
		if(empty($this->session->userdata('cart')))
		{
			$this->session->set_userdata('cart', 0);
			$this->session->set_userdata('total',0);

			if(!empty($products))
			{
				foreach($products as $product){
					$this->session->set_userdata($product['name'], 0);
				}
			}
		}

		$viewdata = array(
			"products"=>$products,
			"cart"=>$this->session->userdata('cart')
		);
		
		$this->load->view('Catalog', $viewdata);
	}

	public function buy()
	{
		$this->load->model('Item');
		$products = $this->Item->get_all_products();
		$post_length = 0;

		foreach($products as $product)
		{
			$post_length += strlen($this->input->post($product['name']));
		
		}
		
		if(!empty($this->input->post()) && $post_length!=0 && $this->input->post('click'))
		{
			foreach($products as $product)
			{
				if(!empty($this->input->post($product['name'])))
				{
					$item = $this->session->userdata($product['name']);//starts with zero
					//when you click the buy button in every item with value, it will added
					$item += $this->input->post($product['name']);
					//set session user data
					$this->session->set_userdata($product['name'], $item);
					//for product quantity, for separtion
					$added_qty = $this->input->post($product['name']);
					//getting another public function to add
					$cart = $this->add_to_cart($added_qty);
					//update
					$viewdata = array(
						"products"=>$products,
						"cart"=>$cart
					);
					$this->load->view('Catalog', $viewdata);
				}
			}
		}
		else{
			redirect("/");
		}

	}
	//index to cart
	public function add_to_cart($qty){
		$cart = $this->session->userdata('cart');
		$cart += $qty;
		$this->session->set_userdata('cart', $cart);
		return $this->session->userdata('cart');
	}

	//Print out in page of cart that you click
	public function cart()
	{
		$this->load->model('Item');
		$products = $this->Item->get_all_products();
		$total = 0;
		$cart = 0;
		foreach($products as $product)
		{
			$total += $this->session->userdata($product['name']) * $product['price'];
			$cart  += $this->session->userdata($product['name']);
		}
		$this->session->set_userdata('total', $total);
		$this->session->set_userdata('cart', $cart);

		//array for print out in the table data
		$orders = array();
		$total_item = 0;
		foreach($products as $product)
		{
			$total_item = $this->session->userdata($product['name']) * $product['price'];
			if($total_item!=0)
			{
				array_push($orders, array(
					'item_name'=>$product['name'],
					'qty'=>$this->session->userdata($product['name']),
					'price'=>$product['price'],
					'amt'=>$total_item,
					'id'=>$product['id']
				));
			}
		}
		$this->session->set_userdata('orders', $orders);
		$viewdata = array(
			'orders'=> $orders,
			'total'=> $total
		);
		$this->load->view('Cart',$viewdata);
	}

	public function delete($order){
		$this->load->model('Item');
		$products = $this->Item->get_all_products();
		if(!empty($products))
		{
			foreach($products as $product)
			{
				if($product['name']==$order){
					$this->session->set_userdata($product['name'],0);
				}
			}
		}
		redirect('/Items/Cart');
	}

	//For queries
	public function bill()
	{
		$total = $this->session->userdata('total');
		$bill = array(
			'bill'=>$this->input->post(),
			'amount'=>$total
		);

		$this->load->model('Item');
		//User
		$add_user = $this->Item->add_user($bill);
		if($add_user==TRUE){
			//to get the user id
			$last_id = $this->Item->get_last_id();
			$items = $this->session->userdata('orders');

			//to get the item_name, qty etc
		    foreach($items as $key=>$value){
				foreach($items[$key] as $id=>$val){
					if($id=="qty"){
						$qty = $val;
					}
					if($id=='id'){
						$id=$val;
					}
					if($id=='amt'){
						$amt=$val;
					}
				}
				$item = array(
					'user_id'=>$last_id,
					'product_id'=>$id,
					'quantity'=>$qty,
					'total_amount'=>$amt
				);
				//order
				$this->Item->add_order($item);
			}

			$message = "Thank you!";
			$this->session->set_flashdata('message', $message);

			$this->load->model('Item');
			$products = $this->Item->get_all_products();
			if(!empty($products))
			{
				foreach($products as $product){
					$this->session->set_userdata($product['name'], 0);
				}
			}
			redirect('/Items/Cart');
		}
		
	}
}

?>
