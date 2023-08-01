@extends('frontend.layouts.app')
 
@section('title', app_name() . ' | ' . __('navs.frontend.dashboard') )

@section('content')
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
							<div class="col-xl-8 col-lg-4 col-md-5 col-11">
								<a href="https://myinstun.instun.gov.my/" class="logo" style="font-size:30px;">
								<img src="/img/SSO_instun_latest.png" alt="" style="width:65%;height:100%;">
								</a>
								
							</div>
							<ul class="nav sf-menu">

								<li class="">
									<a>{{ $nama ->display_name }}</a>
									<ul>
										<li>
											<a href="{{ route('frontend.user.profile')}}">PROFIL</a>
										</li>
										<li>
											<a href="{{ route('frontend.user.profilepassword') }}">KEMASKINI KATA LALUAN</a>
										</li>
										@if($role->role_id == 1)
											<li>
												<a href="{{route('frontend.auth.login')}}">@lang('navs.frontend.login')</a>
											</li>
										@endIf
										<li>
											<a href="{{ route('frontend.auth.logout') }}">LOGOUT</a>
										</li>
									</ul>
								</li>

							</ul>
						</div>
					</div>
					<!-- header toggler -->
				</header>			</div>
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

            <section class="page_title ds s-pt-40 s-pb-40 s-pb-lg-40">
                <div class="divider-50"></div>
                <div class="container">
                    <div class="row">

                        <div class="col-md-12">
                            <a style="font-size: 30px">Profil Pengguna</a>
                        </div>

                    </div>
                </div>
            </section>

            <section class="ls s-py-50">
				<div class="container">
					<div class="">

                        <div class="d-none d-lg-block divider-30"></div>

						<main class="col-lg-12">
							<article>
								<header class="entry-header">
									<h4 style="padding-bottom: 10px">Maklumat Akaun
										<span class="edit-link">
											<a class="post-edit-link" style="font-size: 14px" href="#">Edit
												<span class="screen-reader-text"> "My account"</span>
											</a>
										</span>
									</h4>
								</header>
								<!-- .entry-header -->
								<div class="entry-content">
									<div class="woocommerce">

										<div class="woocommerce-MyAccount-content">

											<form class="woocommerce-EditAccountForm edit-account" action="{{ route('frontend.user.profile.update')}}" method="post">
                                                @csrf <!-- {{ csrf_field() }} -->

                                                <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
													<label for="account_first_name">Nama <span class="required">*</span>
													</label>
													<input type="text" autocomplete="off" class="woocommerce-Input woocommerce-Input--text input-text" name="full_name" id="full_name" value="{{ $nama ->display_name }}"placeholder="Full name">
												</p>
                                                <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
													<label for="account_first_name">No. Kad Pengenalan <span class="required">*</span>
													</label>
													<input type="text" autocomplete="off" class="woocommerce-Input woocommerce-Input--text input-text" name="nokp" id="nokp" value={{ $nama ->username }} disabled>
												</p>
                                                <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
													<label for="account_first_name">Jabatan <span class="required">*</span>
													</label>
													<input type="text" autocomplete="off" maxlength="60" class="woocommerce-Input woocommerce-Input--text input-text" name="jabatan" id="jabatan" value="{{ $nama ->jabatan }}">
												</p>
                                                <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
													<label for="account_first_name">No. Telefon Jabatan <span class="required">*</span>
													</label>
													<input type="text" autocomplete="off" onkeypress="return isNumber(event)" class="woocommerce-Input woocommerce-Input--text input-text" name="notel_jabatan" id="notel_jabatan" value="{{ $nama ->no_tel_jabatan }}">
												</p>
												<div class="clear">

												</div>

												<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
													<label for="account_email">E-mel<span class="required">*</span>
													</label>
													<input type="email" autocomplete="off" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" value="{{ $nama ->email }}" placeholder="Email address">
												</p>
												<div class="clear"></div>
												<p>
													<input type="submit" class="woocommerce-Button button" name="save_account_details" value="Simpan">
												</p>
											</form>

										</div>
									</div>
								</div>
								<!-- .entry-content -->
							</article>

						</main>

						<div class="d-none d-lg-block divider-70"></div>
					</div>

				</div>
			</section>

			<section class="s-py-40 ds gradient-background  d-md-block" id="feature">
				<div class="container" style="padding-top:1%;padding-bottom:1%;">
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
				<div class="container" >
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

	function isNumber(evt)
	{
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;

		return true;
	}
	</script>
@endsection

@section('page-js-files')
@stop

