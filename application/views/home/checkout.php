<!DOCTYPE html>
<html lang="en">
<head>
	<?php
	foreach ($seo->result_array() as $value) {
		$tittle = $value['tittle'];
		$keyword = $value['keyword'];
		$description = $value['description'];
	}
	?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keyword" content="<?php echo $keyword;?>">
    <meta name="description" content="<?php echo $description;?>">
    <meta name="author" content="">
    <title>Home | <?php echo $tittle;?></title>
    <link href="<?php echo base_url();?>asset/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>asset/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>asset/css/prettyPhoto.css" rel="stylesheet">
    <link href="<?php echo base_url();?>asset/css/price-range.css" rel="stylesheet">
    <link href="<?php echo base_url();?>asset/css/animate.css" rel="stylesheet">
	<link href="<?php echo base_url();?>asset/css/main.css" rel="stylesheet">
	<link href="<?php echo base_url();?>asset/css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="<?php echo base_url();?>asset/js/html5shiv.js"></script>
    <script src="<?php echo base_url();?>asset/js/respond.min.js"></script>
    <![endif]-->       
    <!-- <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png"> -->
</head><!--/head-->

<body>
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<?php 
						foreach ($kontak->result_array() as $value) {
							$alamat = $value['alamat'];
							$phone = $value['phone'];
							$email = $value['email'];
						}
						?>
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> <?php echo $phone ?></a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> <?php echo $email ?></a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<?php 
							foreach ($sosial_media->result_array() as $value) {
								$tw = $value['tw'];
								$fb = $value['fb'];
								$gp = $value['gp'];
							}
							?>
							<ul class="nav navbar-nav">
								<li><a href="<?php echo $fb;?>"><i class="fa fa-facebook"></i></a></li>
								<li><a href="<?php echo $tw;?>"><i class="fa fa-twitter"></i></a></li>
								<li><a href="<?php echo $gp;?>"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<?php
							foreach ($logo->result_array() as $value) {
								$logo = $value['gambar'];
							}

							?>
							<a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>images/logo/<?php echo $logo;?>" alt="Adriano MX Online Shop" /></a>
						</div>
						<div class="btn-group pull-right">
							
							
							
						</div>
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
								<li><a href="<?php echo base_url();?>home/tentang_kami"> Tentang Kami</a></li>
								<li><a href="<?php echo base_url();?>home/cara_belanja"> Cara Belanja</a></li>
								<li><a href="<?php echo base_url();?>home/hubungi_kami"> Hubungi Kami</a></li>
								<li><a href="<?php echo base_url();?>home/keranjang"> Keranjang Belanja</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	
		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-9">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="<?php echo base_url();?>" class="active">Home</a></li>
								<li class="dropdown"><a href="#">Category<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                    	<?php
                                    	foreach ($kategori->result_array() as $value) { ?>
                                    		
                                        <li><a href="<?php echo base_url();?>home/kategori/<?php echo $value['id_kategori'];?>"><?php echo $value['nama_kategori'];?></a></li>
                                    	<?php
                                    	}
                                    	?>
										 
                                    </ul>
                                </li> 
								
								
							</ul>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="search_box pull-right">
							<input type="text" placeholder="Search"/>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->
	
	
	<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="<?php echo base_url();?>">Home</a></li>
				  <li class="active">Shopping Cart</li>
				</ol>
			</div>
			<?php if(!$this->cart->contents()):
				echo 'Maaf, Keranjang Belanja Anda Masih Kosong.';
			else:
			?>
			<?php echo form_open('home/checkout_update'); ?>
			<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Jumlah</td>
							<td class="description">Nama Barang</td>
							<td class="price">Harga</td>
							<td class="quantity">Sub Total</td>
							<td class="total">Hapus</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						
						<?php $i = 1; ?>
		<?php foreach($this->cart->contents() as $items): ?>
		
		<?php echo form_hidden('rowid[]', $items['rowid']); ?>
		<tr <?php if($i&1){ echo 'class="alt"'; }?>>
	  		<td class="td-keranjang">
			<select name="qty[]" class="input-teks">
	  			<?php 
				for($i=1;$i<=200;$i+=1)
				{
				if($i==$items['qty'])
				{
					echo "<option selected>".$items['qty']."</option>";
					
				}
				else
				{
					echo "<option>".$i."</option>";
				}
				}	
				?>
			</select>
	  		</td>
	  		
	  		<td class="td-keranjang"><?php echo $items['name']; ?></td>
	  		
	  		<td class="td-keranjang">Rp. <?php echo $this->cart->format_number($items['price']); ?></td>
	  		<td class="td-keranjang">Rp. <?php echo $this->cart->format_number($items['subtotal']); ?></td>
 		 	<td class="td-keranjang" align="center"><a href="<?php echo base_url(); ?>home/checkout_hapus/<?php echo $items['rowid']; ?>"><i class="fa fa-times"></i></a></td>
	  	</tr>
	  	
	  	<?php $i++; ?>
		<?php endforeach; ?>
		
		<tr>
			<td class="td-keranjang" colspan=3><b>Total Belanja</b></td>
 		 	<td class="td-keranjang" colspan=2>Rp. <?php echo $this->cart->format_number($this->cart->total()); ?></td>
		</tr>
						
						
					</tbody>
				</table>
				<input type="submit" class="btn btn-default get" value="Update Keranjang">
				
			</div>
			<?php 
