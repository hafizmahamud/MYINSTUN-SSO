@extends('frontend.layouts.app')
@section('content')

<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
                <div class="text-center" style="font-weight:bold; font-size:30px; 
                padding-top:20px; color:honeydew">PENGUMUMAN</div>
                     
                <div class="card-body">
                  <example-component></example-component>
                </div>
        </div>
    </div>
</div> -->


<!-- <script type="text/javascript">
	window.location = "{{route('frontend.auth.login')}}";      // KALAU BELUM LOGIN SSO
</script> -->

<div class="preloader">
		<div class="preloader_image"></div>
</div>
<div id="canvas">
		<div id="box_wrapper">
        <div class="header_absolute ds cover-background s-overlay">
				<!-- header with two Bootstrap columns - left for logo and right for navigation and includes (search, social icons, additional links and buttons etc -->
				<header class="page_header ds justify-nav-center s-borderbottom container-px-20">
					<div class="container">
						<div class="row align-items-center" style="justify-content: space-between !important; padding-right:5%;">
							<div class="col-xl-6 col-lg-4 col-md-5 col-11">
								<a href="https://myinstun.instun.gov.my/" class="logo" style="font-size:30px;">
								<img src="/img/SSO_instun_latest.png" alt="" style="width:95%;height:100%;">
								</a>
								
							</div>
							<ul class="nav sf-menu">

								<li class="">
									<a style="font-size: 24px;">{{ $nama ->display_name }}</a>
									<ul>
										<li>
											<a href="{{ route('frontend.user.profile')}}">PROFIL</a>
										</li>
										<li>
											<a href="{{ route('frontend.user.profilepassword') }}">KEMASKINI KATA LALUAN</a>
										</li>
										<li>
											<a href="{{ route('frontend.auth.logout') }}">LOGOUT</a>
										</li>
									</ul>
								</li>

							</ul>
						</div>
					</div>
					<!-- header toggler -->
					<span class="toggle_menu"><span></span></span>
				</header>
			</div>
			<!-- template sections -->
			<!--topline section visible only on small screens|-->
			<section class="page_topline ds c-my-10 d-xl-none">
				<div class="container-fluid">
					<div class="row align-items-center text-center">
						<div class="col-12">
							<div class="top-includes main-includes">
								<!-- <button type="button" class="sign-btn-form" data-toggle="modal" data-target="#form2"><i class="fw-900 s-16 fa fa-sign-in" aria-hidden="true"></i>Sign Up</button>
								<button type="button" class="login-btn-form login_modal_window" data-toggle="modal" data-target="#form1"><i class="fs-16 fa fa-user" aria-hidden="true"></i>Login</button> -->
							</div>
						</div>
					</div>
				</div>
			</section>
			<!--eof topline-->
			<div class="header_absolute ds cover-background s-overlay">
				<!-- header with two Bootstrap columns - left for logo and right for navigation and includes (search, social icons, additional links and buttons etc -->
			</div>

			<section class="page_slider ds">
				<span class="flexslider-overlay"></span>
				<img src="/img/Instun_backgroud3.jpg" alt="">
				<div class="container">
					<div class="divider-15 d-none d-lg-block d-xl-none"></div>
					<div class="row align-items-center">
						<div class="col-md-7">
							<div class="intro_layers_wrapper">
										<div class="intro_layers">
										<h6 class="intro_before_featured_word animate" data-animation="fadeInUp">
											P E N G U M U M A N
										</h6>
													<div class="testimonials-slider owl-carousel" data-autoplay="true" data-loop="true" data-responsive-lg="1" data-responsive-md="1" data-responsive-sm="1" data-nav="false" data-dots="false">
													@foreach($announcement_all as $data)
													
															<p>
																<b><a style="font-size: 40px;">
																 {{ $data->title }}
																</a></b></br>
																<span style="white-space: pre-line">{{ $data->content}}</span>
															</p>
													@endforeach
													</div><!-- .testimonials-slider -->

										</div>
									
							</div> <!-- eof .intro_layers_wrapper -->
						</div> <!-- eof .col-* -->
						<div class="col-md-5">
						<div class="intro_layers_wrapper icon-layer">
								<div id="mobile" class="intro_layers">
									<a href="#" id="mylink4" class="icon-box text-center bordered rounded animate" data-animation="moveFromLeft">
										<div class="color-main icon-styled fs-32">
											<i class="icon-espek" aria-hidden="true"></i>
										</div>
										<p>
											e S P E K<br>M O B I L E
										</p>
									</a>
									</div> <!-- eof .intro_layers -->
								<div id="boxApplication" class="intro_layers" >
								<a href="https://espek.instun.gov.my/user/connect" id="espek" class="icon-box text-center bordered rounded animate" data-animation="moveFromLeft">
										<div class="color-main icon-styled fs-32" style="padding-top:10%;">
											<i class="icon-espek" aria-hidden="true"></i>
										</div>
										<p>
											e S P E K
										</p>
									</a>
									<a href="https://elearn.instun.gov.my/oauth2_login.php" class="icon-box text-center bordered rounded animate" data-animation="moveFromLeft">
										<div class="color-main icon-styled fs-32" style="padding-top:10%;">
											<i class="icon-eLearn" aria-hidden="true"></i>
										</div>
										<p>
											e L E A R N
										</p>
									</a>
									<a href="https://egeo.instun.gov.my/login/callback" class="icon-box text-center bordered rounded animate" data-animation="moveFromLeft">
										<div class="color-main icon-styled fs-32" style="padding-top:10%;">
											<i class="icon-eGeo" aria-hidden="true"></i>
										</div>
										<p>
											e G E O
										</p>
									</a>
								</div> <!-- eof .intro_layers -->
								<div id="boxApplication" class="intro_layers">
									<a href="https://galeri.instun.gov.my" class="icon-box text-center bordered rounded animate" data-animation="moveFromLeft">
											<div data-toggle="tooltip" rel="tooltip" data-placement="right" title="Untuk kegunaan dalaman INSTUN sahaja">
											<div class="color-main icon-styled fs-32 itia poumbnail" style="padding-top:10%;">
												<i class="icon-Galeri" aria-hidden="true"></i>
											</div>
											<p>
												G A L E R I
											</p>
											</div>
									</a>
									<a href="https://sso.instun.gov.my/idp/profile/cas/login?service=https://galeri.instun.gov.my/cgi-bin/koha/opac-user.pl" class="icon-box text-center bordered rounded animate" style="pointer-events: none; cursor: default;" data-animation="moveFromLeft">
										<div class="color-main icon-styled fs-32" style="padding-top:10%;">
											<i class="icon-KOHA" aria-hidden="true"></i>
										</div>
										<p>
											O P A C
										</p>
									</a>
									<a href="https://pintu.instun.gov.my/sso/myinstun" class="icon-box text-center bordered rounded animate" data-animation="moveFromLeft">
										<div class="color-main icon-styled fs-32" style="padding-top:10%;">
											<i class="icon-m-math" aria-hidden="true"></i>
										</div>
										<p>
											P I N T U
										</p>
									</a>
								</div> <!-- eof .intro_layers -->
								<div id="boxApplication" class="intro_layers">
									<a href="#" id="mylink3" class="icon-box text-center bordered rounded animate" data-animation="moveFromLeft">
										<div class="color-main icon-styled fs-32">
											<i class="icon-espek" aria-hidden="true"></i>
										</div>
										<p>
											e S P E K<br>M O B I L E
										</p>
									</a>
								</div> <!-- eof .intro_layers -->
							</div>
						</div> <!-- eof .col-* -->
					</div><!-- eof .row -->
				</div><!-- eof .container-fluid -->
			</section>

			<section class="s-py-40 ds gradient-background d-md-block" id="feature">
				<div class="container"  style="padding-top:1%;padding-bottom:1%;">
					<div class="row">
						<div class="col-12 col-md-4">
							<div class="media align-items-center justify-content-center">
								<div class="icon-styled fs-42">
									<i class="icon-m-people" aria-hidden="true"></i>
								</div>

								<div class="media-body">
									<h6><a href="https://espek.instun.gov.my/complaints/new">
									 Hantar Aduan
                                   </a></h6>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="media align-items-center justify-content-center">
								<div class="icon-styled fs-42">
									<i class="icon-book" aria-hidden="true"></i>
								</div>

								<div class="media-body">
									<h6>
									<a href="/manual/UserManual.pdf">
									  Manual Pengguna
                                   </a>
									</h6>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="media align-items-center justify-content-center">
								<div class="icon-styled fs-42">
									<i class="icon-newspaper" aria-hidden="true"></i>
								</div>

								<div class="media-body">
								<h6><a href="https://espek.instun.gov.my/course_implementations/list_public">
									 Senarai Kursus Tahunan
                                   </a></h6>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="page_copyright ds ms s-py-5">
				<div class="container">
					<div class="row align-items-center">
						<div class="divider-20 d-none d-lg-block"></div>
						<div class="col-md-12 text-center">
							<p>Hak Cipta Terpelihara &copy; <span class="copyright_year">INSTUN {{ date('Y') }}</span></p>
						</div>
						<div class="divider-20 d-none d-lg-block"></div>
					</div>
				</div>
			</section>


		</div><!-- eof #box_wrapper -->
	</div><!-- eof #canvas -->
<script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script>
		var time = new Date().getTime();
		$(document.body).bind("mousemove keypress", function(e) {
			time = new Date().getTime();
		});
		function refresh() {
			if(new Date().getTime() - time >= 900000){
				window.location.href='/logout';
			}
			else{
				setTimeout(refresh, 10000);
			}
		}
		setTimeout(refresh, 10000);

		$(document).ready(function (){
			$("#mylink").click(function() {
			if(navigator.userAgent.toLowerCase().indexOf("android") > -1){
				window.location.href = 'https://play.google.com/store/apps/details?id=my.gov.onegovappstore.etouchmobile';
			}
			if(navigator.userAgent.toLowerCase().indexOf("iphone") > -1){
				window.location.href = 'https://www.apple.com/my/app-store/';
			}
			if(navigator.userAgent.toLowerCase().indexOf("ipad") > -1){
				window.location.href = 'https://www.apple.com/my/app-store/';
			}
			if(navigator.userAgent.toLowerCase().indexOf("window") > -1){
				alert("SILA MASUK MELALUI PERANTI MUDAH ALIH");
			}
			if(navigator.userAgent.toLowerCase().indexOf("macintosh") > -1){
				alert("SILA MASUK MELALUI PERANTI MUDAH ALIH");
			}
			});

			$("#mylink2").click(function() {
			if(navigator.userAgent.toLowerCase().indexOf("android") > -1){
				window.location.href = 'https://play.google.com/store/apps/details?id=my.gov.onegovappstore.etouchmobile';
			}
			if(navigator.userAgent.toLowerCase().indexOf("iphone") > -1){
				window.location.href = 'https://www.apple.com/my/app-store/';
			}
			if(navigator.userAgent.toLowerCase().indexOf("ipad") > -1){
				window.location.href = 'https://www.apple.com/my/app-store/';
			}
			if(navigator.userAgent.toLowerCase().indexOf("window") > -1){
				alert("SILA MASUK MELALUI PERANTI MUDAH ALIH");
			}
			if(navigator.userAgent.toLowerCase().indexOf("macintosh") > -1){
				alert("SILA MASUK MELALUI PERANTI MUDAH ALIH");
			}
			});

			$("#mylink3").click(function() {
			if(navigator.userAgent.toLowerCase().indexOf("android") > -1){
				window.location.href = 'https://play.google.com/store/apps/details?id=my.gov.onegovappstore.espekmobile';
			}
			if(navigator.userAgent.toLowerCase().indexOf("iphone") > -1){
				window.location.href = 'https://www.apple.com/my/app-store/';
			}
			if(navigator.userAgent.toLowerCase().indexOf("ipad") > -1){
				window.location.href = 'https://www.apple.com/my/app-store/';
			}
			if(navigator.userAgent.toLowerCase().indexOf("window") > -1){
				alert("SILA MASUK MELALUI PERANTI MUDAH ALIH");
			}
			if(navigator.userAgent.toLowerCase().indexOf("macintosh") > -1){
				alert("SILA MASUK MELALUI PERANTI MUDAH ALIH");
			}
			});

			$("#mylink4").click(function() {
			if(navigator.userAgent.toLowerCase().indexOf("android") > -1){
				window.location.href = 'https://play.google.com/store/apps/details?id=my.gov.onegovappstore.espekmobile';
                                // window.location.href = 'my.gov.onegovappstore.espekmobile://';
			}
			if(navigator.userAgent.toLowerCase().indexOf("iphone") > -1){
				window.location.href = 'https://www.apple.com/my/app-store/';
			}
			if(navigator.userAgent.toLowerCase().indexOf("ipad") > -1){
				window.location.href = 'https://www.apple.com/my/app-store/';
			}
			if(navigator.userAgent.toLowerCase().indexOf("window") > -1){
				alert("SILA MASUK MELALUI PERANTI MUDAH ALIH");
			}
			if(navigator.userAgent.toLowerCase().indexOf("macintosh") > -1){
				alert("SILA MASUK MELALUI PERANTI MUDAH ALIH");
			}
			});

		});
	</script>
@endsection
