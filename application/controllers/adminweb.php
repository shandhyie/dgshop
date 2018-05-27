<?php

class adminweb extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('admin_model');
	}

	public function index() {
		$data['logo'] = $this->admin_model->GetLogo();
		$this->load->view('adminweb/login',$data);
	}

	public function login() {

		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('password','Password','required');

		if ($this->form_validation->run()==FALSE) {

		$data['logo'] = $this->admin_model->GetLogo();
		$this->load->view('adminweb/login',$data);

		}
		else {

			$data['username'] = $this->input->post('username');
			$data['password'] = $this->input->post('password');

			$this->admin_model->CekAdminLogin($data);

		}
	}

	public function home() {

		if($this->session->userdata("logged_in")!=="") {
			$this->template->load('template','adminweb/home');
		}
		else{
			redirect('adminweb');

		}
	}

	public function logout() {
		$this->session->sess_destroy();
		redirect("adminweb");
	} 

	//Awal Seo
	public function seo() {
		if ($this->session->userdata("logged_in")!=="") {

			$query = $this->admin_model->GetSeo();
			foreach ($query->result_array() as $tampil) {
				$data['id_seo']=$tampil['id_seo'];
				$data['tittle']=$tampil['tittle'];
				$data['keyword']=$tampil['keyword'];
				$data['description']=$tampil['description'];
			}

			$this->template->load('template','adminweb/seo/index',$data);
		}
		else {
			redirect("adminweb");
		}
	}

	public function seo_simpan() {
		$id_seo = $this->input->post('id_seo');
		$tittle = $this->input->post('tittle');
		$keyword = $this->input->post('keyword');
		$description = $this->input->post('description');

		$this->admin_model->UpdateSeo($id_seo,$tittle,$keyword,$description);
	}
	//Akhir Seo

	//Awal Kategori Galeri
	public function kategorigaleri() {

		$data['data_kategorigaleri']= $this->admin_model->Getkategorigaleri();
		$this->template->load('template','adminweb/kategorigaleri/index',$data);
	}

	public function kategorigaleri_simpan() {
		$nama_kategorigaleri = $this->input->post("nama_kategorigaleri");
		$cek = $this->admin_model->kategorigaleriSama($nama_kategorigaleri);

		if ($cek->num_rows()>0) {
			$success = "1";
		}
		else {
			$this->session->set_flashdata('berhasil','kategorigaleri Berhasil Disimpan');
			$this->admin_model->kategorigaleriSimpan($nama_kategorigaleri);
			$success="0";
		}

		echo $success;
	}

	public function kategorigaleri_edit() {
		$id_kategorigaleri = $this->uri->segment(3);
		$query = $this->admin_model->GetEditkategorigaleri($id_kategorigaleri);
		foreach ($query->result_array() as $tampil) {
			$data['id_kategorigaleri'] = $tampil['id_kategorigaleri'];
			$data['nama_kategorigaleri'] = $tampil['nama_kategorigaleri'];
		}

		$this->template->load('template','adminweb/kategorigaleri/edit',$data);
	}

	public function kategorigaleri_delete() {
		$id_kategorigaleri = $this->uri->segment(3);
		$this->admin_model->Deletekategorigaleri($id_kategorigaleri);

		$this->session->set_flashdata('message','kategorigaleri Berhasil Dihapus');
		redirect("adminweb/kategorigaleri");
	}

	public function kategorigaleri_update() {
		$id_kategorigaleri = $this->input->post('id_kategorigaleri');
		$nama_kategorigaleri = $this->input->post('nama_kategorigaleri');

		$cek = $this->admin_model->kategorigaleriSama($nama_kategorigaleri);

		if ($cek->num_rows()>0) {
			$success = "1";
		}
		else {
			$this->session->set_flashdata('berhasil','kategorigaleri Berhasil Disimpan');
			$this->admin_model->kategorigaleriUpdate($id_kategorigaleri,$nama_kategorigaleri);
			$success="0";
		}

		echo $success;
	}
	//Akhir kategori

	//Awal Galeri
	public function galeri() {

		$data['data_galeri'] = $this->admin_model->GetGaleri();
		$this->template->load('template','adminweb/galeri/index',$data);

	}

	public function galeri_tambah() {
		$data['data_kategorigaleri'] = $this->admin_model->Getkategorigaleri();
		$this->template->load('template','adminweb/galeri/add',$data);
	}

	public function galeri_simpan() {

			
			$this->form_validation->set_rules('kategorigaleri_id', 'Album', 'required');
			$this->form_validation->set_rules('nama_galeri', 'Nama Gallery', 'required');
			
		
			

			if ($this->form_validation->run() == FALSE)
			{
				$data['data_kategorigaleri']= $this->admin_model->Getkategorigaleri();
				$this->template->load('template','adminweb/galeri/add',$data);
			}
			else {

				if(empty($_FILES['userfile']['name']))
				{
					
						$in_data['nama_galeri'] = $this->input->post('nama_galeri');
						$in_data['kategorigaleri_id'] = $this->input->post('kategorigaleri');
						$this->db->insert("tbl_galeri",$in_data);

					$this->session->set_flashdata('berhasil','Gallery Berhasil Disimpan');
					redirect("adminweb/galeri");
				}
				else
				{
					$config['upload_path'] = './images/galeri/';
					$config['allowed_types']= 'gif|jpg|png|jpeg';
					$config['encrypt_name']	= TRUE;
					$config['remove_spaces']	= TRUE;	
					$config['max_size']     = '3000';
					$config['max_width']  	= '3000';
					$config['max_height']  	= '3000';
					
			 
					$this->load->library('upload', $config);
	 
					if ($this->upload->do_upload("userfile")) {
						$data	 	= $this->upload->data();
			 
						/* PATH */
						$source             = "./images/galeri/".$data['file_name'] ;
						$destination_thumb	= "./images/galeri/thumb/" ;
						$destination_medium	= "./images/galeri/medium/" ;
						// Permission Configuration
						chmod($source, 0777) ;
			 
						/* Resizing Processing */
						// Configuration Of Image Manipulation :: Static
						$this->load->library('image_lib') ;
						$img['image_library'] = 'GD2';
						$img['create_thumb']  = TRUE;
						$img['maintain_ratio']= TRUE;
			 
						/// Limit Width Resize
						$limit_medium   = 800 ;
						$limit_thumb    = 270 ;
			 
						// Size Image Limit was using (LIMIT TOP)
						$limit_use  = $data['image_width'] > $data['image_height'] ? $data['image_width'] : $data['image_height'] ;
			 
						// Percentase Resize
						if ($limit_use > $limit_thumb) {
							$percent_medium = $limit_medium/$limit_use ;
							$percent_thumb  = $limit_thumb/$limit_use ;
						}
			 
						//// Making THUMBNAIL ///////
						$img['width']  = $limit_use > $limit_thumb ?  $data['image_width'] * $percent_thumb : $data['image_width'] ;
						$img['height'] = $limit_use > $limit_thumb ?  $data['image_height'] * $percent_thumb : $data['image_height'] ;
			 
						// Configuration Of Image Manipulation :: Dynamic
						$img['thumb_marker'] = '';
						$img['quality']      = '100%' ;
						$img['source_image'] = $source ;
						$img['new_image']    = $destination_thumb ;
			 
						// Do Resizing
						$this->image_lib->initialize($img);
						$this->image_lib->resize();
						$this->image_lib->clear() ;

						$img['width']   = $limit_use > $limit_medium ?  $data['image_width'] * $percent_medium : $data['image_width'] ;
						$img['height']  = $limit_use > $limit_medium ?  $data['image_height'] * $percent_medium : $data['image_height'] ;
			 
			 			// Configuration Of Image Manipulation :: Dynamic
						$img['thumb_marker'] = '';
						$img['quality']      = '100%' ;
						$img['source_image'] = $source ;
						$img['new_image']    = $destination_medium ;
			 
						// Do Resizing
						$this->image_lib->initialize($img);
						$this->image_lib->resize();
						$this->image_lib->clear() ;
						
						$in_data['nama_galeri'] = $this->input->post('nama_galeri');
						$in_data['gambar'] = $data['file_name'];
						$in_data['kategorigaleri_id'] = $this->input->post('kategorigaleri_id');
						
						
						$this->db->insert("tbl_galeri",$in_data);

				
						
						$this->session->set_flashdata('berhasil','Gallery Berhasil Disimpan');
						redirect("adminweb/galeri");
						
					}
					else 
					{
						$this->template->load('template','adminweb/galeri/error');
					}
				}
				
			}

	}

	public function galeri_delete() {
		$id_galeri = $this->uri->segment(3);
		$this->admin_model->DeleteGaleri($id_galeri);

		$this->session->set_flashdata('message','Gallery Berhasil Dihapus');
		redirect('adminweb/galeri');

	}

	public function galeri_edit() {
		$id_galeri = $this->uri->segment(3);
		$query = $this->admin_model->GetGaleriEdit($id_galeri);
		foreach ($query->result_array() as $tampil) {
			$data['id_galeri'] = $tampil['id_galeri'];
			$data['nama_galeri'] = $tampil['nama_galeri'];
			$data['gambar'] = $tampil['gambar'];
			$data['kategorigaleri_id'] = $tampil['kategorigaleri_id'];
		}
		$data['data_kategorigaleri'] = $this->admin_model->Getkategorigaleri();
		$this->template->load('template','adminweb/galeri/edit',$data);
	}

	public function galeri_update() {
		$id['id_galeri'] = $this->input->post("id_galeri");

		if(empty($_FILES['userfile']['name']))
				{
					
						$in_data['nama_galeri'] = $this->input->post('nama_galeri');
						$in_data['kategorigaleri_id'] = $this->input->post('kategorigaleri_id');
						
						$this->db->update("tbl_galeri",$in_data,$id);

					$this->session->set_flashdata('update','Gallery Berhasil Diupdate');
					redirect("adminweb/galeri");
				}
				else
				{
					$config['upload_path'] = './images/galeri/';
					$config['allowed_types']= 'gif|jpg|png|jpeg';
					$config['encrypt_name']	= TRUE;
					$config['remove_spaces']	= TRUE;	
					$config['max_size']     = '3000';
					$config['max_width']  	= '3000';
					$config['max_height']  	= '3000';
					
			 
					$this->load->library('upload', $config);
	 
					if ($this->upload->do_upload("userfile")) {
						$data	 	= $this->upload->data();
			 
						/* PATH */
						$source             = "./images/galeri/".$data['file_name'] ;
						$destination_thumb	= "./images/galeri/thumb/" ;
						$destination_medium	= "./images/galeri/medium/" ;
			 
						// Permission Configuration
						chmod($source, 0777) ;
			 
						/* Resizing Processing */
						// Configuration Of Image Manipulation :: Static
						$this->load->library('image_lib') ;
						$img['image_library'] = 'GD2';
						$img['create_thumb']  = TRUE;
						$img['maintain_ratio']= TRUE;
			 
						/// Limit Width Resize
						$limit_medium   = 800 ;
						$limit_thumb    = 270 ;
			 
						// Size Image Limit was using (LIMIT TOP)
						$limit_use  = $data['image_width'] > $data['image_height'] ? $data['image_width'] : $data['image_height'] ;
			 
						// Percentase Resize
						if ($limit_use > $limit_thumb) {
							$percent_medium = $limit_medium/$limit_use ;
							$percent_thumb  = $limit_thumb/$limit_use ;
						}
			 
						//// Making THUMBNAIL ///////
						$img['width']  = $limit_use > $limit_thumb ?  $data['image_width'] * $percent_thumb : $data['image_width'] ;
						$img['height'] = $limit_use > $limit_thumb ?  $data['image_height'] * $percent_thumb : $data['image_height'] ;
			 
						// Configuration Of Image Manipulation :: Dynamic
						$img['thumb_marker'] = '';
						$img['quality']      = '100%' ;
						$img['source_image'] = $source ;
						$img['new_image']    = $destination_thumb ;
			 
						// Do Resizing
						$this->image_lib->initialize($img);
						$this->image_lib->resize();
						$this->image_lib->clear() ;
	 
						////// Making MEDIUM /////////////
						$img['width']   = $limit_use > $limit_medium ?  $data['image_width'] * $percent_medium : $data['image_width'] ;
						$img['height']  = $limit_use > $limit_medium ?  $data['image_height'] * $percent_medium : $data['image_height'] ;
			 
						// Configuration Of Image Manipulation :: Dynamic
						$img['thumb_marker'] = '';
						$img['quality']      = '100%' ;
						$img['source_image'] = $source ;
						$img['new_image']    = $destination_medium ;
			 
						// Do Resizing
						$this->image_lib->initialize($img);
						$this->image_lib->resize();
						$this->image_lib->clear() ;
						
						$in_data['nama_galeri'] = $this->input->post('nama_galeri');
						$in_data['gambar'] = $data['file_name'];
						$in_data['kategorigaleri_id'] = $this->input->post('kategorigaleri');
						
						$this->db->update("tbl_galeri",$in_data,$id);
				
						
						$this->session->set_flashdata('update','Gallery Berhasil Diupdate');
						redirect("adminweb/galeri");
						
					}
					else 
					{
						$this->template->load('template','adminweb/galeri/error');
					}
				}

	}
	//Akhir Galeri

	//Awal Logo
	public function logo () {
		$query = $this->admin_model->GetLogo();
		foreach ($query->result_array() as $tampil) {
			$data['id_logo']=$tampil['id_logo'];
			$data['gambar']=$tampil['gambar'];
		}
		$this->template->load('template','adminweb/logo/index',$data);
	}

	 public function logo_simpan()
   {
		if($this->session->userdata("logged_in")!=="") {
			$id['id_logo'] = $this->input->post("id_logo");
			$id_logo = $this->input->post("id_logo");
			

				if(empty($_FILES['userfile']['name']))
				{
					
					
					$this->session->set_flashdata('message','Logo Berhasil Diupdate');
					redirect("adminweb/logo");
				}
				else
				{
					$config['upload_path'] = './images/logo/';
					$config['allowed_types']= 'gif|jpg|png|jpeg';
					$config['encrypt_name']	= TRUE;
					$config['remove_spaces']	= TRUE;	
					$config['max_size']     = '3000';
					$config['max_width']  	= '500';
					$config['max_height']  	= '250';
			 
					$this->load->library('upload', $config);
	 
					if ($this->upload->do_upload("userfile")) {
						$data	 	= $this->upload->data();
			 
						/* PATH */
						$source             = "./images/logo/".$data['file_name'] ;
						$destination_thumb	= "./images/logo/thumb/" ;
			 
						// Permission Configuration
						chmod($source, 0777) ;
			 
						/* Resizing Processing */
						// Configuration Of Image Manipulation :: Static
						$this->load->library('image_lib') ;
						$img['image_library'] = 'GD2';
						$img['create_thumb']  = TRUE;
						$img['maintain_ratio']= TRUE;
			 
						/// Limit Width Resize
						$limit_thumb    = 640 ;
			 
						// Size Image Limit was using (LIMIT TOP)
						$limit_use  = $data['image_width'] > $data['image_height'] ? $data['image_width'] : $data['image_height'] ;
			 
						// Percentase Resize
						if ($limit_use > $limit_thumb) {
							$percent_thumb  = $limit_thumb/$limit_use ;
						}
			 
						//// Making THUMBNAIL ///////
						$img['width']  = $limit_use > $limit_thumb ?  $data['image_width'] * $percent_thumb : $data['image_width'] ;
						$img['height'] = $limit_use > $limit_thumb ?  $data['image_height'] * $percent_thumb : $data['image_height'] ;
			 
						// Configuration Of Image Manipulation :: Dynamic
						$img['thumb_marker'] = '';
						$img['quality']      = '100%' ;
						$img['source_image'] = $source ;
						$img['new_image']    = $destination_thumb ;
			 
						// Do Resizing
						$this->image_lib->initialize($img);
						$this->image_lib->resize();
						$this->image_lib->clear() ;
						
						$in_data['gambar'] = $data['file_name'];
						$this->db->update("tbl_logo",$in_data,$id);
				
						
						$this->session->set_flashdata('message','Logo Berhasil Diupdate');
						redirect("adminweb/logo");
						
					}
					else 
					{
						echo $this->upload->display_errors('<p>','</p>');
					}
				}
			
		}
		else
		{
			redirect("adminweb");
		}
   }
	//Akhir Logo

   //Awal kontak
	public function kontak() {
		if($this->session->userdata("logged_in")!=="") {

			$query=$this->admin_model->Getkontak();
			foreach ($query->result_array() as $tampil) {
				$data["id_kontak"]=$tampil["id_kontak"];
				$data["alamat"]=$tampil["alamat"];
				$data["phone"]=$tampil["phone"];
				$data["email"]=$tampil["email"];
			}

			$this->template->load('template','adminweb/kontak/index',$data);
		}
		else {
			redirect("adminweb");
		}
	}

	public function kontak_simpan() {
		$id_kontak =$this->input->post("id_kontak");
		$alamat =$this->input->post("alamat");
		$phone =$this->input->post("phone");
		$email =$this->input->post("email");

		$this->admin_model->Simpankontak($id_kontak,$alamat,$phone,$email);
	}
	//Akhir kontak

	//Awal Sosial Media 
   public function sosial_media() {
   	if($this->session->userdata("logged_in")!=="") {
		   	$query = $this->admin_model->GetSosialMedia();
		   	foreach ($query->result_array() as $tampil) {
		   		$data['id_sosial_media'] = $tampil['id_sosial_media'];
		   		$data['tw'] = $tampil['tw'];
		   		$data['fb'] = $tampil['fb'];
		   		$data['gp'] = $tampil['gp'];
		   	}
   		$this->template->load('template','adminweb/sosial_media/index',$data);
	}
	else {
		redirect("adminweb");
	}
   }

   public function sosial_media_simpan() {
		$id_sosial_media =$this->input->post("id_sosial_media");
		$tw =$this->input->post("tw");
		$fb =$this->input->post("fb");
		$gp =$this->input->post("gp");
		

		$this->admin_model->SimpanSosialMedia($id_sosial_media,$tw,$fb,$gp);
	}
   //Akhir Sosial Media

	//Awal Kategori
	public function kategori() {

		$data['data_kategori']= $this->admin_model->GetKategori();
		$this->template->load('template','adminweb/kategori/index',$data);
	}

	public function kategori_simpan() {
		$nama_kategori = $this->input->post("nama_kategori");
		$cek = $this->admin_model->KategoriSama($nama_kategori);

		if ($cek->num_rows()>0) {
			$success = "1";
		}
		else {
			$this->session->set_flashdata('berhasil','Kategori Berhasil Disimpan');
			$this->admin_model->KategoriSimpan($nama_kategori);
			$success="0";
		}

		echo $success;
	}

	public function kategori_edit() {
		$id_kategori = $this->uri->segment(3);
		$query = $this->admin_model->GetEditKategori($id_kategori);
		foreach ($query->result_array() as $tampil) {
			$data['id_kategori'] = $tampil['id_kategori'];
			$data['nama_kategori'] = $tampil['nama_kategori'];
		}

		$this->template->load('template','adminweb/kategori/edit',$data);
	}

	public function kategori_delete() {
		$id_kategori = $this->uri->segment(3);
		$this->admin_model->DeleteKategori($id_kategori);

		$this->session->set_flashdata('message','Kategori Berhasil Dihapus');
		redirect("adminweb/kategori");
	}

	public function kategori_update() {
		$id_kategori = $this->input->post('id_kategori');
		$nama_kategori = $this->input->post('nama_kategori');

		$cek = $this->admin_model->KategoriSama($nama_kategori);

		if ($cek->num_rows()>0) {
			$success = "1";
		}
		else {
			$this->session->set_flashdata('berhasil','Kategori Berhasil Disimpan');
			$this->admin_model->KategoriUpdate($id_kategori,$nama_kategori);
			$success="0";
		}

		echo $success;
	}
	//Akhir kategori

	//Awal Brand
	public function brand() {

		$data['data_brand']= $this->admin_model->GetBrand();
		$this->template->load('template','adminweb/brand/index',$data);
	}

	public function brand_simpan() {
		$nama_brand = $this->input->post("nama_brand");
		$cek = $this->admin_model->BrandSama($nama_brand);

		if ($cek->num_rows()>0) {
			$success = "1";
		}
		else {
			$this->session->set_flashdata('berhasil','Brand Berhasil Disimpan');
			$this->admin_model->BrandSimpan($nama_brand);
			$success="0";
		}

		echo $success;
	}

	public function brand_edit() {
		$id_brand = $this->uri->segment(3);
		$query = $this->admin_model->GetEditBrand($id_brand);
		foreach ($query->result_array() as $tampil) {
			$data['id_brand'] = $tampil['id_brand'];
			$data['nama_brand'] = $tampil['nama_brand'];
		}

		$this->template->load('template','adminweb/brand/edit',$data);
	}

	public function brand_delete() {
		$id_brand = $this->uri->segment(3);
		$this->admin_model->DeleteBrand($id_brand);

		$this->session->set_flashdata('message','Brand Berhasil Dihapus');
		redirect("adminweb/brand");
	}

	public function brand_update() {
		$id_brand = $this->input->post('id_brand');
		$nama_brand = $this->input->post('nama_brand');

		$cek = $this->admin_model->BrandSama($nama_brand);

		if ($cek->num_rows()>0) {
			$success = "1";
		}
		else {
			$this->session->set_flashdata('berhasil','Brand Berhasil Disimpan');
			$this->admin_model->BrandUpdate($id_brand,$nama_brand);
			$success="0";
		}

		echo $success;
	}
	//Akhir kategori

	//Awal Kota
	public function kota() {

		$data['data_kota']= $this->admin_model->GetKota();
		$this->template->load('template','adminweb/kota/index',$data);
	}

	public function kota_simpan() {
		$nama_kota = $this->input->post("nama_kota");
		$cek = $this->admin_model->KotaSama($nama_kota);

		if ($cek->num_rows()>0) {
			$success = "1";
		}
		else {
			$this->session->set_flashdata('berhasil','Kota Berhasil Disimpan');
			$this->admin_model->KotaSimpan($nama_kota);
			$success="0";
		}

		echo $success;
	}

	public function kota_edit() {
		$id_kota = $this->uri->segment(3);
		$query = $this->admin_model->GetEditKota($id_kota);
		foreach ($query->result_array() as $tampil) {
			$data['id_kota'] = $tampil['id_kota'];
			$data['nama_kota'] = $tampil['nama_kota'];
		}

		$this->template->load('template','adminweb/kota/edit',$data);
	}

	public function kota_delete() {
		$id_kota = $this->uri->segment(3);
		$this->admin_model->DeleteKota($id_kota);

		$this->session->set_flashdata('message','Kota Berhasil Dihapus');
		redirect("adminweb/kota");
	}

	public function kota_update() {
		$id_kota = $this->input->post('id_kota');
		$nama_kota = $this->input->post('nama_kota');

		$cek = $this->admin_model->KotaSama($nama_kota);

		if ($cek->num_rows()>0) {
			$success = "1";
		}
		else {
			$this->session->set_flashdata('berhasil','Kota Berhasil Disimpan');
			$this->admin_model->KotaUpdate($id_kota,$nama_kota);
			$success="0";
		}

		echo $success;
	}
	//Akhir Kota

	//Awal Bank
	public function bank() {

		$data['data_bank'] = $this->admin_model->GetBank();
		$this->template->load('template','adminweb/bank/index',$data);

	}

	public function bank_tambah() {
		
		$this->template->load('template','adminweb/bank/add');
	}

	public function bank_simpan() {

			
			$this->form_validation->set_rules('nama_bank', 'Nama Bank', 'required');
			$this->form_validation->set_rules('nama_pemilik', 'Nama Pemilik', 'required');
			$this->form_validation->set_rules('no_rekening', 'No Rekening', 'required');

			if ($this->form_validation->run() == FALSE)
			{
				
				$this->template->load('template','adminweb/bank/add');
			}
			else {

				if(empty($_FILES['userfile']['name']))
				{
					
						$in_data['nama_bank'] = $this->input->post('nama_bank');
						$in_data['nama_pemilik'] = $this->input->post('nama_pemilik');
						$in_data['no_rekening'] = $this->input->post('no_rekening');
						$this->db->insert("tbl_bank",$in_data);

					$this->session->set_flashdata('berhasil','Bank Berhasil Disimpan');
					redirect("adminweb/bank");
				}
				else
				{
					$config['upload_path'] = './images/bank/';
					$config['allowed_types']= 'gif|jpg|png|jpeg';
					$config['encrypt_name']	= TRUE;
					$config['remove_spaces']	= TRUE;	
					$config['max_size']     = '3000';
					$config['max_width']  	= '3000';
					$config['max_height']  	= '3000';
					
			 
					$this->load->library('upload', $config);
	 
					if ($this->upload->do_upload("userfile")) {
						$data	 	= $this->upload->data();
			 
						/* PATH */
						$source             = "./images/bank/".$data['file_name'] ;
						$destination_thumb	= "./images/bank/thumb/" ;
						$destination_medium	= "./images/bank/medium/" ;
						// Permission Configuration
						chmod($source, 0777) ;
			 
						/* Resizing Processing */
						// Configuration Of Image Manipulation :: Static
						$this->load->library('image_lib') ;
						$img['image_library'] = 'GD2';
						$img['create_thumb']  = TRUE;
						$img['maintain_ratio']= TRUE;
			 
						/// Limit Width Resize
						$limit_medium   = 800 ;
						$limit_thumb    = 270 ;
			 
						// Size Image Limit was using (LIMIT TOP)
						$limit_use  = $data['image_width'] > $data['image_height'] ? $data['image_width'] : $data['image_height'] ;
			 
						// Percentase Resize
						if ($limit_use > $limit_thumb) {
							$percent_medium = $limit_medium/$limit_use ;
							$percent_thumb  = $limit_thumb/$limit_use ;
						}
			 
						//// Making THUMBNAIL ///////
						$img['width']  = $limit_use > $limit_thumb ?  $data['image_width'] * $percent_thumb : $data['image_width'] ;
						$img['height'] = $limit_use > $limit_thumb ?  $data['image_height'] * $percent_thumb : $data['image_height'] ;
			 
						// Configuration Of Image Manipulation :: Dynamic
						$img['thumb_marker'] = '';
						$img['quality']      = '100%' ;
						$img['source_image'] = $source ;
						$img['new_image']    = $destination_thumb ;
			 
						// Do Resizing
						$this->image_lib->initialize($img);
						$this->image_lib->resize();
						$this->image_lib->clear() ;

						$img['width']   = $limit_use > $limit_medium ?  $data['image_width'] * $percent_medium : $data['image_width'] ;
						$img['height']  = $limit_use > $limit_medium ?  $data['image_height'] * $percent_medium : $data['image_height'] ;
			 
			 			// Configuration Of Image Manipulation :: Dynamic
						$img['thumb_marker'] = '';
						$img['quality']      = '100%' ;
						$img['source_image'] = $source ;
						$img['new_image']    = $destination_medium ;
			 
						// Do Resizing
						$this->image_lib->initialize($img);
						$this->image_lib->resize();
						$this->image_lib->clear() ;
						
						$in_data['nama_bank'] = $this->input->post('nama_bank');
						$in_data['nama_pemilik'] = $this->input->post('nama_pemilik');
						$in_data['no_rekening'] = $this->input->post('no_rekening');
						$in_data['gambar'] = $data['file_name'];
						
						
						$this->db->insert("tbl_bank",$in_data);

				
						
						$this->session->set_flashdata('berhasil','Bank Berhasil Disimpan');
						redirect("adminweb/bank");
						
					}
					else 
					{
						$this->template->load('template','adminweb/bank/error');
					}
				}
				
			}

	}

	public function bank_delete() {
		$id_bank = $this->uri->segment(3);
		$this->admin_model->DeleteBank($id_bank);

		$this->session->set_flashdata('message','Bank Berhasil Dihapus');
		redirect('adminweb/bank');

	}

	public function bank_edit() {
		$id_bank = $this->uri->segment(3);
		$query = $this->admin_model->GetBankEdit($id_bank);
		foreach ($query->result_array() as $tampil) {
			$data['id_bank'] = $tampil['id_bank'];
			$data['nama_bank'] = $tampil['nama_bank'];
			$data['nama_pemilik'] = $tampil['nama_pemilik'];
			$data['no_rekening'] = $tampil['no_rekening'];
			$data['gambar'] = $tampil['gambar'];
		}
		$this->template->load('template','adminweb/bank/edit',$data);
	}

	public function bank_update() {
		$id['id_bank'] = $this->input->post("id_bank");

		if(empty($_FILES['userfile']['name']))
				{
					
						$in_data['nama_bank'] = $this->input->post('nama_bank');
						$in_data['nama_pemilik'] = $this->input->post('nama_pemilik');
						$in_data['no_rekening'] = $this->input->post('no_rekening');
						
						$this->db->update("tbl_bank",$in_data,$id);

					$this->session->set_flashdata('update','Bank Berhasil Diupdate');
					redirect("adminweb/bank");
				}
				else
				{
					$config['upload_path'] = './images/bank/';
					$config['allowed_types']= 'gif|jpg|png|jpeg';
					$config['encrypt_name']	= TRUE;
					$config['remove_spaces']	= TRUE;	
					$config['max_size']     = '3000';
					$config['max_width']  	= '260';
					$config['max_height']  	= '100';
					
			 
					$this->load->library('upload', $config);
	 
					if ($this->upload->do_upload("userfile")) {
						$data	 	= $this->upload->data();
			 
						/* PATH */
						$source             = "./images/bank/".$data['file_name'] ;
						$destination_thumb	= "./images/bank/thumb/" ;
						$destination_medium	= "./images/bank/medium/" ;
			 
						// Permission Configuration
						chmod($source, 0777) ;
			 
						/* Resizing Processing */
						// Configuration Of Image Manipulation :: Static
						$this->load->library('image_lib') ;
						$img['image_library'] = 'GD2';
						$img['create_thumb']  = TRUE;
						$img['maintain_ratio']= TRUE;
			 
						/// Limit Width Resize
						$limit_medium   = 90 ;
						$limit_thumb    = 60 ;
			 
						// Size Image Limit was using (LIMIT TOP)
						$limit_use  = $data['image_width'] > $data['image_height'] ? $data['image_width'] : $data['image_height'] ;
			 
						// Percentase Resize
						if ($limit_use > $limit_thumb) {
							$percent_medium = $limit_medium/$limit_use ;
							$percent_thumb  = $limit_thumb/$limit_use ;
						}
			 
						//// Making THUMBNAIL ///////
						$img['width']  = $limit_use > $limit_thumb ?  $data['image_width'] * $percent_thumb : $data['image_width'] ;
						$img['height'] = $limit_use > $limit_thumb ?  $data['image_height'] * $percent_thumb : $data['image_height'] ;
			 
						// Configuration Of Image Manipulation :: Dynamic
						$img['thumb_marker'] = '';
						$img['quality']      = '100%' ;
						$img['source_image'] = $source ;
						$img['new_image']    = $destination_thumb ;
			 
						// Do Resizing
						$this->image_lib->initialize($img);
						$this->image_lib->resize();
						$this->image_lib->clear() ;
	 
						////// Making MEDIUM /////////////
						$img['width']   = $limit_use > $limit_medium ?  $data['image_width'] * $percent_medium : $data['image_width'] ;
						$img['height']  = $limit_use > $limit_medium ?  $data['image_height'] * $percent_medium : $data['image_height'] ;
			 
						// Configuration Of Image Manipulation :: Dynamic
						$img['thumb_marker'] = '';
						$img['quality']      = '100%' ;
						$img['source_image'] = $source ;
						$img['new_image']    = $destination_medium ;
			 
						// Do Resizing
						$this->image_lib->initialize($img);
						$this->image_lib->resize();
						$this->image_lib->clear() ;
						
						$in_data['nama_bank'] = $this->input->post('nama_bank');
						$in_data['nama_pemilik'] = $this->input->post('nama_pemilik');
						$in_data['no_rekening'] = $this->input->post('no_rekening');
						$in_data['gambar'] = $data['file_name'];
						
						$this->db->update("tbl_bank",$in_data,$id);
				
						
						$this->session->set_flashdata('update','Bank Berhasil Diupdate');
						redirect("adminweb/bank");
						
					}
					else 
					{
						$this->template->load('template','adminweb/bank/error');
					}
				}

	}
	//Akhir Bank

	//Awal Tentang Kami
	public function tentangkami() {
		if ($this->session->userdata("logged_in")!=="") {

			$query = $this->admin_model->GetTentangkami();
			foreach ($query->result_array() as $tampil) {
				$data['id_tentangkami']=$tampil['id_tentangkami'];
				$data['judul']=$tampil['judul'];
				$data['deskripsi']=$tampil['deskripsi'];
			}

			$this->template->load('template','adminweb/tentangkami/index',$data);
		}
		else {
			redirect("adminweb");
		}
	}

	public function tentangkami_simpan() {
		$id_tentangkami = $this->input->post('id_tentangkami');
		$judul = $this->input->post('judul');
		$deskripsi = $this->input->post('deskripsi');

		$this->admin_model->UpdateTentangkami($id_tentangkami,$judul,$deskripsi);
	}
	//Akhir Tentang Kami

	//Awal Cara Belanja
	public function carabelanja() {
		if ($this->session->userdata("logged_in")!=="") {

			$query = $this->admin_model->GetCarabelanja();
			foreach ($query->result_array() as $tampil) {
				$data['id_carabelanja']=$tampil['id_carabelanja'];
				$data['judul']=$tampil['judul'];
				$data['deskripsi']=$tampil['deskripsi'];
			}

			$this->template->load('template','adminweb/carabelanja/index',$data);
		}
		else {
			redirect("adminweb");
		}
	}

	public function carabelanja_simpan() {
		$id_carabelanja = $this->input->post('id_carabelanja');
		$judul = $this->input->post('judul');
		$deskripsi = $this->input->post('deskripsi');

		$this->admin_model->UpdateCarabelanja($id_carabelanja,$judul,$deskripsi);
	}
	//Akhir Cara Belanja

	//Awal Sambutan
	public function sambutan() {
		if ($this->session->userdata("logged_in")!=="") {

			$query = $this->admin_model->GetSambutan();
			foreach ($query->result_array() as $tampil) {
				$data['id_sambutan']=$tampil['id_sambutan'];
				$data['judul']=$tampil['judul'];
				$data['deskripsi']=$tampil['deskripsi'];
			}

			$this->template->load('template','adminweb/sambutan/index',$data);
		}
		else {
			redirect("adminweb");
		}
	}

	public function sambutan_simpan() {
		$id_sambutan = $this->input->post('id_sambutan');
		$judul = $this->input->post('judul');
		$deskripsi = $this->input->post('deskripsi');

		$this->admin_model->UpdateSambutan($id_sambutan,$judul,$deskripsi);
	}
	//Akhir Sambutan

	//Awal Admin
	public function admin() {
		if($this->session->userdata("logged_in")!=="") {

			$data['data_admin'] = $this->admin_model->Getadmin();
			$this->template->load('template','adminweb/admin/index',$data);
		}
		else {
			redirect("adminweb");
		}
	} 

	public function admin_delete() {
		$id = $this->uri->segment(3);
		$this->admin_model->Deleteadmin($id);

		$this->session->set_flashdata('message','Admin Berhasil Dihapus');
		redirect('adminweb/admin');
	}

	public function admin_tambah() {
		$this->template->load('template','adminweb/admin/add');
	}

	public function admin_simpan() {

			$this->form_validation->set_rules('nama_admin', 'Nama Admin', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('phone', 'Phone', 'required');
			$this->form_validation->set_rules('hak_akses', 'Hak Akses', 'required');
			
			

			if ($this->form_validation->run() == FALSE)
			{
				$this->template->load('template','adminweb/admin/add');
			}
			else {

						$in_data['nama_admin'] 		= $this->input->post('nama_admin');
						$in_data['email'] 			= $this->input->post('email');
						$in_data['username'] 		= $this->input->post('username');
						$in_data['password'] 		= md5($this->input->post('password'));
						$in_data['phone'] 			= $this->input->post('phone');
						$in_data['hak_akses'] 		= $this->input->post('hak_akses');
						$this->db->insert("tbl_admin",$in_data);

					$this->session->set_flashdata('berhasil','Admin Berhasil Disimpan');
					redirect("adminweb/admin");
				
			}

	}

	public function admin_edit() {
		$id = $this->uri->segment(3);
		$query = $this->admin_model->GetadminEdit($id);
		foreach ($query->result_array() as $tampil) {
			$data['id_admin'] = $tampil['id_admin'];
			$data['nama_admin'] = $tampil['nama_admin'];
			$data['email'] = $tampil['email'];
			$data['username'] = $tampil['username'];
			$data['password'] = $tampil['password'];
			$data['phone'] = $tampil['phone'];
			$data['hak_akses'] = $tampil['hak_akses'];
			
		}
		$this->template->load('template','adminweb/admin/edit',$data);
	}

	public function admin_update() {
		$id['id_admin'] = $this->input->post("id_admin");

		if ($this->input->post('password')!=="") {

			$in_data['nama_admin'] = $this->input->post('nama_admin');
			$in_data['email'] = $this->input->post('email');
			$in_data['username'] = $this->input->post('username');
			$in_data['password'] = md5($this->input->post('password'));
			$in_data['phone'] = $this->input->post('phone');
			$in_data['hak_akses'] = $this->input->post('hak_akses');

		}
		else {
			$in_data['nama_admin'] = $this->input->post('nama_admin');
			$in_data['email'] = $this->input->post('email');
			$in_data['username'] = $this->input->post('username');
			$in_data['phone'] = $this->input->post('phone');
			$in_data['hak_akses'] = $this->input->post('hak_akses');
		}
								
		$this->db->update("tbl_admin",$in_data,$id);

		$this->session->set_flashdata('update','Admin Berhasil Diupdate');
		redirect("adminweb/admin");
		
	}
	//Akhir Admin

	//Awal Jasa Pengirman
	public function jasapengiriman() {

		$data['data_jasapengiriman'] = $this->admin_model->GetJasapengiriman();
		$this->template->load('template','adminweb/jasapengiriman/index',$data);

	}

	public function jasapengiriman_tambah() {
		$this->template->load('template','adminweb/jasapengiriman/add');
	}

	public function jasapengiriman_simpan() {

			$this->form_validation->set_rules('nama', 'Nama Jasa Pengiriman', 'required');
			
		
			

			if ($this->form_validation->run() == FALSE)
			{
			
				$this->template->load('template','adminweb/jasapengiriman/add');
			}
			else {

				if(empty($_FILES['userfile']['name']))
				{
					
						$in_data['nama'] = $this->input->post('nama');
						$this->db->insert("tbl_jasapengiriman",$in_data);

					$this->session->set_flashdata('berhasil','Jasa Pengiriman Berhasil Disimpan');
					redirect("adminweb/jasapengiriman");
				}
				else
				{
					$config['upload_path'] = './images/jasapengiriman/';
					$config['allowed_types']= 'gif|jpg|png|jpeg';
					$config['encrypt_name']	= TRUE;
					$config['remove_spaces']	= TRUE;	
					$config['max_size']     = '3000';
					$config['max_width']  	= '150';
					$config['max_height']  	= '60';
					
			 
					$this->load->library('upload', $config);
	 
					if ($this->upload->do_upload("userfile")) {
						$data	 	= $this->upload->data();
			 
						/* PATH */
						$source             = "./images/jasapengiriman/".$data['file_name'] ;
						$destination_thumb	= "./images/jasapengiriman/thumb/" ;
						$destination_medium	= "./images/jasapengiriman/medium/" ;
						// Permission Configuration
						chmod($source, 0777) ;
			 
						/* Resizing Processing */
						// Configuration Of Image Manipulation :: Static
						$this->load->library('image_lib') ;
						$img['image_library'] = 'GD2';
						$img['create_thumb']  = TRUE;
						$img['maintain_ratio']= TRUE;
			 
						/// Limit Width Resize
						$limit_medium   = 150 ;
						$limit_thumb    = 60 ;
			 
						// Size Image Limit was using (LIMIT TOP)
						$limit_use  = $data['image_width'] > $data['image_height'] ? $data['image_width'] : $data['image_height'] ;
			 
						// Percentase Resize
						if ($limit_use > $limit_thumb) {
							$percent_medium = $limit_medium/$limit_use ;
							$percent_thumb  = $limit_thumb/$limit_use ;
						}
			 
						//// Making THUMBNAIL ///////
						$img['width']  = $limit_use > $limit_thumb ?  $data['image_width'] * $percent_thumb : $data['image_width'] ;
						$img['height'] = $limit_use > $limit_thumb ?  $data['image_height'] * $percent_thumb : $data['image_height'] ;
			 
						// Configuration Of Image Manipulation :: Dynamic
						$img['thumb_marker'] = '';
						$img['quality']      = '100%' ;
						$img['source_image'] = $source ;
						$img['new_image']    = $destination_thumb ;
			 
						// Do Resizing
						$this->image_lib->initialize($img);
						$this->image_lib->resize();
						$this->image_lib->clear() ;

						$img['width']   = $limit_use > $limit_medium ?  $data['image_width'] * $percent_medium : $data['image_width'] ;
						$img['height']  = $limit_use > $limit_medium ?  $data['image_height'] * $percent_medium : $data['image_height'] ;
			 
			 			// Configuration Of Image Manipulation :: Dynamic
						$img['thumb_marker'] = '';
						$img['quality']      = '100%' ;
						$img['source_image'] = $source ;
						$img['new_image']    = $destination_medium ;
			 
						// Do Resizing
						$this->image_lib->initialize($img);
						$this->image_lib->resize();
						$this->image_lib->clear() ;
						
						$in_data['nama'] = $this->input->post('nama');
						$in_data['gambar'] = $data['file_name'];
						
						
						
						$this->db->insert("tbl_jasapengiriman",$in_data);

				
						
						$this->session->set_flashdata('berhasil','Jasa Pengiriman Berhasil Disimpan');
						redirect("adminweb/jasapengiriman");
						
					}
					else 
					{
						$this->template->load('template','adminweb/jasapengiriman/error');
					}
				}
				
			}

	}

	public function jasapengiriman_delete() {
		$id_jasapengiriman = $this->uri->segment(3);
		$this->admin_model->DeleteJasapengiriman($id_jasapengiriman);

		$this->session->set_flashdata('message','Jasa Pengiriman Berhasil Dihapus');
		redirect('adminweb/jasapengiriman');

	}

	public function jasapengiriman_edit() {
		$id_jasapengiriman = $this->uri->segment(3);
		$query = $this->admin_model->GetJasapengirimanEdit($id_jasapengiriman);
		foreach ($query->result_array() as $tampil) {
			$data['id_jasapengiriman'] = $tampil['id_jasapengiriman'];
			$data['nama'] = $tampil['nama'];
			$data['gambar'] = $tampil['gambar'];
		}
		$this->template->load('template','adminweb/jasapengiriman/edit',$data);
	}

	public function jasapengiriman_update() {
		$id['id_jasapengiriman'] = $this->input->post("id_jasapengiriman");

		if(empty($_FILES['userfile']['name']))
				{
					
						$in_data['nama'] = $this->input->post('nama');
					
						$this->db->update("tbl_jasapengiriman",$in_data,$id);

					$this->session->set_flashdata('update','Jasa Pengiriman Berhasil Diupdate');
					redirect("adminweb/jasapengiriman");
				}
				else
				{
					$config['upload_path'] = './images/jasapengiriman/';
					$config['allowed_types']= 'gif|jpg|png|jpeg';
					$config['encrypt_name']	= TRUE;
					$config['remove_spaces']	= TRUE;	
					$config['max_size']     = '3000';
					$config['max_width']  	= '150';
					$config['max_height']  	= '60';
					
			 
					$this->load->library('upload', $config);
	 
					if ($this->upload->do_upload("userfile")) {
						$data	 	= $this->upload->data();
			 
						/* PATH */
						$source             = "./images/jasapengiriman/".$data['file_name'] ;
						$destination_thumb	= "./images/jasapengiriman/thumb/" ;
						$destination_medium	= "./images/jasapengiriman/medium/" ;
			 
						// Permission Configuration
						chmod($source, 0777) ;
			 
						/* Resizing Processing */
						// Configuration Of Image Manipulation :: Static
						$this->load->library('image_lib') ;
						$img['image_library'] = 'GD2';
						$img['create_thumb']  = TRUE;
						$img['maintain_ratio']= TRUE;
			 
						/// Limit Width Resize
						$limit_medium   = 800 ;
						$limit_thumb    = 270 ;
			 
						// Size Image Limit was using (LIMIT TOP)
						$limit_use  = $data['image_width'] > $data['image_height'] ? $data['image_width'] : $data['image_height'] ;
			 
						// Percentase Resize
						if ($limit_use > $limit_thumb) {
							$percent_medium = $limit_medium/$limit_use ;
							$percent_thumb  = $limit_thumb/$limit_use ;
						}
			 
						//// Making THUMBNAIL ///////
						$img['width']  = $limit_use > $limit_thumb ?  $data['image_width'] * $percent_thumb : $data['image_width'] ;
						$img['height'] = $limit_use > $limit_thumb ?  $data['image_height'] * $percent_thumb : $data['image_height'] ;
			 
						// Configuration Of Image Manipulation :: Dynamic
						$img['thumb_marker'] = '';
						$img['quality']      = '100%' ;
						$img['source_image'] = $source ;
						$img['new_image']    = $destination_thumb ;
			 
						// Do Resizing
						$this->image_lib->initialize($img);
						$this->image_lib->resize();
						$this->image_lib->clear() ;
	 
						////// Making MEDIUM /////////////
						$img['width']   = $limit_use > $limit_medium ?  $data['image_width'] * $percent_medium : $data['image_width'] ;
						$img['height']  = $limit_use > $limit_medium ?  $data['image_height'] * $percent_medium : $data['image_height'] ;
			 
						// Configuration Of Image Manipulation :: Dynamic
						$img['thumb_marker'] = '';
						$img['quality']      = '100%' ;
						$img['source_image'] = $source ;
						$img['new_image']    = $destination_medium ;
			 
						// Do Resizing
						$this->image_lib->initialize($img);
						$this->image_lib->resize();
						$this->image_lib->clear() ;
						
						$in_data['nama'] = $this->input->post('nama');
						$in_data['gambar'] = $data['file_name'];
						
						$this->db->update("tbl_jasapengiriman",$in_data,$id);
				
						
						$this->session->set_flashdata('update','Jasa Pengiriman Berhasil Diupdate');
						redirect("adminweb/jasapengiriman");
						
					}
					else 
					{
						$this->template->load('template','adminweb/jasapengiriman/error');
					}
				}

	}
	//Akhir Jasa Pengiriman

	//Awal Produk 
	public function produk () {

		$data['data_produk'] = $this->admin_model->GetProduk();
		$this->template->load('template','adminweb/produk/index',$data);
	}
	//Akhir Produk

	public function produk_tambah(){
		$data['kode_produk'] = $this->admin_model->GetMaxKodeProduk();
		$data['data_brand'] = $this->admin_model->GetBrand();
		$data['data_kategori'] = $this->admin_model->GetKategori();
		$this->template->load('template','adminweb/produk/add',$data);
	}

	public function produk_simpan() {
		$this->form_validation->set_rules('nama_produk','Nama Produk','required');
		$this->form_validation->set_rules('brand_id','Brand','required');
		$this->form_validation->set_rules('kategori_id','Kategori','required');
		$this->form_validation->set_rules('harga','Harga','required');
		$this->form_validation->set_rules('stok','Stok','required');
		$this->form_validation->set_rules('deskripsi','Deskripsi','required');

		if ($this->form_validation->run()==FALSE) {

			$data['kode_produk'] = $this->admin_model->GetMaxKodeProduk();
			$data['data_brand'] = $this->admin_model->GetBrand();
			$data['data_kategori'] = $this->admin_model->GetKategori();
			$this->template->load('template','adminweb/produk/add',$data);

		}
		else {

			if(empty($_FILES['userfile']['name']))
				{
					
						$in_data['kode_produk'] = $this->input->post('kode_produk');
						$in_data['nama_produk'] = $this->input->post('nama_produk');
						$in_data['harga'] = $this->input->post('harga');
						$in_data['stok'] = $this->input->post('stok');
						$in_data['deskripsi'] = $this->input->post('deskripsi');
						$in_data['kategori_id'] = $this->input->post('kategori_id');
						$in_data['brand_id'] = $this->input->post('brand_id');
						$this->db->insert("tbl_produk",$in_data);

					$this->session->set_flashdata('berhasil','Produk Berhasil Disimpan');
					redirect("adminweb/produk");
				}
				else
				{
					$config['upload_path'] = './images/produk/';
					$config['allowed_types']= 'gif|jpg|png|jpeg';
					$config['encrypt_name']	= TRUE;
					$config['remove_spaces']	= TRUE;	
					$config['max_size']     = '3000';
					$config['max_width']  	= '268';
					$config['max_height']  	= '249';
					
			 
					$this->load->library('upload', $config);
	 
					if ($this->upload->do_upload("userfile")) {
						$data	 	= $this->upload->data();
			 
						/* PATH */
						$source             = "./images/produk/".$data['file_name'] ;
						$destination_thumb	= "./images/produk/thumb/" ;
						$destination_medium	= "./images/produk/medium/" ;
						// Permission Configuration
						chmod($source, 0777) ;
			 
						/* Resizing Processing */
						// Configuration Of Image Manipulation :: Static
						$this->load->library('image_lib') ;
						$img['image_library'] = 'GD2';
						$img['create_thumb']  = TRUE;
						$img['maintain_ratio']= TRUE;
			 
						/// Limit Width Resize
						$limit_medium   = 268 ;
						$limit_thumb    = 249 ;
			 
						// Size Image Limit was using (LIMIT TOP)
						$limit_use  = $data['image_width'] > $data['image_height'] ? $data['image_width'] : $data['image_height'] ;
			 
						// Percentase Resize
						if ($limit_use > $limit_thumb) {
							$percent_medium = $limit_medium/$limit_use ;
							$percent_thumb  = $limit_thumb/$limit_use ;
						}
			 
						//// Making THUMBNAIL ///////
						$img['width']  = $limit_use > $limit_thumb ?  $data['image_width'] * $percent_thumb : $data['image_width'] ;
						$img['height'] = $limit_use > $limit_thumb ?  $data['image_height'] * $percent_thumb : $data['image_height'] ;
			 
						// Configuration Of Image Manipulation :: Dynamic
						$img['thumb_marker'] = '';
						$img['quality']      = '100%' ;
						$img['source_image'] = $source ;
						$img['new_image']    = $destination_thumb ;
			 
						// Do Resizing
						$this->image_lib->initialize($img);
						$this->image_lib->resize();
						$this->image_lib->clear() ;

						$img['width']   = $limit_use > $limit_medium ?  $data['image_width'] * $percent_medium : $data['image_width'] ;
						$img['height']  = $limit_use > $limit_medium ?  $data['image_height'] * $percent_medium : $data['image_height'] ;
			 
			 			// Configuration Of Image Manipulation :: Dynamic
						$img['thumb_marker'] = '';
						$img['quality']      = '100%' ;
						$img['source_image'] = $source ;
						$img['new_image']    = $destination_medium ;
			 
						// Do Resizing
						$this->image_lib->initialize($img);
						$this->image_lib->resize();
						$this->image_lib->clear() ;
						
						$in_data['kode_produk'] = $this->input->post('kode_produk');
						$in_data['nama_produk'] = $this->input->post('nama_produk');
						$in_data['harga'] = $this->input->post('harga');
						$in_data['stok'] = $this->input->post('stok');
						$in_data['deskripsi'] = $this->input->post('deskripsi');
						$in_data['kategori_id'] = $this->input->post('kategori_id');
						$in_data['brand_id'] = $this->input->post('brand_id');
						$in_data['gambar'] = $data['file_name'];
						
						
						
						$this->db->insert("tbl_produk",$in_data);

						

				
						
						$this->session->set_flashdata('berhasil','Produk Berhasil Disimpan');
						redirect("adminweb/produk");
						
					}
					else 
					{
						$this->template->load('template','adminweb/produk/error');
					}
				}

		}
	}

	public function produk_delete() {
		$id_produk = $this->uri->segment(3);
		$this->admin_model->DeleteProduk($id_produk);

		$this->session->set_flashdata('message','Produk Berhasil Dihapus');
		redirect('adminweb/produk');

	}

	public function produk_edit() {
		$id_produk = $this->uri->segment(3);
		$query = $this->admin_model->EditProduk($id_produk);
		foreach ($query->result_array() as $tampil) {

			$data['id_produk']= $tampil['id_produk'];
			$data['kode_produk']= $tampil['kode_produk'];
			$data['nama_produk']= $tampil['nama_produk'];
			$data['harga']= $tampil['harga'];
			$data['stok']= $tampil['stok'];
			$data['deskripsi']= $tampil['deskripsi'];
			$data['kategori_id']= $tampil['kategori_id'];
			$data['brand_id']= $tampil['brand_id'];
			
		}
		$data['data_kategori'] = $this->admin_model->GetKategori();
		$data['data_brand']  = $this->admin_model->GetBrand();
		$this->template->load('template','adminweb/produk/edit',$data);
	}

	public function produk_update() {
		$id['id_produk'] = $this->input->post("id_produk");

		if(empty($_FILES['userfile']['name']))
				{
					
						$in_data['kode_produk'] = $this->input->post('kode_produk');
						$in_data['nama_produk'] = $this->input->post('nama_produk');
						$in_data['harga'] = $this->input->post('harga');
						$in_data['stok'] = $this->input->post('stok');
						$in_data['deskripsi'] = $this->input->post('deskripsi');
						$in_data['kategori_id'] = $this->input->post('kategori_id');
						$in_data['brand_id'] = $this->input->post('brand_id');
					
						$this->db->update("tbl_produk",$in_data,$id);

					$this->session->set_flashdata('update','Produk Berhasil Diupdate');
					redirect("adminweb/produk");
				}
				else
				{
					$config['upload_path'] = './images/produk/';
					$config['allowed_types']= 'gif|jpg|png|jpeg';
					$config['encrypt_name']	= TRUE;
					$config['remove_spaces']	= TRUE;	
					$config['max_size']     = '3000';
					$config['max_width']  	= '268';
					$config['max_height']  	= '249';
					
			 
					$this->load->library('upload', $config);
	 
					if ($this->upload->do_upload("userfile")) {
						$data	 	= $this->upload->data();
			 
						/* PATH */
						$source             = "./images/produk/".$data['file_name'] ;
						$destination_thumb	= "./images/produk/thumb/" ;
						$destination_medium	= "./images/produk/medium/" ;
			 
						// Permission Configuration
						chmod($source, 0777) ;
			 
						/* Resizing Processing */
						// Configuration Of Image Manipulation :: Static
						$this->load->library('image_lib') ;
						$img['image_library'] = 'GD2';
						$img['create_thumb']  = TRUE;
						$img['maintain_ratio']= TRUE;
			 
						/// Limit Width Resize
						$limit_medium   = 268 ;
						$limit_thumb    = 249 ;
			 
						// Size Image Limit was using (LIMIT TOP)
						$limit_use  = $data['image_width'] > $data['image_height'] ? $data['image_width'] : $data['image_height'] ;
			 
						// Percentase Resize
						if ($limit_use > $limit_thumb) {
							$percent_medium = $limit_medium/$limit_use ;
							$percent_thumb  = $limit_thumb/$limit_use ;
						}
			 
						//// Making THUMBNAIL ///////
						$img['width']  = $limit_use > $limit_thumb ?  $data['image_width'] * $percent_thumb : $data['image_width'] ;
						$img['height'] = $limit_use > $limit_thumb ?  $data['image_height'] * $percent_thumb : $data['image_height'] ;
			 
						// Configuration Of Image Manipulation :: Dynamic
						$img['thumb_marker'] = '';
						$img['quality']      = '100%' ;
						$img['source_image'] = $source ;
						$img['new_image']    = $destination_thumb ;
			 
						// Do Resizing
						$this->image_lib->initialize($img);
						$this->image_lib->resize();
						$this->image_lib->clear() ;
	 
						////// Making MEDIUM /////////////
						$img['width']   = $limit_use > $limit_medium ?  $data['image_width'] * $percent_medium : $data['image_width'] ;
						$img['height']  = $limit_use > $limit_medium ?  $data['image_height'] * $percent_medium : $data['image_height'] ;
			 
						// Configuration Of Image Manipulation :: Dynamic
						$img['thumb_marker'] = '';
						$img['quality']      = '100%' ;
						$img['source_image'] = $source ;
						$img['new_image']    = $destination_medium ;
			 
						// Do Resizing
						$this->image_lib->initialize($img);
						$this->image_lib->resize();
						$this->image_lib->clear() ;
						
						$in_data['kode_produk'] = $this->input->post('kode_produk');
						$in_data['nama_produk'] = $this->input->post('nama_produk');
						$in_data['harga'] = $this->input->post('harga');
						$in_data['stok'] = $this->input->post('stok');
						$in_data['deskripsi'] = $this->input->post('deskripsi');
						$in_data['kategori_id'] = $this->input->post('kategori_id');
						$in_data['brand_id'] = $this->input->post('brand_id');
						$in_data['gambar'] = $data['file_name'];
						
						$this->db->update("tbl_produk",$in_data,$id);
				
						
						$this->session->set_flashdata('update','Produk Berhasil Diupdate');
						redirect("adminweb/produk");
						
					}
					else 
					{
						$this->template->load('template','adminweb/produk/error');
					}
				}

	}

	//Akhir Produk

	//Awal Slider 
	public function slider () {

		$data['data_slider'] = $this->admin_model->GetSlider();
		$this->template->load('template','adminweb/slider/index',$data);
	}
	

	public function slider_tambah(){
		
		$this->template->load('template','adminweb/slider/add');
	}

	public function slider_simpan() {
		$this->form_validation->set_rules('tittle','Tittle','required');
		$this->form_validation->set_rules('description','Description','required');

		if ($this->form_validation->run()==FALSE) {

			$this->template->load('template','adminweb/produk/add');

		}
		else {

			if(empty($_FILES['userfile']['name']))
				{
					
						$in_data['tittle'] = $this->input->post('tittle');
						$in_data['description'] = $this->input->post('description');
						$in_data['status'] = $this->input->post('status');
						$this->db->insert("tbl_slider",$in_data);

					$this->session->set_flashdata('berhasil','Slider Berhasil Disimpan');
					redirect("adminweb/produk");
				}
				else
				{
					$config['upload_path'] = './images/slider/';
					$config['allowed_types']= 'gif|jpg|png|jpeg';
					$config['encrypt_name']	= TRUE;
					$config['remove_spaces']	= TRUE;	
					$config['max_size']     = '3000';
					$config['max_width']  	= '484';
					$config['max_height']  	= '441';
					
			 
					$this->load->library('upload', $config);
	 
					if ($this->upload->do_upload("userfile")) {
						$data	 	= $this->upload->data();
			 
						/* PATH */
						$source             = "./images/slider/".$data['file_name'] ;
						$destination_thumb	= "./images/slider/thumb/" ;
						$destination_medium	= "./images/slider/medium/" ;
						// Permission Configuration
						chmod($source, 0777) ;
			 
						/* Resizing Processing */
						// Configuration Of Image Manipulation :: Static
						$this->load->library('image_lib') ;
						$img['image_library'] = 'GD2';
						$img['create_thumb']  = TRUE;
						$img['maintain_ratio']= TRUE;
			 
						/// Limit Width Resize
						$limit_medium   = 481 ;
						$limit_thumb    = 441 ;
			 
						// Size Image Limit was using (LIMIT TOP)
						$limit_use  = $data['image_width'] > $data['image_height'] ? $data['image_width'] : $data['image_height'] ;
			 
						// Percentase Resize
						if ($limit_use > $limit_thumb) {
							$percent_medium = $limit_medium/$limit_use ;
							$percent_thumb  = $limit_thumb/$limit_use ;
						}
			 
						//// Making THUMBNAIL ///////
						$img['width']  = $limit_use > $limit_thumb ?  $data['image_width'] * $percent_thumb : $data['image_width'] ;
						$img['height'] = $limit_use > $limit_thumb ?  $data['image_height'] * $percent_thumb : $data['image_height'] ;
			 
						// Configuration Of Image Manipulation :: Dynamic
						$img['thumb_marker'] = '';
						$img['quality']      = '100%' ;
						$img['source_image'] = $source ;
						$img['new_image']    = $destination_thumb ;
			 
						// Do Resizing
						$this->image_lib->initialize($img);
						$this->image_lib->resize();
						$this->image_lib->clear() ;

						$img['width']   = $limit_use > $limit_medium ?  $data['image_width'] * $percent_medium : $data['image_width'] ;
						$img['height']  = $limit_use > $limit_medium ?  $data['image_height'] * $percent_medium : $data['image_height'] ;
			 
			 			// Configuration Of Image Manipulation :: Dynamic
						$img['thumb_marker'] = '';
						$img['quality']      = '100%' ;
						$img['source_image'] = $source ;
						$img['new_image']    = $destination_medium ;
			 
						// Do Resizing
						$this->image_lib->initialize($img);
						$this->image_lib->resize();
						$this->image_lib->clear() ;
						
						$in_data['tittle'] = $this->input->post('tittle');
						$in_data['description'] = $this->input->post('description');
						$in_data['status'] = $this->input->post('status');
						$in_data['gambar'] = $data['file_name'];
						
						
						
						$this->db->insert("tbl_slider",$in_data);

						

				
						
						$this->session->set_flashdata('berhasil','Slider Berhasil Disimpan');
						redirect("adminweb/slider");
						
					}
					else 
					{
						$this->template->load('template','adminweb/slider/error');
					}
				}

		}
	}

	public function slider_delete() {
		$id_slider = $this->uri->segment(3);
		$this->admin_model->DeleteSlider($id_slider);

		$this->session->set_flashdata('message','Slider Berhasil Dihapus');
		redirect('adminweb/slider');

	}

	public function slider_edit() {
		$id_slider = $this->uri->segment(3);
		$query = $this->admin_model->EditSlider($id_slider);
		foreach ($query->result_array() as $tampil) {

			$data['id_slider']= $tampil['id_slider'];
			$data['tittle']= $tampil['tittle'];
			$data['description']= $tampil['description'];
			$data['status']= $tampil['status'];
			
			
		}
		
		$this->template->load('template','adminweb/slider/edit',$data);
	}

	public function slider_update() {
		$id['id_slider'] = $this->input->post("id_slider");

		if(empty($_FILES['userfile']['name']))
				{
					
						$in_data['tittle'] = $this->input->post('tittle');
						$in_data['description'] = $this->input->post('description');
						$in_data['status'] = $this->input->post('status');
						
					
						$this->db->update("tbl_slider",$in_data,$id);

					$this->session->set_flashdata('update','Slider Berhasil Diupdate');
					redirect("adminweb/slider");
				}
				else
				{
					$config['upload_path'] = './images/slider/';
					$config['allowed_types']= 'gif|jpg|png|jpeg';
					$config['encrypt_name']	= TRUE;
					$config['remove_spaces']	= TRUE;	
					$config['max_size']     = '3000';
					$config['max_width']  	= '481';
					$config['max_height']  	= '441';
					
			 
					$this->load->library('upload', $config);
	 
					if ($this->upload->do_upload("userfile")) {
						$data	 	= $this->upload->data();
			 
						/* PATH */
						$source             = "./images/slider/".$data['file_name'] ;
						$destination_thumb	= "./images/slider/thumb/" ;
						$destination_medium	= "./images/slider/medium/" ;
			 
						// Permission Configuration
						chmod($source, 0777) ;
			 
						/* Resizing Processing */
						// Configuration Of Image Manipulation :: Static
						$this->load->library('image_lib') ;
						$img['image_library'] = 'GD2';
						$img['create_thumb']  = TRUE;
						$img['maintain_ratio']= TRUE;
			 
						/// Limit Width Resize
						$limit_medium   = 481 ;
						$limit_thumb    = 441 ;
			 
						// Size Image Limit was using (LIMIT TOP)
						$limit_use  = $data['image_width'] > $data['image_height'] ? $data['image_width'] : $data['image_height'] ;
			 
						// Percentase Resize
						if ($limit_use > $limit_thumb) {
							$percent_medium = $limit_medium/$limit_use ;
							$percent_thumb  = $limit_thumb/$limit_use ;
						}
			 
						//// Making THUMBNAIL ///////
						$img['width']  = $limit_use > $limit_thumb ?  $data['image_width'] * $percent_thumb : $data['image_width'] ;
						$img['height'] = $limit_use > $limit_thumb ?  $data['image_height'] * $percent_thumb : $data['image_height'] ;
			 
						// Configuration Of Image Manipulation :: Dynamic
						$img['thumb_marker'] = '';
						$img['quality']      = '100%' ;
						$img['source_image'] = $source ;
						$img['new_image']    = $destination_thumb ;
			 
						// Do Resizing
						$this->image_lib->initialize($img);
						$this->image_lib->resize();
						$this->image_lib->clear() ;
	 
						////// Making MEDIUM /////////////
						$img['width']   = $limit_use > $limit_medium ?  $data['image_width'] * $percent_medium : $data['image_width'] ;
						$img['height']  = $limit_use > $limit_medium ?  $data['image_height'] * $percent_medium : $data['image_height'] ;
			 
						// Configuration Of Image Manipulation :: Dynamic
						$img['thumb_marker'] = '';
						$img['quality']      = '100%' ;
						$img['source_image'] = $source ;
						$img['new_image']    = $destination_medium ;
			 
						// Do Resizing
						$this->image_lib->initialize($img);
						$this->image_lib->resize();
						$this->image_lib->clear() ;
						
						$in_data['tittle'] = $this->input->post('tittle');
						$in_data['description'] = $this->input->post('description');
						$in_data['status'] = $this->input->post('status');
						$in_data['gambar'] = $data['file_name'];
						
						$this->db->update("tbl_slider",$in_data,$id);
				
						
						$this->session->set_flashdata('update','Slider Berhasil Diupdate');
						redirect("adminweb/slider");
						
					}
					else 
					{
						$this->template->load('template','adminweb/slider/error');
					}
				}

	}

	//Akhir Slider

	//Awal Buku Tamu
	public function buku_tamu() {

		if($this->session->userdata("logged_in")!=="") {

			$data['data_buku_tamu'] = $this->admin_model->GetBukuTamu();

			$this->template->load('template','adminweb/buku_tamu/index',$data);
		}
		else {
			redirect("adminweb");
		}
	}

	public function buku_tamu_hapus() {

		$id = $this->uri->segment(3);
		$this->admin_model->DeleteBukuTamu($id);
		
		$this->session->set_flashdata('message','Pesan Berhasil Dihapus');
		redirect("adminweb/buku_tamu");
	}

	public function buku_tamu_detail() {

		$id = $this->uri->segment(3);
		$status ="1";
		$query = $this->admin_model->DetailBukuTamu($id);
		foreach ($query->result_array() as $tampil) {
			$data['id_hubungikami'] = $tampil['id_hubungikami'];
			$data['nama'] = $tampil['nama'];
			$data['email'] = $tampil['email'];
			$data['hp'] = $tampil['hp'];
			$data['alamat'] = $tampil['alamat'];
			$data['pesan'] = $tampil['pesan'];
			$data['tanggal'] = $tampil['tanggal'];
		}

		$this->admin_model->UpdateStatusBukuTamu($status,$id);
		
		$this->template->load('template','adminweb/buku_tamu/detail',$data);
	}

	public function buku_tamu_balas() {
		if($this->session->userdata("logged_in")!=="") {

			$id = $this->uri->segment(3);
			$query = $this->admin_model->DetailBukuTamu($id);
			foreach ($query->result_array() as $tampil) {
				$data['id_hubungikami'] = $tampil['id_hubungikami'];
				$data['nama'] = $tampil['nama'];
				$data['email'] = $tampil['email'];
				$data['hp'] = $tampil['hp'];
				$data['alamat'] = $tampil['alamat'];
				$data['pesan'] = $tampil['pesan'];
				$data['tanggal'] = $tampil['tanggal'];
			}

			$this->template->load('template','adminweb/buku_tamu/balas',$data);
		}
		else {
			redirect("adminweb");
		}
	}

	public function buku_tamu_balas_simpan() {
		$email = $this->input->post("email");
		$judul = $this->input->post("judul");
		$isi_hubungi_kami_kirim = $this->input->post("isi_hubungi_kami_kirim");

		$this->admin_model->SimpanBukuTamuAdd($email,$judul,$isi_hubungi_kami_kirim);

		$this->load->library('email');
		$this->email->from('info@adriano.com', 'Adriano MX Online Shop');
		$this->email->to($email); 	
		$this->email->subject($judul);
		$this->email->message($isi_hubungi_kami_kirim);	
		$this->email->send();
	}


	public function buku_tamu_add() {
		if($this->session->userdata("logged_in")!=="") {

			$this->template->load('template','adminweb/buku_tamu/add');
		}
		else {
			redirect("adminweb");
		}
	}

	public function buku_tamu_add_simpan() {
		$email = $this->input->post("email");
		$judul = $this->input->post("judul");
		$isi_hubungi_kami_kirim = $this->input->post("isi_hubungi_kami_kirim");

		$this->admin_model->SimpanBukuTamuAdd($email,$judul,$isi_hubungi_kami_kirim);

		$this->load->library('email');
		$this->email->from('info@adriano.com', 'Adriano MX Online Shop');
		$this->email->to($email); 	
		$this->email->subject($judul);
		$this->email->message($isi_hubungi_kami_kirim);	
		$this->email->send();
	}

	public function buku_tamu_kirim() {

		if($this->session->userdata("logged_in")!=="") {

			$data['data_buku_tamu_kirim'] = $this->admin_model->GetBukuTamuKirim();

			$this->template->load('template','adminweb/buku_tamu/kirim',$data);
		}
		else {
			redirect("adminweb");
		}
	}

	public function buku_tamu_kirim_hapus() {

		$id = $this->uri->segment(3);
		$this->admin_model->DeleteBukuTamuKirim($id);
		
		$this->session->set_flashdata('message','Pesan Berhasil Dihapus');
		redirect("adminweb/buku_tamu_kirim");
	}

	public function buku_tamu_kirim_detail() {

		$id = $this->uri->segment(3);
		$query = $this->admin_model->DetailBukuTamuKirim($id);
		foreach ($query->result_array() as $tampil) {
			$data['id_hubungi_kami_kirim'] = $tampil['id_hubungi_kami_kirim'];
			$data['kepada'] = $tampil['kepada'];
			$data['judul'] = $tampil['judul'];
			$data['isi_hubungi_kami_kirim'] = $tampil['isi_hubungi_kami_kirim'];
			
		}

		
		$this->template->load('template','adminweb/buku_tamu/detail_kirim',$data);
	}
	//Akhir Buku Tamu


	public function transaksi() {


		if($this->session->userdata("logged_in")!=="") {

			$data['data_transaksi'] = $this->admin_model->GetTransaksi();

			$this->template->load('template','adminweb/transaksi/index',$data);
		}
		else {
			redirect("adminweb");
		}

	}

	public function transaksi_proses () {

		if($this->session->userdata("logged_in")!=="") {

			$id  = $this->uri->segment(3);

			$this->admin_model->UpdateTransaksiHeader($id);

			$this->session->set_flashdata('berhasil','Transaksi Berhasil Di Proses');
			redirect("adminweb/transaksi");




		}
		else {
			redirect("adminweb");
		}

	}

	public function transaksi_detail () {

		if($this->session->userdata("logged_in")!=="") {

			$id  			= $this->uri->segment(3);
			$kode_transaksi = $this->uri->segment(4);

			$data['data_header'] 	= $this->admin_model->GetTransaksiheader($id);  
			$data['data_detail']	= $this->admin_model->GetDetailTransaksi($kode_transaksi);
			$data['data_total']		= $this->admin_model->GetDetailTotal($kode_transaksi);

			$this->template->load('template','adminweb/transaksi/detail',$data);

		}
		else {
			redirect("adminweb");
		}

	}

	public function semua_transaksi () {

		if($this->session->userdata("logged_in")!=="") {

			$data['data_transaksi'] = $this->admin_model->GetTransaksiSudah();

			$this->template->load('template','adminweb/transaksi/sudah',$data);


		}
		else {
			redirect("adminweb");
		}

	}

	public function semua_transaksi_detail () {

		if($this->session->userdata("logged_in")!=="") {

			$id  			= $this->uri->segment(3);
			$kode_transaksi = $this->uri->segment(4);

			$data['data_header'] 	= $this->admin_model->GetTransaksiheader($id);  
			$data['data_detail']	= $this->admin_model->GetDetailTransaksi($kode_transaksi);
			$data['data_total']		= $this->admin_model->GetDetailTotal($kode_transaksi);

			$this->template->load('template','adminweb/transaksi/detail_semua',$data);

		}
		else {
			redirect("adminweb");
		}

	}

}