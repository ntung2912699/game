{header}
<body>
	<div class="page">
		<div class="page_content">
			{box_menu}
			<div class="box_page_content">
				{box_left}
				<div class="box_page_content_right">
					<div class="col_right_left">
						<div class="col_right_left_content" style="width: 699px; margin-left: 10px;">
							<div class="box_info_account">
								<div class="midle_content" style="min-height: 400px;">
									<div class="title_content">{tieu_de}</div>
									<div class="box_text_content">
										{list_baiviet}
										{phantrang}
									</div>
								</div>
							</div>
						</div>
					</div>
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