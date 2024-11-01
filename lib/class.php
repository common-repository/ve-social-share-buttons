<?php
/*-------------------------------------------------
 Start Social Share Buttons Shortcode 
 ------------------------------------------------- */
if(!function_exists('ve_social_share_buttons_shortcode_func')):
function ve_social_share_buttons_shortcode_func( $atts ) {
	    global $post;
	    $showheading= get_option('ve_ssb_heading') ? get_option('ve_ssb_heading') : '';
		$social_shortcode_content = '<div id="ve-social-share-buttons-shortcode" class="ve-vesocial-share-shortcode">';
		if($showheading!='')
		$social_shortcode_content .= '<div class="ve-ssb-heading">'.$showheading.'</div>';
		$social_shortcode_content .= '<a onClick="javascript:window.open(\'https://www.facebook.com/sharer/sharer.php?\'+location.href,\'_blank\',\'location=yes,height=570,width=520,scrollbars=yes,status=yes\');" href="javascript:void(0)" class="blg_facebook ve-share"><i class="icon-facebook"></i></a>';
		$social_shortcode_content .= '<a onClick="javascript:window.open(\'https://www.twitter.com/share?url=\'+location.href+\'&amp;text=\'+document.title,\'_blank\',\'location=yes,height=570,width=520,scrollbars=yes,status=yes\');" href="javascript:void(0)" class="blg_twiter ve-share"><i class="icon-twitter"></i></a>';
		$social_shortcode_content .= '<a onClick="javascript:window.open(\'https://www.linkedin.com/shareArticle?mini=true&amp;url=\'+location.href+\'&amp;title=\'+document.title,\'_blank\',\'location=yes,height=570,width=520,scrollbars=yes,status=yes\');" href="javascript:void(0)" class="blg_lnkd ve-share"><i class="icon-linkedin"></i></a>';
		$social_shortcode_content .= '<a onClick="javascript:window.open(\'https://www.pinterest.com/pin/create/button/?url=\'+location.href+\'&amp;description=\'+document.title,\'_blank\',\'location=yes,height=570,width=520,scrollbars=yes,status=yes\');" href="javascript:void(0)"  class="blg_pntst ve-share"><i class="icon-pinterest"></i></a>';
		$social_shortcode_content .= '<a onClick="javascript:window.open(\'https://plus.google.com/share?url=\'+location.href,\'_blank\',\'location=yes,height=570,width=520,scrollbars=yes,status=yes\');" href="javascript:void(0)"  class="blg_gplus ve-share"><i class="icon-gplus"></i></a>';
		$social_shortcode_content .= '</div>';
	
	    $ve_ssb_hide_post_type=get_option('ve_ssb_hide_post_type');
		if(is_singular($ve_ssb_hide_post_type)){
              $social_shortcode_content = '';
			}
		
		// Returns the content.
		return $social_shortcode_content;
}
endif;
add_shortcode( 've_social_share_buttons', 've_social_share_buttons_shortcode_func' );

add_filter('widget_text','do_shortcode');


/*-------------------------------------------------
 Start Virtual Ads content section
 ------------------------------------------------- */
 add_action( 'wp_footer', 've_social_share_buttons_content');
/**
 * Add a icon to the beginning of every post page.
 *
 * @uses is_single()
 */
 if(!function_exists('ve_social_share_buttons_content')):
	function ve_social_share_buttons_content( $content ) {

		global $post;
		$ve_ssb_hide_post_type=get_option('ve_ssb_hide_post_type') ? get_option('ve_ssb_hide_post_type') : array();
		if(is_singular($ve_ssb_hide_post_type) && count($ve_ssb_hide_post_type) > 0){
              return;
			}
		
		$social_sidebar_content = '<div id="ve-social-share-buttons" class="vesocial-share">';
		$social_sidebar_content .= '<a onClick="javascript:window.open(\'https://www.facebook.com/sharer/sharer.php?\'+location.href,\'_blank\',\'location=yes,height=570,width=520,scrollbars=yes,status=yes\');" href="javascript:void(0)" class="blg_facebook ve-share"><i class="icon-facebook"></i></a>';
		$social_sidebar_content .= '<a onClick="javascript:window.open(\'https://www.twitter.com/share?url=\'+location.href+\'&amp;text=\'+document.title,\'_blank\',\'location=yes,height=570,width=520,scrollbars=yes,status=yes\');" href="javascript:void(0)" class="blg_twiter ve-share"><i class="icon-twitter"></i></a>';
		$social_sidebar_content .= '<a onClick="javascript:window.open(\'https://www.linkedin.com/shareArticle?mini=true&amp;url=\'+location.href+\'&amp;title=\'+document.title,\'_blank\',\'location=yes,height=570,width=520,scrollbars=yes,status=yes\');" href="javascript:void(0)" class="blg_lnkd ve-share"><i class="icon-linkedin"></i></a>';
		$social_sidebar_content .= '<a onClick="javascript:window.open(\'https://www.pinterest.com/pin/create/button/?url=\'+location.href+\'&amp;description=\'+document.title,\'_blank\',\'location=yes,height=570,width=520,scrollbars=yes,status=yes\');" href="javascript:void(0)"  class="blg_pntst ve-share"><i class="icon-pinterest"></i></a>';
		$social_sidebar_content .= '<a onClick="javascript:window.open(\'https://plus.google.com/share?url=\'+location.href,\'_blank\',\'location=yes,height=570,width=520,scrollbars=yes,status=yes\');" href="javascript:void(0)"  class="blg_gplus ve-share"><i class="icon-gplus"></i></a>';
		
		$social_sidebar_content .= '</div>';
	

		// Returns the content.
		print $social_sidebar_content;
	}
endif;
/*-------------------------------------------------
 End Social Share Buttons content section
 ------------------------------------------------- */
