<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       bdtask.com
 * @since      1.0.0
 *
 * @package    bdtaskcrm
 * @subpackage bdtaskcrm/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    bdtaskcrm
 * @subpackage bdtaskcrm/admin
 * @author     bdtask <bdtask@gmail.com>
 */
class BDTASKCRM_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        add_action( 'admin_init',array($this,'bdtaskcrm_dependence_loader')  ) ;
        add_action( 'admin_menu',array($this,'bdtaskcrm_page_creater')  ) ;
        add_action( 'admin_menu',array($this,'bdtaskcrm_setting_api')  ) ;
        add_action('init',array($this,'bdtaskcrm_quotations_order_ajax'));

  add_action( 'wp_ajax_add_get_result',array($this,'add_process_ajax'));
  add_action( 'wp_ajax_nopriv_add_get_result',array($this,'add_process_ajax'));


  add_action( 'wp_ajax_relation_result',array($this,'product_total_rate'));
  add_action( 'wp_ajax_nopriv_relation_result',array($this,'product_total_rate')); 

  add_action( 'wp_ajax_card_number_input',array($this,'card_number_show_input_box'));
  add_action( 'wp_ajax_nopriv_card_number_input',array($this,'card_number_show_input_box'));

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in bdtaskcrm_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The bdtaskcrm_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		  wp_enqueue_style( 'bootstrap',
                          plugin_dir_url( __FILE__ ).'css/bootstrap.min.css', 
                           array(), $this->version, 'all' );
          wp_enqueue_style( 'bdtaskcrm-dataTables-min-style',
                           plugin_dir_url( __FILE__ ).'css/bdtaskcrm-dataTables.min.css', 
                           array(), $this->version, 'all' );

          wp_enqueue_style( 'bdtaskcrm-f-min-style',
                           plugin_dir_url( __FILE__ ).'css/select2.min.css', 
                           array(), $this->version, 'all' );

         wp_enqueue_style('font-awesome',plugin_dir_url( __FILE__ ). 'css/font-awesome/css/font-awesome.min.css',array(), $this->version, 'all');

         wp_enqueue_style('alertify-css',plugin_dir_url( __FILE__ ). 'css/alertify.css',array(), $this->version, 'all');
         wp_enqueue_style('default-css',plugin_dir_url( __FILE__ ). 'css/default.css',array(), $this->version, 'all');

		 wp_enqueue_style('jquery-style',plugin_dir_url( __FILE__ ). 'css/jquery-ui.css');
		 wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bdtaskcrm-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in bdtaskcrm_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The bdtaskcrm_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-datepicker');

         wp_enqueue_script( 'bootstrap-min-js',plugin_dir_url( __FILE__ ).'js/bootstrap.min.js',array( 'jquery' ), $this->version,true  );

        wp_enqueue_script( 'bdtaskcrm-dataTables-min', 
                            plugin_dir_url( __FILE__ ).'js/bdtaskcrm-dataTables.min.js',
                            array( 'jquery' ), $this->version,false );

        wp_enqueue_script( 'bdtaskcrm-jQuery-validation',plugin_dir_url( __FILE__ ).'/js/jquery.validate.min.js',array( 'jquery' ), $this->version,true);

        wp_enqueue_script( 'bdtaskcrm-alertify-js',plugin_dir_url( __FILE__ ).'js/alertify.js',array( 'jquery' ), $this->version,false);
 
        wp_enqueue_script( 'bdtaskcrm-select',plugin_dir_url( __FILE__ ).'js/select2.min.js',array( 'jquery' ), $this->version,false);
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/bdtaskcrm-admin.js', array( 'jquery' ), $this->version, true );

	}

  public function bdtaskcrm_dependence_loader(){

     require_once plugin_dir_path( __FILE__ ) . 'query/bdtaskcrm-lead-query.php';
     require_once plugin_dir_path( __FILE__ ) . 'query/bdtaskcrm-customer-query.php';
     require_once plugin_dir_path( __FILE__ ) . 'query/bdtaskcrm-service-query.php';
     require_once plugin_dir_path( __FILE__ ) . 'query/bdtaskcrm-quotation-query.php';
     require_once plugin_dir_path( __FILE__ ) . 'query/bdtaskcrm-order-query.php';

  }




	//==============Main Menu================== 
	public function bdtaskcrm_define_page(){
		
		$parents = array(
			            array(
			           'page_title'  => 'bdtaskcrm',              //$parent_slug
						     'menu_title'  => 'Bdtask CRM',          //$page_title
						     'capability'  => 'manage_options',           //$capability
						     'menu_slug'   => 'bdtaskcrm_invoice',              //$menu_title
						     'dashicons'   => 'dashicons-feedback'    //$dashicons
			            ));

		 return $parents ;

	}

	//==========Submenu=======================

	public function bdtaskcrm_define_subpage(){

		$parents = array(
			            array(
			           'parent_slug' => 'bdtaskcrm_invoice',     //$parent_slug
						     'page_title'  => 'Leads',     //$page_title
						     'menu_title'  => 'Leads',     //$menu_title
						     'capability'  => 'manage_options',  //$capability
						     'menu_slug'   => 'bdtaskcrm_invoice', 
			            ),
		           
			           array(
			           'parent_slug' => 'bdtaskcrm_invoice',    //$parent_slug
						     'page_title'  => 'Customers',       //$page_title
						     'menu_title'  => 'Customers',       //$menu_title
						     'capability'  => 'manage_options', //$capability
						     'menu_slug'   => 'bdtaskcrm_customer', 
			            ),

			            array(
			           'parent_slug' => 'bdtaskcrm_invoice',    //$parent_slug
						     'page_title'  => 'Services',       //$page_title
						     'menu_title'  => 'Services',       //$menu_title
						     'capability'  => 'manage_options', //$capability
						     'menu_slug'   => 'bdtaskcrm_services', 
			            ),

			            array(
			           'parent_slug' => 'bdtaskcrm_invoice',    //$parent_slug
						     'page_title'  => 'Quotation',       //$page_title
						     'menu_title'  => 'Quotation',       //$menu_title
						     'capability'  => 'manage_options', //$capability
						     'menu_slug'   => 'bdtaskcrm_quotation', 
			            ),  

			            array(
			           'parent_slug' => 'bdtaskcrm_invoice',    //$parent_slug
						     'page_title'  => 'Manage Quotations',       //$page_title
						     'menu_title'  => 'Manage Quotations',       //$menu_title
						     'capability'  => 'manage_options', //$capability
						     'menu_slug'   => 'bdtaskcrm_manage_quotation', 
			            ),   

			           array(
			           'parent_slug' => null,    //$parent_slug
						     'page_title'  => 'Update Quotations',       //$page_title
						     'menu_title'  => 'Update Quotation',       //$menu_title
						     'capability'  => 'manage_options', //$capability
						     'menu_slug'   => 'bdtaskcrm_update_qutation', 
			            ),  
			           array(
			           'parent_slug' => null,    //$parent_slug
						     'page_title'  => 'Update order',       //$page_title
						     'menu_title'  => 'Update order',       //$menu_title
						     'capability'  => 'manage_options', //$capability
						     'menu_slug'   => 'bdtaskcrm_update_order', 
			            ),  

			           array(
			           'parent_slug' => null,    //$parent_slug
						     'page_title'  => 'View Quotations',       //$page_title
						     'menu_title'  => 'View Quotations',       //$menu_title
						     'capability'  => 'manage_options', //$capability
						     'menu_slug'   => 'bdtaskcrm_view_quotation', 
			            ),    

			           array(
			           'parent_slug' => null,    //$parent_slug
						     'page_title'  => 'View Order',       //$page_title
						     'menu_title'  => 'View Order',       //$menu_title
						     'capability'  => 'manage_options', //$capability
						     'menu_slug'   => 'bdtaskcrm_view_order', 
			            ),   


			           array(
			           'parent_slug' => 'bdtaskcrm_invoice',    //$parent_slug
						     'page_title'  => 'Order',       //$page_title
						     'menu_title'  => 'Order ',       //$menu_title
						     'capability'  => 'manage_options', //$capability
						     'menu_slug'   => 'bdtaskcrm_create_order', 
			            ),       
			           array(
			           'parent_slug' => 'bdtaskcrm_invoice',    //$parent_slug
						     'page_title'  => 'Manage Order',       //$page_title
						     'menu_title'  => 'Manage Order ',       //$menu_title
						     'capability'  => 'manage_options', //$capability
						     'menu_slug'   => 'bdtaskcrm_manage_order', 
			            ),  
		                array(
			           'parent_slug' => 'bdtaskcrm_invoice',    //$parent_slug
						     'page_title'  => 'Settings',       //$page_title
						     'menu_title'  => 'Settings',       //$menu_title
						     'capability'  => 'manage_options', //$capability
						     'menu_slug'   => 'bdtaskcrm_setting', 
			            ),   
			            array(
			           'parent_slug' => 'bdtaskcrm_invoice',    //$parent_slug
						     'page_title'  => 'Premium',       //$page_title
						     'menu_title'  => 'Premium',       //$menu_title
						     'capability'  => 'manage_options', //$capability
						     'menu_slug'   => 'bdtaskcrm_preminum', 
			            ),    
		              
			         
                  );

		return $parents ;
	}
	public function bdtaskcrm_create_menu_page(){
        $parents = $this->bdtaskcrm_define_page();
        if ( $parents ) {
            foreach ($parents as $parent) {
                add_menu_page(   $parent['page_title'], 
                	             $parent['menu_title'],
                	             $parent['capability'],
                	             $parent['menu_slug'],
                	             array( $this , $parent['menu_slug'].'_callback'),
                	             $parent['dashicons'] ) ; 
             }


        }  

    }
    public function bdtaskcrm_create_submenu_page(){
        $parents = $this->bdtaskcrm_define_subpage();

        if ( $parents ) {
            foreach ($parents as $parent) {
                add_submenu_page($parent['parent_slug'] , 
                	             $parent['page_title'],
                	             $parent['menu_title'],
                	             $parent['capability'],
                	             $parent['menu_slug'],
                	             array( $this , $parent['menu_slug'].'_callback' )) ; 
             }


        }


    }


    public function bdtaskcrm_page_creater(){
       	   $this->bdtaskcrm_create_menu_page();
       	   $this->bdtaskcrm_create_submenu_page();
    }

    public function  bdtaskcrm_invoice_callback(){
     global $pagenow;
      require_once plugin_dir_path( __FILE__ ) . '/templates/bdtaskcrm_lead.php';   
    } 
    public function  bdtaskcrm_customer_callback(){
     global $pagenow;
      require_once plugin_dir_path( __FILE__ ) . '/templates/bdtaskcrm_customer.php'; 
    }     

    public function  bdtaskcrm_services_callback(){
     global $pagenow;
      require_once plugin_dir_path( __FILE__ ) . '/templates/bdtaskcrm_services.php'; 
    }
    public function  bdtaskcrm_quotation_callback(){
     global $pagenow;
      require_once plugin_dir_path( __FILE__ ) . '/templates/bdtaskcrm_quotation.php'; 
    } 
    public function  bdtaskcrm_manage_quotation_callback(){
     global $pagenow;
      require_once plugin_dir_path( __FILE__ ) . '/templates/bdtaskcrm_manage_qutation.php'; 
    } 

   public function  bdtaskcrm_update_qutation_callback(){
     global $pagenow;
      require_once plugin_dir_path( __FILE__ ) . '/templates/bdtaskcrm_update_qutation.php'; 
    } 
   
   public function  bdtaskcrm_create_order_callback(){
     global $pagenow;
      require_once plugin_dir_path( __FILE__ ) . '/templates/bdtaskcrm_create_order.php';
    }  

    public function  bdtaskcrm_manage_order_callback(){
     global $pagenow;
      require_once plugin_dir_path( __FILE__ ) . '/templates/bdtaskcrm_manage_order.php';
    } 
   public function  bdtaskcrm_update_order_callback(){
     global $pagenow;
      require_once plugin_dir_path( __FILE__ ) . '/templates/bdtaskcrm_update_order.php';
    } 
    public function  bdtaskcrm_view_quotation_callback(){
     global $pagenow;
      require_once plugin_dir_path( __FILE__ ) . '/templates/bdtaskcrm_view_quotation.php';
    }     

    public function  bdtaskcrm_view_order_callback(){
     global $pagenow;
      require_once plugin_dir_path( __FILE__ ) . '/templates/bdtaskcrm_view_order.php';
    } 

    public function  bdtaskcrm_preminum_callback(){
     global $pagenow;
      require_once plugin_dir_path( __FILE__ ) . '/templates/bdtaskcrm_preminum.php';
    } 



  public function bdtaskcrm_quotations_order_ajax(){
         wp_enqueue_script( 'bdtaskcrm_quotations_order_ajax', 
                        plugin_dir_url( __FILE__ ).'js/demo.js', 
                        array( 'jquery' ), $this->version, true ); 
         wp_localize_script( 'bdtaskcrm_quotations_order_ajax', 
                        'object',
                         array(  'ajaxurl'  => admin_url( 'admin-ajax.php' ),
                                 'nonce'    => wp_create_nonce('randomnonce'),
                             )
                    );
    }

  

