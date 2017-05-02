<?php
/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://github.com/ReduxFramework/ReduxFramework/wiki
 * */

if (!class_exists("Redux_Framework_config")) {

    class Redux_Framework_config {

        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {
			$this->initSettings();
        }

        public function initSettings() {

            if ( !class_exists("ReduxFramework" ) ) {
                return;
            }       
            
            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/plugin/hooks', array( $this, 'remove_demo' ) );
            // Function to test the compiler hook and demo CSS output.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2); 
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css) {
            //echo "<h1>The compiler hook has run!";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
              require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
              $wp_filesystem->put_contents(
              $filename,
              $css,
              FS_CHMOD_FILE // predefined mode settings for WP files
              );
              }
             */
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'swh'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'swh'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = "Testing filter hook!";

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::get_instance(), 'plugin_meta_demo_mode_link'), null, 2);
            }

            // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
            remove_action('admin_notices', array(ReduxFrameworkPlugin::get_instance(), 'admin_notices'));
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode(".", $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[] = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct = wp_get_theme();
            $this->theme = $ct;
            $item_name = $this->theme->get('Name');
            $tags = $this->theme->Tags;
            $screenshot = $this->theme->get_screenshot();
            $class = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'swh'), $this->theme->display('Name'));
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
            <?php endif; ?>

                <h4>
            <?php echo $this->theme->display('Name'); ?>
                </h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'swh'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'swh'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'swh') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
                <?php
                if ($this->theme->parent()) {
                    printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'swh'), $this->theme->parent()->display('Name'));
                }
                ?>

                </div>

            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }
			//---- Theme Option Here ----//
			$this->sections[] 	=	array(
				'title'	=>	__('General','swh'),
				'icon'	=>	'el-icon-cogs',
				'desc'	=>	null,
				'fields'	=>	array(
                    array(
                        'id'        => 'blog_layout',
                        'type'      => 'image_select',
                        'title'     => __('Blog Layout', 'swh'),
                        'options'   => array(
                        	'right' => array('alt' => 'Right Sidebar',  'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
                            'left' => array('alt' => 'Left Sidebar',   'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
                        ), 
                        'default' => 'right'
                    ),
 
					array(
						'id'	=>	'header_bg',
						'type'	=>	'media',
						'url' => true,
						'subtitle' => __('Upload any media using the WordPress native uploader', 'swh'),
						'title'	=>	__('Header Background','swh')
					),
					/**		
					array(
						'id'	=>	'header_text',
						'title'	=>	__('Header Text','swh'),
						'type'	=>	'text',
						'default'	=>	get_bloginfo('name')
					),
					**/
					array(
						'id'	=>	'favicon',
						'type'	=>	'media',
						'url' => true,
                        'subtitle' => __('Upload any media using the WordPress native uploader', 'swh'),				
						'title'	=>	__('Favicon','swh')
					),
					array(
						'id'	=>	'breadcrumb',
						'type'	=>	'checkbox',
						'subtitle' => __('Do not display the Breadcrumb on Homepage', 'swh'),
						'title'	=>	__('Breadcrumb','swh'),
						'default'   => '0'
					),
                   array(
                        'id' => 'custom_css',
                        'type' => 'ace_editor',
                        'title' => __('Custom CSS', 'swh'),
                        'subtitle' => __('Paste your CSS code here, no style tag.', 'swh'),
                        'mode' => 'css',
                        'theme' => 'monokai'
                    ),	
                    array(
                        'id' => 'custom_js',
                        'type' => 'ace_editor',
                        'title' => __('Custom JS', 'swh'),
                        'subtitle' => __('Paste your JS code here, no script tag, eg: alert(\'hello world\');', 'swh'),
                        'mode' => 'javascript',
                        'theme' => 'chrome'
                    ),
					array(
						'id'	=>	'footer_text',
						'title'	=>	__('Footer Text','swh'),
						'type'	=>	'editor',
						'default'	=>	'© 2014 Sweet Home, All Rights Reserved'
					),
					array(
						'id'	=>	'google-analytics',
						'title'	=>	__('Google Analytics ID','swh'),
						'type'	=>	'text',
						'placeholder'	=>	'UA-39642846-1'
					)
				)
			);
			$this->sections[] = array(
				'icon' => 'el-icon-website',
				'title' => __('Slug Rewrite', 'swh'),
				'desc'	=>	sprintf( __('You may go to %s, click Save Changes button after make this changes.','swh') , '<a href="'.admin_url('options-permalink.php').'">'.__('Permalink Settings','swh').'</a>'),
				'fields' => array(			
					array(
						'id'	=>	'rewrite_property',
						'title'	=>	__('Property','swh'),
						'type'	=>	'text',
						'default'	=>	'property'
					),
					array(
						'id'	=>	'rewrite_agent',
						'title'	=>	__('Agent','swh'),
						'type'	=>	'text',
						'default'	=>	'agent'
					),
					array(
						'id'	=>	'rewrite_ptype',
						'title'	=>	__('Property Type','swh'),
						'type'	=>	'text',
						'default'	=>	'ptype'
					),	
					array(
						'id'	=>	'rewrite_location',
						'title'	=>	__('Property Location','swh'),
						'type'	=>	'text',
						'default'	=>	'location'
					),
					array(
						'id'	=>	'rewrite_property_tag',
						'title'	=>	__('Property Tag','swh'),
						'type'	=>	'text',
						'default'	=>	'property_tag'
					),	
					array(
						'id'	=>	'rewrite_status',
						'title'	=>	__('Property Status','swh'),
						'type'	=>	'text',
						'default'	=>	'status'
					),
				)				
			);
			$this->sections[] = array(
				'icon' => 'el-icon-website',
				'title' => __('Apperance', 'swh'),
				'fields' => array(			
					array(
						'id'        => 'opt-background',
						'type'      => 'background',
						'output'    => array('body'),
						'title'     => __('Body Background', 'swh'),
						'subtitle'  => __('Body background with image, color, etc.', 'swh'),
						'default'   => '#FFFFFF',
					),
					array(
						'id' => 'background-topbar',
						'type' => 'color',
						'title' => __('Top Bar Background', 'swh'),
						'subtitle' => __('Pick a background color for the Top Bar.', 'swh'),
						'default' => 'hsl(201, 100%, 45%)',
						'validate' => 'color',
					),						
					array(
						'id' => 'background-menu',
						'type' => 'color',
						'title' => __('Menu Background', 'swh'),
						'subtitle' => __('Pick a background color for the menu.', 'swh'),
						'default' => 'hsla(0, 0%, 9%, 0.7)',
						'validate' => 'color',
					),
					array(
						'id' => 'color-text-menu',
						'type' => 'color',
						'title' => __('Menu Text Color', 'swh'),
						'subtitle' => __('Pick a color for the Text menu.', 'swh'),
						'default' => '#fff',
						'validate' => 'color',
					),
					array(
						'id' => 'color-text-active-menu',
						'type' => 'color',
						'title' => __('Active Menu Text color', 'swh'),
						'subtitle' => __('Pick a background color for the active menu Text.', 'swh'),
						'default' => '#333',
						'validate' => 'color',
					),
					array(
						'id' => 'background-footer',
						'type' => 'color',
						'title' => __('Footer Background', 'swh'),
						'subtitle' => __('Pick a background for the Footer.', 'swh'),
						'default' => 'hsl(201, 8%, 33%)',
						'validate' => 'color',
					),
					array(
						'id' => 'background-footer-strip',
						'type' => 'color',
						'title' => __('Footer Strip Background', 'swh'),
						'subtitle' => __('Pick a background for the Footer Strip.', 'swh'),
						'default' => 'hsl(201, 100%, 45%)',
						'validate' => 'color',
					),
					array(
						'id' => 'color-footer',
						'type' => 'color',
						'title' => __('Footer Text Color', 'swh'),
						'subtitle' => __('Pick a color for Text in the footer.', 'swh'),
						'default' => 'hsl(0, 100%, 100%)',
						'validate' => 'color',
					),
				)
			);			
			$this->sections[] 	=	array(
				'title'	=>	__('Contact Form','swh'),
				'icon'    => 'el-icon-cogs',
				'fields'	=>array(
					array(
						'id'	=>	'cf_active',
						'title'	=>	__('Active','swh'),
						'subtitle'	=>	__('Active the form.','swh'),
						'type'	=>	'checkbox',
						'default'	=>	'1'
					),
					array(
						'id'	=>	'cf_deactive_message',
						'title'	=>	__('Display this alert if the form is deactivated.','swh'),
						'type'	=>	'text',
						'default'	=>	__('Coming soon.','swh')
					),						
					array(
						'id'	=>	'cf_email',
						'title'	=>	__('Admin email','swh'),
						'subtitle'	=>	__('This address receive the message through the Contact Form Widget.','swh'),
						'desc'	=>	__('adsad','swh'),
						'type'	=>	'text',
						'default'	=>	get_bloginfo('admin_email')						
					),
					array(
						'id'	=>	'cf_subject',
						'title'	=>	__('Subject','swh'),
						'subtitle'	=>	__('The subject of the message.','swh'),
						'type'	=>	'text',
						'default'	=>	sprintf( __('New message from %s','swh') , get_bloginfo('name'))							
					),
					array(
						'id'	=>	'cf_sent_successfully',
						'title'	=>	__('Sender\'s message was sent successfully','swh'),
						'type'	=>	'text',
						'default'	=>	__('Your message was sent successfully. Thanks.','swh')
					),
					array(
						'id'	=>	'cf_sent_failed',
						'title'	=>	__('Sender\'s message was failed to send','swh'),
						'type'	=>	'text',
						'default'	=>	__('Failed to send your message. Please try later or contact the administrator by another method.','swh')
					),
					array(
						'id'	=>	'cf_validation_error',
						'title'	=>	__('Validation errors occurred','swh'),
						'type'	=>	'text',
						'default'	=>	__('Validation errors occurred. Please confirm the fields and submit it again.','swh')
					),
					array(
						'id'	=>	'cf_name_error',
						'title'	=>	__('Name field Validation','swh'),
						'type'	=>	'text',
						'default'	=>	__('Please fill the Name.','swh')
					),
					array(
						'id'	=>	'cf_email_error',
						'title'	=>	__('Email field Validation','swh'),
						'type'	=>	'text',
						'default'	=>	__('Please fill the Email.','swh')
					),
					array(
						'id'	=>	'cf_content_error',
						'title'	=>	__('Content field Validation','swh'),
						'type'	=>	'text',
						'default'	=>	__('Please fill the message content.','swh')
					),
				)
			);
			$this->sections[] = array(
					'title'   => __('Pricing Options','swh'),
					'icon'    => 'el-icon-usd',
					'fields'  => array(
						array(
							'id'	=>	'currency',
							'title'	=>	__('Currency','swh'),
							'type'	=>	'text',
							'default'	=>	'$'
						),
						array(
							'id'	=>	'currency_position',
							'title'	=>	__('Currency Position','swh'),
							'type'	=>	'select',
							'options'	=>	array(
								'left'	=>	__('Left','swh'),
								'right'	=>	__('Right','swh')
							),
							'default'	=>	'left'
						),
						array(
							'id'	=>	'thousand_separator',
							'title'	=>	__('Thousand Separator','swh'),
							'type'	=>	'text',
							'default'	=>	','
						),
						array(
								'id'	=>	'decimal_separator',
								'title'	=>	__('Decimal Separator','swh'),
								'type'	=>	'text',
								'default'	=>	'.'
						)
					),
			);			
			$this->sections[] = array(
				'icon'	=> 'el-icon-home',
				'title'	=>	__('Company','swh'),
				'fields'	=>	array(
					array(
						'id'	=>	'c_address',
						'title'	=>	__('Address','swh'),
						'type'	=>	'text',
						'subtitle'	=>	__('Enter the company address.','swh')
					),
					array(
						'id'	=>	'c_mobile',
						'title'	=>	__('Hotline/Mobile','swh'),
						'type'	=>	'text',
						'subtitle'	=>	__('Enter the Hotline/Mobile number.','swh')
					),
					array(
						'id'	=>	'c_telephone',
						'title'	=>	__('Telephone','swh'),
						'type'	=>	'text',
						'subtitle'	=>	__('Enter the Telephone number.','swh')
					),
					array(
						'id'	=>	'c_fax',
						'title'	=>	__('Fax','swh'),
						'type'	=>	'text',
						'subtitle'	=>	__('Enter the Fax number.','swh')
					),
					array(
						'id'	=>	'c_email',
						'title'	=>	__('Email Address','swh'),
						'type'	=>	'text',
						'default'	=>	get_bloginfo('admin_email'),
						'subtitle'	=>	__('Enter the company email address.','swh')
					),
				)
			);
			
			$this->sections[] =	array(
				'title' => __( 'Gmap', 'swh' ),
				'id'    => 'gmap',
				'icon'  => 'el el-map-marker',
				'fields'	=>	array(
					array(
						'id'	=>	'gmap_marker',
						'type'	=>	'media',
						'url' => true,
						'subtitle' => __('Upload any media using the WordPress native uploader', 'swh'),
						'title'	=>	__('Marker','swh')
					),			
					array(
						'id' => 'gmap_api',
						'type' => 'text',
						'title' => __('Google Map API Key', 'swh')
					),
					array(
						'id'	=>	'gmap_language',
						'title'	=>	__('Language','swh'),
						'type'	=>	'text',
						'description'	=>	sprintf( esc_html__( 'Setting your gmap %s', 'swh' ), '<a target="_blank" href="https://developers.google.com/maps/faq#languagesupport">'. esc_html__( 'language code', 'swh' ) .'</a>' )
					)
				)
			);			
			
			$this->sections[] =	array(
				'icon'	=> ' el-icon-share-alt',
				'title'	=>	__('Socials','swh'),
				'fields'	=>	array(
					array(
						'id'	=>	's-fa-facebook',
						'title'	=>	__('Facebook','swh'),
						'type'	=>	'text',
						'desc'	=>	__('Put the Facebook link.','swh')
					),
					array(
						'id'	=>	's-fa-google-plus',
						'title'	=>	__('Google Plus','swh'),
						'type'	=>	'text',
						'desc'	=>	__('Put the Google Plus link','swh')
					),
					array(
						'id'	=>	's-fa-twitter',
						'title'	=>	__('Twitter','swh'),
						'type'	=>	'text',
						'desc'	=>	__('Put the Twitter link','swh')
					),
					array(
						'id'	=>	's-fa-pinterest',
						'title'	=>	__('Pinterest','swh'),
						'type'	=>	'text',
						'desc'	=>	__('Put the Pinterest link','swh')
					),
					array(
						'id'	=>	's-fa-dribbble',
						'title'	=>	__('Dribbble','swh'),
						'type'	=>	'text',
						'desc'	=>	__('Put the Dribbble link','swh')
					),
					array(
						'id'	=>	's-fa-linkedin',
						'title'	=>	__('Linkedin','swh'),
						'type'	=>	'text',
						'desc'	=>	__('Put the Linkedin link','swh')
					),
					array(
						'id'	=>	's-fa-youtube',
						'title'	=>	__('Youtube','swh'),
						'type'	=>	'text',
						'desc'	=>	__('Put the Youtube link','swh')
					)						
				)
			); 
			
			$this->sections[] =	array(
				'title' => __( 'Update', 'swh' ),
				'id'    => 'update',
				'icon'  => 'el el-refresh',
				'fields'	=>	array(
					array(
						'id'	=>	'purchase_code',
						'title'	=>	__('Purchase Code','swh'),
						'type'	=>	'text'
					),
					array(
						'id'	=>	'access_token',
						'title'	=>	esc_html__('Personal Access Token','swh'),
						'desc'	=>	sprintf( esc_html__('Get one key %s','swh'), '<a target="_blank" href="https://build.envato.com/create-token/">'. esc_html__( 'here', 'swh' ) .'</a>' ),
						'type'	=>	'text'
					)						
				)
			);
					
        }
        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id' => 'redux-opts-1',
                'title' => __('Theme Information 1', 'swh'),
                'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'swh')
            );

            $this->args['help_tabs'][] = array(
                'id' => 'redux-opts-2',
                'title' => __('Theme Information 2', 'swh'),
                'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'swh')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'swh');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name' => 'sweethome', // This is where your data is stored in the database and also becomes your global variable name.
                'display_name' => $theme->get('Name'), // Name that appears at the top of your panel
                'display_version' => $theme->get('Version'), // Version that appears at the top of your panel
                'menu_type' => 'submenu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu' => true, // Show the sections below the admin menu item or not
                'menu_title' => __('Theme Options', 'swh'),
                'page' => __('Theme Options', 'swh'),
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '', // Must be defined to add google fonts to the typography module
                //'admin_bar' => false, // Show the panel pages on the admin bar
                'global_variable' => '', // Set a different name for your global variable other than the opt_name
                'dev_mode' => false, // Show the time the page took to load, etc
                'customizer' => true, // Enable basic customizer support
                // OPTIONAL -> Give you extra features
                'page_priority' => null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent' => 'themes.php', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions' => 'manage_options', // Permissions needed to access the options panel.
                'menu_icon' => '', // Specify a custom URL to an icon
                'last_tab' => '', // Force your panel to always open to a specific tab (by id)
                'page_icon' => 'icon-themes', // Icon displayed in the admin panel next to your menu_title
                'page_slug' => '_options', // Page slug used to denote the panel
                'save_defaults' => true, // On load save the defaults to DB before user clicks save or not
                'default_show' => false, // If true, shows the default value next to each field that is not the default value.
                'default_mark' => '', // What to print by the field's title if the value shown is default. Suggested: *
                // CAREFUL -> These options are for advanced use only
                'transient_time' => 60 * MINUTE_IN_SECONDS,
                'output' => true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag' => true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                //'domain'             	=> 'redux-framework', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
                //'footer_credit'      	=> '', // Disable the footer credit of Redux. Please leave if you can help it.
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database' => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'show_import_export' => true, // REMOVE
                'system_info' => false, // REMOVE
                'help_tabs' => array(),
                'help_sidebar' => '', // __( '', $this->args['domain'] );            
            );
            $this->args['share_icons'][] = array(
                'url' => 'https://twitter.com/wpoffice',
                'title' => 'Follow us on Twitter',
                'icon' => 'el-icon-twitter'
            );
            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace("-", "_", $this->args['opt_name']);
                }
                $this->args['intro_text'] = sprintf(__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'swh'), $v);
            } else {
                $this->args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'swh');
            }

            // Add content after the form.
            //$this->args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'swh');
        }

    }

    new Redux_Framework_config();
}