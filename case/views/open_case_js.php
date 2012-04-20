<?php
/**
 * Reports view js file.
 *
 * Handles javascript stuff related to reports view function.
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     Reports Controller
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */
?>
		

/* Form Actions */
		
		
		// Action on Save Only
		$('.btn_save').live('click', function () {
			$("#save").attr("value", "1");
			$(this).parents("form").submit();
			return false;
		});
		
		jQuery(window).bind("load", function() {
			jQuery("div#slider1").codaSlider()
			// jQuery("div#slider2").codaSlider()
			// etc, etc. Beware of cross-linking difficulties if using multiple sliders on one page.
		});
		
		function rating(id,action,type,loader)
		{
                   <?php echo ">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>" ?>
			$('#' + loader).html('<img src="<?php echo url::file_loc('img')."media/img/loading_g.gif"; ?>">');
			$.post("<?php echo url::site().'case_view/rating/' ?>" + id, { action: action, type: type },
				function(data){
					if (data.status == 'saved'){
						if (type == 'original') {
							$('#oup_' + id).attr("src","<?php echo url::file_loc('img').'media/img/'; ?>gray_up.png");
							$('#odown_' + id).attr("src","<?php echo url::file_loc('img').'media/img/'; ?>gray_down.png");
							$('#orating_' + id).html(data.rating);
						}
						else if (type == 'comment')
						{
							$('#cup_' + id).attr("src","<?php echo url::file_loc('img').'media/img/'; ?>gray_up.png");
							$('#cdown_' + id).attr("src","<?php echo url::file_loc('img').'media/img/'; ?>gray_down.png");
							$('#crating_' + id).html(data.rating);
						}
					} else {
						if(typeof(data.message) != 'undefined') {
							alert(data.message);
						}
					}
					$('#' + loader).html('');
			  	}, "json");
		}
		
	