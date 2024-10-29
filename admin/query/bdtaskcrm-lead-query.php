<?php
 /**
   *@param  bdtaskcrm_Category 
   *@since  1.0.0
   */  
class BDTASKCRM_Leads{

   /**
   *@var protected. 
   *@since 1.0.0
   */ 
   protected static $category;

   
   /**
   *@param  bdtaskcrm_process_category_data($category)/// To Add Category. 
   *@since  1.0.0
   *@return $category (array) .
   */  
   public static function  bdtaskcrm_process_category_data($category = null ){
      self::$category = BDTASKCRM_Leads::bdtaskcrm_category_name_sanitize() ;
      self::$category = BDTASKCRM_Leads::bdtaskcrm_category_table(  self::$category );
      self::$category = BDTASKCRM_Leads::bdtaskcrm_add_category(  self::$category );  
      return self::$category;
   }

   public static function  bdtaskcrm_mas_booking_action($id = '', $status='' ){
         
          global $wpdb;  

          $table_name = $wpdb->prefix.'bdtaskcrm_clients';         

          $action = $wpdb->update($table_name , array('is_active' => $status) , array('client_id' => $id) );
          return ;
                 
   }

  /**
   *@param  bdtaskcrm_process_category_update_data($category)/// To Update Category. 
   *@since  1.0.0
   *@return $category (array) .
   */  

   public static function  bdtaskcrm_process_category_update_data($category = null ){
      self::$category = BDTASKCRM_Leads::bdtaskcrm_category_id_sanitize() ;
      self::$category = BDTASKCRM_Leads::bdtaskcrm_category_name_sanitize( self::$category ) ;
      self::$category = BDTASKCRM_Leads::bdtaskcrm_category_table(  self::$category );
      self::$category = BDTASKCRM_Leads::bdtaskcrm_update_category(  self::$category );  
      return self::$category;
   }


  /**
   *@param  bdtaskcrm_process_category_delete_data($category)/// To Delete Category. 
   *@since  1.0.0
   *@return $category (array).
   */  

   public static function  bdtaskcrm_process_category_delete_data($category = null ){
      self::$category = BDTASKCRM_Leads::bdtaskcrm_category_id_sanitize() ;
      self::$category = BDTASKCRM_Leads::bdtaskcrm_category_table(  self::$category );
      self::$category = BDTASKCRM_Leads::bdtaskcrm_delete_category(  self::$category );  
      return self::$category;
   }

   public static function  bdtaskcrm_process_convert_customer($category = null ){
      self::$category = BDTASKCRM_Leads::bdtaskcrm_category_id_sanitize() ;
      self::$category = BDTASKCRM_Leads::bdtaskcrm_category_table(  self::$category );
      self::$category = BDTASKCRM_Leads::bdtaskcrm_update_status(  self::$category );  
      return self::$category;
   }



   /**
   *@param  bdtaskcrm_process_category_select_data($category)/// To Select Category. 
   *@since  1.0.0
   *@return $category (array) .
   */  

   public static function  bdtaskcrm_process_category_select_data($category = null ){
      self::$category = BDTASKCRM_Leads::bdtaskcrm_category_table(self::$category );
      self::$category = BDTASKCRM_Leads::bdtaskcrm_select_category(self::$category );  
      return self::$category;
   }

  

   /**
   *@param  bdtaskcrm_category_id_sanitize($category). 
   *@since  1.0.0
   *@return Category id .
   */  
   public static function  bdtaskcrm_category_id_sanitize($category = null ){   
      $category['add']['client_id'] = intval( $_POST['client_id']  );
      return $category;
   }



  /**
   *@param  bdtaskcrm_category_name_sanitize($category). 
   *@since  1.0.0
   *@return Category name .
   */  
   public static function  bdtaskcrm_category_name_sanitize($category = null ){ 

      $category['add']['first_name'] = sanitize_text_field( $_POST['first_name']  );
      $category['add']['last_name']= sanitize_text_field($_POST['last_name']);
      $category['add']['phone']= sanitize_text_field($_POST['phone']);
      $category['add']['email']= sanitize_email($_POST['email']);
      $category['add']['address']= sanitize_text_field($_POST['address']);
      return $category;

   }



