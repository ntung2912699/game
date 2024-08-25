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
								<div class="midle_content" style="min-height: 400px;">
									<div class="list_tab">
										<div class="tab active" id="tab_huongdan"><a href="javascript:;">Hướng dẫn</a></div>
										<div class="tab" id="tab_sukien"><a href="javascript:;">Sự kiện</a></div>
										<div class="tab" id="tab_tintuc"><a href="javascript:;">Tin tức</a></div>
									</div>
									<div class="box_text_content">
										<div class="list_box_tab">
											<div class="box_tab active" id="box_tab_huongdan">
												{list_huongdan}
											</div>
											<div class="box_tab" id="box_tab_sukien">
												{list_sukien}
											</div>
											<div class="box_tab" id="box_tab_tintuc">
												{list_tintuc}
											</div>
										</div>
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