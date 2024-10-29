 <?php 
 if ( ! defined( 'WPINC' ) ) {
  die;// Exit if accessed directly.
}
?>
<style type="text/css">
  .alertify-notifier.ajs-right {
    margin-top: 50px!important;
    display: block;
    -webkit-transition-duration: 150ms;
          transition-duration: 150ms;
 }

</style>
<div class="wrap"> 
<?php
global $wpdb;
$id=sanitize_text_field($_GET['id']);
$table_name = $wpdb->prefix.'bdtaskcrm_order_tbl'; 
$bdtaskcrm_order_details = $wpdb->prefix.'bdtaskcrm_order_details'; 
$client_tbl = $wpdb->prefix .'bdtaskcrm_clients';

$sql = "SELECT * FROM $client_tbl AS $client_tbl INNER JOIN $table_name AS $table_name ON $client_tbl.client_id =$table_name.client_id WHERE order_id=$id";
$update_order = $wpdb->get_results( $sql  , OBJECT ) ;

$sqld ="SELECT * FROM $bdtaskcrm_order_details AS $bdtaskcrm_order_details INNER JOIN $table_name AS $table_name ON $bdtaskcrm_order_details.order_id =$table_name.order_id Where $table_name.order_id =$id order by row_id ASC";
$order_details = $wpdb->get_results( $sqld  , OBJECT ) ;

?>

<?php
 if(isset($_POST['order_submit_for_change'])):

  //=================== nonce Security verified checked======================= 

   if(wp_verify_nonce($_POST['update_order_name_nonce'], 'update_order_action_nonce')){

//=================== nonce Security verified checked======================= 
 global $order ;  
 global $customer ;

$order= BDTASKCRM_Orders::bdtaskcrm_process_order_update_data(); 
if( isset($order['action_status']) ):
$order_id =$order['add']['order_id'];  
     ?> 

  <div class = "row">
    <div class = "col-sm-12">
      <?php if($order['action_status'] == 'no_error_data_update_successfully'): ?>
        <script type="text/javascript">
         jQuery(document).ready(function() {
          window.location = "<?php echo admin_url('admin.php?page=bdtaskcrm_update_order&id='.$order_id);?>";
           alertify.set('notifier','position', 'top-right');
           alertify.success("<p><strong><?php esc_html_e('Successfully updated your order','bdtaskcrm') ;?></strong></p>", 'custom', 2, function(){console.log('dismissed');});
           
          });
        </script> 

         <?php endif ; ?>
   </div><!-- end .col-sm-7 -->
 </div><!-- end .row -->
 <?php endif;}else{?>
<p><strong> <?php esc_html_e('Your nonce is not  verified ! .','bdtaskcrm') ;?></strong></p>
<?php }endif ; ?>

