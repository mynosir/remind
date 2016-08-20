<?php
/**
 * undone orders manager controller
 *
 *
 */
class on_handel_order extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['user_id'] = $this->session->userdata('user_id');
        $this->load->view('orders/on_handel_order', $data);
    }
}
