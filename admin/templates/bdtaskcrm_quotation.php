<?php use Dompdf\Dompdf;
if ( ! defined( 'WPINC' ) ) {
  die;// Exit if accessed directly.
}
?>
<div class="wrap"> 
<?php                   
                 
if(isset($_POST['customer_submit'])):

  //=================== nonce Security verified checked======================= 

  if(isset( $_POST['quotation_customer_name_nonce'] ) && wp_verify_nonce($_POST['quotation_customer_name_nonce'], 'quotation_customer_action_nonce')){

//=================== nonce Security verified checked======================= 

global $customer ;
global $quotation ; 
$customer= BDTASKCRM_Customers::bdtaskcrm_process_customer_data(); 
if( isset($customer['action_status']) ):
?> 
  <div class = "row">
    <div class = "col-sm-12">
      <?php if($customer['action_status'] == 'no_error_data_save_successfully'): ?>
        <script type="text/javascript">
         jQuery(document).ready(function() {
          alertify.set('notifier','position', 'top-right');
           alertify.success("<p><strong><?php esc_html_e('Successfully added  your Customer','bdtaskcrm') ;?></strong></p>", 'custom', 2, function(){console.log('dismissed');});
          });
        </script>        

        <?php elseif($customer['action_status'] == 'something_is_error') : ?>
          <script type="text/javascript">
         jQuery(document).ready(function() {
          alertify.set('notifier','position', 'top-right');
           alertify.error("<p><strong> <?php esc_html_e('You are already exist or Some thing is Error . Please try again ! .','bdtaskcrm') ;?></strong></p>", 'custom', 2, function(){console.log('dismissed');});
          });
          </script>  
     <?php endif ; ?>
   </div><!-- end .col-sm-7 -->
 </div><!-- end .row -->
 <?php endif;}else{?>
<p><strong> <?php esc_html_e('Your nonce is not  verified ! .','bdtaskcrm') ;?></strong></p>
<?php }endif ; ?>

<?php 
if(isset($_POST['cat_submit'])):


