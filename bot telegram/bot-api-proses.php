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
			$text = "Selamat datang di official Telegram Dg. Shop (Desain Grafis Shop). Silahkan cari desain sesuai kebutuhan anda : ";
			sendApiPhoto($chatid);
			sendApiKeyboard($chatid,$welcomeKeyboard,false,$text);
			break;
		case $pesan == 'Kategori':
			$text = "Pilih Kategori";
			$keyboard = getData($pesan);
			sendApiKeyboard($chatid,$keyboard,false,$text);
			break;
		case $pesan == 'Desainer':
			$text = "Pilih Desain";
			$keyboard = getData($pesan);
			sendApiKeyboard($chatid,$keyboard,false,$text);
			break;
		case $pesan == 'Semua Desain':
			$data = get_biblio($pesan, '');
			$text = '';
			$no = 1;
			for($i=0; $i<count($data); $i++){
				$text = $no.'. Judul : '.$data[$i]['judul'].'
				Tahun Penerbitan : '.$data[$i]['tahun_penerbitan'].'
				Info Detail Khusus : '.$data[$i]['info_detail_khusus'];
				$no++;
				sendApiMsg($chatid, $text);
				sendApi_foto_buku($chatid, $data[$i]['gambar']);
			}
			break;
		case $pesan == 'Kembali Ke Menu Utama':
			$text = "Menu Utama";
			sendApiPhoto($chatid);
			sendApiKeyboard($chatid,$welcomeKeyboard,false,$text);
			break;
		case preg_match('/Jurusan/', $pesan):
			$data = explode(' ', $pesan);
			$data1 = '';
			for($i = 1; $i < count($data); $i++){
				$data1 .= $data[$i].' '; 
			}
			$data1 = substr($data1, 0, -1);
			$data = get_biblio($data[0], $data1);

			$text = '';
			$no = 1;
			for($i=0; $i<count($data); $i++){
				$text = $no.'. Judul : '.$data[$i]['judul'].'
				Tahun Penerbitan : '.$data[$i]['tahun_penerbitan'].'
				info Detail Khusus : '.$data[$i]['info_detail_khusus'];
				$no++;
				sendApiMsg($chatid, $text);
				sendApi_foto_buku($chatid, $data[$i]['gambar']);
			}
			break;
		case preg_match('/Kategori/', $pesan):
			$data = explode(' ', $pesan);
			$data1 = '';
			for($i = 1; $i < count($data); $i++){
				$data1 .= $data[$i].' '; 
			}
			$data1 = substr($data1, 0, -1);
			$data = get_biblio($data[0], $data1);

			$text = '';
			$no = 1;
			for($i=0; $i<count($data); $i++){
				$text = $no.'. Judul : '.$data[$i]['judul'].'
				Tahun Penerbitan : '.$data[$i]['tahun_penerbitan'].'
				info Detail Khusus : '.$data[$i]['info_detail_khusus'];
				$no++;
				sendApiMsg($chatid, $text);
				sendApi_foto_buku($chatid, $data[$i]['gambar']);
			}
			break;
        default:
            sendApiMsg($chatid, ":) Format salah ");
			break;
    }	
}

function get_biblio($pilihan, $data){
	include('concon.php');

	$data_biblio = array();
	if($pilihan == 'Jurusan'){
		$query = mysqli_query($con, "SELECT * from mst_institusi where nama='$data'");
		$data_institusi = mysqli_fetch_assoc($query);

		$query = mysqli_query($con, "SELECT * from biblio_institusi where mst_institusi_id='".$data_institusi['id']."'");
		
		while($a = mysqli_fetch_assoc($query)){
			$query_biblio = mysqli_query($con, "SELECT * from biblio where id='".$a['biblio_id']."'");
			
			while($b = mysqli_fetch_assoc($query_biblio)){
				$data_biblio[count($data_biblio)] = array(
					'judul' 				=> $b['judul'],
					'tahun_penerbitan'		=> $b['tahun_penerbitan'],
					'info_detail_khusus'	=> $b['info_detail_khusus'],
					'gambar'				=> $b['gambar']
				);
			}
		}
	}
	elseif($pilihan == 'Kategori'){
		$query = mysqli_query($con, "SELECT * from mst_kategori where kategori='$data'");
		$data_kategori = mysqli_fetch_assoc($query);

		$query = mysqli_query($con, "SELECT * from biblio_kategori where mst_kategori_id='".$data_kategori['id']."'");

		while($a = mysqli_fetch_assoc($query)){
			$query_biblio = mysqli_query($con, "SELECT * from biblio where id='".$a['biblio_id']."'");
			
			while($b = mysqli_fetch_assoc($query_biblio)){
				$data_biblio[count($data_biblio)] = array(
					'judul' 				=> $b['judul'],
					'tahun_penerbitan'		=> $b['tahun_penerbitan'],
					'info_detail_khusus'	=> $b['info_detail_khusus'],
					'gambar'				=> $b['gambar']
				);
			}
		}
	}
	elseif($pilihan == 'Semua'){
		$query_biblio = mysqli_query($con, "SELECT * from biblio");

		while($b = mysqli_fetch_assoc($query_biblio)){
			$data_biblio[count($data_biblio)] = array(
				'judul' 				=> $b['judul'],
				'tahun_penerbitan'		=> $b['tahun_penerbitan'],
				'info_detail_khusus'	=> $b['info_detail_khusus'],
				'gambar'				=> $b['gambar']
			);
		}
	}
	return $data_biblio;
}

function getData($data){
	include('concon.php');
	if($data == 'Rekomendasi Jurusan'){
		$query = mysqli_query($con, "SELECT * from mst_institusi");
		$data = array();
		while($a = mysqli_fetch_assoc($query)){
			$data[count($data)] = array("Jurusan ".$a['nama']);
		}
		
	}
	elseif($data == 'Kategori Buku'){
		$query = mysqli_query($con, "SELECT * from mst_kategori");
		$data = array();

		while($a = mysqli_fetch_assoc($query)){
			$data[count($data)] = array("Kategori ".$a['kategori']);
		}
	}
	// elseif($data == '')

	$data[count($data)] = array("Kembali Ke Menu Utama");
	return $data;
}