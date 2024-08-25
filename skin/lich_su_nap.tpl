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
									<div class="title_content">Lịch sử nạp thẻ</div>
									<div class="box_text_content">
										<table class="table_lichsu">
											<tr>
												<th>Ngày</th>
												<th>Loại thẻ</th>
												<th>Mệnh giá</th>
												<th>Tình trạng</th>
											</tr>
											{list_lichsu}
										</table>
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