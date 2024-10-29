<?php
 /**
   *@param  bdtaskcrm_quotation 
   *@since  1.0.0
   */  
class BDTASKCRM_Quotations{

   /**
   *@var protected. 
   *@since 1.0.0
   */ 
   protected static $quotation;

   
   /**
   *@param  bdtaskcrm_process_quotation_data($quotation)/// To Add quotation. 
   *@since  1.0.0
   *@return $quotation (array) .
   */  
   public static function  bdtaskcrm_process_quotation_data($quotation = null ){
      self::$quotation = BDTASKCRM_Quotations::bdtaskcrm_quotation_name_sanitize() ;
      self::$quotation = BDTASKCRM_Quotations::bdtaskcrm_quotation_table(  self::$quotation );
      self::$quotation = BDTASKCRM_Quotations::bdtaskcrm_add_quotation(  self::$quotation );  
      return self::$quotation;
   }



  /**
   *@param  bdtaskcrm_process_quotation_update_data($quotation)/// To Update quotation. 
   *@since  1.0.0
   *@return $quotation (array) .
   */  

   public static function  bdtaskcrm_process_quotation_update_data($quotation = null ){
      self::$quotation = BDTASKCRM_Quotations::bdtaskcrm_quotation_id_sanitize() ;
      self::$quotation = BDTASKCRM_Quotations::bdtaskcrm_quotation_name_sanitize( self::$quotation ) ;
      self::$quotation = BDTASKCRM_Quotations::bdtaskcrm_quotation_table(  self::$quotation );
      self::$quotation = BDTASKCRM_Quotations::bdtaskcrm_update_quotation(  self::$quotation );  
      return self::$quotation;
   }


  /**
   *@param  bdtaskcrm_process_quotation_delete_data($quotation)/// To Delete quotation. 
   *@since  1.0.0
   *@return $quotation (array).
   */  

   public static function  bdtaskcrm_process_quotation_delete_data($quotation = null ){
      self::$quotation = BDTASKCRM_Quotations::bdtaskcrm_quotation_id_sanitize() ;
      self::$quotation = BDTASKCRM_Quotations::bdtaskcrm_quotation_table(  self::$quotation );
      self::$quotation = BDTASKCRM_Quotations::bdtaskcrm_delete_quotation(  self::$quotation );  
      return self::$quotation;
   }

  public static function  bdtaskcrm_process_convert_order($quotation = null ){
      self::$quotation = BDTASKCRM_Quotations::bdtaskcrm_quotation_id_sanitize() ;
      self::$quotation = BDTASKCRM_Quotations::bdtaskcrm_quotation_table(  self::$quotation );
      self::$quotation = BDTASKCRM_Quotations::bdtaskcrm_convert_quotation(  self::$quotation );  
      return self::$quotation;
  }

   /**
   *@param  bdtaskcrm_process_quotation_select_data($quotation)/// To Select quotation. 
   *@since  1.0.0
   *@return $quotation (array) .
   */  

   public static function  bdtaskcrm_process_quotation_select_data($quotation = null ){
      self::$quotation = BDTASKCRM_Quotations::bdtaskcrm_quotation_table(self::$quotation );
      self::$quotation = BDTASKCRM_Quotations::bdtaskcrm_select_quotation(self::$quotation );  
      return self::$quotation;
   }

  

   /**
   *@param  bdtaskcrm_quotation_id_sanitize($quotation). 
   *@since  1.0.0
   *@return quotation id .
   */  
   public static function  bdtaskcrm_quotation_id_sanitize($quotation = null ){   
       $quotation['add']['order_id'] = intval( $_POST['order_id']  );
       $quotation['add']['row_id'] = intval( @$_POST['row_id']  );
       $quotation['add']['client_id'] = intval( @$_POST['client_id']  );
       $quotation['add']['client_type'] = intval( @$_POST['client_type']  );
      return $quotation;
   }



