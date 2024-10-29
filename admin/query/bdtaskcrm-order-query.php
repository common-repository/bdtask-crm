<?php
 /**
   *@param  bdtaskcrm_order 
   *@since  1.0.0
   */  
class BDTASKCRM_Orders{

   /**
   *@var protected. 
   *@since 1.0.0
   */ 
   protected static $order;

   
   /**
   *@param  bdtaskcrm_process_order_data($order)/// To Add order. 
   *@since  1.0.0
   *@return $order (array) .
   */  
   public static function  bdtaskcrm_process_order_data($order = null ){
      self::$order = BDTASKCRM_Orders::bdtaskcrm_order_name_sanitize() ;
      self::$order = BDTASKCRM_Orders::bdtaskcrm_order_table(  self::$order );
      self::$order = BDTASKCRM_Orders::bdtaskcrm_add_order(  self::$order );  
      return self::$order;
   }

  /**
   *@param  bdtaskcrm_process_order_update_data($order)/// To Update order. 
   *@since  1.0.0
   *@return $order (array) .
   */  

   public static function  bdtaskcrm_process_order_update_data($order = null ){
      self::$order = BDTASKCRM_Orders::bdtaskcrm_order_id_sanitize() ;
      self::$order = BDTASKCRM_Orders::bdtaskcrm_order_name_sanitize( self::$order ) ;
      self::$order = BDTASKCRM_Orders::bdtaskcrm_order_table(  self::$order );
      self::$order = BDTASKCRM_Orders::bdtaskcrm_update_order(  self::$order );  
      return self::$order;
   }


  /**
   *@param  bdtaskcrm_process_order_delete_data($order)/// To Delete order. 
   *@since  1.0.0
   *@return $order (array).
   */  

   public static function  bdtaskcrm_process_order_delete_data($order = null ){
      self::$order = BDTASKCRM_Orders::bdtaskcrm_order_id_sanitize() ;
      self::$order = BDTASKCRM_Orders::bdtaskcrm_order_table(  self::$order );
      self::$order = BDTASKCRM_Orders::bdtaskcrm_delete_order(  self::$order );  
      return self::$order;
   }   

   /**
   *@param  bdtaskcrm_process_order_select_data($order)/// To Select order. 
   *@since  1.0.0
   *@return $order (array) .
   */  

   public static function  bdtaskcrm_process_order_select_data($order = null ){
      self::$order = BDTASKCRM_Orders::bdtaskcrm_order_table(self::$order );
      self::$order = BDTASKCRM_Orders::bdtaskcrm_select_order(self::$order );  
      return self::$order;
   }

  

   /**
   *@param  bdtaskcrm_order_id_sanitize($order). 
   *@since  1.0.0
   *@return order id .
   */  
   public static function  bdtaskcrm_order_id_sanitize($order = null ){   
       $order['add']['order_id'] = intval( $_POST['order_id']  );
       $order['add']['row_id'] = intval( @$_POST['row_id']  );
      return $order;
   }

