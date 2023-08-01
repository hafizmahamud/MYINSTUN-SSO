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
								<a href="https://myinstun.instun.gov.my/" class="logo" style="font-size:30px;">
								<img src="/img/SSO_instun_latest.png" alt="" style="width:65%;height:100%;">
								</a>
								
							</div>
							<div class="col-4 d-xl-block">
								<a href="https://myinstun.instun.gov.my/auth/espek/callback" style="padding-left:4%;">LOGIN</a>
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
                            <a style="font-size: 30px">Daftar Pengguna</a>
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
										</span>
									</h4>
								</header>
								<!-- .entry-header -->
								<div class="entry-content">
									<div class="woocommerce">

										<div class="woocommerce-MyAccount-content">

											<form id="register" class="woocommerce-EditAccountForm edit-account" action="{{ route('frontend.register.post')}}" method="post">
                                                @csrf <!-- {{ csrf_field() }} -->

                                                <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
													<label for="full_name">Nama Penuh<span class="required" id="fl">*</span>
													</label>
													<input type="text" style="text-transform:uppercase" class="woocommerce-Input woocommerce-Input--text input-text" name="full_name" id="display_name" placeholder="Nama Penuh">
												</p>
                                                <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
													<label for="nokp">No. Kad Pengenalan <a class="fa fa-info-circle" href="#" data-toggle="tooltip" rel="tooltip" data-placement="right" title="No. Kad Pengenalan tanpa simbol ( - )"></a><span class="required" id="kp">*</span>
													</label>
													<input type="text" maxlength = "12" onkeypress="return isNumber(event)" class="woocommerce-Input woocommerce-Input--text input-text" name="nokp" id="nokp" placeholder="Kad Pengenalan">
												</p>
                                                <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
													<label for="jabatan">Jabatan <span class="required" id="jb">*</span>
													</label>
													<input type="text" style="text-transform:uppercase" class="woocommerce-Input woocommerce-Input--text input-text" name="jabatan" id="jabatan" placeholder="Jabatan" maxlength="60">
												</p>
                                                <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
													<label for="notel_jabatan">No. Telefon Jabatan <span class="required" id="notel_jab">*</span>
													</label>
													<input type="text" maxlength = "12" onkeypress="return isNumber(event)" class="woocommerce-Input woocommerce-Input--text input-text" name="notel_jabatan" id="notel_jabatan" placeholder="No. Telefon">
												</p>
												<div class="clear">

												</div>

												<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
													<label for="account_email">E-mel <span class="required" id="email">*</span>
													</label>
													<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" placeholder="E-mel">
												</p>
												<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
													<label for="katalaluan">Kata Laluan <span id="req" class="required">*</span>
													</label>
													<input type="password" autocomplete="off" class="woocommerce-Input woocommerce-Input--email input-text" name="katalaluan" id="katalaluan" oninput="verify()" placeholder="Kata Laluan">
													<i class="far fa-eye" id="togglePassword" onclick="hide()" style="margin-left: -30px; margin-top: 15px; cursor: pointer;"></i>
												</p>
												<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
													<label for="katalaluan2">Pengesahan Kata Laluan <span id="req2" class="required">*</span>
													</label>
													<input type="password" autocomplete="off" class="woocommerce-Input woocommerce-Input--email input-text" name="katalaluan2" id="katalaluan2" oninput="confirmPassword()" placeholder="Kata Laluan">
													<i class="far fa-eye" id="togglePassword2" onclick="hide2()" style="margin-left: -30px; margin-top: 15px; cursor: pointer;"></i>
												</p>
												<div class="clear"></div>
												<p>
													<input type="button" class="woocommerce-Button button" name="save_account_details" onclick="verifyPassword()" value="Daftar">
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
		function isNumber(evt)
		{
			var charCode = (evt.which) ? evt.which : event.keyCode
			if (charCode > 31 && (charCode < 48 || charCode > 57))
				return false;

			return true;
		}

		function hide(){
			const togglePassword = document.querySelector('#togglePassword');
			const password = document.querySelector('#katalaluan');
			const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
			password.setAttribute('type', type);
			// toggle the eye slash icon
			this.classList.toggle('fa-eye-slash');
		}
		function hide2(){
			const togglePassword = document.querySelector('#togglePassword2');
			const password = document.querySelector('#katalaluan2');
			const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
			password.setAttribute('type', type);
			// toggle the eye slash icon
			this.classList.toggle('fa-eye-slash');
		}

		function verifyPassword() {
			var fn = document.getElementById("display_name").value;
			var jb = document.getElementById("jabatan").value;
			var notel_jab = document.getElementById("notel_jabatan").value;
			var mail = document.getElementById("account_email").value;
			var kp = document.getElementById("nokp").value;
			var pw = document.getElementById("katalaluan").value;
			var pw2 = document.getElementById("katalaluan2").value;  
			//check empty password field  
			if(pw == "") 
			{
				document.getElementById("req").innerHTML = "**Fill the password please!";  
			}
			else
			{	document.getElementById("req").innerHTML = "*";  
				if(pw2 == "") 
				{
					document.getElementById("req2").innerHTML = "**Fill the password please!";  
				}
				else
				{	
					document.getElementById("req2").innerHTML = "*";  
					document.getElementById("register").submit();
				}
			}
			if(fn == "") 
			{
				document.getElementById("fl").innerHTML = "*Fill in the field!";  
			}
			else
			{	
				document.getElementById("fl").innerHTML = "*";  
			}
			if(jb == "") 
			{
				document.getElementById("jb").innerHTML = "*Fill in the field!";  
			}
			else
			{	
				document.getElementById("jb").innerHTML = "*";  
			}
			if(notel_jab == "") 
			{
				document.getElementById("notel_jab").innerHTML = "*Fill in the field!";  
			}
			else
			{	
				document.getElementById("notel_jab").innerHTML = "*";  
			}
			if(mail == "") 
			{
				document.getElementById("email").innerHTML = "*Fill in the field!";  
			}
			else
			{	
				document.getElementById("email").innerHTML = "*";  
			}
			if(kp == "") 
			{
				document.getElementById("kp").innerHTML = "*Fill in the field!";  
			}
			else
			{	
				document.getElementById("kp").innerHTML = "*";  
			}
		}

		function verify() {  
			var pw = document.getElementById("katalaluan").value;
			var paragraph = document.getElementById("req");
			document.getElementById("req").innerHTML = "*";  
			if(pw.length < 8) 
			{  
				var text = document.createTextNode(" **Password length must be atleast 8 characters");
				paragraph.appendChild(text);
			}
			re = /[A-Z]/;
			if(!re.test(pw)) {
				var text = document.createTextNode(" **Password must contain at least one uppercase letter (A-Z)!");
				paragraph.appendChild(text);
			}
			//re2 = /[?!#$*]/;
			re2 = /[#?!@$%^&*-]/
			if(!re2.test(pw)) {
				var text = document.createTextNode(" **Password must contain at least one symbol #?!@$%^&*-");
				paragraph.appendChild(text);
			}			re3 = /[0-9]/;
			if(!re3.test(pw)) {
				var text = document.createTextNode(" **Password must contain at least one number (0-9)!");
				paragraph.appendChild(text);
			}
		}
		
		function confirmPassword() {  
			var pw = document.getElementById("katalaluan").value;
			var pw2 = document.getElementById("katalaluan2").value;
			var paragraph = document.getElementById("req2");
			document.getElementById("req2").innerHTML = "*";
			if(!(pw==pw2)) {
				var text = document.createTextNode(" **Password did not match");
				paragraph.appendChild(text);
			}
		}    

	</script>
@endsection

@section('page-js-files')
@stop