// ========================
//===============================quotation quantity================================= 

public  function add_process_ajax() {
       
      global $wpdb;
      $id=sanitize_text_field($_POST['what']);

  //=================== nonce Security verified checked======================= 
    if(wp_verify_nonce($_POST['security'], 'randomnonce')){	

  //=================== nonce Security verified checked======================= 



      $table_name = $wpdb->prefix.'bdtaskcrm_services'; 
       $sql = "SELECT * FROM  $table_name  WHERE service_id =$id";
       $select_services = $wpdb->get_results( $sql  , OBJECT ) ;
       echo json_encode($select_services);
       ?>
      <?php 
}else{
	echo "Your Ajax nonce not verifyed!";
}
    die();
}


public function product_total_rate(){

   
    global $wpdb;
    $id=sanitize_text_field($_POST['client_restion_id']);

  //=================== nonce Security verified checked======================= 
    if(wp_verify_nonce($_POST['security'], 'randomnonce')){	

  //=================== nonce Security verified checked======================= 

    if($id==1){

      $table_name = $wpdb->prefix.'bdtaskcrm_clients'; 
       $sql = "SELECT * FROM  $table_name  WHERE client_type =$id ";
       $restion = $wpdb->get_results( $sql  , OBJECT ) ;
    ?>
<label for="customer_name" class="col-sm-3 col-form-label"><?php echo esc_html('Leads','bdtaskcrm');?></label>
<div class="col-sm-6">                    
    <select  name="client_id"   class="form-control">
          <?php 
          foreach ($restion as $key => $lead) {
          if($lead->is_active==1){
          ?>
          <option value="<?php echo $lead->client_id?>"><?php echo esc_html($lead->first_name.' '.$lead->last_name)?></option>
          <?php }}?>

   </select>
      <input type='hidden' id='client_type' value='<?php echo $restion[0]->client_type;?>'>
</div>
<?php 
}else{
$table_name = $wpdb->prefix.'bdtaskcrm_clients'; 
$sql = "SELECT * FROM  $table_name  WHERE client_type =$id ORDER BY client_id DESC";
$restion = $wpdb->get_results( $sql  , OBJECT ) ;	

?>

<label for="customer_name" class="col-sm-3 col-form-label"><?php echo esc_html('Customers','bdtaskcrm');?></label>
<div class="col-sm-6">                    
    <select  name="client_id"   class="form-control">
    	  <?php 
          foreach ($restion as $key => $customer) {
          	 if($customer->is_active==1){
          ?>

          <option value="<?php echo $customer->client_id?>"><?php echo esc_html($customer->first_name.' '.$customer->last_name);?></option>
           
      <?php }}?>
   </select>
   <input type='hidden' id='client_type' value='<?php echo $restion[0]->client_type;?>'>
</div>

<?php 

}
}else{
	echo "Your Ajax nonce not verifyed!";
}


 die();
}

