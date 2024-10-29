<?php
/**
 * @package    admin
 * @subpackage admin/templates
 * @author     bdtask@gmail.com
 */
if ( ! defined( 'WPINC' ) ) {
  die;// Exit if accessed directly.
}
function bdtaskcrm_appointment_setting_form(){
 global $pagenow , $current_user ;
 if(($_REQUEST['page']==='bdtaskcrm_setting')&& ($pagenow == 'admin.php')){    
        settings_errors(); 
     
 /*/////////////////////////////////////////////////////////////////////////////////////////
                        Default Value Set for languages
////////////////////////////////////////////////////////////////////////////////////////////*/

        // The option already exists, so we just update it.
        // The option hasn't been added yet. We'll add it with $autoload set to 'no'.

         ( get_option( 'name_language' ) == false )? 
                  update_option( 'name_language', esc_html('Company Name','bdtaskcrm') , null ,  'no' ) : '' ;
         
         ( get_option( 'email_language' ) == false )? 
                  update_option( 'email_language', esc_html('Email','bdtaskcrm'), null ,  'no' ) : '' ;
         
         ( get_option( 'contact_language' ) == false )? 
                  update_option( 'contact_language', esc_html('Contact No','bdtaskcrm'), null ,  'no' ) : '' ;
         
         ( get_option( 'category_language' ) == false )? 
                  update_option( 'category_language', esc_html('Category','bdtaskcrm')  , null ,  'no' ) : '' ;

         ( get_option( 'frontend_location' ) == false )? 
                  update_option( 'service_language', esc_html('Website Link','bdtaskcrm') , null ,  'no' ) : '' ;

         ( get_option( 'professional_language' ) == false )? 
                  update_option( 'professional_language', esc_html('Professional','bdtaskcrm') , null ,  'no' ) : '' ;

         ( get_option( 'message_language' ) == false )? 
                  update_option( 'message_language', esc_html('Message','bdtaskcrm') , null ,  'no' ) : '' ;

         ( get_option( 'frontend_button' ) == false )? 
                  update_option( 'frontend_button', esc_html('Appointment','bdtaskcrm'), null ,  'no' ) : '' ;

        ( get_option( 'frontend_address' ) == false )? 
                  update_option( 'frontend_address', esc_html('Address','bdtaskcrm'), null ,  'no' ) : '' ; 
        
        ( get_option( 'frontend_authorziename' ) == false )? 
                  update_option( 'frontend_authorziename', esc_html('Authorize By','bdtaskcrm'), null ,  'no' ) : '' ;

        
      
/*//////////////////////////////////////////////////////////////////////////
                        Display Setting .
////////////////////////////////////////////////////////////////////////////*/          
?>

    <ul class="nav nav-tabs nav-pills ">
        <li class="active" ><a  href="#mas_language_setting" data-toggle="tab">
        <h5><?php esc_html_e('Label Setting','bdtaskcrm') ;?></h5></a></li>          
    </ul>
    <div class="col-sm-6" >            
         <div class="tab-content admin_custom_css">
            <div class="tab-pane active"  id="mas_language_setting" >  
              <br>
             <?php  require_once plugin_dir_path( __FILE__ ) . 'pabdt-image-uploder.php';?>
             <?php
              echo '<form method="post" action="options.php" id="mas_language_setting">';
                                 
              settings_fields('bdtaskcrm-frontend-language-setting');                    
              do_settings_sections( 'bdtaskcrm_language_setting' );            
              submit_button();
              echo '</form>';
             ?>
            </div>


             <div class="tab-pane"  id="mas_sortcode" >  
             <?php
               if( get_option('frontend_name') !== '' && 
                   get_option('frontend_email') !== '' && 
                   get_option('frontend_contact') !== '' && 
                   get_option('frontend_location') !== '' && 
                   get_option('frontend_professional') !== '' && 
                   get_option('frontend_message') !== '' && 
                   get_option('frontend_error_message') !== '' && 
                   get_option('frontend_button') !== '') :
                
                     echo '<div class="multi-appointment row" >';
                     echo '<div class="col-sm-12" >';
                     ?>
                    <h4> <?php echo esc_html('Shortcode : [bdtaskcrm_bdtask]','bdtaskcrm');?>
                      
                    </h4> 
                     <h5><?php echo esc_html('Please copy the shortcode and paste in the page or post to display the appointment form .','bdtaskcrm');?>
                     </h5> 
                     <?php 
                     echo '</div>';
                     echo '</div>';

                    else:
                        echo esc_html('<h3>Please fillup mendatory field .</h3>','bdtaskcrm') ;
                    endif ;

             ?>            
            </div> 
         </div><!-- .tab-content -->  
    </div><!-- .col-sm -->  
 
<?php
        
    }else{
        wp_die();
    }

}