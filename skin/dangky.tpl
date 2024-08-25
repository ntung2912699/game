{header}
<body>
	{topbar}
	<div class="box_login">
		<div class="box_login_content">
			<div class="box_login_left">
				<img src="/skin/css/images/image-signin.jpg" alt="Đăng ký">
			</div>
			<div class="box_login_right" style="padding-top: 20px;">
				<div class="title" style="margin-bottom: 20px;">
					Đăng ký tài khoản
				</div>
				<div class="li_input">
					<div class="icon_input"><i class="fa fa-user"></i></div>
					<div class="input">
						<input type="text" name="username" placeholder="Tài khoản">
					</div>
				</div>
				<div class="li_input">
					<div class="icon_input"><i class="fa fa-envelope"></i></div>
					<div class="input">
						<input type="text" name="email" placeholder="Địa chỉ Email">
					</div>
				</div>
				<div class="li_input">
					<div class="icon_input"><i class="fa fa-key"></i></div>
					<div class="input">
						<input type="password" name="password" placeholder="Mật khẩu đăng nhập">
					</div>
				</div>
				<div class="li_text">
					<div class="input_left">
						<input type="text" id="ma_bao_mat" class="form-control" name="ma_bao_mat" placeholder="Mã bảo mật" />
					</div>
					<div class="input_right">
			            <img src="/napthe/securimage/securimage_show.php" onclick="document.getElementById('captcha').src='/napthe/securimage/securimage_show.php?sid='+Math.random();" id="captcha" /><img src="/napthe/images/refresh.gif" id="btn_captcha" onclick="document.getElementById('captcha').src='/napthe/securimage/securimage_show.php?sid='+Math.random();" />
					</div>
				</div>
				<div class="li_text" style="font-style: italic;">
					Lưu ý: Email được dùng để lấy lại mật khẩu khi quên, vì vậy hãy <span class="cl_red">dùng email thật để đăng ký</span>.
				</div>
				<div class="li_button">
					<button id="button_dangky">Đăng ký</button>
				</div>
				<div class="li_text" style="margin-top: 10px;">
					<div class="col_50">
						<a href="/dang-nhap.html"><i class="fa fa-user"></i> Đăng nhập tài khoản</a>
					</div>
					<div class="col_50">
						<a href="/quen-mat-khau.html"><i class="fa fa-key"></i>Quên mật khẩu?</a>
					</div>
				</div>
			</div>		
		</div>
	</div>
	{footer}
	{script_footer}
</body>
</html>