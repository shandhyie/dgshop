<?php
session_start();
if (!defined('HS')) {
    die('Tidak boleh diakses langsung.');
}

$welcomeKeyboard = array(
		array("Kategori"),
		array("Desainer"),
		array("Semua Desain")
);

//fungsi yang dipanggil pertama kali bot dirunning
function prosesApiMessage($sumber){
	//if ($GLOBALS['debug']) mypre($sumber);
    if (isset($sumber['message'])){
        $message = $sumber['message'];

		if ($GLOBALS['debug']) mypre($message);
		$chatid = $message['chat']['id'];
        sendApiAction($chatid);	
		
        if (isset($message['text'])) {
			prosesPesanTeks($message);
        }
    }
    if (isset($sumber['callback_query'])) {
        prosesCallAnswer($sumber['callback_query']);
    }
	$updateid = $sumber['update_id'];
    return $updateid;
}

function prosesPesanTeks($message)
{
    //if ($GLOBALS['debug']) mypre($message);
	require_once("concon.php");
    $pesan = $message['text'];
    $chatid = $message['chat']['id'];
    $fromid = $message['from']['id'];
    $messageid = $message['message_id'];
	
	global $welcomeKeyboard;
	
    switch (true) {
		case $pesan == '/start':
			$text = "Selamat datang di official Telegram Dg. Shop (Desain Grafis Shop). Silahkan cari desain sesuai kebutuhan anda :";
			sendApiPhoto($chatid);
			sendApiKeyboard($chatid,$welcomeKeyboard,false,$text);
			break;
		case $pesan == 'Kategori':
			$text = "Pilih Kategori";
			$keyboard = getData($pesan);
			sendApiKeyboard($chatid,$keyboard,false,$text);
			break;
		case $pesan == 'Desainer':
			$text = "Pilih Desainer";
			$keyboard = getData($pesan);
			sendApiKeyboard($chatid,$keyboard,false,$text);
			break;
		case $pesan == 'Semua Desain':
			$data = get_desain($pesan, '');
			$text = '';
			$no = 1;
			for($i=0; $i<count($data); $i++){
				$text = $no.'. Nama Desain : '.$data[$i]['nama_produk'].'
				Harga : '.$data[$i]['harga'].'
				Deskripsi : '.$data[$i]['deskripsi'];
				$no++;
				sendApiMsg($chatid, $text);
				sendApi_foto_desain($chatid, $data[$i]['gambar']);
			}
			break;
		case $pesan == 'Kembali Ke Menu Utama':
			$text = "Menu Utama";
			sendApiPhoto($chatid);
			sendApiKeyboard($chatid,$welcomeKeyboard,false,$text);
			break;
		case preg_match('/Desainer/', $pesan):
			$data = explode(' ', $pesan);
			$data1 = '';
			for($i = 1; $i < count($data); $i++){
				$data1 .= $data[$i].' '; 
			}
			$data1 = substr($data1, 0, -1);
			$data = get_desain($data[0], $data1);

			$text = '';
			$no = 1;
			for($i=0; $i<count($data); $i++){
				$text = $no.'. Nama Desain : '.$data[$i]['nama_produk'].'
				Harga : '.$data[$i]['harga'].'
				Deskripsi : '.$data[$i]['deskripsi'];
				$no++;
				sendApiMsg($chatid, $text);
				sendApi_foto_desain($chatid, $data[$i]['gambar']);
			}
			break;
		case preg_match('/Kategori/', $pesan):
			$data = explode(' ', $pesan);
			$data1 = '';
			for($i = 1; $i < count($data); $i++){
				$data1 .= $data[$i].' '; 
			}
			$data1 = substr($data1, 0, -1);
			$data = get_desain($data[0], $data1);

			$text = '';
			$no = 1;
			for($i=0; $i<count($data); $i++){
				$text = $no.'. Nama Desain : '.$data[$i]['nama_produk'].'
				Harga : '.$data[$i]['harga'].'
				Deskripsi : '.$data[$i]['deskripsi'];
				$no++;
				sendApiMsg($chatid, $text);
				sendApi_foto_desain($chatid, $data[$i]['gambar']);
			}
			break;
        default:
            sendApiMsg($chatid, ":) Format salah ");
			break;
    }	
}

function get_desain($pilihan, $data){
	include('concon.php');

	$data_produk = array();
	if($pilihan == 'Kategori'){
		$query = mysqli_query($con, "SELECT * from tbl_kategori where nama_kategori='$data'");
		
		while($a = mysqli_fetch_assoc($query)){
			$query_produk = mysqli_query($con, "SELECT * from tbl_produk where kategori_id='".$a['id_kategori']."'");
			
			while($b = mysqli_fetch_assoc($query_produk)){
				$data_produk[count($data_produk)] = array(
					'nama_produk' 	=> $b['nama_produk'],
					'harga'			=> $b['harga'],
					'deskripsi'		=> $b['deskripsi'],
					'gambar'		=> $b['gambar']
				);
			}
		}
	}
	elseif($pilihan == 'Desainer'){
		$query = mysqli_query($con, "SELECT * from tbl_brand where nama_brand='$data'");

		while($a = mysqli_fetch_assoc($query)){
			$query_brand = mysqli_query($con, "SELECT * from tbl_produk where brand_id='".$a['id_brand']."'");
			
			while($b = mysqli_fetch_assoc($query_brand)){
				$data_produk[count($data_produk)] = array(
					'nama_produk' 	=> $b['nama_produk'],
					'harga'			=> $b['harga'],
					'deskripsi'		=> $b['deskripsi'],
					'gambar'		=> $b['gambar']
				);
			}
		}
	}
	elseif($pilihan == 'Semua Desain'){
		$query_produk = mysqli_query($con, "SELECT * from tbl_produk");

		while($b = mysqli_fetch_assoc($query_produk)){
			$data_produk[count($data_produk)] = array(
				'nama_produk' 	=> $b['nama_produk'],
				'harga'			=> $b['harga'],
				'deskripsi'		=> $b['deskripsi'],
				'gambar'		=> $b['gambar']
			);
		}
	}
	return $data_produk;
}

function getData($data){
	include('concon.php');
	if($data == 'Kategori'){
		$query = mysqli_query($con, "SELECT * from tbl_kategori");
		$data = array();
		while($a = mysqli_fetch_assoc($query)){
			$data[count($data)] = array("Kategori ".$a['nama_kategori']);
		}
		
	}
	elseif($data == 'Desainer'){
		$query = mysqli_query($con, "SELECT * from tbl_brand");
		$data = array();

		while($a = mysqli_fetch_assoc($query)){
			$data[count($data)] = array("Desainer ".$a['nama_brand']);
		}
	}
	// elseif($data == '')

	$data[count($data)] = array("Kembali Ke Menu Utama");
	return $data;
}