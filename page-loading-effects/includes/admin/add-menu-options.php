<?php
/**
 * WP Submenu and Add and Update Options
 *
 * @since 1.0.0
 * @todo Replace only if your creating your own Plugin
 * @todo ple - Find all and replace text
 * @todo plepreloader - Find all and replace text
 * @todo Page Loading Effects - Find all and replace text
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Sub menu hooks (unused)
 * 
 *
 * @since 1.0
 * @return void
 */

function ple_register_menu() {
	add_menu_page( 
		__( 'Set Page Loading Effects', 'ple-txt' ), // Page Title
		__( 'Page Loading Effects', 'ple-txt' ), // Menu Title
		 'manage_options', // Capability
		 'ple-menu-page', // Menu Slug 
		 'ple_admin_menu_page_callback' ); // Function
}

add_action( 'admin_menu', 'ple_register_menu');

/**
 * WP Options (Get, Update, and Add)
 *
 * @see Options API (https://codex.wordpress.org/Options_API)
 */
function ple_admin_menu_page_callback() {

	// $_POST needs to be sanitized
	if(isset($_POST['submit'])
		&& check_admin_referer('ple_option_action','ple_option_field') // @see WP Docs for check_admin_referer()
	){

		/** Array DB $options; if emtpy assign empty string */
		$options = array(
			'ple_option_1' => isset($_POST["ple_option_1"]) ? $_POST["ple_option_1"]  : "",
			'ple_option_2' => isset($_POST['ple_option_2']) ? $_POST['ple_option_2']  : "",
			'ple_option_3' => isset($_POST['ple_option_3']) ? $_POST['ple_option_3']  : "",
			'ple_option_4' => isset($_POST['ple_option_4']) ? $_POST['ple_option_4']  : "",
			'ple_option_5' => isset($_POST['ple_option_5']) ? $_POST['ple_option_5']  : "",
			'ple_option_6' => isset($_POST['ple_option_6']) ? $_POST['ple_option_6']  : "",
			'ple_option_7' => isset($_POST['ple_option_7']) ? $_POST['ple_option_7']  : "",
			'ple_options' => isset($_POST["ple_options"]) ? $_POST["ple_options"]  : array(),

		);
		/* Handling var Array */	
		foreach($options as $option_name => $option_value) {
			// If option name exist, update it; else add it!
			if ( get_option( $option_name ) !== false ) {
				$sanitize_val = esc_attr($option_value);
				update_option($option_name, $sanitize_val);
			} else {	
				add_option( $option_name, $sanitize_val, '', 'yes');
			}
		}
	}
?>	
	<div id="ple-preloader-setting-page" class="wrap">
		<h1><?php _e('Page Loading Effects Settings', 'ple-txt'); ?></h1>
		<span class="title"><?php _e('Configuration Settings for Page Loading Effects Plugin', 'ple-txt'); ?></span>

		<form method="post" action="<?php echo esc_attr($_SERVER["REQUEST_URI"]); ?>">
			<?php wp_nonce_field('ple_option_action','ple_option_field'); ?>
			<h3><label for="general">General Settings</label></h3>
			<table class="form-table form-table-1">
				<tr>
						<th scope="row">
							<select name="ple_option_3" class="ple_option_3">
								<?php
									$ergs = array(
										'Default'	=>	99,
										'Effect 1'	=>	1,
										'Effect 2'	=>	2,
										'Effect 3'	=>	3,
										'Custom'	=>	4,
									);
									$effects = apply_filters( 'ple_hook_args', $ergs );
										foreach ( $effects as $key => $val):		
								?>
	   								<option value="<?php echo $val; ?>" <?php echo selected(get_option('ple_option_3', ''), $val); ?>><?php echo $key; ?></option>
	   							<?php	
										endforeach;
								?>
							</select>
						</th>
						<td>
							<label><?php _e('Choose your Animation Effects', 'ple-txt'); ?></label>
						</td>
					</tr>
			</table>
			<div id="ple-preview" class="ple-effect">
				<div id="ple-animates" class="ple-animates">
					<div class="ple-spinner">
						<div class="dot1"></div><div class="dot2"></div>
					</div>
				</div>				
			</div>
			<p class="ple-note">
				<?php _e('Note: This doesn\'t relect the actual background and animation color. See color settings below.', 'ple-txt'); ?> 
			</p>
			<table class="form-table form-table-3">
				<tbody>
					<tr>
						<td>
						<h3 style="margin-bottom: 0;"><label for="advanced"><?php _e('Custom Settings', 'ple-txt'); ?></label></h3>
						<p>
							<?php _e('You can read more information here: <a target="_blank" href="https://www.datacareph.com/web-development-guide/page-loading-effects-welcomes-wordpress-5-0/">datacareph.com</a>.', 'ple-txt'); ?>
						</p>
						<textarea class="ple-txtarea ple_option_6" cols="60" rows="5" name="ple_option_6"><?php echo stripslashes(get_option('ple_option_6', '')); ?></textarea>
						<div class="txtarea-label"><label><?php _e('<b>HTML</b>. Insert your HTML code here.', 'ple-txt'); ?></label></div>					
						<textarea class="ple-txtarea ple_option_7" cols="60" rows="5" name="ple_option_7"><?php echo stripslashes(htmlspecialchars_decode(get_option('ple_option_7', ''))); ?></textarea>
						<div class="txtarea-label"><label><?php _e('<b>CSS</b>. Insert your CSS / CSS3 code here.', 'ple-txt'); ?></label></div>
						
						</td>
					</tr>
				</tbody>
			</table>
			<table class="form-table form-table-2">
				<tbody>
					<tr>
						<th scope="row"><input class="ple_option_i " name="ple_options[]" value="<?php echo PLE()->ctrl->get_option('ple_options', -1, 0); ?>" placeholder="30" min="-1" type="number" value=""></th>
						<td>
						<label style="vertical-align: super;"><?php _e('<i>Default: <code>30</code>Days</i>. <b>Set cookie to expire, or <code>-1</code> to disable.</b>', 'ple-txt'); ?></label>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<input class="ple_option_2" name="ple_option_2" type="number" placeholder="4000" value="<?php echo get_option('ple_option_2'); ?>">
						</th>
						<td>
							<label><?php _e('<i>Default: <code>4000</code>milliseconds</i>. <b>Max Page Loader Duration</b>.', 'ple-txt'); ?></label>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<input class="ple_option_1" name="ple_option_1" type="checkbox" value="1" <?php checked(get_option('ple_option_1'), 1); ?>>
						</th>
						<td>
							<label><?php _e('Check to Disable <kbd>Page Loading Effect</kbd> Plugin', 'ple-txt'); ?></label>
						</td>
					</tr>
				</tbody>
			</table>
			<table class="form-table form-table-2">
				<tbody>
					<tr>
						<td><h3><label for="color">Color Settings</label></h3></td>			
					</tr>
					<tr>
						<th scope="row"><input class="ple_option_4 ple-color-field" name="ple_option_4" type="text" value="<?php echo get_option('ple_option_4', '#d35400'); ?>"></th>
						<td>
						<label style="vertical-align: super;"><?php _e('<i>Default: <code>#ffffff</code></i>. <b>Choose Your Preloader\'s Background Color</b>.', 'ple-txt'); ?></label>
						</td>
					</tr>
					<tr>
						<th scope="row"><input class="ple_option_5 ple-color-field" name="ple_option_5" type="text" value="<?php echo get_option('ple_option_5', '#ffffff'); ?>"></th>
						<td>
						<label style="vertical-align: super;"><?php _e('<i>Default: <code>#dddddd</code></i>. <b>Choose Your Animated Object Color</b>.', 'ple-txt'); ?></label>
						</td>
					</tr>
				</tbody>
			</table>
			<table class="form-table form-table-4">
				<tbody> 
					<tr>
						<td>
							<h3 class="title"><?php _e('Follow Me', 'ple-txt'); ?></h3>
							<span><?php _e('Is this helpful? Questions? Suggestions?', 'ple-txt'); ?></span>
							<p><?php _e('Drop me a message via our contact form <a target="_blank" href="https://datacareph.com/">datacareph.com</a>.', 'ple-txt'); ?></p>
							<p>
								<?php _e('Please follow <a target="_blank" href="https://twitter.com/esstat17">@esstat17</a> on Twitter.', 'ple-txt'); ?>
							</p>
						</td>

					</tr>

				</tbody>
			</table>
			<p class="submit"><input type="submit" name="submit" class="button-primary" value="<?php _e('Save Changes', 'ple-txt'); ?>" /></p>
		</form>
	</div>
<?php 	
}