  /**
   *@param  bdtaskcrm_category_table($category). 
   *@since  1.0.0
   *@return table name .
   */  
   public static function  bdtaskcrm_category_table($category){
      global $wpdb ; 

      $category['table'] = $wpdb->prefix .'bdtaskcrm_clients'; 
      $category['table2'] = $wpdb->prefix.'bdtaskcrm_order_tbl'; 
      return $category;     
   }



  /**
   *@param  bdtaskcrm_add_category($category). 
   *@since  1.0.0
   *@return status .
   */  

   public static function  bdtaskcrm_add_category($category){
       global $wpdb ;
      
       $add_new_category = $wpdb->insert( 
                           $category['table'], 
                           array(                  
                            'client_id' => '',
                            'first_name'=> $category['add']['first_name'],      
                            'last_name'=> $category['add']['last_name'],      
                            'phone'=> $category['add']['phone'],      
                            'email'=> $category['add']['email'],      
                            'address'=> $category['add']['address'],      
                                
                            'is_active' => '1' ,
                            'client_type'=>'1',
                            'create_by'=>get_current_user_id(),
                            'createDate'=>date("Y/m/d")
                          )

                         );

      $category['action_status'] = ($add_new_category)? 'no_error_data_save_successfully' : 'something_is_error';
      return  $category ; 
   }

   /**
   *@param  bdtaskcrm_update_category($category). 
   *@since  1.0.0
   *@return status .
   */  
  public static function  bdtaskcrm_update_category($category){
         global $wpdb ;      
         
         $update_category = $wpdb->update( 
                          $category['table'], 
                          array( 
                            'first_name' => $category['add']['first_name'], // column & new value
                            'last_name' => $category['add']['last_name'], // column & new value
                            'phone' => $category['add']['phone'], // column & new value
                            'email' => $category['add']['email'], // column & new value
                            'address' => $category['add']['address'], // column & new value
                            'createDate' =>date("Y/m/d"), // column & new value
                          ), 
                          array( 'client_id' => $category['add']['client_id'] ) ,  // where clause(s)
                          array( '%s') , // column & new value type.
                          array( '%d' ) // where clause(s) format types  
                        ); 


        $category['action_status'] = ($update_category)? 'no_error_data_update_successfully' : 'something_is_error';
        return  $category ; 

   }


 
   /**
   *@param  bdtaskcrm_delete_category($category). 
   *@since  1.0.0
   *@return status.
   */  
  public static function  bdtaskcrm_delete_category($category){

         global $wpdb ;        
         $delete = $wpdb->delete( 
                        $category['table'],   // table name 
                        array( 'client_id' => $category['add']['client_id'] ),  // where clause 
                        array( '%d' )      // where clause data type (int)
                    );    
        $category['action_status'] = ($delete)? 'delete_successfully' : 'something_is_error';
        return  $category ;
   }



     public static function  bdtaskcrm_update_status($category){

       global $wpdb ;         
         $update_category = $wpdb->update( 
          $category['table'], 
          array( 
            'client_type' =>2, // column & new value
            
          ), 
          array( 'client_id' => $category['add']['client_id'] ) ,  // where clause(s)
          array( '%s') , // column & new value type.
          array( '%d' ) // where clause(s) format types  
        ); 
        
        
        
        $update_category = $wpdb->update( 
          $category['table2'], 
          array( 
            'quotation_status' =>2, // column & new value
            
          ), 
          array( 'client_id' => $category['add']['client_id'] ) ,  // where clause(s)
          array( '%s') , // column & new value type.
          array( '%d' ) // where clause(s) format types  
        ); 
        
        
        
      $category['action_status'] = ($update_category)? 'no_error_data_update_successfully' : 'something_is_error';
        return  $category ;
        
        
        
        
        
        
   }



  /**
   *@param  bdtaskcrm_select_category($category = null). 
   *@since  1.0.0
   *@return query.
   */  
  public static function  bdtaskcrm_select_category( $category = null){     
          $table_name = $category['table'];    
          $category['query']['select_all']  = "SELECT * FROM  $table_name  WHERE 1 ORDER BY client_id DESC ";    
          return  $category ;                         
  }

 }/*  / class bdtaskcrm_Category */