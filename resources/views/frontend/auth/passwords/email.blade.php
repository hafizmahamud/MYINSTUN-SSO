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
						<div class="row align-items-center">
							<div class="col-xl-8 col-lg-4 col-md-5 col-11">
								<a href="./" class="logo" style="font-size:30px;">
								<img src="/img/SSO_instun_latest.png" alt="" style="width:65%;height:100%;">
								</a>
								
							</div>
							<div class="col-4 d-xl-block">
								<a href="https://sso.instun.gov.my/oxauth/login.htm" style="padding-left:4%;">LOGIN</a>
							</div>
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
                            <a style="font-size: 30px">Kemaskini Kata Laluan</a>
                        </div>

                    </div>
                </div>
            </section>

             <section class="ls s-py-100">
				<div class="container">
					<div class="">

                        <div class="d-none d-lg-block divider-30"></div>

						<main class="col-lg-12">
							<article>
								<header class="entry-header">
									@if(!session('status'))
										<h4 style="padding-bottom: 10px">No. Kad Pengenalan <a class="fa fa-info-circle" href="#" data-toggle="tooltip" rel="tooltip" data-placement="right" title="No. Kad Pengenalan tanpa simbol ( - )"></a>
											<span class="edit-link">
											</span>
										</h4>
									@endif
								</header>
								<!-- .entry-header -->
								<div class="entry-content">
									<div class="woocommerce">

										<div class="woocommerce-MyAccount-content">

                                            @if(session('status'))
                                                <div class="alert alert-success">
                                                    {{ session('status') }}
                                                </div>
												<br>
												<br>
											@else
                    
                                            {{ html()->form('POST', route('frontend.auth.password.email.post'))->open() }}
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            {{ html()->label(__())->for('username') }}
                        
                                                            <input type="text" class="form-control" id="username" maxlength = "12" onkeypress="return isNumber(event)" name="username" value="{{ old('username') }}" placeholder="Kad Pengenalan" required>
                                                        </div><!--form-group-->
                                                    </div><!--col-->
                                                </div><!--row-->
                        
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group mb-0 clearfix">
															<p>
																<input type="submit" class="woocommerce-Button button" name="save_account_details" value="Hantar">
															</p>
                                                        </div><!--form-group-->
                                                    </div><!--col-->
                                                </div><!--row-->
                                            {{ html()->form()->close() }}
											@endif
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

