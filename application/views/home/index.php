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
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
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
						<?php echo form_open('home/cari');?>
						<div class="search_box pull-right">
							<input type="text" name="cari" placeholder="Search"/>
						</div>
						<?php echo form_close();?>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->

	
	
	<section id="slider"><!--slider-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="slider-carousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
							<li data-target="#slider-carousel" data-slide-to="1"></li>
							<li data-target="#slider-carousel" data-slide-to="2"></li>
						</ol>
						
						<div class="carousel-inner">
							
							<?php
							$terakhir = $this->db->query("select max(id_slider) as terakhir from tbl_slider where status='1' ");
								foreach ($terakhir->result_array() as $value) {
									$t = $value['terakhir'];
								}
							?>
							<?php
							foreach ($slider->result_array() as $value) { 

								if ($value['id_slider']==$t) { ?>
								<div class="item active">
									<div class="col-sm-6">
										<h1><span>Adriano MX</span>-Shop</h1>
										<h2><?php echo $value['tittle'];?></h2>
										<p><?php echo strip_tags(substr($value['description'],0,200));?></p>
										<a href="<?php echo base_url();?>home/detail_slider/<?php echo $value['id_slider'];?>" class="btn btn-default get"> Read More</a>
									</div>
									<div class="col-sm-6">
										<img src="<?php echo base_url();?>images/slider/<?php echo $value['gambar'];?>" class="girl img-responsive" alt="<?php echo $value['tittle'];?>" />
										
									</div>
								</div>

								<?php
								}
								else { ?>
								<div class="item">
									<div class="col-sm-6">
										<h1><span>Adriano MX</span>-Shop</h1>
										<h2><?php echo $value['tittle'];?></h2>
										<p><?php echo strip_tags(substr($value['description'],0,200));?></p>
										<a href="<?php echo base_url();?>home/detail_slider/<?php echo $value['id_slider'];?>" class="btn btn-default get"> Read More</a>
									</div>
									<div class="col-sm-6">
										<img src="<?php echo base_url();?>images/slider/<?php echo $value['gambar'];?>" class="girl img-responsive" alt="<?php echo $value['tittle'];?>" />
										
									</div>
								</div>
								<?php
								}

							?>
							
							<?php
							}
							?>
							
							
						</div>
						
						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
					
				</div>
			</div>
		</div>
	</section><!--/slider-->
	
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>Category</h2>
						<div class="panel-group category-products" id="accordian"><!--category-productsr-->
							
							
							<?php

							foreach ($kategori->result_array() as $value) {?>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="<?php echo base_url();?>home/kategori/<?php echo $value['id_kategori'];?>"><?php echo $value['nama_kategori'];?></a></h4>
								</div>
							</div>		
							<?php
							}
							?>	
						
							

						</div><!--/category-products-->
					
						<div class="brands_products"><!--brands_products-->
							<h2>Brands</h2>
							<div class="brands-name">
								<ul class="nav nav-pills nav-stacked">
									<?php
									foreach ($brand->result_array() as $value) { ?>
									<li><a href="<?php echo base_url();?>home/brand/<?php echo $value['id_brand'];?>"> <span class="pull-right"></span><?php echo $value['nama_brand'];?></a></li>
									
									<?php
									}
									?>
									
									
								</ul>
							</div>
						</div><!--/brands_products-->
					</br>

						<div class="brands_products"><!--Jasa Pengiriman-->
							<h2>Pengiriman</h2>
							<div class="brands-name">
								<ul class="nav nav-pills nav-stacked">
									<?php
									foreach ($jasapengiriman->result_array() as $value) { ?>
									<li><a href=""> <span class="pull-right"></span>
										<img src="<?php echo base_url();?>images/jasapengiriman/<?php echo $value['gambar'];?>">
										</a>
									</li>
									
									<?php
									}
									?>
									
									
								</ul>
							</div>
						</div><!--/Jasa Pengiriman-->
						
						
						
						
					
					</div>
				</div>
				
				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Features Producs</h2>
						
						<?php
						foreach ($produk->result_array() as $value) { ?>
						<div class="col-sm-4">
							<div class="product-image-wrapper">
								<div class="single-products">
										<div class="productinfo text-center">
											<img src="<?php echo base_url();?>images/produk/<?php echo $value['gambar'];?>" alt="" />
											<h2><?php echo $value['harga'];?></h2>
											<p><?php echo $value['kode_produk'];?></p>
											<a href="<?php echo base_url();?>home/produk/<?php echo $value['id_produk'];?>"><p> <?php echo $value['nama_produk'];?></p></a>
											<a href="<?php echo base_url();?>home/keranjang/<?php echo $value['id_produk'];?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
										</div>
										<div class="product-overlay">
											<div class="overlay-content">
												<h2><?php echo $value['harga'];?></h2>
												<p><?php echo $value['kode_produk'];?></p>
												<a href="<?php echo base_url();?>home/produk/<?php echo $value['id_produk'];?>"><p> <?php echo $value['nama_produk'];?></p></a>
												<a href="<?php echo base_url();?>home/keranjang/<?php echo $value['id_produk'];?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
											</div>
										</div>
								</div>
							</div>
						</div>
						<?php
						}
						?>
						
						
						
						
						
						
						
					</div><!--features_items-->
					
					
					
					<div class="recommended_items"><!--recommended_items-->
						<h2 class="title text-center">recommended items</h2>
						
						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								
										
										<div class="item active">	
											<?php
									foreach ($random_active->result_array() as $value) { ?>
										<div class="col-sm-4">
											<div class="product-image-wrapper">
												<div class="single-products">
													<div class="productinfo text-center">
														<img src="<?php echo base_url();?>images/produk/<?php echo $value['gambar'];?>" alt="" />
														<h2><?php echo $value['harga'];?></h2>
														<p><?php echo $value['kode_produk'];?></p>
														<a href="<?php echo base_url();?>home/produk/<?php echo $value['id_produk'];?>"><p> <?php echo $value['nama_produk'];?></p></a>
														<a href="<?php echo base_url();?>home/keranjang/<?php echo $value['id_produk'];?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
													</div>
													
												</div>
											</div>
										</div>
										<?php
									}
									?>
									</div>
									

									
									<div class="item">	
										<?php
									foreach ($random->result_array() as $value) { ?>
										<div class="col-sm-4">
											<div class="product-image-wrapper">
												<div class="single-products">
													<div class="productinfo text-center">
														<img src="<?php echo base_url();?>images/produk/<?php echo $value['gambar'];?>" alt="" />
														<h2><?php echo $value['harga'];?></h2>
														<p><?php echo $value['kode_produk'];?></p>
														<a href="<?php echo base_url();?>home/produk/<?php echo $value['id_produk'];?>"><p> <?php echo $value['nama_produk'];?></p></a>
														<a href="<?php echo base_url();?>home/keranjang/<?php echo $value['id_produk'];?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
													</div>
													
												</div>
											</div>
										</div>
										<?php
									}
									?>
									</div>
									
										
										

							
								
							</div>
							 <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							  </a>
							  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
								<i class="fa fa-angle-right"></i>
							  </a>			
						</div>
					</div><!--/recommended_items-->
					
				</div>
			</div>
		</div>
	</section>
	
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