//=================== nonce Security verified checked======================= 

   if(isset( $_POST['quotation_name_nonce'] ) && wp_verify_nonce($_POST['quotation_name_nonce'], 'quotation_action_nonce')){

//=================== nonce Security verified checked======================= 


      $quotation= BDTASKCRM_Quotations::bdtaskcrm_process_quotation_data(); 
      if( isset($quotation['action_status']) ):
     
global $wpdb;
$client_tbl = $wpdb->prefix .'bdtaskcrm_clients';
$client_id=$quotation['add']['client_id'];
$sql = "SELECT * FROM $client_tbl WHERE client_id=$client_id";
$update_qutation = $wpdb->get_results( $sql  , OBJECT ) ;

if(isset($_POST['service_id']) && !empty($_POST['service_id'])):
$serviceid= $_POST['service_id']; // array service Id 
endif;
if(isset($_POST['qty']) && !empty($_POST['qty'])):
$allqty= $_POST['qty']; //array  qty number 
endif;
if(isset($_POST['service_rate']) && !empty($_POST['service_rate'])):
$allrates= $_POST['service_rate']; // array service_rate 
endif;
if(isset($_POST['product_discount']) && !empty($_POST['product_discount'])):
$alldiscount= $_POST['product_discount']; //array  product_discount
endif;
if(isset($_POST['discount_amount']) && !empty($_POST['discount_amount'])):
$alldiscountamount= $_POST['discount_amount']; //array discount_amount 
endif;
if(isset($_POST['product_price']) && !empty($_POST['product_price'])):
$allprice= $_POST['product_price'];//array product product_price
endif;


$totallength=count($serviceid);
$bdtaskcrm_services = $wpdb->prefix .'bdtaskcrm_services';
$allservices=array();
$trstring='';
$sl=0;
for($i=0;$i<$totallength; $i++){
   $id=sanitize_text_field($serviceid[$i]);
   $qty=sanitize_text_field($allqty[$i]);
   $rate=sanitize_text_field($allrates[$i]);
   $discount=sanitize_text_field($alldiscount[$i]);
   $disamount=sanitize_text_field($alldiscountamount[$i]);
   $p_price=sanitize_text_field($allprice[$i]);
   
$sqld ="SELECT * FROM $bdtaskcrm_services  Where service_id =$id";
$service_name= $wpdb->get_results( $sqld  , OBJECT ) ;
$trstring.='<tr style="border-bottom:1px solid red;">
            <td style="width:10%;text-align: center;border-bottom:1px solid #ddd;">'.++$sl.'</td>
              <td  style="text-align: center;border-bottom:1px solid #ddd;">'.esc_html($service_name[0]->service_name).'</td>
              <td style="width:15%;text-align: center;border-bottom:1px solid #ddd;">'.esc_html($qty).'</td>
              <td style="width:25%;text-align: center;border-bottom:1px solid #ddd;">'.esc_html($rate).'</td>
              <td style="width:20%;text-align: center;border-bottom:1px solid #ddd;">$'.$disamount.' ('.$discount.'%)</td>
              <td style="text-align:right;border-bottom:1px solid #ddd;">'.esc_html($p_price).'</td>
          </tr>';

}
// include autoload.inc from dompdf
$plugin_path = plugin_dir_path( __FILE__ );
define( 'BDTASKCRM_DOMPDF', $plugin_path . 'pdf/dompdf/' );
include( BDTASKCRM_DOMPDF . 'autoload.inc.php' );

// image
$img= wp_get_attachment_url( get_option( "media_selector_attachment_id") );
$path =$img;
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
// image

$company=get_option('name_language');
$address=get_option('frontend_address');
$mobile=get_option('contact_language');
$email=get_option('email_language');
$url=get_option('service_language');
$authorize=get_option('authorize_name');

$html =
      '<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<div class="wrap" style="width:100%;">

                           <div  style="width:100%">
                            <div style="margin-top:10px;display: inline-block">
                                 <img id="image-preview"   src="'.$base64.'" style="margin-bottom:20px;height:55px;">
                             </div>
                                 <address style="margin-top:10px;display: inline-block;float: right;">
                                      <strong> 
                                      '.esc_html('Quotation Invoice','bdtaskcrm').'
                                      </strong>
                                      <br>
                                      <abbr>'.esc_html('Billing Date:','bdtaskcrm').' '.$quotation['add']['create_date'].'</abbr>
                                      
                                      <br>
                                  </address>
                              </div> 
                              <br>
                              <br>
                              <br>
                              <div  style="width:100%">
                            <address style="margin-top:10px;display: inline-block;float: left;">
                                      <strong> 
                                       '.esc_html('Billing From','bdtaskcrm').'
                                      </strong>
                                      <br>
                                      '.esc_html($company).'
                                      <br>
                                      '.esc_html($address).'
                                      <br>
                                       <abbr>'.esc_html('Mobile:','bdtaskcrm').' '.esc_html($mobile).'</abbr><br>
                                       
                                      <abbr>'.esc_html('Email:','bdtaskcrm').' '.esc_html($email).'</abbr> 
                                      <br>
                                      <abbr>'.esc_html('Website:','bdtaskcrm').' '.esc_html($url).'</abbr> 
                                      <br>
                                  </address>
                             </div>
                                 <address style="margin-top:10px;display: inline-block;float: right;">
                                     <strong> 
                                       '.esc_html('Billing To','bdtaskcrm').'
                                      </strong>
                                      <br>
                                      <strong>
                                      '.esc_html($update_qutation[0]->first_name).'  '.esc_html($update_qutation[0]->last_name).'
                                      </strong>
                                      <br>
                                     '.esc_html($update_qutation[0]->address).' 
                                      <br>
                                       <abbr>'.esc_html('Mobile:','bdtaskcrm').' '.esc_html($update_qutation[0]->phone).'</abbr><br>
                                       
                                      <abbr>'.esc_html('Email:','bdtaskcrm').' '.esc_html($update_qutation[0]->email).'</abbr> 
                                  
                                      <br>
                                  </address>
                              </div> 
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>

                           <div class="table-responsive m-b-20">
                              <table class="table table-striped" width="100%" >
                                  <thead>
                                      <tr style="border-bottom:1px solid red;">
                                          <th style="text-align: center;border-bottom:1px solid #000;">'.esc_html('SL','bdtaskcrm').'</th>
                                          <th style="text-align: center;border-bottom:1px solid #000;">'.esc_html('Service Name','bdtaskcrm').'</th>
                                          <th style="text-align: center;border-bottom:1px solid #000;">'.esc_html('Qnty','bdtaskcrm').'</th>
                                          <th style="text-align: center;border-bottom:1px solid #000;">'.esc_html('Rate','bdtaskcrm').'</th>
                                          <th style="text-align: center;border-bottom:1px solid #000;">'.esc_html('Dis%','bdtaskcrm').'</th>
                                          <th style="text-align: center;border-bottom:1px solid #000;">'.esc_html('Amount','bdtaskcrm').'</th>
                                      </tr>
                                  </thead>
                                  <tbody>'.$trstring.'
                                  </tbody>
                              </table>
                          </div>

                       <br>
                       <br>
                       <br>
                       <br>
                       <br>
                       <br>

                            <div class="" style="width:100%;">
                             <table class="table" style="float: left;width:70%;">
                                    <tbody>
                                      
                                      <tr>
                                       <td>'.esc_html($quotation['add']['special_instruction']).'</td>
                                      </tr>
                                    </tbody>
                              </table>
                             
                            <table class="table" style="float: right;width:30%;">
                                    <tbody>
                                      
                                      <tr>
                                      <th style="border-top: 0; border-bottom: 0;text-align: left;">'.esc_html('Total Discount :').'
                                      </th>
                                      <td style="border-top: 0; border-bottom: 0;text-align:right;border-bottom:1px solid #000;">$'.esc_html($quotation['add']['discount']).'</td>
                                    </tr>
                                                                                              
                                    <tr>
                                      <th class="grand_total" style="text-align: left;">'.esc_html('Sub Total :','bdtaskcrm').'</th>
                                      <td class="grand_total" style="text-align:right;border-bottom:1px solid #000;">$
                                                  '.esc_html($quotation['add']['subTotal']).'
                                      </td>
                                    </tr>
                                    <tr>
                                      <th style="border-top: 0; border-bottom: 0;text-align: left;">'.esc_html('Tax :','bdtaskcrm').'</th>
                                      <td style="border-top: 0; border-bottom: 0;text-align:right;border-bottom:1px solid #000;">'.esc_html($quotation['add']['tax']).'</td>
                                    </tr>        
                                     <tr>
                                      <th style="text-align: left;">'.esc_html('Grand Total :','bdtaskcrm').'</th>
                                      <td style="text-align:right;border-bottom:1px solid #000;">$'.esc_html($quotation['add']['grand_total']).'</td>
                                    </tr>
                                    
                                    
                                  </tbody>
                               </table>
                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                <div style="float:left;width:80%;">                 
                  </div>
                  <div style="width:20%;text-align:center;border-top:1px solid #000;margin-top: 100px;font-weight: bold;    float: right;">

                   '.esc_html($authorize).'                
                  </div>
              
                     </div>

</body>
</html>';


// url create plugin directory 
$upload_dir = wp_upload_dir();
define( 'BDTASKCRM_UPLOAD_DIR', $upload_dir['basedir'] . '/invoices');
define( 'BDTASKCRM_UPLOAD_URL', $upload_dir['baseurl'] . '/invoices');
// folder create upload_dir
$uploads_dir = trailingslashit( wp_upload_dir()['basedir'] ) . 'invoices';
wp_mkdir_p( $uploads_dir );

$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->set_paper('A4', 'portrait');
$inv_no=date("Y-m-d-H-i-s");
$output = $dompdf->output();

file_put_contents(BDTASKCRM_UPLOAD_DIR .'/'.$inv_no.'.pdf', $output);
$file_path = $inv_no.'.pdf';
$path =BDTASKCRM_UPLOAD_URL.'/'.$file_path;

$to = $update_qutation[0]->email;
$from_mail=$email;
$from_name=$company;
$subject = esc_html("Invoice Quotation",'bdtaskcrm');
$file = $path;
$content = file_get_contents( $file);
$content = chunk_split(base64_encode($content));
$uid = md5(uniqid(time()));
$name = basename($file);
$message =$quotation['add']['special_instruction'];
// header
$header = "From: ".$from_name." <".$from_mail.">\r\n";
$header .= "Reply-To: ".$to."\r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";

// message & attachment
$nmessage = "--".$uid."\r\n";
$nmessage .= "Content-type:text/plain; charset=iso-8859-1\r\n";
$nmessage .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$nmessage .= $message."\r\n\r\n";
$nmessage .= "--".$uid."\r\n";
$nmessage .= "Content-Type: application/octet-stream; name=\"".$file_path."\"\r\n";
$nmessage .= "Content-Transfer-Encoding: base64\r\n";
$nmessage .= "Content-Disposition: attachment; filename=\"".$file_path."\"\r\n\r\n";
$nmessage .= $content."\r\n\r\n";
$nmessage .= "--".$uid."--";

mail($to, $subject, $nmessage, $header)


?> 

  <div class = "row">
    <div class = "col-sm-12">
      <?php if($quotation['action_status'] == 'no_error_data_save_successfully'): ?>
        <script type="text/javascript">
         jQuery(document).ready(function() {
          alertify.set('notifier','position', 'top-right');
           alertify.success("<p><strong><?php esc_html_e('Successfully added  your quotation','bdtaskcrm') ;?></strong></p>", 'custom', 2, function(){console.log('dismissed');});
          });
        </script>   
        <?php elseif($quotation['action_status'] == 'something_is_error') : ?>
          <script type="text/javascript">
         jQuery(document).ready(function() {
          alertify.set('notifier','position', 'top-right');
           alertify.error("<p><strong> <?php esc_html_e('You are already exist or Some thing is Error . Please try again ! .','bdtaskcrm') ;?></strong></p>", 'custom', 2, function(){console.log('dismissed');});
          });
          </script> 
     <?php endif ; ?>
   </div><!-- end .col-sm-7 -->
 </div><!-- end .row -->
 <?php endif;}else{?>

<p><strong> <?php esc_html_e('Your nonce is not  verified ! .','bdtaskcrm') ;?></strong></p>
<?php }endif ; 

  bdtaskcrm_add_quotation_form() ; 
 ?>  
