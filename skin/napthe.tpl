{header}
<body>
	<div class="page">
		<div class="page_content">
			{box_menu}
			<div class="box_page_content">
				{box_left}
				<div class="box_page_content_right">
					<div class="col_right_left">
						<div class="col_right_left_content">
							{box_slide}
							<div class="box_info_account">
								<div class="top_content"></div>
								<div class="midle_content" style="min-height: 400px;">
									<div class="title_content">Nạp coin vào tài khoản</div>
									<div class="box_text_content" style="width: 400px;">
										<div class="li_input">
											<!-- <label for="">Nạp coin cho: <span class="cl_red">{loginName}</span></label> -->
										</div>
										<div class="li_button">
											<button id="btn_napthe">Nạp thẻ</button>
										</div>
										<div class="title_content">Vui Lòng Liên Hệ Admin Qua Fanpage</div>





												<h3 class="article__title">Hình Thức Nạp Bangking ATM & MOMO</h3>
												<h3>Liên Hệ Admin Thông Qua: Zalo Hoặc PageFacebook</h3>
												<h3>   ---------------------------------------------------------</h3>
												<h3>HỆ THỐNG NẠP THẺ</h3>
												<h3>BANKING :<span class="cl_red">NGÂN HÀNG MBbank</span></h3>
												<h3>STK :<span class="cl_red">9930183918888</span></h3>
												<h3>BANKING :<span class="cl_red">TRUONG MANH DAT</span></h3>
												
												
												<h3>Hình Thức Nạp Thẻ: <span class="cl_red">Tên Nhân Vật+Máy Chủ Hiện Tại</span></h3>
												<a class="nav-link" href="https://zalo.me/g/stbpwn075" target="_blank" style="color: blue; text-decoration: underline;">Click:Truy Cập Nhóm Zalo</a>
												<a class="nav-link" href="https://www.facebook.com/profile.php?id=61560918395799" target="_blank" style="color: blue; text-decoration: underline;">Click:Truy Cập Page Facebook</a>

													<a class="nav-link" href="https://www.facebook.com/profile.php?id=61560918395799" target="_blank">
													    <img src="http://http://kiemthehaclong.net/images/Atm.png" alt="Facebook" style="width: 293px; height: 189px;">
													</a>


											<!-- <div class="col_50"> -->
												<!-- <input type="text" value="" name="seri" placeholder="Vui Lòng Liên Hệ Admin Qua Fanpage" /> -->
											<!-- </div> -->
										<!-- <div class="li_input"> -->
											<!-- <label for="">Loại thẻ</label> -->
                                            <!-- <select name="card_type_id"> -->
                                            	<!-- <option value="0">- Chức Năng Không Hoạt Động -</option> -->
                                                <!-- <option value="1">Viettel</option> -->
                                                <!-- <option value="2">Mobiphone</option> -->
                                                <!-- <option value="3">Vinaphone</option> -->
                                                <!-- <option value="6">Vietnammobile</option> -->
                                            <!-- </select> -->
										<!-- </div> -->
										<!-- <div class="li_input"> -->
											<!-- <label for="">Mệnh giá</label> -->
                                            <!-- <select name="price_guest"> -->
                                                <!-- <option value="0">- Chức Năng Không Hoạt Động -</option> -->
                                                <!-- <option value="10000">10.000</option> -->
                                                <!-- <option value="20000">20.000</option> -->
                                                <!-- <option value="30000">30.000</option> -->
                                                <!-- <option value="50000">50.000</option> -->
                                                <!-- <option value="100000">100.000</option> -->
                                                <!-- <option value="200000">200.000</option> -->
                                                <!-- <option value="300000">300.000</option> -->
                                                <!-- <option value="500000">500.000</option> -->
                                                <!-- <option value="1000000">1.000.000</option> -->
                                            <!-- </select> -->
										<!-- </div> -->
										<!-- <div class="li_input"> -->
											<!-- <label for="">Mã thẻ</label> -->
											<!-- <input type="text" value="" name="pin" placeholder="Mã thẻ cào"/> -->
										<!-- </div> -->
										<!-- <div class="li_input"> -->
											<!-- <label for="">Số serial</label> -->
											<!-- <input type="text" value="" name="seri" placeholder="Số serial thẻ"/> -->
										<!-- </div> -->
										<!-- <div class="li_input"> -->
											<!-- <label for="">Mã bảo mật</label> -->
											<!-- <div class="col_50"> -->
												<!-- <input type="text" value="" name="seri" placeholder="Số serial thẻ" /> -->
											<!-- </div> -->
											<!-- <div class="col_50 vertical img_captcha"> -->
												<!-- <img src="/napthe/securimage/securimage_show.php" id="captcha" onclick="document.getElementById('captcha').src='/napthe/securimage/securimage_show.php?sid='+Math.random();"/><img src="/napthe/images/refresh.gif" onclick="document.getElementById('captcha').src='/napthe/securimage/securimage_show.php?sid='+Math.random();"/> -->
											<!-- </div> -->
											
										<!-- </div> -->

									</div>
								</div>
								<div class="bottom_content"></div>
							</div>
						</div>
					</div>
					{box_right}
				</div>
			</div>
		</div>
	</div>
	{footer}
	{script_footer}
	<script>
	var slide_home = new Swiper('.slide_home', {
	    // Optional parameters
	    direction: 'horizontal',
	    slidesPerView: 1,
	    loop: true,
	    observer: true,
	    observeParents: true,
	    // If we need pagination
	    pagination: {
	        el: '.swiper-pagination',
	        clickable: true,
	    },
	    autoplay: {
	        delay: 5000,
	    },
		pagination: {
		  el: '.swiper-pagination',
				clickable: true,
		    renderBullet: function (index, className) {
		      return '<div class="li_pagination '+ className +'"></div>';
		    },
		},
	    // Navigation arrows
	    navigation: {
	        nextEl: '.slide-next',
	        prevEl: '.slide-prev',
	        disabledClass: 'hide_button',
	        hiddenClass: 'hide_button',
	    },
	});
	</script>
</body>
</html>