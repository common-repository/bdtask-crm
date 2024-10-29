 function client_relation(item) {
 	 var ajaxurl = object.ajaxurl;
       var  client_relation_status = jQuery("#client_relations").val();
            data ={
             action:'relation_result',
             client_restion_id:client_relation_status,
             security :object.nonce
            };
            jQuery.post(ajaxurl,data, function(response) {
                jQuery('#lead_customer').html(response);
            });
            return false;  

 }


//===========product wise rate show=============
//===============================


 function service_cals(item) {
         var product_name = jQuery('#service_id_'+item).val(); 
         var ajaxurl = object.ajaxurl;
            data ={
             action:'add_get_result',
             what:product_name,
             security :object.nonce
            };

            jQuery.post(ajaxurl,data, function(response) {
            var obj = jQuery.parseJSON( response );
            jQuery('#product_rate_'+item).val(obj[0].service_rate); 
            jQuery('#product_discount_'+item).val(obj[0].product_discount);
            
            var product_discount =jQuery('#product_discount_'+item).val(); 
            var avl_qntt = jQuery('#avl_qntt_'+item).val(); 
            var product_rate = jQuery('#product_rate_'+item).val();
            var onchange_cal=avl_qntt*product_rate;
            var dis= onchange_cal * product_discount / 100;
            var sttt =onchange_cal-dis ; 
            // <!-- jQuery('#total_'+item).val(sttt); -->
            jQuery('#total_'+item).val(onchange_cal);
            jQuery("#all_discount_" + item).val(dis);
            calculateSum();

            });
            return false;            

}



 function card_number_input(item) {
       var ajaxurl = object.ajaxurl;
       var  payment_method = jQuery("#payment_method").val();
            data ={
             action:'card_number_input',
             result:payment_method,
             security :object.nonce
            };
            jQuery.post(ajaxurl,data, function(response) {
             console.log(response);
             return false;
             jQuery('#show_card').html(response);
            });
            return false;  
 }