<?php
 /**
   *@param  bdtaskcrm_service 
   *@since  1.0.0
   */  
class BDTASKCRM_Services{

   /**
   *@var protected. 
   *@since 1.0.0
   */ 
   protected static $service;

   
   /**
   *@param  bdtaskcrm_process_service_data($service)/// To Add service. 
   *@since  1.0.0
   *@return $service (array) .
   */  
   public static function  bdtaskcrm_process_service_data($service = null ){
      self::$service = BDTASKCRM_Services::bdtaskcrm_service_name_sanitize() ;
      self::$service = BDTASKCRM_Services::bdtaskcrm_service_table(  self::$service);
      self::$service = BDTASKCRM_Services::bdtaskcrm_add_service(  self::$service );  
      return self::$service;
   }



  /**
   *@param  bdtaskcrm_process_service_update_data($service)/// To Update service. 
   *@since  1.0.0
   *@return $service (array) .
   */  

   public static function  bdtaskcrm_process_service_update_data($service = null ){
      self::$service = BDTASKCRM_Services::bdtaskcrm_service_id_sanitize() ;
      self::$service = BDTASKCRM_Services::bdtaskcrm_service_name_sanitize( self::$service ) ;
      self::$service = BDTASKCRM_Services::bdtaskcrm_service_table(  self::$service );
      self::$service = BDTASKCRM_Services::bdtaskcrm_update_service(  self::$service );  
      return self::$service;
   }


  /**
   *@param  bdtaskcrm_process_service_delete_data($service)/// To Delete service. 
   *@since  1.0.0
   *@return $service (array).
   */  

   public static function  bdtaskcrm_process_service_delete_data($service = null ){
      self::$service = BDTASKCRM_Services::bdtaskcrm_service_id_sanitize() ;
      self::$service = BDTASKCRM_Services::bdtaskcrm_service_table(  self::$service );
      self::$service = BDTASKCRM_Services::bdtaskcrm_delete_service(  self::$service );  
      return self::$service;
   }


   /**
   *@param  bdtaskcrm_process_service_select_data($service)/// To Select service. 
   *@since  1.0.0
   *@return $service (array) .
   */  

   public static function  bdtaskcrm_process_service_select_data($service = null ){
      self::$service = BDTASKCRM_Services::bdtaskcrm_service_table(self::$service );
      self::$service = BDTASKCRM_Services::bdtaskcrm_select_service(self::$service );  
      return self::$service;
   }

  

   /**
   *@param  bdtaskcrm_service_id_sanitize($service). 
   *@since  1.0.0
   *@return service id .
   */  
   public static function  bdtaskcrm_service_id_sanitize($service = null ){   
      $service['add']['service_id'] = intval( $_POST['service_id']  );
      return $service;
   }



  /**
   *@param  bdtaskcrm_service_name_sanitize($service). 
   *@since  1.0.0
   *@return service name .
   */  
   public static function  bdtaskcrm_service_name_sanitize($service = null ){ 

      $service['add']['service_name'] = sanitize_text_field( $_POST['service_name']  );
      $service['add']['description']= sanitize_text_field($_POST['description']);
      $service['add']['service_rate']= sanitize_text_field($_POST['service_rate']);
      $service['add']['product_discount']= sanitize_text_field($_POST['product_discount']);
      return $service;


   }



  /**
   *@param  bdtaskcrm_service_table($service). 
   *@since  1.0.0
   *@return table name .
   */  
   public static function  bdtaskcrm_service_table($service){
      global $wpdb ; 

      $service['table'] = $wpdb->prefix .'bdtaskcrm_services'; 
      return $service;     
   }



  /**
   *@param  bdtaskcrm_add_service($service). 
   *@since  1.0.0
   *@return status .
   */  

   public static function  bdtaskcrm_add_service($service){
       global $wpdb ;
       $add_new_service = $wpdb->insert( 
                           $service['table'], 
                           array(                  
                            'service_id' => '',
                            'service_name'=> $service['add']['service_name'],      
                            'service_rate'=> $service['add']['service_rate'],                 
                            'product_discount'=> $service['add']['product_discount'],                 
                            'description'=> $service['add']['description'],      
                            'is_active' => '1'
                          )

                         );

      $service['action_status'] = ($add_new_service)? 'no_error_data_save_successfully' : 'something_is_error';
      return  $service ; 
   }

   /**
   *@param  bdtaskcrm_update_service($service). 
   *@since  1.0.0
   *@return status .
   */  
  public static function  bdtaskcrm_update_service($service){
         global $wpdb ;            
         $update_service = $wpdb->update( 
                          $service['table'], 
                          array( 
                            'service_name' => $service['add']['service_name'], // column & new value
                            'service_rate' => $service['add']['service_rate'], // column & new value 
                            'product_discount' => $service['add']['product_discount'], // column & new value 
                            'description' => $service['add']['description'], // column & new value
                          ), 
                          array( 'service_id' => $service['add']['service_id'] ) ,  // where clause(s)
                          array( '%s') , // column & new value type.
                          array( '%d' ) // where clause(s) format types  
                        ); 

        $service['action_status'] = ($update_service)? 'no_error_data_update_successfully' : 'something_is_error';
        return  $service ; 

   }


 
   /**
   *@param  bdtaskcrm_delete_service($service). 
   *@since  1.0.0
   *@return status.
   */  
  public static function  bdtaskcrm_delete_service($service){

         global $wpdb ;        
         $delete = $wpdb->delete( 
                        $service['table'],   // table name 
                        array( 'service_id' => $service['add']['service_id'] ),  // where clause 
                        array( '%d' )      // where clause data type (int)
                    );    
        $service['action_status'] = ($delete)? 'delete_successfully' : 'something_is_error';
        return  $service;
   }






  /**
   *@param  bdtaskcrm_select_service($service = null). 
   *@since  1.0.0
   *@return query.
   */  
  public static function  bdtaskcrm_select_service( $service = null){     
          $table_name = $service['table'];    
          $service['query']['select_all']  = "SELECT * FROM  $table_name  WHERE 1 ORDER BY service_id DESC ";    
          return  $service ;                         
  }

     public static function  bdtaskcrm_service_action($id = '', $status='' ){
         
          global $wpdb;  
           $table_name = $wpdb->prefix.'bdtaskcrm_services';         

          $action = $wpdb->update($table_name , array('is_active' => $status) , array('service_id' => $id) );
          return ;
                 
   }

 }/*  / class bdtaskcrm_service */