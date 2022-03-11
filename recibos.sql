/*
 Navicat Premium Data Transfer

 Source Server         : 192.168.0.229
 Source Server Type    : MySQL
 Source Server Version : 100417
 Source Host           : 192.168.0.229:3306
 Source Schema         : wings

 Target Server Type    : MySQL
 Target Server Version : 100417
 File Encoding         : 65001

 Date: 20/03/2021 19:26:03
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for recibos
-- ----------------------------
DROP TABLE IF EXISTS `recibos`;
CREATE TABLE `recibos`  (
  `id_recibo` int(255) NOT NULL AUTO_INCREMENT,
  `id_cc` int(255) NULL DEFAULT NULL,
  `id_alumno` int(11) NULL DEFAULT NULL,
  `nro_recibo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `activo` int(255) NULL DEFAULT NULL,
  `id_pago` int(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id_recibo`) USING BTREE,
  INDEX `alumno`(`id_alumno`) USING BTREE,
  INDEX `recibo`(`nro_recibo`) USING BTREE,
  INDEX `cc`(`id_cc`) USING BTREE,
  INDEX `pago`(`id_pago`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