  /**
   *@param  bdtaskcrm_order_name_sanitize($order). 
   *@since  1.0.0
   *@return order name .
   */  
   public static function  bdtaskcrm_order_name_sanitize($order = null ){ 

      $order['add']['client_id'] = sanitize_text_field(@$_POST['client_id']  );
      $order['add']['create_date'] = sanitize_text_field( $_POST['create_date']  );
      $order['add']['expiry_date'] = sanitize_text_field( $_POST['expiry_date']  );
      $order['add']['subTotal'] = sanitize_text_field( $_POST['subTotal']  );
      $order['add']['tax'] = sanitize_text_field( $_POST['tax']  );
      $order['add']['discount'] = sanitize_text_field( $_POST['discount']  );
      $order['add']['grand_total'] = sanitize_text_field( $_POST['grand_total']  );
      $order['add']['special_instruction'] = sanitize_text_field( $_POST['special_instruction']  );
      $order['add']['Order_status'] =  $_POST['Order_status'];
      $order['add']['payment_method'] = sanitize_text_field( $_POST['payment_method']  );
      $order['add']['due'] = sanitize_text_field( $_POST['due']  );
      $order['add']['paid_amnt'] = sanitize_text_field( $_POST['paid_amnt']  );
      $order['add']['card_number'] = sanitize_text_field( @$_POST['card_number']  );
      // service details
      if(isset($_POST['service_id']) && !empty($_POST['service_id'])):
      $order['add']['service_id']=$_POST['service_id'];//array service_id
      endif;
      if(isset($_POST['service_rate']) && !empty($_POST['service_rate'])):
      $order['add']['service_rate']=$_POST['service_rate']; //array service rate
      endif;
      if(isset($_POST['qty']) && !empty($_POST['qty'])):
      $order['add']['qty']=$_POST['qty'];//array qty 
      endif;
      if(isset($_POST['product_discount']) && !empty($_POST['product_discount'])):
      $order['add']['product_discount']=$_POST['product_discount'];//array product discount
      endif;
      if(isset($_POST['product_price']) && !empty($_POST['product_price'])):
      $order['add']['product_price']=$_POST['product_price'];//array product price
      endif;
      return $order;

   }
  /**
   *@param  bdtaskcrm_order_table($order). 
   *@since  1.0.0
   *@return table name .
   */  
   public static function  bdtaskcrm_order_table($order){
      global $wpdb ; 

      // $order['table'] = $wpdb->prefix .'bdtaskcrm_clients'; 
      $order['table_two'] = $wpdb->prefix .'bdtaskcrm_order_details'; 
      $order['table'] = $wpdb->prefix .'bdtaskcrm_order_tbl'; 
      return $order;     
   }
  /**
   *@param  bdtaskcrm_add_order($order). 
   *@since  1.0.0
   *@return status .
   */  
   public static function  bdtaskcrm_add_order($order){
            global $wpdb ; 
            if(!empty(@$order['add']['client_id'])&&!empty($order['add']['service_id'])):
            $date=$order['add']['create_date'];
            $dates=$order['add']['expiry_date'];
            $create_date = date("Y-m-d", strtotime($date));
            $expiry_date = date("Y-m-d", strtotime($dates));
             $add_new_order = $wpdb->insert( 
                           $order['table'], 
                           array(                  
                            'order_id' => '',
                            'client_id'=> $order['add']['client_id'],      
                            'Order_status'=>$order['add']['Order_status'],      
                            'order_type'=>2,      
                            'create_date'=> $create_date,                 
                            'expiry_date'=>$expiry_date,
                             'create_by'=>get_current_user_id(),      
                            'subTotal'=> $order['add']['subTotal'],      
                            'tax'=> $order['add']['tax'],      
                            'discount'=> $order['add']['discount'],      
                            'grand_total'=> $order['add']['grand_total'],      
                            'paid_amnt'=> $order['add']['paid_amnt'],      
                            'due'=>$order['add']['due'],      
                            'payment_method'=>$order['add']['payment_method'],      
                            'card_number'=> $order['add']['card_number'] ,      
                            'special_instruction'=> $order['add']['special_instruction'],      
                          )
              );


         $lastInsertId = $wpdb->insert_id;

         $aa=count($order['add']['service_id']);

          for($i=0;$i<$aa;$i++) {
          $add_new_order = $wpdb->insert( 
                           $order['table_two'], 
                           array(                  
                            'row_id' => '',
                            'order_id' =>$lastInsertId,
                            'service_id'=> $order['add']['service_id'][$i],      
                            'service_rate'=> $order['add']['service_rate'][$i],      
                            'qty'=> $order['add']['qty'][$i],     
                            'product_discount'=> $order['add']['product_discount'][$i],     
                            'product_price'=> $order['add']['product_price'][$i]     
                            
                          )
                     );
                }

      $order['action_status'] = ($add_new_order)? 'no_error_data_save_successfully' : 'something_is_error';
      endif;
      return  $order ; 
   }

