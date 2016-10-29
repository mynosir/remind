<?php
/**
 * 支付管理模型
 *
 * @author linzequan <lowkey361@gmail.com>
 *
 */
class payRecord_model extends MY_Model {

    private $table = 'payRecord';
    private $fields = 'id, applyid, amount, handelUserId, ext, create_time';


    public function __construct() {
        parent::__construct();
    }


    public function getRecordList($applyid) {
        $where = array(
            'applyid'   => $applyid
        );
        $query = $this->db->get_where($this->table, $where);
        $datas = $query->result_array();
        $this->load->model('sys/user_model', 'user_model');
        $CI = &get_instance();
        foreach($datas as $k=>&$v) {
            if($userinfo=$CI->user_model->get_userinfo_by_id($v['handelUserId'])) {
                $v['handelUsername'] = $userinfo['true_name'];
            } else {
                $v['handelUsername'] = '';
            }
            $v['create_time'] = date('Y-m-d H:i:s', $v['create_time']);

        }
        return $datas;
    }


    public function insert($data) {
        $data = array(
            'applyid'       => get_value($data, 'applyid'),
            'amount'        => floatval(get_value($data, 'amount')),
            'handelUserId'  => $this->session->userdata('user_id'),
            'ext'           => get_value($data, 'ext'),
            'create_time'   => time()
        );
        $this->db->insert($this->table, $data);
        return $this->create_result(true, 0, array('id'=>$this->db->insert_id()));
    }
}
