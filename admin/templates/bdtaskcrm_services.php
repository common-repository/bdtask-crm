<?php 
if ( ! defined( 'WPINC' ) ) {
  die;// Exit if accessed directly.
}      
?>

<div class="wrap"> 

   <h2><?php echo esc_html('Services','bdtaskcrm');?></h2>
   <?php 
if(isset($_POST['cat_submit'])):

//=================== nonce Security verified checked======================= 

      if(isset( $_POST['service_name_nonce'] ) && wp_verify_nonce($_POST['service_name_nonce'], 'service_action_nonce')){

//=================== nonce Security verified checked======================= 
global $service ; 
      $service= BDTASKCRM_Services::bdtaskcrm_process_service_data(); 
      if( isset($service['action_status']) ):?> 

  <div class = "row">
    <div class = "col-sm-12">
      <?php if($service['action_status'] == 'no_error_data_save_successfully'): ?>
         <script type="text/javascript">
         jQuery(document).ready(function() {
          alertify.set('notifier','position', 'top-right');
           alertify.success("<p><strong><?php esc_html_e('Successfully added  your service','bdtaskcrm') ;?></strong></p>", 'custom', 2, function(){console.log('dismissed');});
          });
          </script>

        <?php elseif($service['action_status'] == 'something_is_error') : ?>
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
 if(isset($_POST['cat_submit_for_change'])):

//=================== nonce Security verified checked======================= 

      if(isset( $_POST['edit_service_name_nonce'] ) && wp_verify_nonce($_POST['edit_service_name_nonce'], 'edit_service_action_nonce')){

//=================== nonce Security verified checked======================= 


  $service= BDTASKCRM_Services::bdtaskcrm_process_service_update_data(); 
  if( isset($service['action_status']) ):?> 
  <div class = "row">
    <div class = "col-sm-12">
      <?php if($service['action_status'] == 'no_error_data_update_successfully'): ?>
        <script type="text/javascript">
         jQuery(document).ready(function() {
          alertify.set('notifier','position', 'top-right');
           alertify.success("<p><strong><?php esc_html_e('Updated your service','bdtaskcrm') ;?></strong></p>", 'custom', 2, function(){console.log('dismissed');});
          });
        </script>        
    <?php endif ; ?>
   </div><!-- end .col-sm-7 -->
 </div><!-- end .row -->
 <?php endif;}else{?>
<p><strong> <?php esc_html_e('Your nonce is not  verified ! .','bdtaskcrm') ;?></strong></p>

<?php }endif ; ?>

<?php
 if(isset($_POST['cat_submit_for_delete'])):

//=================== nonce Security verified checked======================= 

      if(isset( $_POST['delete_service_name_nonce'] ) && wp_verify_nonce($_POST['delete_service_name_nonce'], 'delete_service_action_nonce')){

//=================== nonce Security verified checked======================= 

      $service= BDTASKCRM_Services::bdtaskcrm_process_service_delete_data(); 
      if( isset($service['action_status']) ):?> 

  <div class = "row">
    <div class = "col-sm-12">
      <?php if($service['action_status'] == 'delete_successfully'): ?>
        <script type="text/javascript">
         jQuery(document).ready(function() {
          alertify.set('notifier','position', 'top-right');
           alertify.success("<p><strong><?php esc_html_e('Delete your service','bdtaskcrm') ;?></strong></p>", 'custom', 2, function(){console.log('dismissed');});
          });
        </script>       
         <?php endif ; ?>
   </div><!-- end .col-sm-7 -->
 </div><!-- end .row -->
 <?php endif;}else{?>
<p><strong> <?php esc_html_e('Your nonce is not  verified ! .','bdtaskcrm') ;?></strong></p>

<?php }endif ; ?>
<?php 

//============= active service and inactive service================
if(isset($_GET['active_id']) && isset($_GET['status'])):
       $active_id = intval( $_GET['active_id']  );
       $status = intval( $_GET['status']  );
       $acton = BDTASKCRM_Services::bdtaskcrm_service_action(  $active_id  ,  $status );
endif;  
if(isset($_GET['inactive_id']) && isset($_GET['status'])):
       $active_id = intval( $_GET['inactive_id']  );
       $status = intval( $_GET['status']  );
       $acton = BDTASKCRM_Services::bdtaskcrm_service_action(  $active_id  ,  $status );
endif;
?>

<div class="row">
    <div class='col-sm-12' >
      <div class="lead_button" style="display: inline-block;width: 100%">
          <div class='form-group' style="float: right;">
            <button type='button' class='btn btn-success' data-toggle='modal' data-target='#myModal' style="margin-top: 10px;"><i class='glyphicon glyphicon-plus'></i><?php echo esc_html('New service','bdtaskcrm');?></button>
          </div>
        </div>
    </div>
</div> 
<table class="table table-bordered textColorForAllPage" 
                        id = "displayservice">
                  <thead>
                    <tr>
                      <th><?php echo esc_html('SRL','bdtaskcrm');?></th> 
                      <th><?php echo esc_html('Service Name:','bdtaskcrm');?></th>
                      <th><?php echo esc_html('Service Rate:','bdtaskcrm');?></th>
                      <th><?php echo esc_html('Discount %:','bdtaskcrm');?></th>
                      <th><?php echo esc_html('Description','bdtaskcrm');?></th>
                      <th class="none"><?php echo esc_html('Status','bdtaskcrm');?></th >
                      <th><?php echo esc_html('Action','bdtaskcrm');?></th >
                    </tr>
                  </thead>
                  <tbody> 

                     <?php 
                     if(method_exists('BDTASKCRM_Services','bdtaskcrm_process_service_select_data')) :
                     global $wpdb ;
                     $service= BDTASKCRM_Services::bdtaskcrm_process_service_select_data();    
                     $categories = $wpdb->get_results( $service['query']['select_all'], OBJECT ) ;
                     endif ; 
                     $serial_no = 1; 
                      $categories= array_filter($categories);
                      
                     foreach ($categories as $cat):    
                     ?>
                    <tr>
                      
                      <td><?php esc_html_e($serial_no); ?></td>
                      <td>
                        <?php echo esc_html($cat->service_name); ?>
                      </td>
                      <td><?php echo esc_html('$'.$cat->service_rate);?></td>
                      <td><?php echo esc_html('$'.$cat->product_discount);?></td>
                      <td><?php echo esc_html($cat->description);?></td>
                     
                      <td>
                      
                       <?php $active=$cat->is_active;
                        $nonce= wp_create_nonce('active_deactive');
                         if($active==0){
                         ?>
                          <a class='btn btn-danger' style="margin-top:10px; " href="?page=bdtaskcrm_services&status=1&active_id=<?php echo $cat->service_id; ?>&_wpnonce=<?php echo $nonce; ?>">
                               <?php esc_html_e('Inactive','bdtaskcrm')?></a>
                          <?php } else{?>    
                               <a class='btn btn-success' style="margin-top:10px; " href="?page=bdtaskcrm_services&status=0&inactive_id=<?php echo $cat->service_id; ?>&_wpnonce=<?php echo $nonce; ?>">
                               <?php esc_html_e('Active','bdtaskcrm')?></a>
                         <?php }?>
                      </td>
                      <td>
                        <button type="button" class="btn btn-success" data-toggle='modal' data-target='#myModal<?php echo $cat->service_id ; ?>' style="margin-top: 10px;"><i class="glyphicon glyphicon-edit" data-toggle="tooltip" title="Edit Service"></i></button>

                         <?php  bdtaskcrm_edit_service_form($cat);?>

                       <button type="button" class="btn btn-danger" data-toggle='modal' data-target='#delete<?php echo $cat->service_id ; ?>' style="margin-top: 10px;"><i class="glyphicon glyphicon-trash" data-toggle="tooltip" title="Delete Service"></i></button>
                          <?php   bdtaskcrm_service_delete($cat)?>
                      </td>
                          
                    </tr> 
                    <?php 
                     $serial_no++;
                     endforeach ;
                    ?>
                  </tbody>
                  <tfoot>
                    
                  </tfoot>
                </table>


        <?php bdtaskcrm_add_service_form('4') ; ?>  

</div> 

<?php 
function bdtaskcrm_add_service_form($col_label){?>
 <form method = "post" action = "" id="service_form">


          <!-- nonce security token  field-->
          <?php wp_nonce_field("service_action_nonce","service_name_nonce");?>
          <!-- nonce security token field -->

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><h2><?php echo esc_html('New Service','bdtaskcrm');?></h2></h4>
        </div>
        <div class="modal-body">

            <div class="form-group">
            <label for="service_name"><?php echo esc_html('Service Name:','bdtaskcrm');?><i class="text-danger">*</i></label>
            <input type="text" name="service_name" class="form-control" id="service_name">
            </div> 

            <div class="form-group">
            <label for="service_rate"><?php echo esc_html('Service Rate:','bdtaskcrm');?><i class="text-danger">*</i></label>
            <input type="number" name="service_rate" class="form-control" id="service_rate">
            </div>

            <div class="form-group">
            <label for="product_discount"><?php echo esc_html('Service Discount %:','bdtaskcrm');?></label>
            <input type="number" name="product_discount" class="form-control" id="product_discount">
            </div>

            <div class="form-group">
            <label for="description"><?php echo esc_html('Service  Description:','bdtaskcrm');?></label>
            <textarea class="form-control" cols="50" rows="5" id="description" name="description"></textarea>
            </div>
          

           
            <button type="submit" class="btn btn-success run" name="cat_submit" id="submit"><?php echo esc_html('Submit','bdtaskcrm');?></button>
           
   


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo esc_html('Close','bdtaskcrm');?></button>
        </div>
      </div>
      
    </div>
  </div>
</form>
<script type="text/javascript">
  
jQuery().ready(function() {
jQuery("#service_form").validate({
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
  submitHandler: function(form) {
      jQuery(form).ajaxSubmit();
  },
    errorElement: 'span',
    errorClass: 'help-block', 
     rules: {

       service_name:{
          required: true,
        },
        service_rate: {
          required: true,
        },
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
<?php 
}
function bdtaskcrm_edit_service_form($cat){?>

   <div class="modal fade" id="myModal<?php echo $cat->service_id ; ?>" role="dialog">
    <div class="modal-dialog">

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo esc_html('Edit Service','bdtaskcrm');?></h4>
        </div>
        <div class="modal-body">
           <form method = "post" action = "">
             <input type="hidden" name="bdtaskcrm_service_nonce" value="<?php echo wp_create_nonce('bdtaskcrm-nonce'); ?>"/>
           <input type="hidden" name="service_id" value="<?php echo $cat->service_id;?>">
          <div class="row">
            <div class="col-md-12">
            <label for="service_name"><?php echo esc_html('Service Name:','bdtaskcrm');?><i class="text-danger">*</i></label>
            <input type="text" name="service_name" class="form-control" id="service_name" value="<?php echo esc_html($cat->service_name);?>">
          </div>
          </div>
          <br>
          <br> 
          <div class="row">
            <div class="col-md-12">
            <label for="service_rate"><?php echo esc_html('Service Rate','bdtaskcrm');?><i class="text-danger">*</i> &nbsp;:</label>
            <input type="number" name="service_rate" id="service_rate"  class="form-control" value="<?php echo esc_html($cat->service_rate);?>">
          </div>
          </div>
          <br>
          <br>          

        <div class="row">
            <div class="col-md-12">
            <label for="product_discount"><?php echo esc_html('Discount  % ');?>&nbsp;:</label>
            <input type="number" name="product_discount" id="product_discount"  class="form-control" value="<?php echo esc_html($cat->product_discount);?>">
          </div>
          </div>
          <br>
          <br>
          
          <div class="row">
            <div class="col-md-12">
            <textarea type="text" class="form-control" cols="70" rows="5" id="description" name="description" placeholder="Service Description"><?php echo esc_html($cat->description);?></textarea>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">
              <button type="submit" class="btn btn-success" name="cat_submit_for_change"><?php echo esc_html('Update','bdtaskcrm');?></button>
            </div>
          </div>
          <br><br>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo esc_html('Close','bdtaskcrm');?></button>
          </div>
          </div>

          <!-- nonce security token  field-->
          <?php wp_nonce_field("edit_service_action_nonce","edit_service_name_nonce");?>
          <!-- nonce security token field -->


          </form>
        </div>
     
      </div>
      
    </div>
    </div>
<?php 
}
?>

<?php 
function bdtaskcrm_service_delete($cat){?>

   <div class="modal fade" id="delete<?php echo $cat->service_id ; ?>" role="dialog">
    <div class="modal-dialog">

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo esc_html('Delete Service','bdtaskcrm');?></h4>
        </div>
        <div class="modal-body">
             <div class="row">
             <div class="col-md-12">
            <form method = "post" action = "">
               <input type="hidden" name="bdtaskcrm_service_nonce" value="<?php echo wp_create_nonce('bdtaskcrm-nonce'); ?>"/>
             <input type="hidden" name="service_id" value="<?php echo $cat->service_id;?>">

            <div class="row">
            <div class="col-sm-6 form-group">
             <?php echo esc_html('Are you Sure you want to delete?');?>
            </div>
            </div> 
            <div class="row">
            <div class="col-sm-12 form-group">
              <input type="submit" name="cat_submit_for_delete" class="btn btn-danger" value="Delete">
              <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo esc_html('Close','bdtaskcrm')?></button>
            </div>
            </div>



          <!-- nonce security token  field-->
          <?php wp_nonce_field("delete_service_action_nonce","delete_service_name_nonce");?>
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

                jQuery("#displayservice").DataTable({ 
                  dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp", 
                       "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],     
                  buttons: [ 
                            {extend: 'copy', className: 'btn-sm'},

                            {
                              extend: 'csv', 
                              title: 'Service',
                              className: 'btn-sm',
                              exportOptions: {columns:[0,1,2,3,4], modifier: {page: 'current'} }
                            },

                            {
                            extend: 'excel', 
                            title: 'Service',
                            className: 'btn-sm',
                            exportOptions: {columns:[0,1,2,3,4],modifier: {page: 'current'} }

                            }, 

                            {
                            extend: 'pdf', 
                            title: 'Service',
                            className: 'btn-sm',
                            exportOptions: { columns:[0,1,2,3,4],modifier: {page: 'current'} }
                            },

                           {
                            extend: 'print', className: 'btn-sm',
                            exportOptions: { columns:[0,1,2,3,4], modifier: { page: 'current'}}
                           } 

                     ]

   });
jQuery(document).ready(function(){
  jQuery('[data-toggle="tooltip"]').tooltip();   
});
              </script>
