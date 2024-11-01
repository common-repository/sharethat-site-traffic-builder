<?php
	$stgp_sharethat_login_token = get_option('stgp_sharethat_login_token');
	$qs = "?baa_ic=" . get_option("stgp_sharethat_baa_ic") . "&multi_comp_id=" . get_option("stgp_sharethat_mci");
	if ($stgp_sharethat_login_token !== FALSE) {
		$qs .= "&login_token=" . $stgp_sharethat_login_token;
	}
	$qs .= "&wpurl=" . urlencode(home_url());
	
	$admin_url = get_admin_url();
	
	$error_message = $GLOBALS["error_message"];
	$error_title = $GLOBALS["error_title"];
	
	$error_message = json_encode($error_message);
	$error_title = json_encode($error_title);
	
?>
<script type="text/javascript">

	jQuery(document).ready(function($) {
		$('#stgp_sharethat_outer_container iframe').attr('src', '<?php echo $GLOBALS["sharethat_content_endpoint_prefix"]; echo $page_type . $qs; ?>');

		var error_message = <?php echo $error_message; ?>;
		var error_title = <?php echo $error_title; ?>;

		if (error_message) {

			if (error_title) {
				$('#stgp_sharethat_error_title').html(error_title);
			}
			$('#stgp_sharethat_error_message').html(error_message);

			jQuery('#stgps_sharethat_close_overlay').click(function() {
				$('#stgp_sharethat_message_overlay').addClass('stgp_overlay_hidden');
				return false;
			});

			jQuery('#stgp_sharethat_message_overlay > div:first-child').click(function() {
				$('#stgp_sharethat_message_overlay').addClass('stgp_overlay_hidden');
				return false;
			});
			
			$('#stgp_sharethat_message_overlay').removeClass('stgp_overlay_hidden');
		}
	});
		
	(function() {
		
		var getQueryVariable = function (query, variable) {
		    var vars = query.split('&');
		    for (var i = 0; i < vars.length; i++) {
		        var pair = vars[i].split('=');
		        if (decodeURIComponent(pair[0]) == variable) {
		            return decodeURIComponent(pair[1]);
		        }
		    }
		    return false;
		};
		
		// Listen for iframe resize messages
		//
		window.addEventListener("message", function(e) {
			var type = getQueryVariable(e.data, "type");
			if (type == 'sharethat') {	    	
				var subtype = getQueryVariable(e.data, "subtype");
				if (subtype == 'resize_frame') {
			    	var h = getQueryVariable(e.data, "height");
			    	jQuery("#stgp_sharethat_outer_container iframe").css("height", h + "px");
				} else if (subtype == 'navigate_to') {
					var page = getQueryVariable(e.data, "page");
					window.location = "<?php echo $admin_url; ?>" + "admin.php?page=" + page;
				} else if (subtype == 'connect') {
					var login_token = getQueryVariable(e.data, "login_token");
					window.location =  "<?php echo $admin_url; ?>" + "admin.php?page=sharethat&login_token=" + login_token;			
				}
			}
		});
		
	})();
</script>
<style type="text/css">
.toplevel_page_sharethat, 
.sharethat_page_sharethat_pricing, 
.sharethat_page_sharethat_account, 
.sharethat_page_sharethat_stats, 
.sharethat_page_sharethat_leads, 
.sharethat_page_sharethat_popups #wpwrap {
	background-image:		url('<?php echo plugins_url() . '/sharethat-site-traffic-builder/images/sharethat-content-top-banner.jpg'; ?>');
	background-repeat:		no-repeat;
	background-size:		100% 170px;
}
#stgp_sharethat_outer_container iframe {
	width: 100%;
	overflow: hidden;
}
#stgp_sharethat_message_overlay {	
	position: absolute;
	display: block;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 999;	
}
.stgp_overlay_hidden {
	display: none !important;
}
#stgp_sharethat_message_overlay > div:first-child {
	position: absolute;
	top: 0px;
	left: 0px;
	opacity: 0.65;	
	width: 100%;
	height: 100%;
	background-color: #333;
	opacity: 0.65;	
	z-index: 1;
}	
#stgp_sharethat_message_overlay > div:last-child {
	position: relative;
	margin-left: auto;
	margin-right: auto;
	margin-top: 100px;
	width: 450px;
	padding: 15px;
	border: 1px solid gray;
	background: white;
	z-index: 2;
	
	-moz-box-shadow: 0px 0px 30px #FFF;
	-webkit-box-shadow: 0px -5px 30px #FFF;
	box-shadow: 0px 0px 30px #FFF;	
}
#stgp_sharethat_error_message {
	padding: 10px 10px 0px 10px; 
	font-size: 11pt; 
	font-weight: normal;
	line-height: 150%;
	color: #555;
}
</style>
<div id='stgp_sharethat_message_overlay' class='stgp_overlay_hidden'>
	<div></div>
	<div>
		<div style='border-bottom: 1px solid #aaa; padding-bottom: 10px; font-size: 14pt; font-weight: bold;'>
			<table style='width: 100%;'>
				<tr>
					<td id='stgp_sharethat_error_title' style='width: 75%'>Ooops</td>
					<td id='stgps_sharethat_close_overlay' style='width: 25%; text-align: right; color: #888; cursor: pointer;'>X</td>
				</tr>
			</table>
		</div>
		<div id='stgp_sharethat_error_message' style=''></div>
	</div>
</div>
<div id='stgp_sharethat_outer_container'>
	<iframe></iframe>
</div>