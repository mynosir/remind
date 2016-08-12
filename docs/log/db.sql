-- jinmengjie 20160811
-- 添加客户信息表
CREATE TABLE `customer` (
    `id` int(11) NOT NULL COMMENT '自增ID',
    `user_name` varchar(256) NOT NULL COMMENT '申请人姓名',
    `type` tinyint(2) NOT NULL COMMENT '客户类型，0公司，1个人',
    `id_code` varchar(18) NOT NULL COMMENT '身份证/机构编码',
    `address` varchar(256) NOT NULL COMMENT '地址',
    `zip_code` varchar(10) NOT NULL COMMENT '邮编',
    `linkman` varchar(20) NOT NULL COMMENT '联系人',
    `fixed_tel` varchar(20) NOT NULL COMMENT '固话',
    `mobile_tel` varchar(20) NOT NULL COMMENT '手机',
    `create_time` int(11) NOT NULL COMMENT '创建时间',
    `update_time` int(11) NOT NULL COMMENT '更新时间',
    primary key (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客户管理';


-- jinmengjie 20160811
-- 添加节点配置表
create table if not exists `point_tbl` (
    `id` int(11) not null comment '自增ID',
    `name` varchar(256) not null comment '节点名称',
    primary key (`id`)
) engine = myisam character set utf8 collate utf8_general_ci comment = '节点配置表';


-- jinmengjie 20160811
-- 添加订单表
create table if not exists `corder` (
    `id` int(11) not null comment '自增id',
    `applyid` varchar(32) not null comment '申请id,username+时间戳',
    `name` varchar(256) not null comment '申请名称',
    `customer` int(11) not null comment '申请人',
    `type` tinyint(2) default 0 comment '类型，0商标、1专利、2版权、3其他',
    `islater` tinyint(2) default 0 comment '专利时是否减缓，0否，1是',
    `billinfo` varchar(256) default '' comment '发票信息',
    `receiptinfo` varchar(256) default '' comment '收据信息',
    `handelpoint` tinyint(2) default 0 comment '当前处理节点id',
    `step` int(11) default 0 comment '当前第几步骤',
    `handeltime` int(11) not null comment '处理期限',
    `nexthandeler` int(11) not null comment '下一步处理人id',
    `remark` varchar(256) default '' comment '备注：每个步骤备注追加记录',
    `zipname` varchar(256) default '' comment '压缩包名称',
    `registerdate` int(11) comment '登记任务申请日',
    `applyno` varchar(256) default '' comment '申请号',
    `ispaid` tinyint(2) default 0 comment '是否收费，0否，1是',
    `isslowdown` tinyint(2) default 0 comment '财务给出是否减缓，0否，1是',
    `isbillout` tinyint(2) default 0 comment '是否开具发票，0否，1是',
    `registrationdate` int(11) comment '登记发文日',
    primary key (`id`)
) engine = myisam character set utf8 collate utf8_general_ci comment = '客户订单表';



