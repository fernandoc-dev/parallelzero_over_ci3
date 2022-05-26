	<!-- JavaScripts
	============================================= -->
	<script src="<?php echo base_url('assets/canvas/js/jquery.js') ?>"></script>
	<script src="<?php echo base_url('assets/canvas/js/plugins.min.js') ?>"></script>

	<!-- Footer Scripts
	============================================= -->
	<script src="<?php echo base_url('assets/canvas/js/functions.js') ?>"></script>

	<!-- Bootstrap File Upload Plugin -->
	<script src="<?php echo base_url('assets/canvas/js/components/bs-filestyle.js') ?>"></script>

	<script>
	    $("#input-10").fileinput({
	        showUpload: false,
	        maxFileCount: 1,
	        allowedFileTypes: ["image"]
	    });
	</script>