echo form_close(); 
endif;
?>



			<div class="register-req">
			<ul>
				<li>Apabila Anda mengubah jumlah (Qty), jangan lupa tekan tombol Update Keranjang Belanja</li>
				<li>Untuk menghaspus barang pada keranjang belanja, klik tombol Hapus.</li>
				<!-- <li>Total harga di atas belum termasuk ongkos kirim yang akan dihitung saat Selesai Belanja</li> -->
			</ul>
		</div>

		<?php if(validation_errors()) { ?>
                                <div class="alert alert-block alert-danger show">
                                  <button type="button" class="close" data-dismiss="alert">×</button>
                                    <?php echo validation_errors(); ?>
                                </div>
                                <?php 
                                } 
                                ?>

		

		<div class="shopper-informations">
				<div class="row">
					<div class="col-sm-3">
						<div class="shopper-info">
							<p>Data Pembeli</p>
							<?php echo form_open('home/checkout_invoice');?>
								<input type="text" placeholder="Nama Penerima" name="penerima">
								<input type="text" placeholder="Email Penerima" name="email">
								<input type="text" placeholder="Alamat Penerima" name="alamat">
								<input type="text" placeholder="No Telp" name="no_telepon">
								<input type="text" placeholder="Propinsi" name="propinsi">
								<input type="text" placeholder="Kota" name="kota">
								<input type="text" placeholder="Kode Pos" name="kode_pos">
								
							
							
							
						</div>
					</div>
					<div class="col-sm-5 clearfix">
						<div class="bill-to">
							<p>Metode Pembayaran</p>
							<div class="form-two">
								
									<select name="bank_id">
										<?php
										foreach ($bank->result_array() as $value) { ?>
											<option value="<?php echo $value['id_bank'];?>"><?php echo $value['nama_bank'];?>- <?php echo $value['no_rekening'];?></option>
										<?php
										}
										?>
									</select>
									<select name="jasapengiriman_id">
										<?php
										foreach ($jasapengiriman->result_array() as $value) { ?>
											<option value="<?php echo $value['id_jasapengiriman'];?>"><?php echo $value['nama'];?></option>
										<?php
										}
										?>
									</select>
								
								<button class="btn btn-primary" type="submit">Kirim</button> 
								<?php echo form_close();?>
							</div>
							
						</div>
					</div>
								
				</div>
			</div>
		
		</div>

		
		
	</section> <!--/#cart_items-->
	
	
	<footer id="footer"><!--Footer-->
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="companyinfo">
							<h2><span>Adriano MX</span>-Shop</h2>
							<!-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,sed do eiusmod tempor</p> -->
						</div>
					</div>
					<div class="col-sm-7">
						<?php
						foreach ($bank->result_array() as $value) {?>

						<div class="col-sm-3">
							<div class="video-gallery text-center">
								
									<div class="">
										<img src="<?php echo base_url();?>/images/bank/<?php echo $value['gambar'];?>" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								
								<p><?php echo $value['nama_pemilik'];?></p>
								<h2><?php echo $value['no_rekening'];?></h2>
							</div>
						</div>
							
						<?php
						}
						?>
						
					</div>
					<div class="col-sm-3">
						<div class="address">
							
						</div>
					</div>
				</div>
			</div>
		</div>
		
		
		
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">Copyright © 2014 Adriano MX Online Shop. All rights reserved.</p>
					
				</div>
			</div>
		</div>
		
	</footer><!--/Footer-->
	

  
    <script src="<?php echo base_url();?>asset/js/jquery.js"></script>
	<script src="<?php echo base_url();?>asset/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>asset/js/jquery.scrollUp.min.js"></script>
	<script src="<?php echo base_url();?>asset/js/price-range.js"></script>
    <script src="<?php echo base_url();?>asset/js/jquery.prettyPhoto.js"></script>
    <script src="<?php echo base_url();?>asset/js/main.js"></script>
</body>
</html>