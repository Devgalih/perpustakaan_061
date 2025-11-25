-- -----------------------------------------------------
-- Schema: Perpustakaan
-- -----------------------------------------------------

CREATE DATABASE IF NOT EXISTS perpustakaan
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE perpustakaan;

CREATE TABLE admin (
  id_admin INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(100) UNIQUE,
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  nama_lengkap VARCHAR(100)
) ENGINE = InnoDB;

CREATE TABLE anggota (
  id_anggota INT AUTO_INCREMENT PRIMARY KEY,
  nama_lengkap VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255) NOT NULL,
  alamat VARCHAR(255),
  no_telepon VARCHAR(20)
) ENGINE = InnoDB;

CREATE TABLE buku (
  id_buku INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(150) NOT NULL,
  penulis VARCHAR(100),
  penerbit VARCHAR(100),
  tahun_terbit INT,
  stok INT DEFAULT 0
) ENGINE = InnoDB;

CREATE TABLE kategori (
  id_kategori INT AUTO_INCREMENT PRIMARY KEY,
  nama_kategori VARCHAR(100) NOT NULL UNIQUE
) ENGINE = InnoDB;

CREATE TABLE buku_kategori (
  id_buku INT NOT NULL,
  id_kategori INT NOT NULL,
  PRIMARY KEY (id_buku, id_kategori),
  CONSTRAINT fk_buku_kategori_buku FOREIGN KEY (id_buku)
    REFERENCES buku (id_buku)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_buku_kategori_kategori FOREIGN KEY (id_kategori)
    REFERENCES kategori (id_kategori)
    ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE booking (
  id_booking INT AUTO_INCREMENT PRIMARY KEY,
  tanggal_booking DATE NOT NULL,
  status VARCHAR(50) DEFAULT 'pending',
  id_anggota INT NOT NULL,
  id_buku INT NOT NULL,
  CONSTRAINT fk_booking_anggota FOREIGN KEY (id_anggota)
    REFERENCES anggota (id_anggota)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_booking_buku FOREIGN KEY (id_buku)
    REFERENCES buku (id_buku)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE = InnoDB;

CREATE TABLE peminjaman (
  id_peminjaman INT AUTO_INCREMENT PRIMARY KEY,
  tanggal_pinjam DATE NOT NULL,
  tanggal_kembali DATE,
  status VARCHAR(50) DEFAULT 'dipinjam',
  id_anggota INT NOT NULL,
  id_buku INT NOT NULL,
  CONSTRAINT fk_peminjaman_anggota FOREIGN KEY (id_anggota)
    REFERENCES anggota (id_anggota)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_peminjaman_buku FOREIGN KEY (id_buku)
    REFERENCES buku (id_buku)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE = InnoDB;