</div> 
<?php 
function bdtaskcrm_add_quotation_form(){
global $wpdb;
$lastInsertId = $wpdb->insert_id;
?>
<div class="row">
<div class="col-sm-12">
    <div class="panel panel-bd lobidrag">
        <div class="panel-heading">
            <div class="panel-title">
                <h2><?php echo esc_html('Quotation','bdtaskcrm'); 
                ?>

                </h2>
            </div>
        </div>
        <form action="" class="form-vertical cusomer_booking_form" id="cusomer_booking_form" enctype="multipart/form-data" method="post" accept-charset="utf-8">

          <!-- nonce security token  field-->
          <?php wp_nonce_field("quotation_action_nonce","quotation_name_nonce");?>
          <!-- nonce security token field -->

        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6" id="payment_from_1">
                    <div class="form-group row">
                        <label for="related" class="col-sm-3 col-form-label"><?php echo esc_html('Related','bdtaskcrm');?></label>
                        <div class="col-sm-6">
            
                            <select  name="client_type"  id ="client_relations" class="form-control" onchange="client_relation('1');">
                                  <option value=""><?php echo esc_html('Select Related','bdtaskcrm');?></option>
                                  <option value="1"><?php echo esc_html('Lead','bdtaskcrm');?></option>
                                  <option value="2" <?php if($lastInsertId){ echo 'selected'; } ?>><?php echo esc_html('Customer','bdtaskcrm');?></option>
                            </select>
                        </div>
                    </div>
                   <!-- news customer create section  -->
                    <?php 
                     $table_name = $wpdb->prefix.'bdtaskcrm_clients'; 
                     $sqlgg = "SELECT * FROM  $table_name";
                     $restion = $wpdb->get_results( $sqlgg  , OBJECT ) ;
                     
                    if($lastInsertId){ 
                    ?>
                    <div class="form-group row">
                    <label for="customer_name" class="col-sm-3 col-form-label"><?php echo esc_html('Customers','bdtaskcrm');?></label>
                    <div class="col-sm-6">                    
                        <select  name="client_id"   class="form-control">
                            <?php 
                            $restion= array_filter($restion);
                            foreach ($restion as $key => $customer) {?>
                              <option value="<?php echo $customer->client_id;?>"<?php if($customer->client_id==$lastInsertId){ echo 'selected';}?>><?php echo esc_html($customer->first_name).' '.esc_html($customer->last_name);?></option>
                          <?php }?>
                       </select>
                       <input type='hidden' id='client_type' value='<?php echo $restion[0]->client_type;?>'>
                    </div>
                    </div>
                   <!-- end create customer section  -->

                    <!-- on change customer or lead section  -->
                    <?php }else{?>
                    <div class="form-group row">
                        <div id="lead_customer"></div>
                    </div>
                    <?php  }?>


                    <div class="form-group row">
                        <label for="create_date" class="col-sm-3 col-form-label"><?php echo esc_html('Create Date','bdtaskcrm');?></label>
                        <div class="col-sm-6">
                            <input type="text"  name="create_date" class="customerSelection form-control ui-autocomplete-input" value="<?php echo  date("M-d-Y");?>" placeholder="<?php echo  date("M-d-Y");?>" id="create_date" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="expiry_date" class="col-sm-3 col-form-label"><?php echo esc_html('Expiry Date','bdtaskcrm')?></label>
                        <div class="col-sm-6">
                          <?php
                          $date =date("M-d-Y");
                          $date = strtotime($date);
                          $date = strtotime("+7 day", $date); 
                          ?>
                            <input type="text" name="expiry_date" class="customerSelection form-control ui-autocomplete-input" value="<?php echo date('M-d-Y', $date);?>" placeholder="<?php echo date('M-d-Y', $date);?>"  id="expiry_date" readonly="readonly">
                        </div>
                    </div>
                </div>    
                <div class="col-sm-6" id="payment_from_1">
                    <div class="form-group row">
                      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal_one"><?php echo esc_html('Create New Customer','bdtaskcrm');?></button> 
                       <?php bdtaskcrm_add_customer_form(4);?>
                        
                    </div>
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
                        <th class="text-center"><?php echo esc_html('Item Information','bdtaskcrm');?> <i class="text-danger">*</i></th>
                        <th class="text-center"><?php echo esc_html('Qnty','bdtaskcrm');?> 
                        <i class="text-danger">*</i></th>
                        <th class="text-center"><?php echo esc_html('Rate','bdtaskcrm');?> 
                        
                        </th>
                        <th class="text-center"><?php echo esc_html('Dis%','bdtaskcrm');?> </th>
                        <th class="text-center"><?php echo esc_html('Service Amount','bdtaskcrm');?>
                         
                        </th>
                        <th class="text-center"><?php echo esc_html('Action','bdtaskcrm');?> 
                        
                        </th>
                    </tr>
                    </thead>
                    <tbody id="addinvoiceItem">
                    <tr>
                    <td>      
                  <select class="myselect service_id" name="service_id[]" id="service_id_1" onchange="service_cals('1')" onkeyup="service_cals('1')" style="width:200px;"  data-placeholder="-- select your service --">

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
                       <option value="<?php echo $services->service_id;?>">
                          <?php echo esc_html($services->service_name);?>
                        </option>
                          <?php }} ?>
                        </select>
                        </td>

                        <td>
                            <input type="number" name="qty[]" class="form-control text-right available_quantity_1" id="avl_qntt_1" placeholder="0" value="1" onkeyup="quantity_calculate('1');" min="1" onchange="quantity_calculate('1');">
                        </td>
                        <td>
                            <input type="number" id="product_rate_1" class="form-control text-right unit_1" name="service_rate[]"  readonly="readonly" onchange="quantity_calculate('1');" onkeyup="quantity_calculate('1');">
                            
                        </td>
                        <td>
                            <input type="number" name="product_discount[]" onkeyup="quantity_calculate('1');" onchange="quantity_calculate('1');" id="product_discount_1" class="form-control text-right" value="" placeholder="0.00"  min="0" aria-required="true">
                        </td>
                        <input type="hidden" class="form-control all_discount" id="all_discount_1" name="discount_amount[]">
                        <td>
                            <input class="total_price form-control text-right" type="text" name="product_price[]" id="total_1" placeholder="0.00" readonly="readonly" onchange="quantity_calculate('1');" onkeyup="quantity_calculate('1');">
                          
                        </td>      
                                              
                        <td><input type="button" class="btn btn-md btn-danger "  value="Delete"></td>                      
                    </tr>
                    </tbody>
                    <tfoot>         
                        <tr>
                          <td style="text-align:right;" colspan="4">
                          <b><?php echo esc_html('Total Discount:','bdtaskcrm');?></b></td>
                          <td class="text-right">
                              <input type="text" id="total_discount" class="form-control text-right " name="discount" placeholder="0.00" onchange="quantity_calculate('1');" onkeyup="quantity_calculate('1');" value="" readonly="readonly">
                          </td>

                        </tr>
                        
                        <tr>
                          <td colspan="3" rowspan="3">
                              <label for="details" class=""><?php echo esc_html('Details','bdtaskcrm');?></label>
                              <textarea class="form-control" name="special_instruction" id="details" rows="4" placeholder="Details"></textarea>
                          </td>
                            <!-- /// SubTotal -->
                          <td style="text-align:right;" colspan="1"><b><?php echo esc_html('Sub Total:','bdtaskcrm');?></b></td>
                          <td class="text-right">
                              <input type="text" id="subTotal" class="form-control text-right" name="subTotal" placeholder="0.00" readonly="readonly" value="">

                          </td>
                    </tr>
                    <tr>
                       <td style="text-align:right;" colspan="1"><b><?php echo esc_html('Tax:','bdtaskcrm');?></b></td>
                        <td class="text-right">
                                <input type="text" id="tax" class="form-control text-right" name="tax" placeholder="0.00" onchange="quantity_calculate('1');" onkeyup="quantity_calculate('1');" value="" >
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1" style="text-align:right;"><b><?php echo esc_html('Grand Total:','bdtaskcrm');?></b>
                        </td>
                        <td class="text-right">
                            <input type="text" id="grandTotal" class="form-control text-right" name="grand_total" placeholder="0.00" readonly="readonly">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 220px" colspan="5">
                            <input type="submit" id="add-invoice" class="btn btn-success" name="cat_submit" value="Submit">
                        
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



