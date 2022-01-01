/*
 Navicat Premium Data Transfer

 Source Server         : 本地
 Source Server Type    : MySQL
 Source Server Version : 50644
 Source Host           : localhost:3306
 Source Schema         : zeyudada

 Target Server Type    : MySQL
 Target Server Version : 50644
 File Encoding         : 65001

 Date: 01/01/2022 15:33:05
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for api_admin
-- ----------------------------
DROP TABLE IF EXISTS `api_admin`;
CREATE TABLE `api_admin`  (
  `a_a_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `a_a_name` varchar(18) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '管理员账户',
  `a_a_passwd` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '管理员密码',
  `a_a_time` time(0) NULL DEFAULT NULL COMMENT '登录时间',
  PRIMARY KEY (`a_a_name`) USING BTREE,
  INDEX `a_a_id`(`a_a_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of api_admin
-- ----------------------------
INSERT INTO `api_admin` VALUES (1, 'zeyudada', '5009267d40cfc837a962bf0aa6f4bdde', NULL);

-- ----------------------------
-- Table structure for api_binding
-- ----------------------------
DROP TABLE IF EXISTS `api_binding`;
CREATE TABLE `api_binding`  (
  `a_b_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `a_b_api_id` int(10) NOT NULL COMMENT '接口id',
  `a_b_table` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '绑定表',
  `a_b_field` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '绑定字段',
  `a_b_where` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '查询条件',
  `a_b_sort` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '排序',
  `a_b_sort_field` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '排序字段',
  `a_b_val` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '参数',
  `a_b_list` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '数量',
  `a_b_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '添加时间',
  PRIMARY KEY (`a_b_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of api_binding
-- ----------------------------

-- ----------------------------
-- Table structure for api_info
-- ----------------------------
DROP TABLE IF EXISTS `api_info`;
CREATE TABLE `api_info`  (
  `a_l_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '接口id',
  `a_l_title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '接口标题',
  `a_l_desc` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '接口介绍',
  `a_l_keyword` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '接口关键字',
  `a_l_alias` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '接口别名',
  `a_l_address` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '接口地址',
  `a_l_format` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '返回格式',
  `a_l_mode` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '请求方式',
  `a_l_ask` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '请求示例',
  `a_l_demo` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '调用示例',
  `a_l_example` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '返回示例',
  `a_l_data` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '数据绑定',
  `a_l_show` int(10) NOT NULL DEFAULT 0 COMMENT '上架状态',
  `a_l_found_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '添加时间',
  `a_l_count` int(10) NOT NULL DEFAULT 0 COMMENT '调用次数',
  `a_l_pay` int(10) NOT NULL DEFAULT 0 COMMENT '是否收费',
  PRIMARY KEY (`a_l_id`, `a_l_title`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of api_info
-- ----------------------------

-- ----------------------------
-- Table structure for api_kami
-- ----------------------------
DROP TABLE IF EXISTS `api_kami`;
CREATE TABLE `api_kami`  (
  `a_k_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '卡密表',
  `a_k_content` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '卡密',
  `a_k_money` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '余额',
  `a_k_state` int(2) NOT NULL DEFAULT 1 COMMENT '1未使用 2已使用',
  `a_k_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '添加时间',
  `a_u_name` varchar(18) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '使用用户',
  PRIMARY KEY (`a_k_id`) USING BTREE,
  INDEX `kami`(`a_k_content`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of api_kami
-- ----------------------------

-- ----------------------------
-- Table structure for api_order
-- ----------------------------
DROP TABLE IF EXISTS `api_order`;
CREATE TABLE `api_order`  (
  `o_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `o_u_id` int(10) NOT NULL COMMENT '用户ID',
  `o_l_id` int(10) NOT NULL COMMENT '接口id',
  `o_title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '接口名',
  `o_pay_no` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '订单号',
  `o_type` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1' COMMENT '消费类型',
  `o_price` int(10) NOT NULL COMMENT '购买价格',
  `o_expire` bigint(11) NOT NULL DEFAULT 0 COMMENT '到期时间',
  `o_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '订单时间',
  PRIMARY KEY (`o_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of api_order
-- ----------------------------

-- ----------------------------
-- Table structure for api_owned
-- ----------------------------
DROP TABLE IF EXISTS `api_owned`;
CREATE TABLE `api_owned`  (
  `ow_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `ow_u_id` int(10) NOT NULL COMMENT '用户id',
  `ow_l_id` int(10) NOT NULL COMMENT '接口id',
  `ow_md5` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密钥',
  `ow_ip` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '白名单',
  `ow_count` int(10) NOT NULL DEFAULT 0 COMMENT '统计',
  `ow_start_time` bigint(11) NOT NULL DEFAULT 0 COMMENT '开始时间',
  `ow_end_time` bigint(11) NOT NULL DEFAULT 0 COMMENT '到期时间',
  `ow_found_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  PRIMARY KEY (`ow_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of api_owned
-- ----------------------------

-- ----------------------------
-- Table structure for api_parameter
-- ----------------------------
DROP TABLE IF EXISTS `api_parameter`;
CREATE TABLE `api_parameter`  (
  `a_p_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `a_p_api_id` int(10) NOT NULL COMMENT '接口id',
  `a_p_api_type` int(1) NOT NULL COMMENT '参数类型 0请求 1返回 2错误',
  `a_p_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '参数名称',
  `a_p_type` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '参数类型',
  `a_p_desc` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '参数说明',
  `a_p_crux` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '是否关键',
  `a_p_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '添加时间',
  PRIMARY KEY (`a_p_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of api_parameter
-- ----------------------------

-- ----------------------------
-- Table structure for api_price
-- ----------------------------
DROP TABLE IF EXISTS `api_price`;
CREATE TABLE `api_price`  (
  `p_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `p_month` float NOT NULL DEFAULT 0 COMMENT '月费用',
  `p_season` float NOT NULL DEFAULT 0 COMMENT '季费用',
  `p_year` float NOT NULL DEFAULT 0 COMMENT '年费用',
  `p_l_id` int(10) NOT NULL COMMENT '接口id',
  PRIMARY KEY (`p_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = FIXED;

-- ----------------------------
-- Records of api_price
-- ----------------------------

-- ----------------------------
-- Table structure for api_user
-- ----------------------------
DROP TABLE IF EXISTS `api_user`;
CREATE TABLE `api_user`  (
  `a_u_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `a_u_name` varchar(18) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户账户',
  `a_u_passwd` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户密码',
  `a_u_email` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户邮箱',
  `a_u_balance` float NOT NULL DEFAULT 0 COMMENT '用户余额',
  `a_u_found_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '注册时间',
  `a_u_state` int(5) NOT NULL COMMENT '用户状态',
  INDEX `a_u_id`(`a_u_id`) USING BTREE,
  INDEX `a_u_name`(`a_u_name`) USING BTREE,
  INDEX `a_u_found_time`(`a_u_found_time`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of api_user
-- ----------------------------

-- ----------------------------
-- Table structure for api_whitelist
-- ----------------------------
DROP TABLE IF EXISTS `api_whitelist`;
CREATE TABLE `api_whitelist`  (
  `a_w_id` int(10) NOT NULL AUTO_INCREMENT,
  `w_ow_id` int(10) NULL DEFAULT NULL,
  `w_u_id` int(10) NULL DEFAULT NULL,
  `w_l_id` int(10) NULL DEFAULT NULL,
  `w_ip` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`a_w_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of api_whitelist
-- ----------------------------

-- ----------------------------
-- Table structure for codepay_order
-- ----------------------------
DROP TABLE IF EXISTS `codepay_order`;
CREATE TABLE `codepay_order`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pay_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户ID或订单ID',
  `money` decimal(6, 2) UNSIGNED NOT NULL COMMENT '实际金额',
  `price` decimal(6, 2) UNSIGNED NOT NULL COMMENT '原价',
  `type` int(1) NOT NULL DEFAULT 1 COMMENT '支付方式',
  `pay_no` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '流水号',
  `param` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '自定义参数',
  `pay_time` bigint(11) NOT NULL DEFAULT 0 COMMENT '付款时间',
  `pay_tag` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '金额的备注',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '订单状态',
  `creat_time` bigint(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `up_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `main`(`pay_id`, `pay_time`, `money`, `type`, `pay_tag`) USING BTREE,
  UNIQUE INDEX `pay_no`(`pay_no`, `type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用于区分是否已经处理' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of codepay_order
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