  /**
   *@param  bdtaskcrm_quotation_name_sanitize($quotation). 
   *@since  1.0.0
   *@return quotation name .
   */  
   public static function  bdtaskcrm_quotation_name_sanitize($quotation = null ){ 

      $quotation['add']['client_id'] = sanitize_text_field(@intval($_POST['client_id'] ) );
      $quotation['add']['create_date'] = sanitize_text_field( $_POST['create_date']  );
      $quotation['add']['expiry_date'] = sanitize_text_field( $_POST['expiry_date']  );
      $quotation['add']['subTotal'] = sanitize_text_field( $_POST['subTotal']  );
      $quotation['add']['tax'] = sanitize_text_field( $_POST['tax']  );
      $quotation['add']['discount'] = sanitize_text_field( $_POST['discount']  );
      $quotation['add']['grand_total'] = sanitize_text_field( $_POST['grand_total']  );
      $quotation['add']['special_instruction'] = sanitize_text_field( $_POST['special_instruction']  );
      $quotation['add']['client_type'] = sanitize_text_field( $_POST['client_type']  );
     

      // service details

      if(isset($_POST['service_id']) && !empty($_POST['service_id'])):
      $quotation['add']['service_id']=$_POST['service_id']; //array service_id
      endif;
      if(isset($_POST['service_rate']) && !empty($_POST['service_rate'])):
      $quotation['add']['service_rate']=$_POST['service_rate']; // array service_rate
      endif;
        if(isset($_POST['qty']) && !empty($_POST['qty'])):
      $quotation['add']['qty']=$_POST['qty']; //array qty
      endif;
      if(isset($_POST['product_discount']) && !empty($_POST['product_discount'])):
      $quotation['add']['product_discount']=$_POST['product_discount'];//array product_discount
      endif;
      if(isset($_POST['product_price']) && !empty($_POST['product_price'])):
      $quotation['add']['product_price']=$_POST['product_price']; //array product_price
      endif;
      return $quotation;


   }



  /**
   *@param  bdtaskcrm_quotation_table($quotation). 
   *@since  1.0.0
   *@return table name .
   */  
   public static function  bdtaskcrm_quotation_table($quotation){
      global $wpdb ; 

      $quotation['table_clients'] = $wpdb->prefix .'bdtaskcrm_clients'; 
      $quotation['table_two'] = $wpdb->prefix .'bdtaskcrm_order_details'; 
      $quotation['table'] = $wpdb->prefix .'bdtaskcrm_order_tbl'; 
      return $quotation;     
   }



  /**
   *@param  bdtaskcrm_add_quotation($quotation). 
   *@since  1.0.0
   *@return status .
   */  

   public static function  bdtaskcrm_add_quotation($quotation){
            global $wpdb ;
            if(!empty(@$quotation['add']['client_id'])&&!empty($quotation['add']['service_id'])):
            $id=$quotation['add']['client_type'];
            $date=$quotation['add']['create_date'];
            $dates=$quotation['add']['expiry_date'];
            $create_date = date("Y-m-d", strtotime($date));
            $expiry_date = date("Y-m-d", strtotime($dates));
            if($id==1){
             $add_new_customer = $wpdb->insert( 
                           $quotation['table'], 
                           
                           array(                  
                            'order_id' => '',
                            'client_id'=> $quotation['add']['client_id'],      
                            'Order_status'=>0,      
                            'order_type'=>1,      
                            'create_date'=> $create_date,                 
                            'expiry_date'=> $expiry_date,
                             'create_by'=>get_current_user_id(),      
                            'subTotal'=> $quotation['add']['subTotal'],      
                            'tax'=> $quotation['add']['tax'],      
                            'discount'=> $quotation['add']['discount'],      
                            'grand_total'=> $quotation['add']['grand_total'],      
                            'paid_amnt'=>0,      
                            'due'=>0,      
                            'payment_method'=>0,      
                            'card_number'=>0,      
                            'special_instruction'=> $quotation['add']['special_instruction'],      
                            'quotation_status'=>1,      
                            
                          )

              );


         $lastInsertId = $wpdb->insert_id;

         $aa=count($quotation['add']['service_id']);

          for($i=0;$i<$aa;$i++) {
          $add_new_customer = $wpdb->insert( 
                           $quotation['table_two'], 
                           array(                  
                            'row_id' => '',
                            'order_id' =>$lastInsertId,
                            'service_id'=> $quotation['add']['service_id'][$i],      
                            'service_rate'=> $quotation['add']['service_rate'][$i],      
                            'qty'=> $quotation['add']['qty'][$i],     
                            'product_discount'=> $quotation['add']['product_discount'][$i],     
                            'product_price'=> $quotation['add']['product_price'][$i]     
                            
                          )
                     );
                }



            }else{
               
                    $add_new_customer = $wpdb->insert( 
                           $quotation['table'], 
                           
                           array(                  
                            'order_id' => '',
                            'client_id'=> $quotation['add']['client_id'],      
                            'Order_status'=>0,      
                            'order_type'=>1,      
                            'create_date'=> $create_date,                 
                            'expiry_date'=> $expiry_date,
                             'create_by'=>get_current_user_id(),      
                            'subTotal'=> $quotation['add']['subTotal'],      
                            'tax'=> $quotation['add']['tax'],      
                            'discount'=> $quotation['add']['discount'],      
                            'grand_total'=> $quotation['add']['grand_total'],      
                            'paid_amnt'=>0,      
                            'due'=>0,      
                            'payment_method'=>0,      
                            'card_number'=>0,      
                            'special_instruction'=> $quotation['add']['special_instruction'],      
                            'quotation_status'=>2,      
                            
                          )

              );


         $lastInsertId = $wpdb->insert_id;

         $aa=count($quotation['add']['service_id']);

          for($i=0;$i<$aa;$i++) {
          $add_new_customer = $wpdb->insert( 
                           $quotation['table_two'], 
                           array(                  
                            'row_id' => '',
                            'order_id' =>$lastInsertId,
                            'service_id'=> $quotation['add']['service_id'][$i],      
                            'service_rate'=> $quotation['add']['service_rate'][$i],      
                            'qty'=> $quotation['add']['qty'][$i],     
                            'product_discount'=> $quotation['add']['product_discount'][$i],     
                            'product_price'=> $quotation['add']['product_price'][$i]     
                            
                          )
                     );
                }

            }

      $quotation['action_status'] = ($add_new_customer)? 'no_error_data_save_successfully' : 'something_is_error';
    endif;
      return  $quotation ; 
   }