<div class="row">
<div class="col-sm-12">
    <div class="panel panel-bd lobidrag">
        <div class="panel-heading">
            <div class="panel-title">
                <h2><?php echo esc_html('Order','bdtaskcrm');?></h2>
            </div>
        </div>
        <form action="" class="form-vertical" id="order_form" enctype="multipart/form-data" method="post" accept-charset="utf-8">
        

        <!-- nonce security token  field-->
          <?php wp_nonce_field("update_order_action_nonce","update_order_name_nonce");?>
          <!-- nonce security token field -->


        <input type="hidden" name="order_id" value="<?php echo  $update_order[0]->order_id;?>">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6" id="payment_from_1">
                   <div class="form-group row">
                        <label for="related" class="col-sm-3 col-form-label"><?php echo esc_html('Customer','bdtaskcrm');?></label>
                        <div class="col-sm-6">
                        <select  name="client_id"  id ="" class="form-control">
                        <option value=""><?php echo esc_html('Select Customer','bdtaskcrm');?></option>
                         <?php 
                          if(method_exists('BDTASKCRM_Customers','bdtaskcrm_process_customer_select_data')) :
                          global $wpdb ;
                          $customer= BDTASKCRM_Customers::bdtaskcrm_process_customer_select_data();    
                          $categories = $wpdb->get_results( $customer['query']['select_all'], OBJECT ) ;
                          endif ;
                          $categories= array_filter($categories);
                          foreach ($categories as $cat):
                          if($cat->client_type==2){
                        if($cat->is_active==1){
                          ?>
                          <option value="<?php echo $cat->client_id;?>" <?php if($cat->client_id == $update_order[0]->client_id){ echo 'selected'; } ?>><?php echo esc_html($cat->first_name.' '.$cat->last_name);?></option>

                         <?php 
                         }}
                         endforeach;
                         ?>         
                          </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="create_date" class="col-sm-3 col-form-label"><?php echo esc_html('Create Date','bdtaskcrm');?></label>
                        <div class="col-sm-6">
                          <?php 
                           
                            $date=$update_order[0]->create_date;
                            $date=date('M-d-y', strtotime($date));
                          ?>
                            <input type="text"  name="create_date" class="customerSelection form-control ui-autocomplete-input" placeholder="Create Date" id="create_date" value="<?php echo $date;?>" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="expiry_date" class="col-sm-3 col-form-label"><?php echo esc_html('Expiry Date','bdtaskcrm');?></label>
                        <div class="col-sm-6">
                           <?php 
                           $dated=$update_order[0]->expiry_date;
                           $newDate = date("M-d-y", strtotime($dated));
                           ?>
                            <input type="text" name="expiry_date" class="customerSelection form-control ui-autocomplete-input" placeholder="Expiry Date"  id="expiry_date" value="<?php echo $newDate;?>" readonly="readonly">
                        </div>
                    </div>
                </div>    
                <div class="col-sm-6" id="payment_from_1">
      
                     <div class="form-group row">
                      <label for="expiry_date" class="col-sm-3 col-form-label"><?php echo esc_html("Order Status:",'bdtaskcrm');?></label>

                        <div class="col-sm-6 ">
                           <select name="Order_status" class="form-control" >
                              <option value="1" <?php if($update_order[0]->Order_status ==1){echo 'selected';}?>><?php echo esc_html('Draft','bdtaskcrm');?></option>
                              <option value="2" <?php if($update_order[0]->Order_status ==2){echo 'selected';}?>><?php echo esc_html('Unpaid','bdtaskcrm');?></option>
                              <option value="3" <?php if($update_order[0]->Order_status ==3){echo 'selected';}?>><?php echo esc_html('Partially Paid','bdtaskcrm');?></option>
                              <option value="4" <?php if($update_order[0]->Order_status ==4){echo 'selected';}?>><?php echo esc_html('Paid','bdtaskcrm');?></option>
                           </select>
                        </div>
                    </div> 
                     <div class="form-group row">
                      <label for="" class="col-sm-3 col-form-label" ><?php echo esc_html('Payment Method','bdtaskcrm')?></label>
                        <div class="col-sm-6 " >
                           <select name="payment_method" onchange="card_number_input(1);" onkeyup="card_number_input(1);" class="form-control card_number_input" id="payment_method">
                              <option value="1" <?php if($update_order[0]->payment_method ==1){echo 'selected';}?>><?php echo esc_html('Cash','bdtaskcrm')?></option>
                              <option value="2" <?php if($update_order[0]->payment_method ==2){echo 'selected';}?>><?php echo esc_html('Card','bdtaskcrm');?></option>
                              <option value="3" <?php if($update_order[0]->payment_method ==3){echo 'selected';}?>><?php echo esc_html('online','bdtaskcrm');?></option>
                            
                           </select>
                        </div>
                        
                    </div>
                    <?php 
                      
                    if($update_order[0]->payment_method ==2){?>
                    <div class="form-group row">
                           <label for='card_number' class="col-sm-3 col-form-label"><?php echo esc_html('Card No:','bdtaskcrm');?></label>
                           <div class="col-sm-6">
                            <input id="card_number" type="text" name="card_number" class='form-control' value="<?php echo esc_html($update_order[0]->card_number); ?>">
                           </div>                         
                    </div>
                   <?php }
                      ?>
                    
                </div>
            </div>

                    <div class="row">
                      <div class="col-sm-12 text-right">
                        <button type="button" class="btn btn-info add-new"  id="addrow"><i class="fa fa-plus"></i><?php echo esc_html('Add New','bdtaskcrm');?></button>
                      </div>
                    </div>
            
            <div class="table-responsive" style="margin-top: 10px">
                    
               <table class="table table-bordered table-hover order-list" id="normalinvoice">
                    <thead>
                      
                    <tr>
                        <th class="text-center"><?php echo esc_html('Item Information','bdtaskcrm');?>
                        <i class="text-danger">*</i></th>
                        <th class="text-center"><?php echo esc_html('Qnty','bdtaskcrm');?> 
                        <i class="text-danger">*</i></th>
                        <th class="text-center"><?php echo esc_html('Rate','bdtaskcrm');?>
                        </th>
                        <th class="text-center"><?php echo esc_html('Dis/Pcs %','bdtaskcrm');?> </th>
                        <th class="text-center"><?php echo esc_html('Total','bdtaskcrm');?> 
                
                        </th>
                        <th class="text-center"><?php echo esc_html('Action','bdtaskcrm');?>
                       
                        </th>
                    </tr>
                    </thead>
                    <tbody id="addinvoiceItem">
                    <?php
                    $i=0; 
                    $dis=0;
                    $order_details= array_filter($order_details);
                    foreach ($order_details as $key => $value) {
                    $i++;
                     $tttprices=$value->service_rate*$value->qty;
                    $discount_val=$tttprices* $value->product_discount/100;
                    $dis=$dis+$discount_val;
                    ?>   
                    <tr>
                    <td>      
                  <select class="myselect service_id" name="service_id[]" id="service_id_<?php echo $i;?>" onchange="service_cals(<?php echo $i;?>)"  style="width:200px;"  data-placeholder="-- select your service --">
                 <?php 
                   if(method_exists('BDTASKCRM_Services','bdtaskcrm_process_service_select_data')) :
                    global $wpdb ;
                    $service= BDTASKCRM_Services::bdtaskcrm_process_service_select_data();    
                    $tbl_services= $wpdb->get_results( $service['query']['select_all'], OBJECT ) ;
                    
                   endif ; 
                        ?> 
                       <option value=""></option>
                      <?php 
                       $tbl_services= array_filter($tbl_services);
                      foreach ($tbl_services as $services){
                      if($services->is_active==1){
                      ?>     
                       <option value="<?php echo $services->service_id;?>" <?php if($value->service_id == $services->service_id){ echo 'selected'; } ?>>
                        <?php echo esc_html($services->service_name);?>
                          
                        </option>
                          <?php 
                         } }
                         ?>
                        </select>
                        </td>
                        <input type="hidden" name="row_id" value="<?php echo $value->row_id;?>">
                        <td>
                            <input type="number" name="qty[]" class="form-control text-right available_quantity_1" id="avl_qntt_<?php echo $i;?>" placeholder="0" value="<?php echo esc_html($value->qty);?>" onkeyup="quantity_calculate(<?php echo $i ;?>)" min="1" onchange="quantity_calculate(<?php echo $i ;?>)">
                        </td>
                        <td>
                            <input type="number" id="product_rate_<?php echo $i;?>" class="form-control text-right unit_1" name="service_rate[]"  readonly="readonly" onchange="quantity_calculate(<?php echo $i; ?>)" onkeyup="quantity_calculate(<?php echo $i;?>)" value="<?php echo esc_html($value->service_rate);?>">
                            
                        </td>
                        <td>
                            <input type="number" name="product_discount[]" onkeyup="quantity_calculate(<?php echo $i;?>);" onchange="quantity_calculate(<?php echo $i;?>)" id="product_discount_<?php echo $i;?>" class="form-control text-right" value="<?php echo esc_html($value->product_discount);?>" min="0"  aria-required="true" >
                        </td>
                        
                        <td>
                            <input class="total_price form-control text-right" type="text" name="product_price[]" id="total_<?php echo $i;?>" placeholder="0.00" readonly="readonly" onchange="quantity_calculate(<?php echo $i;?>)" onkeyup="quantity_calculate(<?php echo $i;?>);" value="<?php echo esc_html($value->product_price);?>">
                          
                        </td>      
                                              
                        <td>
                          <input type="hidden" class="form-control all_discount" id="all_discount_<?php echo $i;?>" name="discount_amount[]" value="<?php echo esc_html($discount_val);?>">
                          <input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>                      
                    </tr>
                   <?php }?>
                    </tbody>
                    <tfoot>         
                        <tr>
                          <td style="text-align:right;" colspan="4">
                          <b><?php echo esc_html('Discount:','bdtaskcrm');?></b></td>
                          <td class="text-right">
                              <input type="text" id="total_discount" class="form-control text-right " name="discount" placeholder="0.00" onchange="quantity_calculate(1);" onkeyup="quantity_calculate(1);" value="<?php echo esc_html($dis);?>" readonly="readonly">
                          </td>
                        </tr>
                        
                        <tr>
                          <td colspan="3" rowspan="5">
                              <label for="details" class=""><?php echo esc_html('Details','bdtaskcrm');?></label>
                              <textarea  type="text" class="form-control" name="special_instruction" id="details" rows="4" placeholder="Details"><?php echo esc_html($update_order[0]->special_instruction);?></textarea>
                          </td>
                            <!-- /// SubTotal -->
                          <td style="text-align:right;" colspan="1"><b><?php echo esc_html('Sub Total:','bdtaskcrm');?></b></td>
                          <td class="text-right">
                              <input type="text" id="subTotal" class="form-control text-right" name="subTotal" placeholder="0.00" readonly="readonly" value="<?php echo esc_html($update_order[0]->subTotal);?>">

                          </td>
                    </tr>
                    <tr>
                       <td style="text-align:right;" colspan="1"><b><?php echo esc_html('Tax:','bdtaskcrm');?></b></td>
                        <td class="text-right">
                                <input type="text" id="tax" class="form-control text-right" name="tax" placeholder="0.00" onchange="quantity_calculate(1);" onkeyup="quantity_calculate(1);" value="<?php echo esc_html($update_order[0]->tax);?>" >
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1" style="text-align:right;"><b><?php echo esc_html('Grand Total:','bdtaskcrm');?></b>
                        </td>
                        <td class="text-right">
                            <input type="text" id="grandTotal" class="form-control text-right" name="grand_total" placeholder="0.00" readonly="readonly" value="<?php echo esc_html($update_order[0]->grand_total);?>">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1" style="text-align:right;"><b><?php echo esc_html('Paid Amount:','bdtaskcrm');?></b>
                        </td>
                        <td class="text-right">
                            <input type="text" onkeyup="invoice_paidamount();" onchange="invoice_paidamount();"  id="paidAmount" class="form-control text-right" name="paid_amnt" placeholder="0.00" value="<?php echo  esc_html($update_order[0]->paid_amnt);?>">
                        </td>
                    </tr>   

                    <tr>
                        <td colspan="1" style="text-align:right;"><b><?php echo esc_html('Due:','bdtaskcrm');?></b>
                        </td>
                        <td class="text-right">
                             <input type="text" id="dueAmmount" class="form-control text-right" name="due" placeholder="0.00" readonly="readonly" value="<?php echo esc_html($update_order[0]->due);?>">
                        </td>
                    </tr>
                    <tr>

                        <td style="width: 220px" colspan="5">
                            <input type="submit" id="add-invoice" class="btn btn-success" name="order_submit_for_change" value="Update">
                            <button type='button' onclick="fullPaid()" class="btn btn-info" ><?php echo esc_html('Full Paid','bdtaskcrm');?></button>
                        </td>
                        
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </form> 


               
  </div>
