<?php
/*
Plugin Name: VE Social Share Buttons
Plugin URI: http://www.virtualemployee.com/
Description: This plugin will help to manage your ads on your site.
Version: 1.2
Author: virtualemployee
Author URI: http://www.virtualemployee.com
Text Domain: virtualemployee
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    /**
     * Determine value of option $name from database, $default value or $params,
     * save it to the db if needed and return it.
     *
     * @param string $name
     * @param mixed  $default
     * @param array  $params
     * @return string
     */
    /** Define Action for register "Virtual Ads" Options */
	add_action('admin_init','ve_social_share_buttons_register_settings_init');
	if(!function_exists('ve_social_share_buttons_register_settings_init')):
		function ve_social_share_buttons_register_settings_init(){
			 register_setting('ve_social_share_buttons_settings','ve_ssb_enable');
			 register_setting('ve_social_share_buttons_settings','ve_ssb_heading');
			 register_setting('ve_social_share_buttons_settings','ve_ssb_hide_blog');
			 register_setting('ve_social_share_buttons_settings','ve_ssb_hide_home');  
			 register_setting('ve_social_share_buttons_settings','ve_ssb_hide_post_type');
		} 
	endif;
    /**
     * Plugin's interface
     *
     * @return void
     */
	if(!function_exists('ve_social_share_buttons_form')):
		function ve_social_share_buttons_form() 
		{
		?>
			<div id="virtual-settings"> 
			<div class="wrap">
				<h1>VE Social Share Buttons Settings</h1><a href="http://www.virtualemployee.com/contactus">Click here</a> for send to your query on plugin support<hr />
				 <form action="options.php" method="post" id="ve-social-share-buttons-admin-form">
					 
					<table class="form-table">
						
					<tr valign="top">
					<th scope="row">Enable</th>
					<td><input type="checkbox" value="1" name="ve_ssb_enable" id="ve_ssb_enable" <?php checked(get_option('ve_ssb_enable'),1); ?> /></td>
					</tr>
					
					<tr valign="top">
					<th scope="row">Heading</th>
					<td><input type="text" name="ve_ssb_heading" id="ve_ssb_heading" value="<?php echo get_option('ve_ssb_heading'); ?>" /></td>
					</tr>
					
					<tr valign="top">
					<th scope="row">Hide on home page</th>
					<td><input type="checkbox" value="1" name="ve_ssb_hide_home" id="ve_ssb_hide_home" <?php checked(get_option('ve_ssb_hide_home'),1); ?> /></td>
					</tr>
					
					<tr valign="top">
					<th scope="row">Hide on Blog page</th>
					<td><input type="checkbox" value="1" name="ve_ssb_hide_blog" id="ve_ssb_hide_blog" <?php checked(get_option('ve_ssb_hide_blog'),1); ?> /></td>
					</tr>	
					
					<tr valign="top">
					<th scope="row" nowrap>Choose post type where want to hide buttons</th>
					<td>
					<?php $ve_ssb_hide_post_type=get_option('ve_ssb_hide_post_type');?>
					<select name="ve_ssb_hide_post_type[]" id="ve_ssb_hide_post_type" style="width:500px;" multiple>
						<?php 
						$args = array(
						   'public'   => true,
						   '_builtin' => false
						);

						$output = 'names'; // names or objects, note names is the default
						$operator = 'and'; // 'and' or 'or'

						$post_types = get_post_types( $args, $output, $operator ); 
						array_push($post_types,'post');array_push($post_types,'page');
						foreach ( $post_types  as $post_type ) {

							echo '<option value="'.$post_type.'" '.selected(true, in_array($post_type, $ve_ssb_hide_post_type), false).'>'.$post_type.'</option>';
						}

						?>
						<option value="">None</option>
						
					</select></td>
					</tr>
					
				</table>
					<span class="submit-btn"><?php echo get_submit_button('Save Settings','button-primary','submit','','');?></span>
					 <?php settings_fields('ve_social_share_buttons_settings'); ?>
				</form>
				<p>&nbsp;</p>
				<hr>
				<p><h2>Shortcodes</h2></p>

				<table class="form-table">
				<tr valign="top">
				<th scope="row">[ve_social_share_buttons]</th>
				<td> Use this shortcode for display Ads in header section</td>
				</tr>
				</table>
			</div><!-- end wrap -->
			</div>
		<?php
		 }
	endif;
	/** add js into admin footer */
	if(isset($_GET['page']) && $_GET['page']=='ve-social-share-buttons'){
	add_action('admin_footer','init_ve_social_share_buttons_admin_scripts');
		if(!function_exists('init_ve_social_share_buttons_admin_scripts')):
			function init_ve_social_share_buttons_admin_scripts()
			{
			  echo $script='<style type="text/css">
				#virtual-settings {width: 90%; padding: 10px; margin: 10px;}
				 #virtual-settings label{width: 100%;display:block;}
				</style>';
			}
		endif;
	}	
	// Add settings link to plugin list page in admin
	if(!function_exists('ve_social_share_buttons_settings_link')):
		function ve_social_share_buttons_settings_link( $links ) {
		  $settings_link = '<a href="options-general.php?page=ve-social-share-buttons">' . __( 'Settings', 'virtualemployee' ) . '</a>';
		   array_unshift( $links, $settings_link );
		  return $links;
		}
	endif;
	$plugin = plugin_basename( __FILE__ );
	add_filter( "plugin_action_links_$plugin", 've_social_share_buttons_settings_link' );
	// admin menu
	if(!function_exists('ve_social_share_buttons_admin_menu')):
		function ve_social_share_buttons_admin_menu() {
			add_submenu_page('options-general.php','VE Social Share Buttons', 'VE Social Share Buttons', 'manage_options','ve-social-share-buttons','ve_social_share_buttons_form');
		}
	endif;
	add_action('admin_menu', 've_social_share_buttons_admin_menu');

$ve_ssb_enable = get_option('ve_ssb_enable') ? get_option('ve_ssb_enable') : 0;
if($ve_ssb_enable)
{
	
	/*-------------------------------------------------
	Start VE Social Share Buttons Style
	------------------------------------------------- */
	add_action( 'wp_enqueue_scripts', 've_ssb_enqueue_styles' );
	if(!function_exists('ve_ssb_enqueue_styles'))
	{
	function ve_ssb_enqueue_styles() {
	 
	global $wp_styles;

	wp_register_style( 've_ssb_style', plugins_url( 'css/ve-ssb.css',__FILE__ ) );
	wp_enqueue_style( 've_ssb_style' );  
			
	}
	}
	/*-------------------------------------------------
	End VE Social Share Buttons Style
	------------------------------------------------- */
	
   require dirname(__FILE__).'/lib/class.php';
}
?>
