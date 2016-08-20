<?php
/**
 * done orders manager controller
 *
 *
 */
class order_manager extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('orders/order_manager');
    }

}