<script type="text/javascript">
  //insert validation 
jQuery().ready(function() {

jQuery("#cusomer_booking_form").validate({
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

</script>
<style type="text/css">
  .help-block{
    color: red;
    font-weight: 700;
  }
</style>




<script type="text/javascript">

jQuery(".myselect").select2();
// add new row
jQuery(document).ready(function () {
    var counter = 2;

   jQuery("#addrow").on("click", function () {
        var newRow = jQuery("<tr>");
        var cols = "";

        cols +='<td><select class="myselect service_id form-control"  id="service_id_'+ counter + '" style="width: 200px;" data-placeholder="-- select your service --" name="service_id[]" onchange="service_cals('+counter+')"><?php $tbl_services= array_filter($tbl_services); foreach ($tbl_services as $service){  if($service->is_active==1){?>
          <option value="">--select--</option><option value="<?php echo $service->service_id;?>"><?php echo $service->service_name; }}?></option></select></td>';
        cols += '<td> <input type="number" name="qty[]" class="form-control text-right available_quantity_1" id="avl_qntt_' + counter + '" placeholder="0" value="1" min="1"onkeyup="quantity_calculate('+counter+')" onchange="quantity_calculate('+counter+');"></td>';
        cols += '<td><input type="number" id="product_rate_'+ counter + '" class="form-control text-right" readonly="readonly" onkeyup="quantity_calculate('+ counter +');" onchange="quantity_calculate('+ counter +');" name="service_rate[]"></td>';
        cols += '<td><input type="number" name="product_discount[]" onkeyup="quantity_calculate('+ counter +');" onchange="quantity_calculate('+ counter +');" id="product_discount_'+ counter +'" class="form-control text-right" value="" placeholder="0.00" min="0" aria-required="true"></td>';
        cols += '<td> <input class="total_price form-control text-right" type="text" name="product_price[]" id="total_' + counter + '" placeholder="0.00" readonly="readonly" onchange="quantity_calculate('+ counter +');" onkeyup="quantity_calculate('+ counter +');"></td>';    

         cols += '<input type="hidden" class="form-control all_discount" id="all_discount_' + counter + '" name="discount_amount[]">';

        cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger"  value="Delete"></td>';
        newRow.append(cols);
        jQuery("table.order-list").append(newRow);
        counter++;

        //  select input box 
      jQuery(".myselect").select2();
    });


    jQuery("table.order-list").on("click", ".ibtnDel", function (event) {
        jQuery(this).closest("tr").remove();       
        counter -= 1
    });


});
// end add_row


//====================quantity and service_rate
//////////////////////////////////////////////////////=========================
 function quantity_calculate(item) {
     var avl_qntt = jQuery('#avl_qntt_'+item).val(); 
     var product_rate = jQuery('#product_rate_'+item).val();
     var product_discount = jQuery("#product_discount_"+item).val();
     var total_discount = jQuery("#total_discount_" + item).val();
     var tax = jQuery("#tax").val();
      var total_amount=avl_qntt*product_rate;
      var dis = total_amount * product_discount / 100;
      var sttt =total_amount-dis ;
     jQuery('#total_'+item).val(total_amount);
     jQuery("#all_discount_" + item).val(dis);

     calculateSum();
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
        var tx =jQuery("#tax").val();

         var subTotal = st-sd;
         var tax=+tx+ +subTotal;
        jQuery("#subTotal").val(subTotal);
        jQuery("#grandTotal").val(tax);
    }


</script>

<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery('#create_date').datepicker({
  dateFormat: 'M-d-yy'
  });  

  jQuery('#expiry_date').datepicker({
  dateFormat: 'M-d-yy'
  });
});

