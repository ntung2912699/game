<script type="text/javascript" src="/js/jquery.countdown.js"></script>
<script type="text/javascript" src="/js/jquery.nicescroll.min.js"></script>
<script src="/swiper/swiper.min.js"></script>
<script type="text/javascript" src="/js/lazyload.min.js"></script>
<script src="/js/process.js?t=<?php echo time();?>"></script>
<div class="load_overlay" style="display: none;"></div>
<div class="load_process" style="display: none;">
	<div class="load_content">
		<img src="/images/load.gif" alt="loading" width="70">
		<div class="load_note">Hệ thống đang xử lý</div>
	</div>
</div>
<script type="text/javascript">
    $(function() {
        $("img.lazyload").lazyload({
            effect : "fadeIn"
        });
    });
</script>
<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.2&appId=641938006744130&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>