   /**
   *@param  bdtaskcrm_update_order($order). 
   *@since  1.0.0
   *@return status .
   */  
  public static function  bdtaskcrm_update_order($order){
         global $wpdb ;     

         

          $update_order  = $wpdb->delete( 
                        $order['table_two'],   // table name 
                        array( 'order_id' => $order['add']['order_id'] ),  // where clause 
                        array( '%d' )      // where clause data type (int)
            );   
        $create_date =$order['add']['create_date'];
        $create_date=date('Y-m-d', strtotime($create_date)); 
        $expiry_date =$order['add']['expiry_date'];
        $newDate = date("Y-m-d", strtotime($expiry_date));

         $update_order = $wpdb->update( 
                          $order['table'], 
                              array(                  
                            'client_id'=> $order['add']['client_id'],      
                            'Order_status'=>$order['add']['Order_status'],      
                            'order_type'=>2,      
                            'create_date'=>  $create_date,                 
                            'expiry_date'=> $newDate,
                             'create_by'=>get_current_user_id(),      
                            'subTotal'=> $order['add']['subTotal'],      
                            'tax'=> $order['add']['tax'],      
                            'discount'=> $order['add']['discount'],      
                            'grand_total'=> $order['add']['grand_total'],      
                            'paid_amnt'=>$order['add']['paid_amnt'],      
                            'due'=>$order['add']['due'],      
                            'payment_method'=>$order['add']['payment_method'],      
                            'card_number'=>$order['add']['card_number'],      
                            'special_instruction'=> $order['add']['special_instruction'],      
                            
                          ),
                          array( 'order_id' => $order['add']['order_id'] ) ,  // where clause(s)
                          array( '%s') , // column & new value type.
                          array( '%d' ) // where clause(s) format types  
                        );

         
         $aa=count($order['add']['service_id']);
          for($i=0;$i<$aa;$i++) {
         $update_order = $wpdb->insert( 
                           $order['table_two'], 
                           array(                  
                            'order_id' =>$order['add']['order_id'],
                            'service_id'=> $order['add']['service_id'][$i],      
                            'service_rate'=> $order['add']['service_rate'][$i],      
                            'qty'=> $order['add']['qty'][$i],     
                            'product_discount'=> $order['add']['product_discount'][$i],     
                            'product_price'=> $order['add']['product_price'][$i]     
                            
                          )
                     );
                }         


        $order['action_status'] = ($update_order)? 'no_error_data_update_successfully' : 'something_is_error';
        return  $order ; 
      
   }


   /**
   *@param  bdtaskcrm_delete_order($order). 
   *@since  1.0.0
   *@return status.
   */  
  public static function  bdtaskcrm_delete_order($order){

         global $wpdb ;        
         $delete = $wpdb->delete( 
                        $order['table'],   // table name 
                        array( 'order_id' => $order['add']['order_id'] ),  // where clause 
                        array( '%d' )      // where clause data type (int)
                    );    
        $order['action_status'] = ($delete)? 'delete_successfully' : 'something_is_error';
        return  $order ;
   }  

  /**
   *@param  bdtaskcrm_select_order($order = null). 
   *@since  1.0.0
   *@return query.
   */  
  public static function  bdtaskcrm_select_order( $order = null){ 
  global $wpdb ;         
          $table_name = $order['table'];    
          // $table_two = $order['table_two'];  
         $order['table_clients'] = $wpdb->prefix .'bdtaskcrm_clients';  
         $client_tbl=$order['table_clients'];     
         
          $order['query']['select_all']  =  "SELECT * FROM $client_tbl AS $client_tbl INNER JOIN $table_name AS $table_name ON $client_tbl.client_id =$table_name.client_id";  
          return  $order ;                            
  }

 }/*  / class bdtaskcrm_order */