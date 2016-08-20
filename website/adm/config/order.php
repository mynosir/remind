<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$step = array(
    '0' => '订单管理（市场部）',
    '1' => '任务处理（专利编制人）',
    '2' => '流程部（与产权局沟通前）',
    '3' => '流程部（与产权局沟通后）',
    '4' => '财务缴费',
    '5' => '流程部（登记发文日）',
    '6' => '财务确认结果'
);

$step_0 = array(
    'name' => '申请名称',
    'customer' => '申请人',
    'type' => '类型',
    'islater' => '是否减缓',
    'billinfo' => '发票信息',
    'receiptinfo' => '收据信息',
    'handeltime' => '下一步处理限期',
    'nexthandeler' => '下一步责任人',
    'remark' => '备注',
    'createuser' => '处理人',
    'createtime' => '处理时间'
);

$step_1 = array(
    'zipname' => '压缩包名称',
    'handeltime' => '下一步处理限期',
    'nexthandeler' => '下一步责任人',
    'createuser' => '处理人',
    'createtime' => '处理时间'
);

$step_2 = array(
    'registerdate' => '登记任务申请日',
    'createuser' => '处理人',
    'createtime' => '处理时间'
);

$step_3 = array(
    'applyno' => '申请号',
    'handeltime' => '下一步处理限期',
    'nexthandeler' => '下一步责任人',
    'createuser' => '处理人',
    'createtime' => '处理时间'
);

$step_4 = array(
    'ispaid' => '是否收费',
    'isslowdown' => '是否减缓',
    'isbillout' => '是否已开票',
    'handeltime' => '下一步处理限期',
    'nexthandeler' => '下一步责任人',
    'remark' => '备注',
    'createuser' => '处理人',
    'createtime' => '处理时间'
);

$step_5 = array(
    'registrationdate' => '登记发文日',
    'handeltime' => '下一步处理限期',
    'nexthandeler' => '下一步责任人',
    'createuser' => '处理人',
    'createtime' => '处理时间'
);

$step_6 = array(
    'isend' => '是否交完最后一笔款',
    'createuser' => '处理人',
    'createtime' => '处理时间'
);

$config['corder'] = array(
    'step'   => $step,
    'step_0' => $step_0,
    'step_1' => $step_1,
    'step_2' => $step_2,
    'step_3' => $step_3,
    'step_4' => $step_4,
    'step_5' => $step_5,
    'step_6' => $step_6
);