   /**
   *@param  bdtaskcrm_update_quotation($quotation). 
   *@since  1.0.0
   *@return status .
   */  
  public static function  bdtaskcrm_update_quotation($quotation){
         global $wpdb ;
         $id=$quotation['add']['client_type'];  

          if($id==1){
        $create_date =$quotation['add']['create_date'];
        $create_date=date('Y-m-d', strtotime($create_date)); 
     $expiry_date =$quotation['add']['expiry_date'];
       $newDate = date("Y-m-d", strtotime($expiry_date)); 
          $update_quotation  = $wpdb->delete( 
                        $quotation['table_two'],   // table name 
                        array( 'order_id' => $quotation['add']['order_id'] ),  // where clause 
                        array( '%d' )      // where clause data type (int)
            );    
          $update_quotation = $wpdb->update( 
                          $quotation['table'], 
                           array(                  
                            'client_id'=> $quotation['add']['client_id'],      
                            'Order_status'=>0,      
                            'order_type'=>1,      
                            'create_date'=> $create_date,                 
                            'expiry_date'=> $newDate,
                             'create_by'=>get_current_user_id(),      
                            'subTotal'=> $quotation['add']['subTotal'],      
                            'tax'=> $quotation['add']['tax'],      
                            'discount'=> $quotation['add']['discount'],      
                            'grand_total'=> $quotation['add']['grand_total'],      
                            'paid_amnt'=>0,      
                            'due'=>0,      
                            'payment_method'=>0,      
                            'card_number'=>0,      
                            'special_instruction'=> $quotation['add']['special_instruction'], 
                            'quotation_status'=>1,     
                            
                          ),
                          array( 'order_id' => $quotation['add']['order_id'] ) ,  // where clause(s)
                          array( '%s') , // column & new value type.
                          array( '%d' ) // where clause(s) format types  
                        );

         $aa=count($quotation['add']['service_id']);
          for($i=0;$i<$aa;$i++) {
         $update_quotation = $wpdb->insert( 
                           $quotation['table_two'], 
                           array(                  
                            'order_id' =>$quotation['add']['order_id'],
                            'service_id'=> $quotation['add']['service_id'][$i],      
                            'service_rate'=> $quotation['add']['service_rate'][$i],      
                            'qty'=> $quotation['add']['qty'][$i],     
                            'product_discount'=> $quotation['add']['product_discount'][$i],     
                            'product_price'=> $quotation['add']['product_price'][$i]     
                            
                          )
                     );
                }         

        }else{

            
        $create_date =$quotation['add']['create_date'];
        $create_date=date('Y-m-d', strtotime($create_date)); 
        $expiry_date =$quotation['add']['expiry_date'];
        $newDate = date("Y-m-d", strtotime($expiry_date)); 
            $update_quotation  = $wpdb->delete( 
                        $quotation['table_two'],   // table name 
                        array( 'order_id' => $quotation['add']['order_id'] ),  // where clause 
                        array( '%d' )      // where clause data type (int)
            );    

         
         $update_quotation = $wpdb->update( 
                          $quotation['table'], 
                           array(                  
                            'client_id'=> $quotation['add']['client_id'],      
                            'Order_status'=>0,      
                            'order_type'=>1,      
                            'create_date'=> $create_date,                 
                            'expiry_date'=> $newDate,
                             'create_by'=>get_current_user_id(),      
                            'subTotal'=> $quotation['add']['subTotal'],      
                            'tax'=> $quotation['add']['tax'],      
                            'discount'=> $quotation['add']['discount'],      
                            'grand_total'=> $quotation['add']['grand_total'],      
                            'paid_amnt'=>0,      
                            'due'=>0,      
                            'payment_method'=>0,      
                            'card_number'=>0,      
                            'special_instruction'=> $quotation['add']['special_instruction'], 
                            'quotation_status'=>2,     
                            
                          ),
                          array( 'order_id' => $quotation['add']['order_id'] ) ,  // where clause(s)
                          array( '%s') , // column & new value type.
                          array( '%d' ) // where clause(s) format types  
                        );

         
         $aa=count($quotation['add']['service_id']);
          for($i=0;$i<$aa;$i++) {
         $update_quotation = $wpdb->insert( 
                           $quotation['table_two'], 
                           array(                  
                            'order_id' =>$quotation['add']['order_id'],
                            'service_id'=> $quotation['add']['service_id'][$i],      
                            'service_rate'=> $quotation['add']['service_rate'][$i],      
                            'qty'=> $quotation['add']['qty'][$i],     
                            'product_discount'=> $quotation['add']['product_discount'][$i],     
                            'product_price'=> $quotation['add']['product_price'][$i]     
                            
                          )
                     );
                }         

}


        $quotation['action_status'] = ($update_quotation)? 'no_error_data_update_successfully' : 'something_is_error';

        
        return  $quotation ; 
      
   }


 
   /**
   *@param  bdtaskcrm_delete_quotation($quotation). 
   *@since  1.0.0
   *@return status.
   */  
  public static function  bdtaskcrm_delete_quotation($quotation){

         global $wpdb ;        
         $delete = $wpdb->delete( 
                        $quotation['table'],   // table name 
                        array( 'order_id' => $quotation['add']['order_id'] ),  // where clause 
                        array( '%d' )      // where clause data type (int)
                    );    
        $quotation['action_status'] = ($delete)? 'delete_successfully' : 'something_is_error';
        return  $quotation ;
   }  