</script>

<?php 
} 
function bdtaskcrm_add_customer_form(){?>
 <form action="" class="form-vertical"  enctype="multipart/form-data" accept-charset="utf-8" method = "post"  id="bookingform">

<!-- nonce security token  field-->
<?php wp_nonce_field("quotation_customer_action_nonce","quotation_customer_name_nonce");?>
<!-- nonce security token field -->

  <div class="modal fade" id="myModal_one" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><h2><?php echo esc_html('New Customer','bdtaskcrm');?></h2></h4>
        </div>
        <div class="modal-body">

            <div class="form-group">
            <label for="first_name"><?php echo esc_html('First Name:','bdtaskcrm');?><i class="text-danger">*</i></label>
            <input type="text" name="first_name" class="form-control" id="first_name">
            </div> 
            <div class="form-group">
            <label for="last_name"><?php echo esc_html('Last Name:','bdtaskcrm');?></label>
            <input type="text" name="last_name" class="form-control" id="last_name">
            </div>
            <div class="form-group">
            <label for="phone"><?php echo esc_html('Phone:','bdtaskcrm');?></label>
            <input type="text" name="phone" class="form-control" id="phone">
            </div>

            <div class="form-group">
            <label for="email"><?php echo esc_html('Email Address:','bdtaskcrm');?><i class="text-danger">*</i></label>
            <input type="email" name="email" class="form-control" id="email">
            </div>
            <div class="form-group">
            <label for="address"><?php echo esc_html('Address:','bdtaskcrm');?></label>
            <textarea class="form-control" cols="50" rows="5" id="address" name="address"></textarea>
            </div>
          
            <button type="submit" class="btn btn-success" name="customer_submit"><?php echo esc_html('Submit','bdtaskcrm');?></button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo esc_html('Close','bdtaskcrm');?></button>
        </div>
      </div>
      
    </div>
  </div>
</form>
<script type="text/javascript">
jQuery().ready(function(){ 
jQuery("#bookingform").validate({
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
</script>
<style type="text/css">
  .help-block{
    color: red;
    font-weight: 700;
  }
</style>
<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery('#dated').datepicker({
  dateFormat: 'yy-mm-dd'
  });
});

</script>
<?php 
}