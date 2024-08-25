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
							<div class="box_info_account">
								<div class="midle_content" style="min-height: 400px;">
									<div class="title_view"><h1><i class="fa fa-newspaper-o"></i> {tieu_de}</h1></div>
									<div class="box_text_content" style="width: calc(100% - 30px);line-height: 22px;">
										{noidung}
										<div class="title">Bài viết liên quan</div>
										{list_lienquan}
									</div>
								</div>
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