   public static function  bdtaskcrm_convert_quotation($quotation){

         global $wpdb ;
         if($quotation['add']['client_type']==2){
         $deletes = $wpdb->update( 
                        $quotation['table'],   // table name 
                        array(
                          'order_type'=>2,
                          'quotation_status'=>2,
                          'order_type'=>2,
                        ),
                        array( 'order_id' => $quotation['add']['order_id'] ),  // where clause 
                        array( '%s') , // column & new value type.
                        array( '%d' ) // where clause(s) format types  
                    ); 
         }else{  
        //  this option pore kora hoice 
        $deletes = $wpdb->update( 
                        $quotation['table'],   // table name 
                        array(
                          'order_type'=>2,
                          'quotation_status'=>2,
                          'order_type'=>2,
                        ),
                        array( 'order_id' => $quotation['add']['order_id'] ),  // where clause 
                        array( '%s') , // column & new value type.
                        array( '%d' ) // where clause(s) format types  
         ); 
        $deletes = $wpdb->update( 
                        $quotation['table_clients'],   // table name 
                        array(
                         
                          'client_type'=>2,
                        ),
                        array( 'client_id' => $quotation['add']['client_id'] ) ,  // where clause(s)
                        array( '%s') , // column & new value type.
                        array( '%d' ) // where clause(s) format types  
        );  
         }
        $quotation['action_status'] = ($deletes)? 'convert_successfully' : 'something_is_error';
        

         return  $quotation ;
   }






  /**
   *@param  bdtaskcrm_select_quotation($quotation = null). 
   *@since  1.0.0
   *@return query.
   */  
  public static function  bdtaskcrm_select_quotation( $quotation = null){ 
  global $wpdb ;         
          $table_name = $quotation['table'];    
          // $table_two = $quotation['table_two'];  
         $quotation['table_clients'] = $wpdb->prefix .'bdtaskcrm_clients';  
         $client_tbl=$quotation['table_clients'];     
         
          $quotation['query']['select_all']  =  "SELECT * FROM $client_tbl AS $client_tbl INNER JOIN $table_name AS $table_name ON $client_tbl.client_id =$table_name.client_id";  
          return  $quotation ;                            
  }

 }/*  / class bdtaskcrm_quotation */