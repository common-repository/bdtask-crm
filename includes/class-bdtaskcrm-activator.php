<?php

/**
 * Fired during plugin activation
 *
 * @link       bdtask.com
 * @since      1.0.0
 *
 * @package    bdtaskcrm
 * @subpackage bdtaskcrm/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    bdtaskcrm
 * @subpackage bdtaskcrm/includes
 * @author     bdtask <bdtask@gmail.com>
 */
class BDTASKCRM_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

	    global $wpdb ; 
        $charset_collate     = $wpdb->get_charset_collate();
        $table_category      = $wpdb->prefix .'bdtaskcrm_clients';
        $table_service       = $wpdb->prefix .'bdtaskcrm_services';
        $table_order_tbl     = $wpdb->prefix .'bdtaskcrm_order_tbl';
        $table_order_details = $wpdb->prefix .'bdtaskcrm_order_details';
       
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

      /*============================ create table Client  =================================================================================*/

        $sql = ' ';
        $sql .= 'CREATE TABLE  IF NOT EXISTS  ';
        $sql .= $table_category;
        $sql .= '  (  ';
        $sql .= 'client_id bigint(20)  AUTO_INCREMENT,  ';
        $sql .= 'first_name varchar(30)  NOT NULL,  ';
        $sql .= 'last_name  varchar(30) NOT NULL, ';
        $sql .= 'phone  varchar(50) NOT NULL, ';
        $sql .= 'email  varchar(50) NOT NULL, ';
        $sql .= 'address varchar(200) NOT NULL, ';
        $sql .= "is_active tinyint(1) NOT NULL COMMENT '0=inactive, 1=active', ";
        $sql .= "client_type tinyint(1) NOT NULL COMMENT '1=Lead, 2=Customer'	, ";
        $sql .= 'create_by  int(11) NOT NULL, ';
        $sql .= 'createDate  DATE NOT NULL, ';
        $sql .= 'PRIMARY KEY (client_id)  ';
        $sql .= ' ) ';
        $sql .=  $charset_collate ; 
       
        $ct_category = (!$table_category =='' )?dbDelta($sql):'';         




     /*============================ create table service  =================================================================================*/

        $sql = ' ';
        $sql .= 'CREATE TABLE  IF NOT EXISTS  ';
        $sql .= $table_service;
        $sql .= '  (  ';
        $sql .= 'service_id int(11)  AUTO_INCREMENT,  ';
        $sql .= 'service_name varchar(150)  NOT NULL,  ';
        $sql .= 'description varchar(250) NOT NULL, ';
        $sql .= 'service_rate  FLOAT NOT NULL, ';
        $sql .= "is_active tinyint(1) NOT NULL COMMENT '0=inactive, 1=active', ";
        $sql .= 'product_discount FLOAT NOT NULL ,  ';
        $sql .= 'PRIMARY KEY (service_id)  ';
        $sql .= ' ) ';
        $sql .=  $charset_collate ; 
       
        $ct_service = (!$table_service =='' )?dbDelta($sql):'';  


/*============================ create table order  =================================================================================*/

        $sql = ' ';
        $sql .= 'CREATE TABLE  IF NOT EXISTS  ';
        $sql .= $table_order_tbl ;
        $sql .= '  (  ';
        $sql .= 'order_id bigint(20)  AUTO_INCREMENT,  ';
        $sql .= 'client_id bigint(20) NOT NULL ,  ';
        $sql .= "Order_status tinyint(1) NOT NULL COMMENT '1=draft,2=unpaid,3=partial paid,4=paid' ,  ";
        $sql .= "order_type tinyint(5) NOT NULL COMMENT '1=quotation, 2=Order',";
        $sql .= 'create_date date NOT NULL,  ';
        $sql .= 'expiry_date date NOT NULL, ';
        $sql .= 'create_by  int(11) NOT NULL, ';
        $sql .= 'subTotal  float NOT NULL, ';
        $sql .= 'tax  float NOT NULL, ';
        $sql .= 'discount  float NOT NULL, ';
        $sql .= 'grand_total  float NOT NULL, ';
        $sql .= 'paid_amnt  float NOT NULL, ';
        $sql .= 'due  float NOT NULL, ';
        $sql .= "payment_method  varchar(20) NOT NULL COMMENT 'cash/card/online',";
        $sql .= 'card_number  varchar(20) NOT NULL, ';
        $sql .= 'special_instruction  varchar(250) NOT NULL, ';
         $sql .= "quotation_status tinyint(1) NOT NULL COMMENT '1=Lead, 2=Customer'  , ";
        $sql .= 'PRIMARY KEY (order_id)  ';
        $sql .= ' ) ';
        $sql .=  $charset_collate ; 
       
        $ct_table_order_tbl  = (!$table_order_tbl  =='' )?dbDelta($sql):''; 

       
/*============================ create table order details =================================================================================*/

        $sql = ' ';
        $sql .= 'CREATE TABLE  IF NOT EXISTS  ';
        $sql .= $table_order_details ;
        $sql .= '  (  ';
        $sql .= 'row_id bigint(20)  AUTO_INCREMENT,  ';
        $sql .= 'order_id bigint(20) NOT NULL ,  ';
        $sql .= 'service_id int(11) NOT NULL ,  ';
        $sql .= 'service_rate float NOT NULL ,  ';
        $sql .= 'qty int(11) NOT NULL ,  ';
        $sql .= 'product_discount FLOAT NOT NULL ,  ';
        $sql .= 'product_price FLOAT NOT NULL ,  ';
        $sql .= 'PRIMARY KEY (row_id)  ';
        $sql .= ' ) ';
        $sql .=  $charset_collate ; 
       
        $ct_table_order_details  = (!$table_order_details  =='' )?dbDelta($sql):''; 


	}

}
