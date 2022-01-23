/*
 Navicat Premium Data Transfer

 Source Server         : mamp
 Source Server Type    : MySQL
 Source Server Version : 50724
 Source Host           : localhost:3306
 Source Schema         : stroom

 Target Server Type    : MySQL
 Target Server Version : 50724
 File Encoding         : 65001

 Date: 23/01/2022 13:32:39
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for agen
-- ----------------------------
DROP TABLE IF EXISTS `agen`;
CREATE TABLE `agen`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `fee` double NULL DEFAULT NULL,
  `saldo` double NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of agen
-- ----------------------------
INSERT INTO `agen` VALUES (1, 3, 2500, 1000000);

-- ----------------------------
-- Table structure for migration
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration`  (
  `version` varchar(180) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `apply_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`version`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migration
-- ----------------------------
INSERT INTO `migration` VALUES ('m000000_000000_base', 1642274621);
INSERT INTO `migration` VALUES ('m130524_201442_init', 1642274637);
INSERT INTO `migration` VALUES ('m190124_110200_add_verification_token_column_to_user_table', 1642274637);
INSERT INTO `migration` VALUES ('m220115_195858_create_tarif_table', 1642277060);
INSERT INTO `migration` VALUES ('m220115_201734_create_golongan_table', 1642282666);

-- ----------------------------
-- Table structure for pelanggan
-- ----------------------------
DROP TABLE IF EXISTS `pelanggan`;
CREATE TABLE `pelanggan`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(14) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `no_meter` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nama` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `alamat` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tenggang` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tarif_id` int(11) NOT NULL,
  `uuid` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pelanggan
-- ----------------------------
INSERT INTO `pelanggan` VALUES (1, '20220122042720', '021220160421', 'Arief Rahman', 'Pontianak', '22', 5, '82353f18-ad59-4759-abc6-9c9b502a8dac');

-- ----------------------------
-- Table structure for pembayaran
-- ----------------------------
DROP TABLE IF EXISTS `pembayaran`;
CREATE TABLE `pembayaran`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tgl_bayar` datetime NOT NULL,
  `jumlah_tagihan` double NOT NULL,
  `biaya_admin` double NOT NULL,
  `total_bayar` double NOT NULL,
  `bayar` double NOT NULL,
  `kembalian` double NOT NULL,
  `agen_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pembayaran
-- ----------------------------

-- ----------------------------
-- Table structure for pembayaran_detail
-- ----------------------------
DROP TABLE IF EXISTS `pembayaran_detail`;
CREATE TABLE `pembayaran_detail`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pembayaran_id` int(11) NULL DEFAULT NULL,
  `tagihan_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pembayaran_detail
-- ----------------------------

-- ----------------------------
-- Table structure for penggunaan
-- ----------------------------
DROP TABLE IF EXISTS `penggunaan`;
CREATE TABLE `penggunaan`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pelanggan_id` int(11) NOT NULL,
  `bulan` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tahun` year NOT NULL,
  `meter_awal` int(11) NOT NULL,
  `meter_akhir` int(11) NOT NULL DEFAULT 0,
  `tgl_cek` date NULL DEFAULT NULL,
  `petugas_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of penggunaan
-- ----------------------------
INSERT INTO `penggunaan` VALUES (1, '20220122042720012022', 1, '01', 2022, 0, 100, '2022-01-23', 1);

-- ----------------------------
-- Table structure for tagihan
-- ----------------------------
DROP TABLE IF EXISTS `tagihan`;
CREATE TABLE `tagihan`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pelanggan_id` int(11) NOT NULL,
  `bulan` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tahun` year NOT NULL,
  `jumlah_meter` int(11) NOT NULL,
  `tarif_perkwh` double NOT NULL DEFAULT 0,
  `total_bayar` double NOT NULL DEFAULT 0,
  `data` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `petugas_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tagihan
-- ----------------------------
INSERT INTO `tagihan` VALUES (2, '0b86df4d-9cc8-4e83-9922-3a0f2df81e68', 1, '01', 2022, 100, 750, 75000, '{\"tarif\":{\"kode\":\"R2\\/450VA\",\"daya\":\"450VA\",\"tarif_perkwh\":750}}', 0, 1);

-- ----------------------------
-- Table structure for tarif
-- ----------------------------
DROP TABLE IF EXISTS `tarif`;
CREATE TABLE `tarif`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `golongan` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `daya` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tarif_perkwh` double NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tarif
-- ----------------------------
INSERT INTO `tarif` VALUES (3, 'R3/450VA', 'R3', '450VA', 1000);
INSERT INTO `tarif` VALUES (4, 'R1/900VA', 'R1', '900VA', 1500);
INSERT INTO `tarif` VALUES (5, 'R2/450VA', 'R2', '450VA', 750);
INSERT INTO `tarif` VALUES (8, 'R2/900VA', 'R2', '900VA', 1500);
INSERT INTO `tarif` VALUES (9, 'B1/1500VA', 'B1', '1500VA', 2000);
INSERT INTO `tarif` VALUES (10, 'R3/900VA', 'R3', '900VA', 1400);
INSERT INTO `tarif` VALUES (13, 'R1/450VA', 'R1', '450VA', 1000);
INSERT INTO `tarif` VALUES (16, 'R3/1300VA', 'R3', '1300VA', 1500);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT 10,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `role` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE,
  UNIQUE INDEX `email`(`email`) USING BTREE,
  UNIQUE INDEX `password_reset_token`(`password_reset_token`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'admin', 'z3CqAXmBR3hR-jJeKu32CwMEAuN1IQLo', '$2y$13$aLwWFLLpRbZdHZFsMecsHOlvF3.TTk0M5NWIoSmqCrn04HqZgTsMG', NULL, 'admin@example.com', 1, 1642275328, 1642275328, 'HdEtreKFg7_hbJnJvC8dn2hPGqaktEiC_1642275328', 'admin');
INSERT INTO `user` VALUES (2, 'petugas001', 'CVgkq3nJgsFV4YZyJi_KcjTw2KOKHE0f', '$2y$13$gV9owmlok9t/PlAVPzZCYu48d/QMgv1vXBzJgjDtUmShUIV0r5HhW', NULL, 'petugas001@example.com', 1, 1642275677, 1642275677, 'KAsJdBFOlWaKMys5gvVAydZqVnxN-bdA_1642275677', 'petugas');
INSERT INTO `user` VALUES (3, 'agen001', 'ekPX9Ndb_QIWb25HZeJ5U98gR4briI_k', '$2y$13$D5waZn83xYQaJlDyOGzY0u3D7fcz.Mj.kGTaDHi9FrmLhxodY2Bqm', NULL, 'agen001@example.com', 1, 1642829399, 1642829399, 'b_PofMu2on9g0TueYktnD5JebJKC4EDH_1642829399', NULL);

SET FOREIGN_KEY_CHECKS = 1;
