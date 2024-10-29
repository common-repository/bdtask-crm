<?php 
if ( ! defined( 'WPINC' ) ) {
	die;// Exit if accessed directly.
}
global $wpdb;

//======================nonce Security verified checked======================= 
if (!isset($_GET['bdtaskcrm_order_view_nonce']) || !wp_verify_nonce($_GET['bdtaskcrm_order_view_nonce'], 'bdtaskcrm_action_view')) {

echo esc_html("Your request is invalid !","bdtaskcrm");

}else{
$id=sanitize_text_field($_GET['id']);
 if(isset($_POST[$id])|| !empty($id)){

$table_name = $wpdb->prefix.'bdtaskcrm_order_tbl'; 
$bdtaskcrm_order_details = $wpdb->prefix.'bdtaskcrm_order_details'; 
$client_tbl = $wpdb->prefix .'bdtaskcrm_clients';
$bdtaskcrm_services = $wpdb->prefix .'bdtaskcrm_services';

$sql = "SELECT * FROM $client_tbl AS $client_tbl INNER JOIN $table_name AS $table_name ON $client_tbl.client_id =$table_name.client_id WHERE order_id=$id";
$update_qutation = $wpdb->get_results( $sql  , OBJECT ) ;

$sqld ="SELECT * FROM $bdtaskcrm_order_details AS $bdtaskcrm_order_details INNER JOIN $table_name AS $table_name ON $bdtaskcrm_order_details.order_id =$table_name.order_id Where $table_name.order_id =$id";
$order_details = $wpdb->get_results( $sqld  , OBJECT ) ;

?>

<div class="wrap">
	<section class="content">
	    	<!-- Alert Message -->
		            <div class="row">
	            <div class="col-sm-12">
	                <div class="panel panel-bd">
		                <div id="printableArea">
		                    <div class="panel-body">
		                    	<div class="row">
		                    		 <div class="col-sm-10" style="display:inline-block;width: 60%">
		                             <img id='image-preview'src='<?php echo wp_get_attachment_url( get_option( 'media_selector_attachment_id' ) ); ?>' style="margin-bottom:20px;height: 55px;">
		                            </div> 
		                            <div class="col-sm-2 text-left" style="display: inline-block;margin-left: 5px;float: right;">
		                            	<div class="m-t-0" style="font-weight:bold;font-size:20px;">
		                            		<?php if($update_qutation[0]->Order_status==1){?>
		                            		   <b style="color:#50BDE3;"><?php echo esc_html('Draft','bdtaskcrm');?></b>
		                            		
		                            		 	
		                            		<?php }elseif($update_qutation[0]->Order_status==2){ ?> <b style="color:red;"><?php echo esc_html('Unpaid','bdtaskcrm');?></b>
		                            	    <?php }elseif($update_qutation[0]->Order_status==3){?>
		                            	     <b style="color:blue;"><?php echo esc_html('Partially paid','bdtaskcrm');?></b>
		                            	    <?php }else{?><b style="color:green;"><?php echo esc_html('Paid','bdtaskcrm');?> </b>
		                            	    <?php }?></b>
		                            	    <br>
		                            		<?php echo esc_html('Invoice','bdtaskcrm');?>
		                            	</div>
		                                <div><?php echo esc_html('Invoice No:','bdtaskcrm');?> 
		                                <?php echo esc_html($update_qutation[0]->order_id);?>
		                                </div>
		                                <div class="m-b-15">
		                                <?php echo esc_html('Billing Date:','bdtaskcrm');?> 
		                                <?php echo esc_html($update_qutation[0]->create_date);?>
		                                </div>
	                                </div>
	                                
		                    	</div>
		                        <div class="row">
		                        	
		                            <div class="col-sm-10" style="display: inline-block;width:60%">
		                               <h4 style="font-weight:bold;"><?php echo esc_html('Billing From','bdtaskcrm');?></h4>
		                                <address style="margin-top:10px">
		                                    <strong> 
		                                    <?php echo esc_html( get_option('name_language'),'bdtaskcrm' );  ?>
		                                    </strong>
		                                    <br>
		                                    <?php echo esc_html(get_option('frontend_address'),'bdtaskcrm');?>
		                                    <br>
		                                    <abbr><?php echo esc_html('Mobile:','bdtaskcrm');?></abbr>
		                                    <?php echo esc_html(get_option('contact_language'),'bdtaskcrm')?><br>
		                                    <abbr><?php echo esc_html('Email:','bdtaskcrm');?></abbr> 
		                                    <?php echo esc_html(get_option('email_language','bdtaskcrm'));?>
		                                    <br>
		                                    <abbr><?php echo esc_html('Website:','bdtaskcrm');?></abbr> 
		                                   <?php echo esc_html(get_option('service_language'),'bdtaskcrm');?>
		                                </address>
		                            </div>
		                            
		                            <div class="col-sm-2 text-left" style="display: inline-block;float: right;">
		                                <h4 style="font-weight:bold;"><?php echo esc_html('Billing To','bdtaskcrm');?></h4>
	                                    <address style="margin-top:10px">
	                                        <strong>
	                                        <?php echo esc_html($update_qutation[0]->first_name.'   '.$update_qutation[0]->last_name);?>
	                                        </strong><br>
	                                        <abbr><?php echo esc_html('Address:','bdtaskcrm');?></abbr>
	                                        <c style="width: 10px;margin: 0px;padding: 0px;">
	                                         <?php echo esc_html($update_qutation[0]->address);?>
	                                        </c>
	                                        <br>
	                                        <abbr><?php echo esc_html('Mobile:','bdtaskcrm');?></abbr>
	                                        <?php echo esc_html($update_qutation[0]->phone);?> 
	                                        </br>
	                                        <abbr><?php echo esc_html('Email:','bdtaskcrm');?></abbr>
	                                        <?php echo esc_html($update_qutation[0]->email);?>
	                                    </address>
	                                    
		                            </div>
		                        </div> <hr>

		                        <div class="table-responsive m-b-20">
		                            <table class="table table-striped">
		                                <thead>
		                                    <tr>
		                                        <th><?php echo esc_html('SL.','bdtaskcrm');?></th>
		                                        <th><?php echo esc_html('Service Name','bdtaskcrm');?></th>
		                                        <th><?php echo esc_html('Qnty','bdtaskcrm');?></th>
		                                        <th><?php echo esc_html('Rate','bdtaskcrm');?></th>
		                                        <th><?php echo esc_html('Dis/ Pcs','bdtaskcrm');?></th>
		                                        <th><?php echo esc_html('Amount','bdtaskcrm');?></th>
		                                    </tr>
		                                </thead>
		                                <tbody>
										<?php 
										$i=0;
										$order_details=array_filter($order_details);
										foreach ($order_details as $key => $value) {
                                
										// service table  use  here	
	                                    $ids =$value->service_id;
										$sqld ="SELECT * FROM $bdtaskcrm_services  Where service_id =$ids";
										$service_name = $wpdb->get_results( $sqld  , OBJECT ) ;
	                                    $dis = $value->product_discount;
	                                    $rate = $value->service_rate;
	                                    $al_dis = $rate*$dis/100;
										?>
											<tr>
		                                    	<td style="width:10%;"><?php echo ++$i;?></td>
		                                        <td ><strong><?php echo esc_html($service_name[0]->service_name);?></strong></td>
		                                        <td style="width:15%;"><?php echo esc_html($value->qty);?></td>
		                                        <td style="width:25%;">$<?php echo esc_html($value->service_rate);?></td>
		                                        <td style="width:20%;">$<?php echo esc_html($al_dis);?>(<?php echo esc_html($dis);?>%)</td>
		                                        <td style="text-align:right;">$<?php echo esc_html($value->product_price);?> </td>
		                                    </tr>
		                                <?php }?>    
		                                    
		                                </tbody>
		                            </table>
		                        </div>
		                        <div class="row">
			                        <div class="col-sm-12">
			                        	<div class="" style="width: 70%;float: left">
			                                <p> <?php 
			                                echo esc_html($update_qutation[0]->special_instruction);
			                               ?></p>
			                            </div>

			                            <div class="" style="width:30%;float: right;">

					                    <table class="table">
					                            <tbody>
					                            	<tr>
				                            		<th style="border-top: 0; border-bottom: 0;"><?php echo esc_html('Total Discount :','bdtaskcrm');?> </th>
				                            		<td style="border-top: 0; border-bottom: 0;text-align:right;">$<?php echo esc_html($update_qutation[0]->discount);?></td>
				                            	</tr>
					                            															                            
				                            	<tr>
				                            		<th class="grand_total"><?php echo esc_html('Sub Total :','bdtaskcrm');?></th>
				                            		<td class="grand_total" style="text-align:right;">$<?php echo esc_html($update_qutation[0]->subTotal);?></td>
				                            	</tr>
				                            	<tr>
				                            		<th style="border-top: 0; border-bottom: 0;"><?php echo esc_html('Tax :','bdtaskcrm');?> </th>
				                            		<td style="border-top: 0; border-bottom: 0;text-align:right;">$<?php echo esc_html($update_qutation[0]->tax);?></td>
				                            	</tr>				 
					                             <tr>
				                            		<th><?php echo esc_html('Grand Total :','bdtaskcrm');?> </th>
				                            		<td style="text-align:right;">$<?php echo esc_html($update_qutation[0]->grand_total);?></td>
				                            	</tr>
				                            	 <tr>
				                            		<th><?php echo esc_html('Paid Amount:','bdtaskcrm');?> </th>
				                            		<td style="text-align:right;">$<?php echo  esc_html($update_qutation[0]->paid_amnt);?></td>
				                            	</tr> 
				                            	<tr>
				                            		<th><?php echo esc_html('Due Amount:','bdtaskcrm');?> </th>
				                            		<td style="text-align:right;">$<?php echo esc_html($update_qutation[0]->due);?></td>
				                            	</tr>
				                            </tbody>
				                         </table>

			                            <div style="float:left;width:90%;text-align:center;border-top:1px solid #000;margin-top: 100px;font-weight: bold;">

										<?php echo esc_html(get_option('authorize_name'),'bdtaskcrm');?>										
										</div>
			                            </div>
			                        </div>
		                        </div>
		                    </div>
		                </div>

	                     <div class="panel-footer text-left">
							<a class="btn btn-info" href="#" onclick="printDiv('printableArea')"><span class="fa fa-print"></span>
							</a>
	                    </div>
	                </div>
	            </div>
	        </div>
	</section>
</div>
<script type="text/javascript">
	function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    // document.body.style.marginTop="-45px";
    window.print();
    document.body.innerHTML = originalContents;
}
</script>
<?php }else{
?>
<p><strong> <?php esc_html_e('Your request is Invalid! .','bdtaskcrm') ;?></strong></p>
<?php 
}
}