{header}
<body>
	{box_menu}
	<div class="box_1">
		<div class="wrap">
 			<div class="button_box_1">
			    <a href="/page/tai-game.html" title="Tải game" class="btn_down">Tải game</a>
			    <a href="/nap-the.html" title="Nạp thẻ" class="btn_nap">Nạp thẻ</a>
			</div>
			<div style="clear: both;"></div>
		</div>
		<div class="box_list">
			<div class="box_list_content">
				{box_account}
				<div class="box_li">
					<div class="box_li_content">
						<div class="tieu_de"><a href="/the-loai/su-kien.html">Sự kiện</a></div>
						<div class="list_content">
							{list_sukien}
						</div>
					</div>
				</div>
				<div class="box_li">
					<div class="box_li_content">
						<div class="tieu_de"><a href="/the-loai/tin-tuc.html">Tin tức</a></div>
						<div class="list_content">
							{list_tintuc}
						</div>
					</div>
				</div>
				<div class="box_slide_mini">
					<div class="swiper-container slide_mini">
						<div class="swiper-wrapper">
							{slide_home_1}
						</div>
						<div class="swiper-pagination"></div>
					</div>
				</div>				
			</div>
		</div>
	</div>
	{footer}
	{script_footer}
	<script>
	var menu = [{tieude_home_2}]
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
		      return '<div class="li_pagination '+ className +'"><div class="top_pagination"></div><div class="midle_pagination">' + (menu[index]) + '<div style="clear:both;"></div></div><div class="bottom_pagination"></div></div>';
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
	var slide_mini = new Swiper('.slide_mini', {
	    // Optional parameters
	    direction: 'horizontal',
	    slidesPerView: 1,
	    loop: true,
	    observer: true,
	    observeParents: true,
	    // If we need pagination
	    autoplay: {
	        delay: 7000,
	    },
	    pagination: {
	        el: '.swiper-pagination',
	        clickable: true,
	    },

	    // Navigation arrows
	    navigation: {
	        nextEl: '.slide-sp-next',
	        prevEl: '.slide-sp-prev',
	        disabledClass: 'hide_button',
	        hiddenClass: 'hide_button'
	    },
	});
	</script>
</body>
</html>