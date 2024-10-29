<?php 
if ( ! defined( 'WPINC' ) ) {
  die;// Exit if accessed directly.
}
?>
<div class="wrap"> 
 <?php
 if(isset($_POST['cat_submit_for_delete'])):
  //=================== nonce Security verified checked======================= 

   if(isset( $_POST['delete_order_name_nonce'] ) && wp_verify_nonce($_POST['delete_order_name_nonce'], 'delete_order_action_nonce')){


//=================== nonce Security verified checked======================= 
global $order ;
$order= BDTASKCRM_Orders::bdtaskcrm_process_order_delete_data(); 
if( isset($order['action_status']) ):?> 

  <div class = "row">
    <div class = "col-sm-7">
      <?php if($order['action_status'] == 'delete_successfully'): ?>
        <script type="text/javascript">
         jQuery(document).ready(function() {
          alertify.set('notifier','position', 'top-right');
           alertify.success("<p><strong><?php esc_html_e('Delete Successfully','bdtaskcrm') ;?></strong></p>", 'custom', 2, function(){console.log('dismissed');});
          });
        </script> 
         <?php endif ; ?>
   </div><!-- end .col-sm-7 -->
 </div><!-- end .row -->
 <?php endif; }else{?>
  <p><strong> <?php esc_html_e('Your nonce is not  verified ! .','bdtaskcrm') ;?></strong></p>
<?php }endif ; ?>

<table class="table table-bordered textColorForAllPage" 
                        id = "displaysd">
                  <thead>
                    <tr>
                      <th><?php echo esc_html('SRL','bdtaskcrm');?></th> 
                      <th><?php echo esc_html('Order No','bdtaskcrm');?></th>
                      <th><?php echo esc_html('Name','bdtaskcrm');?></th>
                      <th><?php echo esc_html('Date:','bdtaskcrm');?></th>
                      <th><?php echo esc_html('Total Amount','bdtaskcrm');?></th>
                      <th><?php echo esc_html('Payment Status','bdtaskcrm');?></th>
                      <th><?php echo esc_html('Create By','bdtaskcrm');?></th>
                      <th><?php echo esc_html('Action','bdtaskcrm');?></th >
                    </tr>
                  </thead>
                  <tbody> 

            <?php 
						if(method_exists('BDTASKCRM_Orders','bdtaskcrm_process_order_select_data')) :
						global $wpdb ;
						$order= BDTASKCRM_Orders::bdtaskcrm_process_order_select_data();    
						$categories = $wpdb->get_results( $order['query']['select_all'], OBJECT ) ;
						endif ;
        
            $serial_no =1; 
             $categories= array_filter($categories);
            foreach ($categories as $order):
            if($order->order_type==2){
            ?>
                    <tr>
                      
                      <td><?php  echo esc_html($serial_no); ?></td>
                      <td><?php  echo esc_html($order->order_id); ?></td>
                      <td>
                        <?php echo esc_html($order->first_name.' '.$order->last_name); ?>
                      </td>
                      <td>
                      <?php 
                        $date=$order->create_date;
                        $create_date = date("M-d-y", strtotime($date));
                        echo esc_html($create_date);
                      ?></td>
                      <td><?php echo esc_html($order->grand_total);?></td>
                      <td>
                      <?php if($order->Order_status==1){ 
                        echo "<b style='color:#50BDE3;'>".esc_html('Draft','bdtaskcrm')."</b>";
                      }elseif($order->Order_status==2) {
                        echo "<b style='color:red;'>".esc_html('Unpaid','bdtaskcrm')."</b>";
                      }elseif($order->Order_status==3){
                      echo "<b style='color:blue;'>".esc_html('Partial Paid','bdtaskcrm')."</b>";
                      }elseif($order->Order_status==4){
                       echo "<b style='color:green;'>".esc_html('Paid','bdtaskcrm')."</b>";
                      }
                      ?>
                        
                      </td>
                      
                      <td><?php 
                      $create_bys=$order->create_by;
                      $us=get_user_by('id', $create_bys);
                      echo esc_html($us->user_nicename);
                      ?></td>
                      <td>
                        <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=bdtaskcrm_view_order&id='.$order->order_id),'bdtaskcrm_action_view', 'bdtaskcrm_order_view_nonce'); ?>" class="btn btn-success"  style="margin-top: 10px;"><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=bdtaskcrm_update_order&id='.$order->order_id),'bdtaskcrm_action_orders', 'bdtaskcrm_orders_nonce'); ?>" class="btn btn-success" style="margin-top: 10px;"><i class="glyphicon glyphicon-edit"></i></a>
                       <button type="button" class="btn btn-danger" data-toggle='modal' data-target='#delete<?php echo $order->order_id?>' style="margin-top: 10px;"><i class="glyphicon glyphicon-trash"></i></button>
                          <?php   bdtaskcrm_order_delete($order)?>
                      </td>
                       <?php }?>
                    </tr> 
                      <?php 
                        $serial_no++ ;
                        endforeach ;
                      ?>
                  </tbody>
                  <tfoot>
                    
                  </tfoot>
                </table>



  </div>
<?php 

function bdtaskcrm_order_delete($order){?>

   <div class="modal fade" id="delete<?php echo $order->order_id;?>" role="dialog">
    <div class="modal-dialog">

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo esc_html('Delete quations','bdtaskcrm');?></h4>
        </div>
        <div class="modal-body">
             <div class="row">
             <div class="col-md-12">
            <form method = "post" action = "">
             <input type="hidden" name="order_id" value="<?php echo $order->order_id;?>">

            <div class="row">
            <div class="col-sm-6 form-group">
             <?php echo esc_html(' Are you Sure you want to delete?','bdtaskcrm');?>
            </div>
            </div> 
            <div class="row">
            <div class="col-sm-12 form-group">
              <input type="submit" name="cat_submit_for_delete" class="btn btn-danger" value="Delete">
              <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo esc_html('Close','bdtaskcrm');?></button>
            </div>
            </div>

          <!-- nonce security token  field-->
          <?php wp_nonce_field("delete_order_action_nonce","delete_order_name_nonce");?>
          <!-- nonce security token field -->



            </form>
            </div>
            </div>

        </div>
      </div>
      
    </div>
    </div>
<?php 
}
?>  




               <script type="text/javascript">

                jQuery("#displaysd").DataTable({ 
                  dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp", 
                       "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],     
                  buttons: [ 
                            {extend: 'copy', className: 'btn-sm'},

                            {
                              extend: 'csv', 
                              title: 'Order',
                              className: 'btn-sm',
                              exportOptions: {columns:[0,1,2,3,4,5,6], modifier: {page: 'current'} }
                            },

                            {
                            extend: 'excel', 
                            title: 'Order',
                            className: 'btn-sm',
                            exportOptions: {columns:[0,1,2,3,4,5,6],modifier: {page: 'current'} }

                            }, 

                            {
                            extend: 'pdf', 
                            title: 'Order',
                            className: 'btn-sm',
                            exportOptions: { columns:[0,1,2,3,4,5,6],modifier: {page: 'current'} }
                            },

                           {
                            extend: 'print', className: 'btn-sm',
                            exportOptions: { columns:[0,1,2,3,4,5,6], modifier: { page: 'current'}}
                           } 

                     ]

                      });

              </script>
