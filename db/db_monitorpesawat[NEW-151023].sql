-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Okt 2023 pada 04.39
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_monitorpesawat`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_jam_terbang`
--

CREATE TABLE `data_jam_terbang` (
  `jamter_id` int(11) NOT NULL,
  `pesawat_id` char(36) NOT NULL,
  `pengguna_id` char(36) NOT NULL,
  `tanggalwaktu_terbang` int(11) NOT NULL,
  `tujuan_penerbangan` text NOT NULL,
  `status_jamterbang` enum('menunggu','digunakan','selesai') NOT NULL,
  `waktu_ditambahkan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_jam_terbang`
--

INSERT INTO `data_jam_terbang` (`jamter_id`, `pesawat_id`, `pengguna_id`, `tanggalwaktu_terbang`, `tujuan_penerbangan`, `status_jamterbang`, `waktu_ditambahkan`) VALUES
(1, '2ad43787-ec3b-4a6a-805f-e41dbb104390', '54ec54e2-54f4-11ee-b395-f02f74a66517', 1696944180, 'Pelatihan 001', 'selesai', 1696540498),
(2, '2ad43787-ec3b-4a6a-805f-e41dbb184390', '54ec54e2-54f4-11ee-b395-f02f74a66517', 1696944180, 'Pelatihan C001', 'selesai', 1696540514),
(3, '2ad43787-ec3b-4a6a-805f-e41dbb104390', '54ec54e2-54f4-11ee-b395-f02f74a66517', 1697116980, 'Pelatihan 002', 'selesai', 1696540986),
(4, '2ad43787-ec3b-4a6a-805f-e41dbb184390', '54ec54e2-54f4-11ee-b395-f02f74a66517', 1697289780, 'Pelatihan C0045', 'selesai', 1696541769),
(5, '2ad43787-ec3v-4a6a-805f-e41dbb104391', '54ec54e2-54f4-11ee-b395-f02f74a66517', 1696944180, 'Uji Coba Pesawat', 'selesai', 1696541794),
(6, '2ad43787-ec3b-4a6a-805f-e41dbb104390', '54ec54e2-54f4-11ee-b395-f02f74a66517', 1697808180, 'Pengujian Terakhir', 'selesai', 1696542107),
(7, '2ad43787-ec3v-4b6b-805f-e41dbb104391', '54ec54e2-54f4-11ee-b395-f02f74a66517', 1698672180, 'Log Test', 'menunggu', 1696542571),
(8, '2ad43787-ec3v-4a6a-805f-e41dbb104391', '54ec54e2-54f4-11ee-b395-f02f74a66517', 1698585780, 'Pelatihan HJ03', 'menunggu', 1696542601),
(9, '2ad43787-ec3b-4a6a-805f-e41dbb184390', '54ec54e2-54f4-11ee-b395-f02f74a66517', 1698758580, 'Log Test 34', 'selesai', 1696542703),
(10, '2ad43787-ec3v-4a6a-805f-e41dbb104391', '54ec54e2-54f4-11ee-b395-f02f74a66517', 1697808180, 'Log Test 343', 'selesai', 1696561989);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_laporanpesawat`
--

CREATE TABLE `data_laporanpesawat` (
  `lapor_id` int(11) NOT NULL,
  `pesawat_id` char(36) NOT NULL,
  `pelapor_id` char(36) NOT NULL,
  `teknisi_id` char(36) DEFAULT NULL,
  `keterangan_laporan` text NOT NULL,
  `gambar_laporan` varchar(30) DEFAULT NULL,
  `waktu_ditambahkan` int(11) NOT NULL,
  `status_laporan` enum('menunggu','telah-dikonfirmasi') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_laporanpesawat`
--

INSERT INTO `data_laporanpesawat` (`lapor_id`, `pesawat_id`, `pelapor_id`, `teknisi_id`, `keterangan_laporan`, `gambar_laporan`, `waktu_ditambahkan`, `status_laporan`) VALUES
(4, '2ad43787-ec3v-4a6a-805f-e41dbb104391', '54ec54e2-54f4-11ee-b395-f02f74a90517', '54ec54e2-54f4-11ee-b395-f02f74a90517', 'asdasdasdas', '652b1e84e4ccf.jpg', 1697324676, 'telah-dikonfirmasi'),
(5, '2ad43787-ec3v-4a6a-805f-e41dbb104391', '54ec54e2-54f4-11ee-b395-f02f74a90517', NULL, 'Ban pesawat terasa kempes mohon teknisi check', '-', 1697336757, 'menunggu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_maintenanceinspection`
--

CREATE TABLE `data_maintenanceinspection` (
  `minspect_id` int(11) NOT NULL,
  `jenis_inspeksi` enum('50jam','100jam','300jam','400jam','500jam','1000jam','2000jam') NOT NULL,
  `jenis_maintenance` enum('engine','propeller') NOT NULL,
  `pesawat_id` char(36) NOT NULL,
  `teknisi_id` char(36) NOT NULL,
  `total_time_inair` int(11) NOT NULL,
  `aircraft_jam` int(11) NOT NULL,
  `engine_jam` int(11) NOT NULL,
  `propeller_jam` int(11) NOT NULL,
  `landing_jumlah` int(11) NOT NULL,
  `tanggal_inspeksi` date NOT NULL,
  `catatan_inspeksi` text NOT NULL,
  `status_inspeksi` enum('selesai','diproses') DEFAULT NULL,
  `waktu_ditambahkan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_maintenanceinspection`
--

INSERT INTO `data_maintenanceinspection` (`minspect_id`, `jenis_inspeksi`, `jenis_maintenance`, `pesawat_id`, `teknisi_id`, `total_time_inair`, `aircraft_jam`, `engine_jam`, `propeller_jam`, `landing_jumlah`, `tanggal_inspeksi`, `catatan_inspeksi`, `status_inspeksi`, `waktu_ditambahkan`) VALUES
(1, '50jam', 'engine', '2ad43787-ec3b-4a6a-805f-e41dbb184390', '54ec54e2-54f4-11ee-b395-f02f74a90518', 2546, 2546, 2546, 2546, 23, '2023-10-13', 'Inspeksi rutin', 'selesai', 1696541965),
(2, '50jam', 'engine', '2ad43787-ec3v-4a6a-805f-e41dbb104391', '54ec54e2-54f4-11ee-b395-f02f74a90518', 2615, 2615, 2615, 2615, 24, '2023-10-21', '-', 'selesai', 1696562239);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_maintenancelog`
--

CREATE TABLE `data_maintenancelog` (
  `maintenance_id` int(11) NOT NULL,
  `pesawat_id` char(36) NOT NULL,
  `jamter_id` int(11) DEFAULT NULL,
  `tanggal_terbang` date NOT NULL,
  `waktu_diudara` int(11) NOT NULL,
  `jumlah_pendaratan` int(11) NOT NULL,
  `pengguna_id` char(36) NOT NULL,
  `tujuan_penerbangan` varchar(150) NOT NULL,
  `catatan` text DEFAULT NULL,
  `jumlah_aircraft` int(11) NOT NULL,
  `jumlah_engine` int(11) NOT NULL,
  `jumlah_engine_numberlanding` int(11) NOT NULL,
  `jumlah_propeller` int(11) NOT NULL,
  `total_waktu_aircraft` int(11) NOT NULL,
  `total_waktu_engine` int(11) NOT NULL,
  `total_engine_numberlanding` int(11) NOT NULL,
  `total_waktu_propeller` int(11) NOT NULL,
  `waktu_ditambahkan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_maintenancelog`
--

INSERT INTO `data_maintenancelog` (`maintenance_id`, `pesawat_id`, `jamter_id`, `tanggal_terbang`, `waktu_diudara`, `jumlah_pendaratan`, `pengguna_id`, `tujuan_penerbangan`, `catatan`, `jumlah_aircraft`, `jumlah_engine`, `jumlah_engine_numberlanding`, `jumlah_propeller`, `total_waktu_aircraft`, `total_waktu_engine`, `total_engine_numberlanding`, `total_waktu_propeller`, `waktu_ditambahkan`) VALUES
(1, '2ad43787-ec3b-4a6a-805f-e41dbb104390', 1, '2023-10-10', 67, 5, '54ec54e2-54f4-11ee-b395-f02f74a66517', 'Pelatihan 001', '-', 0, 0, 0, 0, 67, 67, 5, 67, 1696540920),
(2, '2ad43787-ec3b-4a6a-805f-e41dbb184390', 2, '2023-10-10', 2546, 23, '54ec54e2-54f4-11ee-b395-f02f74a66517', 'Pelatihan C001', '-', 0, 0, 0, 0, 2546, 2546, 23, 2546, 1696541536),
(3, '2ad43787-ec3b-4a6a-805f-e41dbb104390', 3, '2023-10-12', 98, 5, '54ec54e2-54f4-11ee-b395-f02f74a66517', 'Pelatihan 002', '-', 67, 67, 5, 67, 165, 165, 10, 165, 1696541707),
(4, '2ad43787-ec3v-4a6a-805f-e41dbb104391', 5, '2023-10-10', 65, 3, '54ec54e2-54f4-11ee-b395-f02f74a66517', 'Uji Coba Pesawat', '-', 0, 0, 0, 0, 65, 65, 3, 65, 1696541874),
(5, '2ad43787-ec3b-4a6a-805f-e41dbb184390', 4, '2023-10-14', 34, 3, '54ec54e2-54f4-11ee-b395-f02f74a66517', 'Pelatihan C0045', '-', 2546, 2546, 23, 2546, 2580, 2580, 26, 2580, 1696542000),
(6, '2ad43787-ec3b-4a6a-805f-e41dbb104390', 6, '2023-10-20', 2300, 45, '54ec54e2-54f4-11ee-b395-f02f74a66517', 'Pengujian Terakhir', 'Test Show Maintenance', 165, 165, 10, 165, 2465, 2465, 55, 2465, 1696542160),
(7, '2ad43787-ec3b-4a6a-805f-e41dbb184390', 9, '2023-10-31', 3400, 34, '54ec54e2-54f4-11ee-b395-f02f74a66517', 'Log Test 34', '-', 2580, 2580, 26, 2580, 5980, 5980, 60, 5980, 1696542746),
(8, '2ad43787-ec3v-4a6a-805f-e41dbb104391', 10, '2023-10-20', 2550, 21, '54ec54e2-54f4-11ee-b395-f02f74a66517', 'Log Test 343', '-', 65, 65, 3, 65, 2615, 2615, 24, 2615, 1696562181);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_pengguna`
--

CREATE TABLE `data_pengguna` (
  `pengguna_id` char(36) NOT NULL,
  `email_pengguna` varchar(50) NOT NULL,
  `password_pengguna` varchar(100) NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') NOT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jabatan` varchar(40) NOT NULL,
  `status_akun` enum('aktif','tidak-aktif') NOT NULL,
  `level_akun` enum('admin','pilot','enginer','supervisor') NOT NULL,
  `foto_profile` varchar(30) NOT NULL DEFAULT 'default.jpg',
  `waktu_terdaftar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_pengguna`
--

INSERT INTO `data_pengguna` (`pengguna_id`, `email_pengguna`, `password_pengguna`, `nama_lengkap`, `no_hp`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `jabatan`, `status_akun`, `level_akun`, `foto_profile`, `waktu_terdaftar`) VALUES
('54ec54e2-54f4-11ee-b395-f02f74a66517', 'andri@mail.com', '$2y$10$zQNlvMvvWt3xG6kl0FwuDuLlYfcqLLjqhGbBI1v2FLXU9ShmrqQcS', 'Andri Pilot', '20893742', 'laki-laki', 'Duri', '2023-10-17', 'Co-Pilot', 'aktif', 'pilot', 'default.jpg', 0),
('54ec54e2-54f4-11ee-b395-f02f74a90517', 'admin@gmail.com', '$2y$10$QyWFunm3HKEIqypyEguyXuBWbGYWYweIIPysZYIt3rXcNf4.QnKR6', 'Administrators', '085243557896', 'perempuan', 'Palembangs', '1994-07-13', 'Developer Sistem', 'aktif', 'admin', 'default.jpg', 1691174891),
('54ec54e2-54f4-11ee-b395-f02f74a90518', 'teknisi@gmail.com', '$2y$10$RNJvS7EkpIo6kN9VJOFFjubyRI7ip0ylPpa9.DDcuqeEok857zXXm', 'Teknisi Pesawat I', '081243557896', 'laki-laki', 'Palembang', '1990-09-01', 'Teknisi Pesawat', 'aktif', 'enginer', 'default.jpg', 1691174891),
('8fea2ac8-8796-47f4-96b4-41ebfbc0cf69', 'david@mail.com', '$2y$10$zKUSBawfiQsDVMCQg9N0GeDrBC2cPbq4vFlEjeepuraHSCGWn33oS', 'David Hendra', '0817263234', 'laki-laki', 'Pekanbaru', '2023-10-06', 'Head Supervisor', 'aktif', 'supervisor', 'default.jpg', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_pesawat`
--

CREATE TABLE `data_pesawat` (
  `pesawat_id` char(36) NOT NULL,
  `kode_pesawat` varchar(25) NOT NULL,
  `nomor_registrasi` varchar(50) NOT NULL,
  `nama_pesawat` varchar(50) NOT NULL,
  `max_lifetime` int(11) NOT NULL,
  `total_time_inair` int(11) NOT NULL,
  `time_since_overhaul` int(11) NOT NULL,
  `aircraft_time` int(11) NOT NULL,
  `engine_time` int(11) NOT NULL,
  `engine_numberlanding` int(11) NOT NULL,
  `propeller_time` int(11) NOT NULL,
  `gambar_pesawat` text NOT NULL,
  `keterangan` text NOT NULL,
  `riwayat_maintenance` text NOT NULL DEFAULT '{"mt50":0,"mt100":0,"mt300":0,"mt400":0,"mt500":0,"mt1000":0,"mt2000":0}',
  `status_pesawat` enum('aktif','tidak-aktif','maintenance') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_pesawat`
--

INSERT INTO `data_pesawat` (`pesawat_id`, `kode_pesawat`, `nomor_registrasi`, `nama_pesawat`, `max_lifetime`, `total_time_inair`, `time_since_overhaul`, `aircraft_time`, `engine_time`, `engine_numberlanding`, `propeller_time`, `gambar_pesawat`, `keterangan`, `riwayat_maintenance`, `status_pesawat`) VALUES
('2ad43787-ec3b-4a6a-805f-e41dbb104390', 'Piper Acher III PA 28-181', 'PK-ARA', 'LATIK', 2000, 2465, 0, 2465, 2465, 55, 2465, '651f258492cab.jpg', '-', '{\"mt50\":0,\"mt100\":0,\"mt300\":0,\"mt400\":0,\"mt500\":0,\"mt1000\":0,\"mt2000\":0}', 'aktif'),
('2ad43787-ec3b-4a6a-805f-e41dbb184390', 'Piper Acher III PA 28-181', 'PK-ARG', 'LATIK', 2000, 5980, 0, 5980, 5980, 60, 5980, '651f258492cab.jpg', '-', '{\"mt50\":\"2546\",\"mt100\":0,\"mt300\":0,\"mt400\":0,\"mt500\":0,\"mt1000\":0,\"mt2000\":0}', 'aktif'),
('2ad43787-ec3v-4a6a-805f-e41dbb104391', 'Piper Acher III PA 28-181', 'PK-ARC', 'LATIK', 2000, 2615, 0, 2615, 2615, 24, 2615, '651f258492cab.jpg', '-', '{\"mt50\":\"2615\",\"mt100\":0,\"mt300\":0,\"mt400\":0,\"mt500\":0,\"mt1000\":0,\"mt2000\":0}', 'maintenance'),
('2ad43787-ec3v-4b6b-805f-e41dbb104391', 'Piper Acher III PA 28-181', 'PK-ARJ', 'LATIK', 2000, 0, 0, 0, 0, 0, 0, '651f258492cab.jpg', '-', '{\"mt50\":0,\"mt100\":0,\"mt300\":0,\"mt400\":0,\"mt500\":0,\"mt1000\":0,\"mt2000\":0}', 'aktif');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `data_jam_terbang`
--
ALTER TABLE `data_jam_terbang`
  ADD PRIMARY KEY (`jamter_id`),
  ADD KEY `pesawat_id` (`pesawat_id`),
  ADD KEY `pengguna_id` (`pengguna_id`);

--
-- Indeks untuk tabel `data_laporanpesawat`
--
ALTER TABLE `data_laporanpesawat`
  ADD PRIMARY KEY (`lapor_id`),
  ADD KEY `pelapor_id` (`pelapor_id`),
  ADD KEY `teknisi_id` (`teknisi_id`),
  ADD KEY `pesawat_id` (`pesawat_id`);

--
-- Indeks untuk tabel `data_maintenanceinspection`
--
ALTER TABLE `data_maintenanceinspection`
  ADD PRIMARY KEY (`minspect_id`),
  ADD KEY `pesawat_id` (`pesawat_id`),
  ADD KEY `teknisi_id` (`teknisi_id`);

--
-- Indeks untuk tabel `data_maintenancelog`
--
ALTER TABLE `data_maintenancelog`
  ADD PRIMARY KEY (`maintenance_id`),
  ADD KEY `noreg_pesawat` (`pesawat_id`),
  ADD KEY `pengguna_id` (`pengguna_id`),
  ADD KEY `jamter_id` (`jamter_id`);

--
-- Indeks untuk tabel `data_pengguna`
--
ALTER TABLE `data_pengguna`
  ADD PRIMARY KEY (`pengguna_id`);

--
-- Indeks untuk tabel `data_pesawat`
--
ALTER TABLE `data_pesawat`
  ADD PRIMARY KEY (`pesawat_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_jam_terbang`
--
ALTER TABLE `data_jam_terbang`
  MODIFY `jamter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `data_laporanpesawat`
--
ALTER TABLE `data_laporanpesawat`
  MODIFY `lapor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `data_maintenanceinspection`
--
ALTER TABLE `data_maintenanceinspection`
  MODIFY `minspect_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `data_maintenancelog`
--
ALTER TABLE `data_maintenancelog`
  MODIFY `maintenance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `data_jam_terbang`
--
ALTER TABLE `data_jam_terbang`
  ADD CONSTRAINT `data_jam_terbang_ibfk_1` FOREIGN KEY (`pengguna_id`) REFERENCES `data_pengguna` (`pengguna_id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `data_maintenanceinspection`
--
ALTER TABLE `data_maintenanceinspection`
  ADD CONSTRAINT `data_maintenanceinspection_ibfk_1` FOREIGN KEY (`teknisi_id`) REFERENCES `data_pengguna` (`pengguna_id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `data_maintenancelog`
--
ALTER TABLE `data_maintenancelog`
  ADD CONSTRAINT `data_maintenancelog_ibfk_1` FOREIGN KEY (`pesawat_id`) REFERENCES `data_pesawat` (`pesawat_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `data_maintenancelog_ibfk_2` FOREIGN KEY (`pengguna_id`) REFERENCES `data_pengguna` (`pengguna_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
