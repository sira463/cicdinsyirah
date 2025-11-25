-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2025 at 05:35 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kontak_sederhana`
--

-- --------------------------------------------------------

--
-- Table structure for table `kontak`
--

CREATE TABLE `kontak` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kontak`
--

INSERT INTO `kontak` (`id`, `nama`, `telepon`, `email`) VALUES
(124, 'Andi Setiawan', '08123456789', 'andi@gmail.com'),
(125, 'Budi Santoso', '082345', ''),
(126, 'zizah', '081234567801', 'ahmad.fauzi@gmail.com'),
(127, 'insyirah', '081234567802', 'budi.santoso@gmail.com'),
(128, 'Dewi', '081234567803', 'citra.dewi@gmail.com'),
(129, 'Pratama', '081234567804', 'dedi.pratama@gmail.com'),
(130, 'Eka Saputra', '081234567805', 'eka.saputra@gmail.com'),
(131, 'hhhhhhh', '081234567806', ''),
(132, 'Galih Permana', '081234567807', 'galih.permana@gmail.com'),
(133, 'Hani Wulandari', '081234567808', 'hani.wulandari@gmail.com'),
(134, 'Indra Lesmana', '081234567809', 'indra.lesmana@gmail.com'),
(135, 'Joko Susanto', '081234567810', 'joko.susanto@gmail.com'),
(136, 'Kartika Ayu', '081234567811', 'kartika.ayu@gmail.com'),
(137, 'Lutfi Rahman', '081234567812', 'lutfi.rahman@gmail.com'),
(138, 'Mega Putri', '081234567813', 'mega.putri@gmail.com'),
(139, 'Nanda Setiawan', '081234567814', 'nanda.setiawan@gmail.com'),
(140, 'Oka Prasetyo', '081234567815', 'oka.prasetyo@gmail.com'),
(141, 'Putri Maharani', '081234567816', 'putri.maharani@gmail.com'),
(142, 'Qori Amalia', '081234567817', 'qori.amalia@gmail.com'),
(143, 'Rian Hidayat', '081234567818', 'rian.hidayat@gmail.com'),
(144, 'Siti Nurhaliza', '081234567819', 'siti.nurhaliza@gmail.com'),
(145, 'Teguh Kurniawan', '081234567820', 'teguh.kurniawan@gmail.com'),
(146, 'Umar Faruq', '081234567821', 'umar.faruq@gmail.com'),
(147, 'Vina Anggraini', '081234567822', 'vina.anggraini@gmail.com'),
(148, 'Wahyu Prasetya', '081234567823', 'wahyu.prasetya@gmail.com'),
(149, 'Xenia Wulandari', '081234567824', 'xenia.wulandari@gmail.com'),
(150, 'Yoga Aditya', '081234567825', 'yoga.aditya@gmail.com'),
(151, 'Zahra Khairunnisa', '081234567826', 'zahra.khairunnisa@gmail.com'),
(152, 'Andi Nugraha', '081234567827', 'andi.nugraha@gmail.com'),
(153, 'Bella Kartika', '081234567828', 'bella.kartika@gmail.com'),
(154, 'Cahyo Prasetyo', '081234567829', 'cahyo.prasetyo@gmail.com'),
(155, 'Dewi Lestari', '081234567830', 'dewi.lestari@gmail.com'),
(156, 'Erwin Prakoso', '081234567831', 'erwin.prakoso@gmail.com'),
(157, 'Farah Syifa', '081234567832', 'farah.syifa@gmail.com'),
(158, 'Gilang Ramadhan', '081234567833', 'gilang.ramadhan@gmail.com'),
(159, 'Hafiz Alamsyah', '081234567834', 'hafiz.alamsyah@gmail.com'),
(160, 'Ika Yuliani', '081234567835', 'ika.yuliani@gmail.com'),
(161, 'Jihan Safitri', '081234567836', 'jihan.safitri@gmail.com'),
(162, 'Kurniawan Saputra', '081234567837', 'kurniawan.saputra@gmail.com'),
(163, 'Laila Rahmah', '081234567838', 'laila.rahmah@gmail.com'),
(164, 'Miko Anggara', '081234567839', 'miko.anggara@gmail.com'),
(165, 'Novi Andriani', '081234567840', 'novi.andriani@gmail.com'),
(166, 'Omar Zulfikar', '081234567841', 'omar.zulfikar@gmail.com'),
(167, 'Putra Perdana', '081234567842', 'putra.perdana@gmail.com'),
(168, 'Qaniah Zahra', '081234567843', 'qaniah.zahra@gmail.com'),
(169, 'Rizki Maulana', '081234567844', 'rizki.maulana@gmail.com'),
(170, 'Salsa Nuraini', '081234567845', 'salsa.nuraini@gmail.com'),
(171, 'Taufik Hidayat', '081234567846', 'taufik.hidayat@gmail.com'),
(172, 'Ulfah Ningsih', '081234567847', 'ulfah.ningsih@gmail.com'),
(173, 'Vino Pradana', '081234567848', 'vino.pradana@gmail.com'),
(174, 'Wulan Ayu', '081234567849', 'wulan.ayu@gmail.com'),
(175, 'Xaverius', '081234567850', 'xaverius@gmail.com'),
(176, 'Yuni Safitri', '081234567851', 'yuni.safitri@gmail.com'),
(177, 'Zaki Ramli', '081234567852', 'zaki.ramli@gmail.com'),
(178, 'Ardiansyah', '081234567853', 'ardiansyah@gmail.com'),
(179, 'Bella Anggun', '081234567854', 'bella.anggun@gmail.com'),
(180, 'Chandra Wijaya', '081234567855', 'chandra.wijaya@gmail.com'),
(181, 'Dian Maharani', '081234567856', 'dian.maharani@gmail.com'),
(182, 'Erlangga Putra', '081234567857', 'erlangga.putra@gmail.com'),
(183, 'Fadilah Syah', '081234567858', 'fadilah.syah@gmail.com'),
(184, 'Gita Permatasari', '081234567859', 'gita.permatasari@gmail.com'),
(185, 'Hendra Wijaya', '081234567860', 'hendra.wijaya@gmail.com'),
(186, 'Intan Permata', '081234567861', 'intan.permata@gmail.com'),
(187, 'Joko Priyono', '081234567862', 'joko.priyono@gmail.com'),
(188, 'Kirana Ayu', '081234567863', 'kirana.ayu@gmail.com'),
(189, 'Lukman Hakim', '081234567864', 'lukman.hakim@gmail.com'),
(190, 'Maya Kartika', '081234567865', 'maya.kartika@gmail.com'),
(191, 'Naufal Ramadhan', '081234567866', 'naufal.ramadhan@gmail.com'),
(192, 'Olivia', '081234567867', 'olivia@gmail.com'),
(193, 'Pratama', '081234567868', 'pratama@gmail.com'),
(194, 'Qoriatul Hasanah', '081234567869', 'qoriatul.hasanah@gmail.com'),
(195, 'Rahmat Hidayat', '081234567870', 'rahmat.hidayat@gmail.com'),
(196, 'Syifa Lestari', '081234567871', 'syifa.lestari@gmail.com'),
(197, 'Tania Putri', '081234567872', 'tania.putri@gmail.com'),
(198, 'Ujang Suryana', '081234567873', 'ujang.suryana@gmail.com'),
(199, 'Vera Anggraini', '081234567874', 'vera.anggraini@gmail.com'),
(200, 'Wahida', '081234567875', 'wahida@gmail.com'),
(201, 'Xenia Kartika', '081234567876', 'xenia.kartika@gmail.com'),
(202, 'Yusuf Maulana', '081234567877', 'yusuf.maulana@gmail.com'),
(203, 'Zara Putri', '081234567878', 'zara.putri@gmail.com'),
(204, 'Agus Prabowo', '081234567879', 'agus.prabowo@gmail.com'),
(205, 'Bintang Saputra', '081234567880', 'bintang.saputra@gmail.com'),
(206, 'Cindy Permata', '081234567881', 'cindy.permata@gmail.com'),
(207, 'Dwi Handayani', '081234567882', 'dwi.handayani@gmail.com'),
(208, 'Eko Prasetyo', '081234567883', 'eko.prasetyo@gmail.com'),
(209, 'Fajar Nugraha', '081234567884', 'fajar.nugraha@gmail.com'),
(210, 'Gilang Saputra', '081234567885', 'gilang.saputra@gmail.com'),
(211, 'Hilda Oktavia', '081234567886', 'hilda.oktavia@gmail.com'),
(212, 'Irwan Maulana', '081234567887', 'irwan.maulana@gmail.com'),
(213, 'Jihan Kartika', '081234567888', 'jihan.kartika@gmail.com'),
(214, 'Kiki Ramadhani', '081234567889', 'kiki.ramadhani@gmail.com'),
(215, 'Lutvia Ayu', '081234567890', 'lutvia.ayu@gmail.com'),
(216, 'Mila Oktaviani', '081234567891', 'mila.oktaviani@gmail.com'),
(217, 'Niko Santoso', '081234567892', 'niko.santoso@gmail.com'),
(218, 'Oni Rahman', '081234567893', 'oni.rahman@gmail.com'),
(219, 'Puspita Sari', '081234567894', 'puspita.sari@gmail.com'),
(220, 'Qosim Abdullah', '081234567895', 'qosim.abdullah@gmail.com'),
(221, 'Rina Aprilia', '081234567896', 'rina.aprilia@gmail.com'),
(222, 'Sandi Kurniawan', '081234567897', 'sandi.kurniawan@gmail.com'),
(223, 'Tomi Hidayat', '081234567898', 'tomi.hidayat@gmail.com'),
(224, 'dddddddd', '22222', 'ssssssss@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=225;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