// ========================
//==============================End quotation quantity================================= 



public function card_number_show_input_box(){

    $public=sanitize_text_field($_POST['result']);
    
    //=================== nonce Security verified checked======================= 
    if(wp_verify_nonce($_POST['security'], 'randomnonce')){	

  //=================== nonce Security verified checked======================= 


          if($public==2){?>
            	<label for='' class='col-sm-3 col-form-label' ><?php echo esc_html('Card Number:','bdtaskcrm')?></label>
                <div class='col-sm-6'>
          	      <input type='text' name='card_number' class='form-control' value=''>
               </div>
        <?php 
          }
  }else{
	echo "Your Ajax nonce not verifyed!";
}  
        die();
}




    public function  bdtaskcrm_setting_callback(){
           require_once plugin_dir_path( __FILE__ ) . '/templates/bdtaskcrm_settings.php';
           $setting = (current_user_can('manage_options') && is_admin())?
                        bdtaskcrm_appointment_setting_form(): 
                        wp_die();
     }
    public function bdtaskcrm_setting_api(){
        /**
         * @package    admin
         * @author     bdtask<bdtask@gmail.com> <bdtask@gmail.com>
         * @since      1.0.0
         * @param Frontend Settings Section name change to Advance Setting Section.
         */         
                   
         /*//////////////////////////////////////////////////////////////////////////////////////
                           Language setting   
         ///////////////////////////////////////////////////////////////////////////////////////*/

        /* register_setting( $option_group, $option_name, $sanitize_callback );  */  
          register_setting('bdtaskcrm-frontend-language-setting','name_language',
                           array($this,'bdtaskcrm_frontend_name_sanitize'));

          register_setting('bdtaskcrm-frontend-language-setting','email_language',
                           array($this,'bdtaskcrm_frontend_email_sanitize'));


          register_setting('bdtaskcrm-frontend-language-setting','authorize_name',
                           array($this,'bdtaskcrm_frontend_authorize_sanitize'));

          register_setting('bdtaskcrm-frontend-language-setting','contact_language',
                            array($this,'bdtaskcrm_frontend_contact_sanitize'));

          register_setting('bdtaskcrm-frontend-language-setting','service_language',
                            array($this,'bdtaskcrm_frontend_location_sanitize'));
          register_setting('bdtaskcrm-frontend-language-setting','frontend_button_language',
                            array($this,'bdtaskcrm_frontend_button_sanitize'));

          register_setting('bdtaskcrm-frontend-language-setting','frontend_address');

          add_settings_section( 
                            'bdtaskcrm_language_setting',
                            '',
                             array($this,'bdtaskcrm_mas_section_cb'), 
                            'bdtaskcrm_language_setting' );
                           

          add_settings_field('frontend_name' ,                                       // $id
                            esc_html( 'Company Name', 'bdtaskcrm' ),                         // $title
                          array($this,'bdtaskcrm_frontend_langues_setting_cb_for_name'),  //$callback
                              'bdtaskcrm_language_setting',                                // $page
                              'bdtaskcrm_language_setting',                                // $section
                               array( 'id' => 'professional_title',                  // $args 
                                     'class'=>'form-group',
                                     'type' => 'text' , 
                                     'name'=>'name_language' ));
           
           add_settings_field('frontend_email' , 
                              esc_html( 'Email', 'bdtaskcrm' ), 
                               array($this,'bdtaskcrm_frontend_langues_setting_cb_for_email'),
                              'bdtaskcrm_language_setting',
                              'bdtaskcrm_language_setting',
                               array( 'id' => 'frontend_email', 
                                     'class'=>'form-group',
                                     'type' => 'email' , 
                                     'name'=>'email_language' ));

           add_settings_field('frontend_contact' , 
                               esc_html( 'Mobile No', 'bdtaskcrm' ), 
                               array($this,'bdtaskcrm_frontend_langues_setting_cb_for_contact'),
                              'bdtaskcrm_language_setting',
                              'bdtaskcrm_language_setting',
                               array( 'id' => 'frontend_contact', 
                                     'class'=>'form-group',
                                     'type' => 'text' , 
                                     'name'=>'contact_language' ));

        
               add_settings_field('frontend_address' , 
                              esc_html( 'Address', 'bdtaskcrm' ),
                               array($this,'bdtaskcrm_frontend_address_setting_cb'),
                              'bdtaskcrm_language_setting',
                              'bdtaskcrm_language_setting',
                               array( 'id' => 'frontend_address', 
                                     'class'=>'form-group',
                                     'type' => 'text' , 
                                     'name'=>'frontend_address' ));

            add_settings_field('frontend_location' , 
                               esc_html( 'Website Link', 'bdtaskcrm' ), 
                               array($this,'bdtaskcrm_frontend_langues_setting_cb_for_service'),
                              'bdtaskcrm_language_setting',
                              'bdtaskcrm_language_setting',
                               array( 'id' => 'frontend_location', 
                                     'class'=>'form-group',
                                     'type' => 'text' , 
                                     'name'=>'service_language' ));


            add_settings_field('frontend_authorziename' , 
                               esc_html( 'Authorize ', 'bdtaskcrm' ), 
                               array($this,'bdtaskcrm_frontend_langues_setting_authorize'),
                              'bdtaskcrm_language_setting',
                              'bdtaskcrm_language_setting',
                               array( 'id' => 'frontend_authorziename', 
                                     'class'=>'form-group',
                                     'type' => 'text' , 
                                     'name'=>'authorize_name' ));



             /* Error message color */ 
           add_settings_field('error_message_color' , 
                              esc_html( 'Error Message Color', 'bdtaskcrm' ),
                              array($this,'bdtaskcrm_error_message_color_cb'),
                              'frontend_setting',
                              'bdtaskcrm_frontend_section',
                              array( 'id' => 'error_message_color', 
                                     'class'=>'form-group',
                                     'type' => 'text' , 
                                     'name'=>'error_message_color' ));

    }
    //section cb
    public function bdtaskcrm_mas_section_cb(){
      return ;
    }

     /*/////////////////// Langues ///////////////////////// */

    public function bdtaskcrm_frontend_langues_setting_cb_for_name($args){
      
      $value = esc_attr(get_option($args['name']));
      $value = str_replace("@"," ",$value);
        $output = sprintf( '<input id="%1s" 
                                 class = "form-control" 
                                 type = "%2s"  
                                 name ="%3s" 
                                 value = "%4s"',$args['id'],$args['type'],$args['name'],$value );
      echo $output;       
     }

     public function bdtaskcrm_frontend_langues_setting_cb_for_email($args){
      
      $value = esc_attr(get_option($args['name']));
      $output = sprintf( '<input id="%1s" 
                                 class = "form-control" 
                                 type = "%2s"  
                                 name ="%3s" 
                                 value = "%4s"',$args['id'],$args['type'],$args['name'],$value );
      echo $output;    
    }

    public function bdtaskcrm_frontend_langues_setting_cb_for_contact($args){
      
      $value = esc_attr(get_option($args['name']));
      $value = str_replace("@"," ",$value);     
      $output = sprintf( '<input id="%1s" 
                                 class = "form-control" 
                                 type = "%2s"  
                                 name ="%3s" 
                                 value = "%4s"',$args['id'],$args['type'],$args['name'],$value );

      echo $output;       
    }




    public function bdtaskcrm_frontend_langues_setting_cb_for_service($args){
      
      $value = esc_attr(get_option($args['name']));
      $value = str_replace("@"," ",$value);    
      $output = sprintf( '<input id="%1s" 
                                 class = "form-control" 
                                 type = "%2s"  
                                 name ="%3s" 
                                 value = "%4s"',$args['id'],$args['type'],$args['name'],$value );

      echo $output;    
    }

    

    public function bdtaskcrm_frontend_langues_setting_authorize($args){
      $value = esc_attr(get_option($args['name']));
      $value = str_replace("@"," ",$value);    
      $output = sprintf( '<input id="%1s" 
                                 class = "form-control" 
                                 type = "%2s"  
                                 name ="%3s" 
                                 value = "%4s"',$args['id'],$args['type'],$args['name'],$value );
      echo $output;     
    }

   
     public function bdtaskcrm_frontend_langues_setting_cb_for_button($args){
      
      $value = esc_attr(get_option($args['name']));
      $value = str_replace("@"," ",$value); 
      $output = sprintf( '<input id="%1s" 
                                 class = "form-control" 
                                 type = "%2s"  
                                 name ="%3s" 
                                 value = "%4s"',$args['id'],$args['type'],$args['name'],$value );

      echo $output;    
     }

    public function bdtaskcrm_frontend_address_setting_cb($args){ 
      
     $value = esc_attr(get_option($args['name']));
     // Render the output
     echo '<textarea id="textarea_example" 
                     name="frontend_address" 
                     rows="5" cols="50">' . $value . '</textarea>';   
     }

     public function bdtaskcrm_error_message_color_cb($args){
      $value = esc_attr(get_option($args['name']));
      $value = str_replace("@"," ",$value);       
      $output = sprintf( '<input id="%1s" 
                                 class = "color-field" 
                                 type = "%2s"  
                                 name ="%3s" 
                                 value = "%4s" ',$args['id'],$args['type'],$args['name'],$value );

      echo $output;       
    }


   
    public function bdtaskcrm_frontend_name_sanitize($input){
       $output = sanitize_text_field($input);
       return $output;
    }
    public function bdtaskcrm_frontend_email_sanitize($input){
       $output = sanitize_email($input);
       return $output;
    }
    public function bdtaskcrm_frontend_contact_sanitize($input){
       $output = sanitize_text_field($input);
       return $output;
    }

    public function bdtaskcrm_frontend_location_sanitize($input){
       $output = sanitize_text_field($input);
       return $output;
    }


    public function bdtaskcrm_frontend_button_sanitize($input){
       $output = sanitize_text_field($input);
       return $output;
    } 
    public function bdtaskcrm_frontend_authorize_sanitize($input){
       $output = sanitize_text_field($input);
       return $output;
    }



}
