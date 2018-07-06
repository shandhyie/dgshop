-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2018 at 03:37 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dgshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id_admin` int(11) NOT NULL,
  `nama_admin` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` bigint(15) NOT NULL,
  `hak_akses` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id_admin`, `nama_admin`, `username`, `password`, `email`, `phone`, `hak_akses`) VALUES
(3, 'Ahmad Sandi', 'sandi', 'ac9b4e0b6a21758534db2a6324d34a54', 'shandhyie13@gmail.com', 812437588, 'admin'),
(4, 'Akhmad Zhadiqin Hirman', 'amma', '7a41f726b70367f7aff8f08cd85119b0', 'amma@gmail.com', 812371237136, 'pegawai'),
(5, 'Rafsanjani Lestari Negara', 'rafsan', '533064a849d476ebb06768ec04824d89', 'rafsan@gmail.com', 823131231, 'admin'),
(6, 'Yori putra Pradana', 'yori', '54693fd76d7ca383ebcca64594a3cc0f', 'yori@gmail.com', 8134123424, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bank`
--

CREATE TABLE `tbl_bank` (
  `id_bank` int(11) NOT NULL,
  `nama_bank` varchar(100) NOT NULL,
  `nama_pemilik` varchar(250) NOT NULL,
  `no_rekening` varchar(50) NOT NULL,
  `gambar` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_bank`
--

INSERT INTO `tbl_bank` (`id_bank`, `nama_bank`, `nama_pemilik`, `no_rekening`, `gambar`) VALUES
(1, 'BCA', 'Rafsanjani Lestari Negara', '12342456', 'aa9d3ec4243250956a314578ff477f1b.png'),
(2, 'Mandiri', 'Akhmad Zhaqin Hirman', '543643512', 'ef548aea6b56db9a723f9c7ac91d46da.png'),
(3, 'BRI', 'Yori Putra Pradana', '1356787', '778473b7e82f9e47ba2c284eb60a6dfb.png'),
(4, 'Mandiri Syariah', 'Ahmad Sandi', '35323264642623', 'b8a5a05025b265f80b85ec7f2494e367.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_brand`
--

CREATE TABLE `tbl_brand` (
  `id_brand` int(11) NOT NULL,
  `nama_brand` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_brand`
--

INSERT INTO `tbl_brand` (`id_brand`, `nama_brand`) VALUES
(1, 'Ivan Rivaldy M'),
(2, 'Muh. Jaka Saputra'),
(3, 'Danton Sihombing'),
(4, 'Bayu Santosa'),
(5, 'Meisal Subkhan'),
(6, 'Gilang Bogy');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_carabelanja`
--

CREATE TABLE `tbl_carabelanja` (
  `id_carabelanja` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_carabelanja`
--

INSERT INTO `tbl_carabelanja` (`id_carabelanja`, `judul`, `deskripsi`) VALUES
(1, 'Cara Belanja Online di Andriano MX Online Shop', 'Berikut petunjuk pembelian secara Online melalui website kami :<div></div><ol><li>Lihat gamnbar barang yang akan Anda beli lihat juga detail produknya</li><li>Klik tombol "Beli" pada barang yang akan anda beli<br></li><li>Pada tabel anda masukan quantity barang yang akan Anda beli.</li><li>Setelah mengubah quantity jangan lupa untuk klik tombol "refresh"(untuk menampilkan kalkulasi harga)</li><li>Tidak ada minimal belanja anda boleh belanja berapapun.</li><li>Untuk kembali memilih barang lainnya atau melanjutkan berbelanja silahkan klik tombol "lanjut berbelanja" dan cari produk lainnya.</li><li>Jika sudah selesai membeli silahkan klik tombol "selesai berbelanja"</li><li>Bia anda belum login silahkan login terlebih dahulu. Dengan cara mengisi form yang sudah tersedia. Jika belum menjadi member silahkan mendaftar dahulu dengan cara yang mudah mengklik tombol "registrasi member".</li><li>Selanjutnya silahkan mengisi data lengkap pada form yang sudah tersedia</li><li>Sebelum anda selesai periksa dahulu data yang anda isi kebenarnnya atau barangkali ada yang lupa dikosongkan.</li><li>Tunggu paling lambat 1x24 jam kami akan menkonfirmsi kiriman anda melalui email atau Hp yang anda cantumkan sebelumnya."</li><li>Anda akan menerima balasan melalui email atau Hp Anda tentang kalkulasi harga disertai jasa pengirmiannnya.</li><li>Jika Anda setuju silhkan kirim sejumlah uang yang kami konfimasikan. Berikut rekining Bank yang kami sediakan :</li><div>BANK BRI<br>5555555555 A/n : ADRIANO</div><div>BANK BCA<br>44455555555 A/n : ADRIANO</div><div>BANK MANDIRI<br>345235235 A/n : ADRIANO</div><div>BANK MANDIRI SYARIAH<br>235235235 A/n : ADRIANO</div><li>Setelah melakukan transfer ke bank silahkan anda lakukan konfirmasi ke email kami atau hotline kami di 08656455677776.</li><li>Pengiriman barang akan kami proses secepatnya dan Anda akan enerima nomer resi yang akan kami infokan melali alamt email atau No Hp Anda.</li><li>Jika Anda menemui kesulitan silahkan hubungi Costumer service kami.</li>Terimakasih Atas kepercayaan Anda. Semoga tetap menjadi pelanggan kami...<br><br><br><br><br><br></ol>');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hubungikami`
--

CREATE TABLE `tbl_hubungikami` (
  `id_hubungikami` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `hp` bigint(15) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `pesan` text NOT NULL,
  `tanggal` date NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hubungi_kami_kirim`
--

CREATE TABLE `tbl_hubungi_kami_kirim` (
  `id_hubungi_kami_kirim` int(11) NOT NULL,
  `kepada` varchar(50) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `isi_hubungi_kami_kirim` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kategori`
--

CREATE TABLE `tbl_kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_kategori`
--

INSERT INTO `tbl_kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Poster'),
(2, 'Baju'),
(3, 'Undangan'),
(4, 'Kartu Nama'),
(5, 'Kalender'),
(6, 'Spanduk'),
(7, 'Kemasan'),
(8, 'Logo'),
(9, 'Browsur');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kontak`
--

CREATE TABLE `tbl_kontak` (
  `id_kontak` int(11) NOT NULL,
  `alamat` varchar(250) NOT NULL,
  `phone` bigint(15) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_kontak`
--

INSERT INTO `tbl_kontak` (`id_kontak`, `alamat`, `phone`, `email`) VALUES
(1, 'Makassar. Sulawesi Selatan', 81231000000, 'dgshop@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_logo`
--

CREATE TABLE `tbl_logo` (
  `id_logo` int(11) NOT NULL,
  `gambar` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_logo`
--

INSERT INTO `tbl_logo` (`id_logo`, `gambar`) VALUES
(1, '3f7111bcbed6e96a9109a098f0bfec43.PNG');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_produk`
--

CREATE TABLE `tbl_produk` (
  `id_produk` int(11) NOT NULL,
  `kode_produk` varchar(20) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `harga` bigint(15) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(200) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_produk`
--

INSERT INTO `tbl_produk` (`id_produk`, `kode_produk`, `nama_produk`, `harga`, `deskripsi`, `gambar`, `kategori_id`, `brand_id`, `status`) VALUES
(1, 'DGS00001', 'Desain Logo 1', 150000, 'Lorem Ipsum Doler', 'b21bdeba61cb9ed6b2950bf1843d31e1.jpg', 8, 1, 1),
(2, 'DGS00002', 'Desain Logo 2', 165000, 'Lorem Ipsum doller', '4a14e7ecca199a48e479d171599d135d.jpg', 8, 2, 1),
(3, 'DGS00003', 'Desain Logo 3', 156000, 'Lorem Ipsum Doler', '279baa8c116ddd6d0974930a58247396.jpg', 8, 3, 1),
(4, 'DGS00004', 'Desain Logo 4', 175000, 'Lorem Ipsum Doller', 'efc077dbdd38c8b1c443e2652c917833.jpg', 8, 4, 1),
(5, 'DGS00005', 'Desain Logo 5', 145000, 'Lorem Ipsum Doller', '000d044cb62e8110519f00cb01b4ed41.jpg', 8, 5, 1),
(6, 'DGS00006', 'Desain Browsur 1', 225000, 'Lorem Ipsum doller', '86805284c83450f76bb29f26389aea98.jpg', 9, 6, 1),
(7, 'DGS00007', 'Desain Browsur 2', 216000, 'Lorem Ipsum Doler', '0754ef11e21639d25fe3a88e23ebf9da.jpg', 9, 5, 1),
(8, 'DGS00008', 'Desain Browsur 3', 256000, 'tes', '3375f2e8e30370dc020aa5a0475ada52.jpg', 9, 4, 1),
(9, 'DGS00009', 'Desain Browsur 4', 320000, 'tes', 'c1ace8a2a6162d5871fffd24998874aa.jpg', 9, 3, 1),
(10, 'DGS00010', 'Desain Browsur 5', 289000, 'tes', '83674e71ad7437af80b0d1857a69f32d.jpg', 9, 2, 1),
(11, 'DGS00011', 'Desain Kartu Nama 1', 210000, 'tes', 'acba53f8803d971cd93a7cfdfe8cf487.jpg', 4, 1, 1),
(12, 'DGS00012', 'Desain Kartu Nama 2', 190000, 'tes', '6ba814e0525254e929cf763d716be0e3.jpg', 4, 2, 1),
(13, 'DGS00013', 'Desain Kartu Nama 3', 175000, 'tes', '74a00c4d85acb623b3012feaadcc26a6.jpg', 4, 3, 1),
(14, 'DGS00014', 'Desain Kartu Nama 4', 195000, 'tes', '96220651c5b6b636d52071e1f6cf8435.jpg', 4, 4, 1),
(15, 'DGS00015', 'Desain Kartu Nama 5', 170000, 'tes', 'ba285d3e4793b65f29a1fe73af77264a.jpg', 4, 5, 1),
(16, 'DGS00016', 'Desain Kartu Nama 6', 220000, 'tes', '3cf61aefcee930681dda1f8088aebbe3.jpg', 4, 6, 1),
(17, 'DGS00017', 'Desain Poster 1', 130000, 'tes', 'bf56938de4e857bb9a320f311b85d7d7.jpg', 1, 1, 1),
(18, 'DGS00018', 'Desain Poster 2', 170000, 'tes', '2a64c47b9e0d443001831b1697bfbb4e.jpg', 1, 2, 1),
(19, 'DGS00019', 'Desain Poster 3', 155000, 'tes', '5a6c4709b9a44cc1258cd2bac84d91b1.jpg', 1, 3, 1),
(20, 'DGS00020', 'Desain Poster 4', 186000, 'tes', 'd4f4d6157b535ec97faa993080994b53.jpg', 1, 4, 1),
(21, 'DGS00021', 'Desain Spanduk ', 210000, 'tes', '5958742897aba925a7b30877f0ec5f86.jpg', 6, 5, 1),
(22, 'DGS00022', 'Desain Spanduk 2', 230000, 'tes', '7ac4d5cf51ca344f95dec2b957faa4ec.jpg', 6, 6, 1),
(23, 'DGS00023', 'Desain Spanduk 3', 245000, 'tes', 'ea1385eb5947a183b5945665099e2dfc.jpg', 6, 1, 1),
(24, 'DGS00024', 'Desain Spanduk 4', 254000, 'tes', 'f59d41ffe742c33a056bddbfc70c31a1.jpg', 6, 2, 1),
(25, 'DGS00025', 'Desain Undangan 1', 320000, 'tes', 'b7f23281ce520123728ccea25ded1683.jpg', 3, 6, 1),
(26, 'DGS00026', 'Desain Undangan 2', 310000, 'tes', 'ab8cd2de42d115afd903d15a9190ab4a.jpg', 3, 5, 1),
(27, 'DGS00027', 'Desain Undangan 3', 300000, 'tes', '4baf3f54a77c65a2ad554c6bcf24795f.jpg', 3, 3, 1),
(28, 'DGS00028', 'Desain Undangan 4', 315000, 'tes', 'f18d149153dc92e49771c39a3664d9d3.jpg', 3, 1, 1),
(29, 'DGS00029', 'Desain Baju 1', 187000, 'tes', '63f60eb7764e98b770436856dfdf9a0e.jpg', 2, 1, 1),
(30, 'DGS00030', 'Desain Poster 5', 234000, 'tes', 'f9627146bcb6dc98a38376cf9abcea0e.jpg', 1, 2, 2),
(31, 'DGS00031', 'Desain Spanduk 5', 250000, 'tes', '8382d37751ad79718156ca3cb56d1bf6.jpg', 6, 5, 2),
(32, 'DGS00032', 'Desain Baju 2', 215000, 'tes', '431832f1c874baf21463dc8dc001a58d.jpg', 2, 3, 1),
(33, 'DGS00033', 'Desain Undangan 5', 218000, 'tes', 'd0c59ff8c903663e0a6248046c92af22.jpg', 3, 2, 1),
(34, 'DGS00034', 'apa aja', 1, 'weqweqwe', '344cc8ecc8c23da7f3847663c81c9e9d.jpg', 9, 6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sambutan`
--

CREATE TABLE `tbl_sambutan` (
  `id_sambutan` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_sambutan`
--

INSERT INTO `tbl_sambutan` (`id_sambutan`, `judul`, `deskripsi`) VALUES
(1, 'Kami Hadir Untuk Anda', 'isi sambutan');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seo`
--

CREATE TABLE `tbl_seo` (
  `id_seo` int(11) NOT NULL,
  `tittle` varchar(50) NOT NULL,
  `keyword` varchar(500) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_seo`
--

INSERT INTO `tbl_seo` (`id_seo`, `tittle`, `keyword`, `description`) VALUES
(1, 'Dg. Shop (Design Grafis Shop)', 'Dg. Shop, Desain Grafis', 'Dg. Shop adalah situs rensi pembelian desain dan jasa desainer');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_slider`
--

CREATE TABLE `tbl_slider` (
  `id_slider` int(11) NOT NULL,
  `tittle` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `gambar` varchar(200) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_slider`
--

INSERT INTO `tbl_slider` (`id_slider`, `tittle`, `description`, `gambar`, `status`) VALUES
(2, 'Layanan Jasa Desain Kami', '<div><div><div>Logo, Maskot, Kartu Nama, Company Profile, Katalog, Kemasan, Banner, Spanduk, Poster, Cover Buku, Stiker, Flyer, Kalender, Sosial Media, Kaos, dan desain apapun.</div></div></div>', '6ccb429d252b13d8207a44ced87839de.png', 1),
(3, 'Keuntungan Menggunakan Jasa DG.Shop', 'Desain Anda&nbsp;dibuat oleh para desainer ahli&nbsp;kami, sehingga original &amp; dijamin sesuai ekspektasi Anda.Anda tinggal&nbsp;terima beres, tanpa repot. Kami siap mengonsep, mendesain, &amp; mengirim file siap pakai.&nbsp;Gratis File Master&nbsp;sesuai format yang Anda inginkan, yang tidak diberikan di tempat lain secara cuma-cuma.&nbsp;Jaminan kepuasan dengan tanpa batas revisi, sampai deal.&nbsp;100% Uang Kembali, jika Anda masih tidak puas.', 'a8ba85a3ea2ab0d3550b922f243f87af.png', 1),
(4, 'Jasa Desain Grafis Online Profesional', 'Yang sudah paham betapa pentingnya membangun branding perusahaan atau bisnis Anda dan membutuhkan partner yang benar-benar profesional untuk mewujudkannya.', '8488e8e470da8d606985435c4f84e771.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sosial_media`
--

CREATE TABLE `tbl_sosial_media` (
  `id_sosial_media` int(11) NOT NULL,
  `tw` varchar(100) NOT NULL,
  `fb` varchar(100) NOT NULL,
  `gp` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_sosial_media`
--

INSERT INTO `tbl_sosial_media` (`id_sosial_media`, `tw`, `fb`, `gp`) VALUES
(1, 'http://twitter.com/dgshop', 'http://facebook.com/dgshop', 'http://gplus.com/dgshop');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tentangkami`
--

CREATE TABLE `tbl_tentangkami` (
  `id_tentangkami` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_tentangkami`
--

INSERT INTO `tbl_tentangkami` (`id_tentangkami`, `judul`, `deskripsi`) VALUES
(1, 'Kami Hadir Untuk Anda | Dg. Shop', 'Halo sahabat yang luar biasa, pada kesempatan kali ini izinkan kami dari DgShop untuk memperkenalkan diri. Mudaha-mudahan dengan adanya perkenalan ini sahabat-sahabat sekalian akan lebih senang berbelanja di toko online ini.<br><br>Sungguh terhormat bagi kami jika Anda mengunjungi web kami dan bisa memperoleh banyak hal yang bermanfaat.<br><br><blockquote>DgShop merupakan sebuah web yang menyediakan pembelian desain dan jasa desainer. DgShop didirikann oleh Mahasiswa Kelompok I kelas 3A-D4 Teknik Komputer dan Jaringan Jurusan Teknik Elektro Politeknik Negeri Ujung Pandang Tahun 2018. Keberadaan dari toko online ini diharapkan dapat mempermudah Anda untuk mendapatkan berbagai produk berkualitas tinggi namun dengan harga terjangkau.<br>Dalam memberi layanan kami selalu mencoba memberi persembahan terbaik kepada siapapun. Selain itu kami juga selalu menjunjung tinggi nilai-nilai etika yang baik seperti kejujuran, ketetapan, dan profesinalitas dalam berbisnis. Mudah-mudahan dengan adanya toko online kami bisa memberi banyak manfaat bagi Anda.<br><br></blockquote>Sekian dulu perkenalan ini, <i>Salam Super dan Semoga Anda Sukses Selalu !!!</i><br><br><ul><li><b>Rafsanjani Lestari Negara</b></li><li><b>Akhmad Zhadiqin Hirman</b></li><li><b>Yori Putra Pradana</b></li><li><b>Ahmad Sandi</b></li></ul><b>Jalan Perintis Kemerdekaan KM.10 Tamanlanrea, Makassar 90245<br></b><br><blockquote style="margin: 0 0 0 40px; border: none; padding: 0px;"><blockquote style="margin: 0 0 0 40px; border: none; padding: 0px;"><blockquote style="margin: 0 0 0 40px; border: none; padding: 0px;"><blockquote style="margin: 0 0 0 40px; border: none; padding: 0px;"><b><i>Selalu Melakukan yang Terbaik Maka Kau Akan Menikmati Hasilnya !!!</i></b></blockquote></blockquote></blockquote></blockquote>');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaksi_detail`
--

CREATE TABLE `tbl_transaksi_detail` (
  `id_transaksi_detail` int(11) NOT NULL,
  `kode_transaksi` bigint(15) NOT NULL,
  `kode_produk` varchar(20) NOT NULL,
  `nama_produk` varchar(25) NOT NULL,
  `harga` varchar(20) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaksi_header`
--

CREATE TABLE `tbl_transaksi_header` (
  `id_transaksi_header` int(11) NOT NULL,
  `kode_transaksi` bigint(15) NOT NULL,
  `penerima` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id_user`, `nama_user`, `username`, `password`, `email`, `phone`) VALUES
(1, 'Ahsan', 'ahsan', 'ahsan', 'ahsan@gmail.com', 346534564);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `oauth_provider` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `oauth_uid` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `cover` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `tbl_bank`
--
ALTER TABLE `tbl_bank`
  ADD PRIMARY KEY (`id_bank`);

--
-- Indexes for table `tbl_brand`
--
ALTER TABLE `tbl_brand`
  ADD PRIMARY KEY (`id_brand`);

--
-- Indexes for table `tbl_carabelanja`
--
ALTER TABLE `tbl_carabelanja`
  ADD PRIMARY KEY (`id_carabelanja`);

--
-- Indexes for table `tbl_hubungikami`
--
ALTER TABLE `tbl_hubungikami`
  ADD PRIMARY KEY (`id_hubungikami`);

--
-- Indexes for table `tbl_hubungi_kami_kirim`
--
ALTER TABLE `tbl_hubungi_kami_kirim`
  ADD PRIMARY KEY (`id_hubungi_kami_kirim`);

--
-- Indexes for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `tbl_kontak`
--
ALTER TABLE `tbl_kontak`
  ADD PRIMARY KEY (`id_kontak`);

--
-- Indexes for table `tbl_logo`
--
ALTER TABLE `tbl_logo`
  ADD PRIMARY KEY (`id_logo`);

--
-- Indexes for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `tbl_sambutan`
--
ALTER TABLE `tbl_sambutan`
  ADD PRIMARY KEY (`id_sambutan`);

--
-- Indexes for table `tbl_seo`
--
ALTER TABLE `tbl_seo`
  ADD PRIMARY KEY (`id_seo`);

--
-- Indexes for table `tbl_slider`
--
ALTER TABLE `tbl_slider`
  ADD PRIMARY KEY (`id_slider`);

--
-- Indexes for table `tbl_sosial_media`
--
ALTER TABLE `tbl_sosial_media`
  ADD PRIMARY KEY (`id_sosial_media`);

--
-- Indexes for table `tbl_tentangkami`
--
ALTER TABLE `tbl_tentangkami`
  ADD PRIMARY KEY (`id_tentangkami`);

--
-- Indexes for table `tbl_transaksi_detail`
--
ALTER TABLE `tbl_transaksi_detail`
  ADD PRIMARY KEY (`id_transaksi_detail`);

--
-- Indexes for table `tbl_transaksi_header`
--
ALTER TABLE `tbl_transaksi_header`
  ADD PRIMARY KEY (`id_transaksi_header`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tbl_bank`
--
ALTER TABLE `tbl_bank`
  MODIFY `id_bank` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_brand`
--
ALTER TABLE `tbl_brand`
  MODIFY `id_brand` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tbl_carabelanja`
--
ALTER TABLE `tbl_carabelanja`
  MODIFY `id_carabelanja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_hubungikami`
--
ALTER TABLE `tbl_hubungikami`
  MODIFY `id_hubungikami` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_hubungi_kami_kirim`
--
ALTER TABLE `tbl_hubungi_kami_kirim`
  MODIFY `id_hubungi_kami_kirim` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tbl_kontak`
--
ALTER TABLE `tbl_kontak`
  MODIFY `id_kontak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_logo`
--
ALTER TABLE `tbl_logo`
  MODIFY `id_logo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `tbl_sambutan`
--
ALTER TABLE `tbl_sambutan`
  MODIFY `id_sambutan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_seo`
--
ALTER TABLE `tbl_seo`
  MODIFY `id_seo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_slider`
--
ALTER TABLE `tbl_slider`
  MODIFY `id_slider` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_sosial_media`
--
ALTER TABLE `tbl_sosial_media`
  MODIFY `id_sosial_media` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_tentangkami`
--
ALTER TABLE `tbl_tentangkami`
  MODIFY `id_tentangkami` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_transaksi_detail`
--
ALTER TABLE `tbl_transaksi_detail`
  MODIFY `id_transaksi_detail` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_transaksi_header`
--
ALTER TABLE `tbl_transaksi_header`
  MODIFY `id_transaksi_header` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
