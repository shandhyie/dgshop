<?php

class home extends CI_controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('home_model');

	}

	public function index() {
		$data['logo'] 			= $this->home_model->GetLogo();
		$data['kontak'] 		= $this->home_model->GetKontak();
		$data['sosial_media'] 	= $this->home_model->GetSosialMedia();
		$data['seo'] 			= $this->home_model->GetSeo(); 
		$data['slider']			= $this->home_model->GetSlider();
		$data['bank'] 			= $this->home_model->GetBank(); 
		$data['brand'] 			= $this->home_model->GetBrand(); 
		$data['kategori'] 		= $this->home_model->GetKategori(); 
		$data['produk']			= $this->home_model->GetProduk();
		$data['random']			= $this->home_model->GetRandomProduk();
		$data['random_active']	= $this->home_model->GetRandomActiveProduk();
		$data['jasapengiriman']	= $this->home_model->GetJasaPengiriman();

		$this->load->view('home/index',$data);
	}

	public function tentang_kami () {
		$data['logo'] 			= $this->home_model->GetLogo();
		$data['kontak'] 		= $this->home_model->GetKontak();
		$data['sosial_media'] 	= $this->home_model->GetSosialMedia();
		$data['seo'] 			= $this->home_model->GetSeo(); 
		$data['bank'] 			= $this->home_model->GetBank(); 
		$data['brand'] 			= $this->home_model->GetBrand(); 
		$data['kategori'] 		= $this->home_model->GetKategori(); 
		$data['tentangkami'] 	= $this->home_model->GetTentangKami();
		$data['produk']			= $this->home_model->GetProduk();
		$data['jasapengiriman']	= $this->home_model->GetJasaPengiriman();
		
		$this->load->view('home/tentang_kami',$data);
	}

	public function cara_belanja() {
		$data['logo'] 			= $this->home_model->GetLogo();
		$data['kontak'] 		= $this->home_model->GetKontak();
		$data['sosial_media'] 	= $this->home_model->GetSosialMedia();
		$data['seo'] 			= $this->home_model->GetSeo(); 
		$data['bank'] 			= $this->home_model->GetBank(); 
		$data['brand'] 			= $this->home_model->GetBrand(); 
		$data['kategori'] 		= $this->home_model->GetKategori(); 
		$data['carabelanja'] 	= $this->home_model->GetCaraBelanja();
		$data['jasapengiriman']	= $this->home_model->GetJasaPengiriman();
		
		
		$this->load->view('home/cara_belanja',$data);
	}

	public function hubungi_kami () {
		$data['logo'] 			= $this->home_model->GetLogo();
		$data['kontak'] 		= $this->home_model->GetKontak();
		$data['sosial_media'] 	= $this->home_model->GetSosialMedia();
		$data['seo'] 			= $this->home_model->GetSeo(); 
		$data['bank'] 			= $this->home_model->GetBank(); 
		$data['kategori'] 		= $this->home_model->GetKategori(); 

		
		
		$this->load->view('home/hubungi_kami',$data);
	}

	public function hubungi_kami_kirim() {
		$tanggal 	= date('Y-m-d');
		$nama 		= $this->input->post('nama');
		$email 		= $this->input->post('email');
		$hp 		= $this->input->post('hp');
		$alamat 		= $this->input->post('alamat');
		$pesan 		= $this->input->post('pesan');

		$this->home_model->InsertHubungiKami($nama,$email,$hp,$alamat,$pesan,$tanggal);

		$this->session->set_flashdata('sukses','Data Berhasil Dikirim');
		redirect("home/hubungi_kami");
	}

	public function kategori() {
		$id_kategori= $this->uri->segment(3);
		$data['logo'] 			= $this->home_model->GetLogo();
		$data['kontak'] 		= $this->home_model->GetKontak();
		$data['sosial_media'] 	= $this->home_model->GetSosialMedia();
		$data['seo'] 			= $this->home_model->GetSeo(); 
		$data['bank'] 			= $this->home_model->GetBank(); 
		$data['brand'] 			= $this->home_model->GetBrand(); 
		$data['kategori'] 		= $this->home_model->GetKategori(); 
		$data['nama_kategori']  = $this->home_model->GetNamaKategoriId($id_kategori);
		$data['jasapengiriman']	= $this->home_model->GetJasaPengiriman();

			$page=$this->uri->segment(4);
			$limit=12;
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$data['tot'] = $offset;
			$tot_hal = $this->home_model->GetProdukKategori($id_kategori);
			$config['base_url'] = base_url() . 'home/kategori/'.$id_kategori.'/';
			$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit;
			$config['uri_segment'] = 4;
			$config['first_link'] = 'Awal';
	        $config['last_link'] = 'Akhir';
	        $config['next_link'] = 'Selanjutnya';
	        $config['prev_link'] = 'Sebelumnya';
	        $config['full_tag_open'] = '<ul class="pagination">';
	        $config['full_tag_close'] = '</ul>';

	        $config['first_link'] = 'Awal';
	        $config['first_tag_open'] = '<li class="prev page">';
	        $config['first_tag_close'] = '</li>';

	        $config['last_link'] = 'Akhir';
	        $config['last_tag_open'] = '<li class="next page">';
	        $config['last_tag_close'] = '</li>';

	        $config['next_link'] = 'Selanjutnya';
	        $config['next_tag_open'] = '<li class="next page">';
	        $config['next_tag_close'] = '</li>';

	        $config['prev_link'] = 'Sebelumnya';
	        $config['prev_tag_open'] = '<li class="prev page">';
	        $config['prev_tag_close'] = '</li>';

	        $config['cur_tag_open'] = '<li class="active"><a href="">';
	        $config['cur_tag_close'] = '</a></li>';

	        $config['num_tag_open'] = '<li class="page">';
	        $config['num_tag_close'] = '</li>';

			$this->pagination->initialize($config);
			$data["paginator"] =$this->pagination->create_links();
			
			$data['produk_kategori'] = $this->db->query("select a.*,b.* from tbl_produk a join tbl_kategori b on a.kategori_id=b.id_kategori  where a.kategori_id='$id_kategori' order by a.id_produk desc 
			LIMIT ".$offset.",".$limit."");

		$this->load->view('home/kategori',$data);

	}

	public function brand() {
		$id_brand= $this->uri->segment(3);
		$data['logo'] 			= $this->home_model->GetLogo();
		$data['kontak'] 		= $this->home_model->GetKontak();
		$data['sosial_media'] 	= $this->home_model->GetSosialMedia();
		$data['seo'] 			= $this->home_model->GetSeo(); 
		$data['bank'] 			= $this->home_model->GetBank(); 
		$data['brand'] 			= $this->home_model->GetBrand(); 
		$data['kategori'] 		= $this->home_model->GetKategori(); 
		$data['nama_brand']  = $this->home_model->GetNamaBrandId($id_brand);
		$data['jasapengiriman']	= $this->home_model->GetJasaPengiriman();

			$page=$this->uri->segment(4);
			$limit=12;
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$data['tot'] = $offset;
			$tot_hal = $this->home_model->GetProdukBrand($id_brand);
			$config['base_url'] = base_url() . 'home/brand/'.$id_brand.'/';
			$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit;
			$config['uri_segment'] = 4;
			$config['first_link'] = 'Awal';
	        $config['last_link'] = 'Akhir';
	        $config['next_link'] = 'Selanjutnya';
	        $config['prev_link'] = 'Sebelumnya';
	        $config['full_tag_open'] = '<ul class="pagination">';
	        $config['full_tag_close'] = '</ul>';

	        $config['first_link'] = 'Awal';
	        $config['first_tag_open'] = '<li class="prev page">';
	        $config['first_tag_close'] = '</li>';

	        $config['last_link'] = 'Akhir';
	        $config['last_tag_open'] = '<li class="next page">';
	        $config['last_tag_close'] = '</li>';

	        $config['next_link'] = 'Selanjutnya';
	        $config['next_tag_open'] = '<li class="next page">';
	        $config['next_tag_close'] = '</li>';

	        $config['prev_link'] = 'Sebelumnya';
	        $config['prev_tag_open'] = '<li class="prev page">';
	        $config['prev_tag_close'] = '</li>';

	        $config['cur_tag_open'] = '<li class="active"><a href="">';
	        $config['cur_tag_close'] = '</a></li>';

	        $config['num_tag_open'] = '<li class="page">';
	        $config['num_tag_close'] = '</li>';

			$this->pagination->initialize($config);
			$data["paginator"] =$this->pagination->create_links();
			
			$data['produk_brand'] = $this->db->query("select a.*,b.* from tbl_produk a join tbl_brand b on a.brand_id=b.id_brand where a.brand_id='$id_brand' order by a.id_produk desc 
			LIMIT ".$offset.",".$limit."");

		$this->load->view('home/brand',$data);

	}

	public function cari () {
		$cari = $this->input->post('cari');

		if ($cari=="") {

		}
		else {

			$data['logo'] 			= $this->home_model->GetLogo();
			$data['kontak'] 		= $this->home_model->GetKontak();
			$data['sosial_media'] 	= $this->home_model->GetSosialMedia();
			$data['seo'] 			= $this->home_model->GetSeo(); 
			$data['bank'] 			= $this->home_model->GetBank(); 
			$data['brand'] 			= $this->home_model->GetBrand(); 
			$data['kategori'] 		= $this->home_model->GetKategori(); 
			$data['jasapengiriman']	= $this->home_model->GetJasaPengiriman();
			$data['produk_cari']	= $this->home_model->GetProdukCari($cari);

			$this->load->view('home/cari',$data);

		}
	}

	public function produk () {
		$id_produk = $this->uri->segment(3);

		$data['logo'] 			= $this->home_model->GetLogo();
		$data['kontak'] 		= $this->home_model->GetKontak();
		$data['sosial_media'] 	= $this->home_model->GetSosialMedia();
		$data['seo'] 			= $this->home_model->GetSeo(); 
		$data['bank'] 			= $this->home_model->GetBank(); 
		$data['brand'] 			= $this->home_model->GetBrand(); 
		$data['kategori'] 		= $this->home_model->GetKategori(); 
		$data['jasapengiriman']	= $this->home_model->GetJasaPengiriman();
		$data['random']			= $this->home_model->GetRandomProduk();
		$data['random_active']	= $this->home_model->GetRandomActiveProduk();

		$data['data_produk']= $this->home_model->GetProdukId($id_produk);

		$this->load->view('home/produk',$data);
	}

	public function keranjang() {

		$data['logo'] 			= $this->home_model->GetLogo();
		$data['kontak'] 		= $this->home_model->GetKontak();
		$data['sosial_media'] 	= $this->home_model->GetSosialMedia();
		$data['seo'] 			= $this->home_model->GetSeo(); 
		$data['bank'] 			= $this->home_model->GetBank(); 
		$data['kategori'] 		= $this->home_model->GetKategori(); 

		$id_produk = $this->uri->segment(3);

		if ($id_produk!="") {

			$query  = $this->home_model->GetProdukId($id_produk);

			foreach ($query->result_array() as $value) {

				$id_produk = $value['id_produk'];
				$kode_produk = $value['kode_produk'];
				$harga = $value['harga'];	
				$nama_produk = $value['nama_produk'];	
				$stok 	= 1;
				
			}

			$masuk = array(
				'id'      => $kode_produk,
				'qty'     => $stok,
			    'price'   => $harga,
				'name'    => $nama_produk);
			$this->cart->insert($masuk);

		}
		else {

		}
		
		
		$this->load->view('home/keranjang',$data);
	}

	public function keranjang_hapus($kode) {

		$data = array(
			'rowid' => $kode,
			'qty'   => 0);
			$this->cart->update($data);
		redirect('home/keranjang');

	}

	public function keranjang_update() {
		$total = $this->cart->total_items();
		$item = $this->input->post('rowid');
		$qty = $this->input->post('qty');
		for($i=0;$i < $total;$i++)
		{
			$data = array(
			'rowid' => $item[$i],
			'qty'   => $qty[$i]);
			$this->cart->update($data);
		}
		redirect('home/keranjang');
	}

	public function checkout () {

		$data['logo'] 			= $this->home_model->GetLogo();
		$data['kontak'] 		= $this->home_model->GetKontak();
		$data['sosial_media'] 	= $this->home_model->GetSosialMedia();
		$data['seo'] 			= $this->home_model->GetSeo(); 
		$data['bank'] 			= $this->home_model->GetBank(); 
		$data['kategori'] 		= $this->home_model->GetKategori(); 
		$data['jasapengiriman']	= $this->home_model->GetJasaPengiriman();

		$this->load->view('home/checkout',$data);

	}

	public function checkout_hapus($kode) {

		$data = array(
			'rowid' => $kode,
			'qty'   => 0);
			$this->cart->update($data);
		redirect('home/checkout');

	}

	public function checkout_update() {
		$total = $this->cart->total_items();
		$item = $this->input->post('rowid');
		$qty = $this->input->post('qty');
		for($i=0;$i < $total;$i++)
		{
			$data = array(
			'rowid' => $item[$i],
			'qty'   => $qty[$i]);
			$this->cart->update($data);
		}
		redirect('home/checkout');
	}

	public function checkout_invoice () {

		$this->form_validation->set_rules('penerima','Nama Penerima','required');
		$this->form_validation->set_rules('email','Email','required');
		$this->form_validation->set_rules('alamat','Alamat','required');
		$this->form_validation->set_rules('no_telepon','No Telp','required');
		$this->form_validation->set_rules('propinsi','Propinsi','required');
		$this->form_validation->set_rules('kota','Kota','required');
		$this->form_validation->set_rules('kode_pos','Kode Pos','required');
		$this->form_validation->set_rules('bank_id','Bank','required');
		$this->form_validation->set_rules('jasapengiriman_id','Jasa Pengiriman','required');

		if ($this->form_validation->run()==FALSE) {

				$data['logo'] 			= $this->home_model->GetLogo();
				$data['kontak'] 		= $this->home_model->GetKontak();
				$data['sosial_media'] 	= $this->home_model->GetSosialMedia();
				$data['seo'] 			= $this->home_model->GetSeo(); 
				$data['bank'] 			= $this->home_model->GetBank(); 
				$data['kategori'] 		= $this->home_model->GetKategori(); 
				$data['jasapengiriman']	= $this->home_model->GetJasaPengiriman();

			$this->load->view('home/checkout',$data);

		}
		else {

			$tgl_skr = date('Ymd');
			$cek_kode = $this->home_model->cek_kode($tgl_skr);
			$kode_trans = "";
			foreach($cek_kode->result() as $ck)
			{
				if($ck->kd==NULL)
				{
					$kode_trans = $tgl_skr.'001';
				}
				else
				{
					$kd_lama = $ck->kd;
					$kode_trans = $kd_lama+1;
				}
			}

			$penerima 			= $this->input->post("penerima");
			$email 				= $this->input->post("email");
			$alamat 			= $this->input->post("alamat");
			$no_telepon 		= $this->input->post("no_telepon");
			$propinsi 			= $this->input->post("propinsi");
			$kota 				= $this->input->post("kota");
			$kode_pos 			= $this->input->post("kode_pos");
			$bank_id 			= $this->input->post("bank_id");
			$jasapengiriman_id 	= $this->input->post("jasapengiriman_id");

			$isi_psn ='<table style="border:1px solid #000;" border="1" cellpadding=0>';
					$isi_psn ='<tr><td>Kode Produk</td><td>Nama Produk</td><td>Harga</td><td>Jumlah</td><td>Subtotal</td></tr>';
					foreach($this->cart->contents() as $items)
					{
$isi_psn = '<tr><td>'.$items["id"].'</td><td>'.$items["name"].'</td><td>Rp.'.$this->cart->format_number($items["price"]).'</td><td>'.$items["qty"].'</td><td>Rp.'.$this->cart->format_number($items["subtotal"]).'</td></tr>
';
					}
					$isi_psn = '<tr><td>Total Belanja (belum biaya kirim): </td><td colspan=4>Rp.'.$this->cart->format_number($this->cart->total()).'</td></tr>
';
					$isi_psn ='</table><br>';
					$isi_psn ='Harga di atas belum termasuk biaya kirim. Kami akan mengirimkan total yang harus anda bayar ke email anda dalam jangka waktu 1x24 jam.<br>';
					$isi_psn ='Salam, Adriano MX Online Shop';


					$this->load->library('email');
					$this->email->set_mailtype('html');
					$this->email->from("adrianomxshoponlin@gmail.com", "Admin Adriano MX Online Shop");
					$this->email->to($email);
					$this->email->subject('Detail Pesanan/Belanja Adriano MX Online Shop');
					$this->email->message($isi_psn);
					$this->email->send();

			$this->home_model->InsertTransaksiHeader($kode_trans,$penerima,$email,$alamat,$no_telepon,$propinsi,$kota,$kode_pos,$bank_id,$jasapengiriman_id);
			foreach($this->cart->contents() as $items)
						{
							$this->home_model->simpan_pesanan("insert into tbl_transaksi_detail (kode_transaksi,kode_produk,nama_produk,harga,jumlah) values('".$kode_trans."','".$items['id']."','".$items['name']."','".$items['price']."','".$items['qty']."')");
							// $this->home_model->update_dibeli($items['id'],$items['qty']);
						}
						$this->cart->destroy();
						?>
						<script type="text/javascript">
						alert("Pesanan anda telah terkirim, kami akan segera memprosesnya dalam waktu 1x24 jam. Silahkan cek email anda beberapa saat lagi untuk melihat rincian detail pembayaran.\n Terima Kasih");			
						</script>
						<?php
						echo "<meta http-equiv='refresh' content='0; url=".base_url()."home/'>";

		}
	}
}