</div>
</div>

<style type="text/css">
  .help-block{
    color: red;
    font-weight: 700;
  }
</style>
<script type="text/javascript">

jQuery().ready(function() {

jQuery("#order_form").validate({
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function(form) {
            jQuery(form).ajaxSubmit();
        },
        errorElement: 'span',
        errorClass: 'help-block', 
 rules: {

   first_name:{
      required: true,
    },
    email: {
      required: true,
      email: true
    },
},
    // Specify validation error messages
    messages: {
        first_name:"Please write First Name.",
        email: "Please enter a valid email address"
    },
});

});







 jQuery("select.card_number_input").change(function(){
        var selectedCountry = jQuery(this).children("option:selected").val();
        console.log(selectedCountry);
         
    });


jQuery(".myselect").select2();
// add new row
jQuery(document).ready(function () {
    var a = jQuery("table.order-list > tbody > tr").length;
    var counter =++a;

   jQuery("#addrow").on("click", function () {
        var newRow = jQuery("<tr>");
        var cols = "";

        cols += 

       '<td><select class="myselect service_id form-control"  id="service_id_'+ counter + '" style="width: 200px;" data-placeholder="-- select your service --" name="service_id[]" onchange="service_cals('+counter+')"><?php  $tbl_services= array_filter($tbl_services);foreach ($tbl_services as $service) { if($service->is_active==1){ ?><option value="">--select--</option><option value="<?php echo 
         $service->service_id;?>"><?php echo $service->service_name; }}?></option></select></td>';
        cols += '<td> <input type="number" name="qty[]" class="form-control text-right available_quantity_1" id="avl_qntt_' + counter + '" placeholder="0" value="1" onkeyup="quantity_calculate('+counter+')" onchange="quantity_calculate('+counter+');"></td>';
        cols += '<td><input type="number" id="product_rate_'+ counter + '" class="form-control text-right" readonly="readonly" onkeyup="quantity_calculate('+ counter +');" onchange="quantity_calculate('+ counter +');" name="service_rate[]"></td>';
        cols += '<td><input type="number" name="product_discount[]" onkeyup="quantity_calculate('+ counter +');" onchange="quantity_calculate('+ counter +');" id="product_discount_'+ counter +'" class="form-control text-right" value="" min="1" aria-required="true"></td>';
        cols += '<td> <input class="total_price form-control text-right" type="text" name="product_price[]" id="total_' + counter + '" placeholder="0.00" readonly="readonly" onchange="quantity_calculate('+ counter +');" onkeyup="quantity_calculate('+ counter +');"></td>';    

         cols += '<input type="hidden" class="form-control all_discount" id="all_discount_' + counter + '" name="discount_amount[]"> value="0"';   

        cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
        newRow.append(cols);
        jQuery("table.order-list").append(newRow);
        counter++;

        // select input box 
      jQuery(".myselect").select2();
    calculateSum();
    });



    jQuery("table.order-list").on("click", ".ibtnDel", function (event) {
      var a = jQuery("table.order-list > tbody > tr").length;
        if (1 == a) {
            alert("There only one row you can't delete it.");
        } else {
        jQuery(this).closest("tr").remove();       
        counter -= 1;
            calculateSum();

            
          } 
    });


});
// end add_row


