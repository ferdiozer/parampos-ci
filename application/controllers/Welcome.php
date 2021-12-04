<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index($orderId){

		if(isset($_POST['pos_id'])){
            $config['GUID'] = '0c13d406-873b-403b-9c09-a5766840d98c';
            $config['CLIENT_CODE'] ='10738';
            $config['CLIENT_USERNAME'] ='Test';
            $config['CLIENT_PASSWORD'] ='Test';
            $config['MODE'] = "TEST"; // PROD or TEST
            $config['orderId'] = $orderId;
            $config['cardHolderPhone'] ="5445555555";

            $config['payAction'] = base_url('/checkout/payment/'.$orderId);
            $config['successUrl'] =base_url('/checkout/result/'.$orderId.'?success=true');
            $config['failUrl'] = base_url('/checkout/result/'.$orderId);

            $this->load->library('Parampos',$config);

            $post['card_number'] = $_POST['card_number'];
            $post['card_name'] = $_POST['card_name'];
            $post['card_expmonth'] = $_POST['card_expmonth'];
            $post['card_expyear'] = $_POST['card_expyear'];
            $post['card_cvv'] = $_POST['card_cvv'];
            $post['total_price']= '10,00';

            $payed = $this->Parampos->setPaid($post);
            if ($payed["success"]){
                redirect( '/Welcome/index/'.$orderId.'?success');
            }
            else{
                redirect('/Welcome/index/'.$orderId);
            }
        }

		$this->load->view('welcome_message',$data);
	}
}
