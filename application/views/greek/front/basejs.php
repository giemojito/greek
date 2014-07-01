<script>
var ARRJS = (function(){
	var _baseUrl = "<?php echo base_url(); ?>";
	var _siteUrl = "<?php echo site_url(); ?>";
	return{
		"BASE_URL": _baseUrl,
		"SITE_URL": _siteUrl,
		"uri_segment_1":"<?php echo (isset($uri_segment1)) ? $uri_segment_1 : '';?>",
		"uri_segment_2":"<?php echo (isset($uri_segment2)) ? $uri_segment_2 : '';?>"
	}
})();
</script>