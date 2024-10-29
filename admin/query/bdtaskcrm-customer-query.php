<?php
 /**
   *@param  bdtaskcrm_Customer 
   *@since  1.0.0
   */  
class BDTASKCRM_Customers{

   /**
   *@var protected. 
   *@since 1.0.0
   */ 
   protected static $customer;

   
   /**
   *@param  bdtaskcrm_process_Customer_data($Customer)/// To Add Customer. 
   *@since  1.0.0
   *@return $Customer (array) .
   */  
   public static function  bdtaskcrm_process_customer_data($customer = null ){
      self::$customer = BDTASKCRM_Customers::bdtaskcrm_customer_name_sanitize() ;
      self::$customer = BDTASKCRM_Customers::bdtaskcrm_customer_table(  self::$customer );
      self::$customer = BDTASKCRM_Customers::bdtaskcrm_add_customer(  self::$customer );  
      return self::$customer;
   }



  /**
   *@param  bdtaskcrm_process_Customer_update_data($Customer)/// To Update Customer. 
   *@since  1.0.0
   *@return $Customer (array) .
   */  

   public static function  bdtaskcrm_process_customer_update_data($customer = null ){
      self::$customer = BDTASKCRM_Customers::bdtaskcrm_customer_id_sanitize() ;
      self::$customer = BDTASKCRM_Customers::bdtaskcrm_customer_name_sanitize( self::$customer ) ;
      self::$customer = BDTASKCRM_Customers::bdtaskcrm_customer_table(  self::$customer );
      self::$customer = BDTASKCRM_Customers::bdtaskcrm_update_customer(  self::$customer );  
      return self::$customer;
   }


  /**
   *@param  bdtaskcrm_process_Customer_delete_data($Customer)/// To Delete Customer. 
   *@since  1.0.0
   *@return $Customer (array).
   */  

   public static function  bdtaskcrm_process_customer_delete_data($customer = null ){
      self::$customer = BDTASKCRM_Customers::bdtaskcrm_customer_id_sanitize() ;
      self::$customer = BDTASKCRM_Customers::bdtaskcrm_customer_table(  self::$customer );
      self::$customer = BDTASKCRM_Customers::bdtaskcrm_delete_customer(  self::$customer );  
      return self::$customer;
   }


   /**
   *@param  bdtaskcrm_process_Customer_select_data($Customer)/// To Select Customer. 
   *@since  1.0.0
   *@return $Customer (array) .
   */  

   public static function  bdtaskcrm_process_customer_select_data($customer = null ){
      self::$customer = BDTASKCRM_Customers::bdtaskcrm_customer_table(self::$customer );
      self::$customer = BDTASKCRM_Customers::bdtaskcrm_select_customer(self::$customer );  
      return self::$customer;
   }

  

   /**
   *@param  bdtaskcrm_Customer_id_sanitize($Customer). 
   *@since  1.0.0
   *@return Customer id .
   */  
   public static function  bdtaskcrm_customer_id_sanitize($customer = null ){   
      $customer['add']['client_id'] = intval( $_POST['client_id']  );
      return $customer;
   }



  /**
   *@param  bdtaskcrm_Customer_name_sanitize($Customer). 
   *@since  1.0.0
   *@return Customer name .
   */  
   public static function  bdtaskcrm_customer_name_sanitize($customer = null ){ 

      $customer['add']['first_name'] = sanitize_text_field( $_POST['first_name']  );
      $customer['add']['last_name']= sanitize_text_field($_POST['last_name']);
      $customer['add']['phone']= sanitize_text_field($_POST['phone']);
      $customer['add']['email']= sanitize_email($_POST['email']);
      $customer['add']['address']= sanitize_text_field($_POST['address']);
      return $customer;


   }



  /**
   *@param  bdtaskcrm_Customer_table($Customer). 
   *@since  1.0.0
   *@return table name .
   */  
   public static function  bdtaskcrm_customer_table($customer){
      global $wpdb ; 

      $customer['table'] = $wpdb->prefix .'bdtaskcrm_clients'; 
      return $customer;     
   }



  /**
   *@param  bdtaskcrm_add_Customer($Customer). 
   *@since  1.0.0
   *@return status .
   */  

   public static function  bdtaskcrm_add_customer($customer){
       global $wpdb ;
       $add_new_customer = $wpdb->insert( 
                           $customer['table'], 
                           array(                  
                            'client_id' => '',
                            'first_name'=> $customer['add']['first_name'],      
                            'last_name'=> $customer['add']['last_name'],      
                            'phone'=> $customer['add']['phone'],      
                            'email'=> $customer['add']['email'],      
                            'address'=> $customer['add']['address'],      
                                
                            'is_active' => '1' ,
                            'client_type'=>'2',
                            'create_by'=>get_current_user_id(),
                            'createDate'=>date("Y/m/d")
                          )

                         );

      $customer['action_status'] = ($add_new_customer)? 'no_error_data_save_successfully' : 'something_is_error';
      return  $customer ; 
   }

   /**
   *@param  bdtaskcrm_update_Customer($Customer). 
   *@since  1.0.0
   *@return status .
   */  
  public static function  bdtaskcrm_update_customer($customer){
         global $wpdb ;            
         $update_customer = $wpdb->update( 
                          $customer['table'], 
                          array( 
                            'first_name' => $customer['add']['first_name'], // column & new value
                            'last_name' => $customer['add']['last_name'], // column & new value
                            'phone' => $customer['add']['phone'], // column & new value
                            'email' => $customer['add']['email'], // column & new value
                            'createDate' =>date("Y/m/d"), // column & new value
                            'address' => $customer['add']['address'], // column & new value
                          ), 
                          array( 'client_id' => $customer['add']['client_id'] ) ,  // where clause(s)
                          array( '%s') , // column & new value type.
                          array( '%d' ) // where clause(s) format types  
                        ); 

        $customer['action_status'] = ($update_customer)? 'no_error_data_update_successfully' : 'something_is_error';
        return  $customer ; 

   }


 
   /**
   *@param  bdtaskcrm_delete_Customer($Customer). 
   *@since  1.0.0
   *@return status.
   */  
  public static function  bdtaskcrm_delete_customer($customer){

         global $wpdb ;        
         $delete = $wpdb->delete( 
                        $customer['table'],   // table name 
                        array( 'client_id' => $customer['add']['client_id'] ),  // where clause 
                        array( '%d' )      // where clause data type (int)
                    );    
        $customer['action_status'] = ($delete)? 'delete_successfully' : 'something_is_error';
        return  $customer ;
   }






  /**
   *@param  bdtaskcrm_select_Customer($Customer = null). 
   *@since  1.0.0
   *@return query.
   */  
  public static function  bdtaskcrm_select_customer( $customer = null){     
          $table_name = $customer['table'];    
          $customer['query']['select_all']  = "SELECT * FROM  $table_name  WHERE 1 ORDER BY client_id DESC ";    
          return  $customer ;                         
  }


    public static function  bdtaskcrm_active_and_deactive($id = '', $status='' ){
         
          global $wpdb;  

          $table_name = $wpdb->prefix.'bdtaskcrm_clients';         

          $action = $wpdb->update($table_name , array('is_active' => $status) , array('client_id' => $id) );
          return ;
                 
   }

 }/*  / class bdtaskcrm_Customer */