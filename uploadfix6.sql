-- Adminer 4.3.1 MySQL dump
SET NAMES utf8;
SET time_zone = '+00:00';

DROP TABLE IF EXISTS `jadwal_kelas`;
CREATE TABLE `jadwal_kelas` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `kode_ujian` VARCHAR(255) DEFAULT NULL COMMENT 'generate',
  `nama_dosen` VARCHAR(255) DEFAULT NULL COMMENT 'nama pjmk',
  `matakuliah` VARCHAR(255) DEFAULT NULL,
  `prodi` VARCHAR(255) DEFAULT NULL,
  `ruang_ujian` VARCHAR(255) DEFAULT NULL COMMENT 'kelas / ruang prakt',
  `tanggal` DATE DEFAULT NULL COMMENT 'tanggal ujian',
  `batas_waktu` DATETIME DEFAULT NULL COMMENT 'batas akhir ujian',
  `jenis_ujian` INT(1) DEFAULT '1' COMMENT '1=upload;2=pil.ganda;3=all',
  `is_aktif` INT(1) DEFAULT '0' COMMENT '1:aktif;',
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `jawaban_siswa`;
CREATE TABLE `jawaban_siswa` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `mahasiswa_id` BIGINT(20) NOT NULL,
  `no_soal` INT(1) NOT NULL,
  `jawaban` INT(1) NOT NULL,
  `ip_address` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `kunci_jawaban`;
CREATE TABLE `kunci_jawaban` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `jadwal_kelas_id` BIGINT(20) NOT NULL,
  `tipe_soal` INT(1) DEFAULT NULL,
  `no_soal` INT(1) NOT NULL,
  `jawaban` INT(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jadwal_kelas_id` (`jadwal_kelas_id`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `mahasiswa`;
CREATE TABLE `mahasiswa` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `jadwal_kelas_id` BIGINT(20) NOT NULL,
  `tipe_soal` INT(1) DEFAULT NULL,
  `nim` VARCHAR(255) DEFAULT NULL,
  `nama` VARCHAR(255) DEFAULT NULL,
  `ip_address` VARCHAR(255) DEFAULT NULL,
  `skor` FLOAT DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `jadwal_kelas_id` (`jadwal_kelas_id`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(256) NOT NULL,
  `username` VARCHAR(256) NOT NULL,
  `password` VARCHAR(1024) NOT NULL,
  `flag_role_id` INT(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `user_role`;
CREATE TABLE `user_role` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT(20) NOT NULL,
  `role_id` BIGINT(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;

INSERT INTO USER SET id=1,`name`='admin',username='admin',`password`=MD5('admin');
-- 2017-06-06 06:39:50

ALTER TABLE jadwal_kelas ADD COLUMN nilai_salah FLOAT DEFAULT 0 AFTER jenis_ujian;
ALTER TABLE jadwal_kelas ADD COLUMN nilai_benar FLOAT DEFAULT 0 AFTER jenis_ujian;

ALTER TABLE mahasiswa ADD COLUMN tidak_menjawab int(2) DEFAULT 0 AFTER skor;
ALTER TABLE mahasiswa ADD COLUMN salah int(2) DEFAULT 0 AFTER skor;
ALTER TABLE mahasiswa ADD COLUMN benar int(2) DEFAULT 0 AFTER skor;

----------------------------