//====================quantity and service_rate
//////////////////////////////////////////////////////=========================
 function quantity_calculate(item) {
     var avl_qntt = jQuery('#avl_qntt_'+item).val(); 
     var product_rate = jQuery('#product_rate_'+item).val();
     var product_discount = jQuery("#product_discount_"+item).val();
     var tax = jQuery("#tax").val();
     var total_amount=avl_qntt*product_rate;
     var dis = total_amount * product_discount / 100;
     var sttt =total_amount-dis ;

     // jQuery('#total_'+item).val(sttt);
     jQuery('#total_'+item).val(total_amount);
     jQuery("#all_discount_" + item).val(dis);

     calculateSum();
     invoice_paidamount();
}

function calculateSum() {
        var t = 0,
                a = 0,
                e = 0,
                o = 0,
                p = 0;
       jQuery(".total_price").each(function () {
            isNaN(this.value) || 0 == this.value.length || (e += parseFloat(this.value))
        }),
               jQuery(".all_discount").each(function () {
            isNaN(this.value) || 0 == this.value.length || (p += parseFloat(this.value))
        }),
              jQuery("#total_discount").val(p.toFixed(2, 2)),
              jQuery("#subTotal").val(e.toFixed(2))
              jQuery("#grandTotal").val(e.toFixed(2))
        var sd = jQuery("#total_discount").val(); 
        var st =jQuery("#subTotal").val();
        var tx =jQuery("#tax").val();
        var gt =jQuery("#grandTotal").val();
        var subTotal = st-sd;
        var tax=+tx+ +subTotal;
        jQuery("#subTotal").val(subTotal);
        jQuery("#grandTotal").val(tax);
        invoice_paidamount();
    }

//Invoice Paid Amount
function invoice_paidamount() {
  var t = jQuery("#grandTotal").val(),
          a = jQuery("#paidAmount").val(),
          e = t - a;
  jQuery("#dueAmmount").val(e.toFixed(2, 2))
}

// Full Paid on click
function fullPaid() {
var eb=jQuery('#grandTotal').val();

jQuery("#paidAmount").val(eb);
jQuery("#dueAmmount").val(0);
}
</script>

<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery('#create_date').datepicker({
  dateFormat: 'M-d-y'
  });  

  jQuery('#expiry_date').datepicker({
  dateFormat: 'M-d-y'
  });
});



</script>

</div>

