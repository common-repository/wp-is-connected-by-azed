<?php
/*
Plugin Name: WP Is Connected by Azed
Author: Azed - Cyril Chaniaud
Plugin URI: http://www.azed-dev.com/wordpress/wp-is-connected-by-azed/
Description: You want to show specific content for each user role ?
Version: 0.1
Author URI: http://www.azed-dev.com/
License: GPL3
*/


if( !class_exists('AzedWPIsConnected') ){

	class AzedWPIsConnected{

		const textDomain = 'azedwpisconnectedtextdomain';
	  /**
		* Construct the plugin object
		*/

		public function __construct()
		{

			add_action('init',array(&$this, 'init'));

			add_action('admin_menu', array(&$this, 'azedWpIsConnected_menu'));

			add_action( 'admin_enqueue_scripts', array(&$this,'admin_custom_css') );

			add_action('media_buttons', array( 'AzedWPIsConnected' , 'add_my_media_button'));
		} // END public function __construct
		public static function init(){
			if( is_admin() ){
				load_plugin_textdomain( SELF :: textDomain, false, dirname(plugin_basename(__FILE__)).'/languages/' );
			}
			else{
				add_shortcode('wisco', array( 'AzedWPIsConnected' , 'wisco_shortcode' ));
				add_shortcode('wishow', array( 'AzedWPIsConnected' , 'wishow_shortcode' ));
			}
		}
		public function azedWpIsConnected_menu(){
			$pageID = add_plugins_page (
				__('Is connected Examples', SELF :: textDomain),
				__('Is connected Examples', SELF :: textDomain),
				'edit_posts',
				'AzedWPIsConnected',
				array(&$this,'is_connected_examples')
			);
		} // END admin init function for adding submenu item

		public function admin_custom_css(){
			wp_register_style( 'AzedWPIsConnected_CSS', plugins_url( 'css/styles.css', __FILE__ ));
			wp_register_script( 'AzedWPIsConnected_JS', plugins_url( 'js/wisco_main.js', __FILE__ ) );
		}

		public function is_connected_examples()
		{
			wp_enqueue_style('AzedWPIsConnected_CSS');
			?>
			<div class="azedGlobal">
				<div class="azedContainer">
					<div class="azedWrapper">
						<h1><?php _e('WP Is Connected by Azed', SELF :: textDomain);?></h1>
					</div>
					<div class="azedWrapper">
						<h2><?php _e('The user is not logged' , SELF :: textDomain); ?></h2>
						<p>[wisco off] <?php _e('Put your content here', SELF :: textDomain); ?> [/wisco]</p>
					</div>
					<div class="azedWrapper">
						<h2><?php _e('The user is logged' , SELF :: textDomain); ?></h2>
						<p>[wisco on] <?php _e('Put your content here', SELF :: textDomain); ?> [/wisco]</p>
					</div>
					<div class="azedWrapper">
						<h2><?php _e('The user is logged and his role is subsciber or author' , SELF :: textDomain); ?></h2>
						<p>[wisco on="subscriber,author"] <?php _e('Put your content here', SELF :: textDomain); ?> [/wisco]</p>
					</div>
					<div class="azedWrapper">
						<h2><?php _e('The user is logged and his role is not subsciber or author' , SELF :: textDomain); ?></h2>
						<p>[wisco on="!subscriber,!author"] <?php _e('Put your content here', SELF :: textDomain); ?> [/wisco]</p>
					</div>
				</div>
			</div>
			<?php
			//$this -> create_form();
		} // END is_connected_form for display and exec the form

		public function create_form(){
			wp_enqueue_script('AzedWPIsConnected_JS');
			wp_enqueue_style('AzedWPIsConnected_CSS');
			?>
			<div class="azedGlobal azedPopinBG" id="popInBG">
			<div class="azedPopin azedGlobal" id="popDatas">
				<div class="azedContainer">
					<div class="azedWrapper">
						<h3><?php _e('Choose user data to insert' , SELF :: textDomain ); ?></h3>
						<div class="azedWrapper">
							<div class="azedRow">
								<h4 class="fleft-2"><?php _e( 'Name' , SELF :: textDomain ); ?></h4>
								<p class="fleft-2"><input type="button" id="name" value="<?php _e('Add shortcode' , SELF :: textDomain ); ?>" class="button button-primary" /></p>
							</div>
						</div>
						<div class="azedWrapper">
							<div class="azedRow">
								<h4 class="fleft-2"><?php _e( 'ID' , SELF :: textDomain ); ?></h4>
								<p class="fleft-2"><input type="button" id="id" value="<?php _e('Add shortcode' , SELF :: textDomain ); ?>" class="button button-primary" /></p>
							</div>
						</div>
						<div class="azedWrapper">
							<div class="azedRow">
								<h4 class="fleft-2"><?php _e( 'E-mail' , SELF :: textDomain ); ?></h4>
								<p class="fleft-2"><input type="button" id="email" value="<?php _e('Add shortcode' , SELF :: textDomain ); ?>" class="button button-primary" /></p>
							</div>
						</div>
						<div class="azedWrapper">
							<div class="azedRow">
								<h4 class="fleft-2"><?php _e( 'Website' , SELF :: textDomain ); ?></h4>
								<p class="fleft-2"><input type="button" id="website" value="<?php _e('Add shortcode' , SELF :: textDomain ); ?>" class="button button-primary" /></p>
							</div>
						</div>
						<div class="azedWrapper">
							<div class="azedRow">
								<h4 class="fleft-2"><?php _e( 'Description' , SELF :: textDomain ); ?></h4>
								<p class="fleft-2"><input type="button" id="description" value="<?php _e('Add shortcode' , SELF :: textDomain ); ?>" class="button button-primary" /></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="azedPopin azedGlobal" id="popAccess">
				<div class="azedContainer">
					<div class="azedWrapper">
						<form action="#" id="connectedForm">
							<h3><?php _e('Select your target' , SELF :: textDomain ); ?></h3>
							<p><label for="wiscoFilter"><?php _e( 'Filter' , SELF :: textDomain ); ?></label></p>
							<p><select name="wiscoFilter" id="wiscoFilter" class="formElt">
								<option value="none"><?php _e( 'None' , SELF :: textDomain ); ?></option>
									<option value="all"><?php _e( 'All' , SELF :: textDomain ); ?></option>
								<option value="allowedRoles"><?php _e( 'Allowed roles' , SELF :: textDomain ); ?></option>
								<option value="disallowRoles"><?php _e( 'Disallowed roles' , SELF :: textDomain ); ?></option>
								<option value="ids"><?php _e( 'Specific ID\'s' , SELF :: textDomain ); ?></option>
							</select></p>
							<div class="azedContainer disableSection sectionSwipe" id="allowedRolesSection">
								<div class="azedWrapper">
									<h4><?php _e( 'Allowed roles' , SELF :: textDomain ); ?></h4>
									<div class="azedRow">
									<?php
									foreach (get_editable_roles() as $role_name => $role_info){
											?>
											<p class="fleft-3"><input type="checkbox" id="allowroles[<?php echo $role_name; ?>]" name="allowroles[<?php echo $role_name; ?>]" value="<?php echo $role_name; ?>" />
											<label for="allowroles[<?php echo $role_name; ?>]"><?php echo $role_name; ?></label></p>
											<?php
									}
									?>
									</div>
								</div>
							</div>
							<div class="azedContainer disableSection sectionSwipe" id="disallowRolesSection">
								<div class="azedWrapper">
									<h4><?php _e( 'Disallowed roles' , SELF :: textDomain ); ?></h4>
									<div class="azedRow">
									<?php
									foreach (get_editable_roles() as $role_name => $role_info){
											?>
											<p class="fleft-3"><input type="checkbox" id="disallowroles[<?php echo $role_name; ?>]" name="disallowroles[<?php echo $role_name; ?>]" value="<?php echo $role_name; ?>" />
											<label for="disallowroles[<?php echo $role_name; ?>]"><?php echo $role_name; ?></label></p>
											<?php
									}
									?>
									</div>
								</div>
							</div>
							<div class="azedContainer disableSection sectionSwipe" id="idsSection">
								<div class="azedWrapper">
									<h4><label for="allowIds"><?php _e( 'Specific ID\'s' , SELF :: textDomain ); ?></label></h4>
									<p><input type="text" name="allowIds" id="allowIds" value="" class="formElt" /></p>
								</div>
							</div>

							<div class="azedContainer"><div id="shortcodeResult" class="azedWrapper"></div></div>
						</form>
					</div>
				</div>
				<div class="btnPlace"><input name="submit" id="wiscoInserter" class="button button-primary" value="<?php _e('Insert Shortcode' , SELF :: textDomain); ?>" type="submit"></div>
			</div>
		</div>

			<?php
		}
		public function add_my_media_button() {
			add_action('admin_footer', array( 'AzedWPIsConnected' , 'create_form' ));
			?>
			<a href="#" id="wisco_shortcode_button" class="button"><?php _e('User restriction' , SELF :: textDomain) ; ?></a>
			<a href="#" id="wishow_shortcode_button" class="button"><?php _e('User datas' , SELF :: textDomain) ; ?></a>
			<?php
		}

		public function wisco_shortcode( $atts , $content = '' ){
			if( is_user_logged_in() ){
				$currentUser = wp_get_current_user();
				$currentUserInfo = get_userdata( $currentUser->ID );
				$currentUserRole = implode(', ', $currentUserInfo->roles);
			}
			$show = true;

			foreach( $atts as $att => $value ){
				if ( $value == 'on' ) {
					if(!is_user_logged_in()){
						$show = false;
					}
				}
				elseif ( $value == 'off' ) {
					if(is_user_logged_in()){
						$show = false;
					}
				}
				elseif ( $att == 'id' ) {
					if(!is_user_logged_in()){
						$show = false;
					}
					else{
						$ids = explode( ',' , $value );
						if( !in_array( $currentUser->ID , $ids ) ){
							$show = false;
						}
					}
				}
				elseif( $att == 'on' ){
					if( is_user_logged_in() ){
						$blocage = explode( ',' ,$value );
						if( !in_array( $currentUserRole , $blocage ) ){
							$yesItIs = false;
							$show2 = true;
							foreach( $blocage as $key => $val ){
								if( stripos( $val , '!') !== false ){
									$yesItIs = true;
									if( $val == '!'.$currentUserRole ){
										$show2 = false;
									}
								}
							}
							if( $yesItIs && $show2 ){
							}
							else{
								$show = false;
							}
							unset($show2);
							unset($yesItIs);
						}
						if( in_array( '!'.$currentUserRole , $blocage ) ){
							$show = false;
						}
					}
					else{
						$show = false;
					}
				}

			}

			if( $show ){
				return do_shortcode($content);
			}
			else {
				return;
			}

		}

		public function wishow_shortcode( $atts  ){
			if( is_user_logged_in() ){
				$currentUser = wp_get_current_user();
				foreach( $atts as $att => $value ){
					if ( $value == 'name' ) {
						return $currentUser -> display_name;
					}
					elseif ( $value == 'id' ) {
						return $currentUser -> ID;
					}
					elseif ( $value == 'email' ) {
						return $currentUser -> user_email;
					}
					elseif ( $value == 'website' ) {
						return $currentUser -> user_url;
					}
					elseif ( $value == 'description' ) {
						return get_the_author_meta('description');
					}
					elseif ( $value == 'role' ) {
						$currentUserInfo = get_userdata( $currentUser->ID );
						$currentUserRole = implode(', ', $currentUserInfo->roles);
						return $currentUserRole;
					}

				}
			}
			else {
				return;
			}

		}
	}
}
$azedWpIsConnectedPlugin = new AzedWPIsConnected();

?>
