<?php 
if ( ! defined( 'WPINC' ) ) {
  die;// Exit if accessed directly.
}
?>
<div class="wrap"> 

   <h2><?php echo esc_html('Leads','bdtaskcrm');?></h2>
   <?php 
if(isset($_POST['cat_submit'])):


//======================nonce Security verified checked======================= 
 
 if(isset( $_POST['lead_name_nonce'] ) && wp_verify_nonce($_POST['lead_name_nonce'], 'lead_action_nonce')){

//==================nonce security verified checked=============== 
global $category ; 

      $category = BDTASKCRM_Leads::bdtaskcrm_process_category_data(); 
      if( isset($category['action_status']) ):?> 

  <div class = "row">
    <div class = "col-sm-12" style="display:block;">
      <?php if($category['action_status'] == 'no_error_data_save_successfully'): ?>         
        <script type="text/javascript">
         jQuery(document).ready(function() {
          alertify.set('notifier','position', 'top-right');
        
           alertify.success("<p><strong><?php esc_html_e('Successfully added  your lead','bdtaskcrm') ;?></strong></p>", 'custom', 2, function(){console.log('dismissed');});
          });
        </script>

        <?php elseif($category['action_status'] == 'something_is_error') : ?>
        <script type="text/javascript">
         jQuery(document).ready(function() {
          alertify.set('notifier','position', 'top-right');
           alertify.error("<p><strong> <?php esc_html_e('You are already exist or Some thing is Error . Please try again ! .','bdtaskcrm') ;?></strong></p>", 'custom', 2, function(){console.log('dismissed');});
          });
        </script>  
       

     <?php endif ; ?>
   </div><!-- end .col-sm-7 -->
 </div><!-- end .row -->
 <?php endif; ?>
<?php 
}else{?>
<p><strong> <?php esc_html_e('Your nonce is not  verified ! .','bdtaskcrm') ;?></strong></p>
<?php 
}
endif ; ?>

<?php
 if(isset($_POST['cat_submit_for_change'])):



  //======================nonce Security verified checked================================ 

    if(isset( $_POST['edit_lead_name_nonce'] ) && wp_verify_nonce($_POST['edit_lead_name_nonce'], 'edit_lead_action_nonce')){


  //=============================== nonce Security verified checked================== 


      $category = BDTASKCRM_Leads::bdtaskcrm_process_category_update_data(); 
      if( isset($category['action_status']) ):?> 

  <div class = "row">
    <div class = "col-sm-12">
      <?php if($category['action_status'] == 'no_error_data_update_successfully'): ?>
        <script type="text/javascript">
         jQuery(document).ready(function() {
          alertify.set('notifier','position', 'top-right');
           alertify.success("<p><strong><?php esc_html_e('Successfully updated  your lead','bdtaskcrm') ;?></strong></p>", 'custom', 2, function(){console.log('dismissed');});
          });
        </script>
         <?php endif ; ?>
   </div><!-- end .col-sm-7 -->
 </div><!-- end .row -->
 <?php endif;
}else{?>
<p><strong> <?php esc_html_e('Your nonce is not  verified ! .','bdtaskcrm') ;?></strong></p>

<?php 
}
 endif ; 
?>

<?php
 if(isset($_POST['cat_submit_for_delete'])):

//=================== nonce Security verified checked======================= 


    if(isset( $_POST['delete_lead_name_nonce'] ) && wp_verify_nonce($_POST['delete_lead_name_nonce'], 'delete_lead_action_nonce')){



//================== nonce Security verified checked======================  

      $category = BDTASKCRM_Leads::bdtaskcrm_process_category_delete_data(); 
      if( isset($category['action_status']) ):?> 

  <div class = "row">
    <div class = "col-sm-7">
      <?php if($category['action_status'] == 'delete_successfully'): ?>
            
        <script type="text/javascript">
         jQuery(document).ready(function() {
          alertify.set('notifier','position', 'top-right');
           alertify.success("<p><strong><?php esc_html_e('Delete successful','bdtaskcrm') ;?></strong></p>", 'custom', 2, function(){console.log('dismissed');});
          });
        </script>

         <?php endif ; ?>
   </div><!-- end .col-sm-7 -->
 </div><!-- end .row -->
 <?php endif;
}else{ ?>
<p><strong> <?php esc_html_e('Your nonce is not  verified ! .','bdtaskcrm') ;?></strong></p>
<?php 
}
endif ; ?>


<?php
 if(isset($_POST['conver_customer'])):
      $category = BDTASKCRM_Leads::bdtaskcrm_process_convert_customer(); 
      if( isset($category['action_status']) ):?> 

  <div class = "row">
    <div class = "col-sm-7">
      <?php if($category['action_status'] == 'no_error_data_update_successfully'): ?>
        
        <script type="text/javascript">
         jQuery(document).ready(function() {
          alertify.set('notifier','position', 'top-right');
           alertify.success("<p><strong><?php esc_html_e('Convert successful','bdtaskcrm') ;?></strong></p>", 'custom', 2, function(){console.log('dismissed');});
          });
        </script>   
<script>
window.location = "<?php echo admin_url('admin.php?page=bdtaskcrm_customer');?>";
</script>
                   
         <?php endif ; ?>
   </div><!-- end .col-sm-7 -->
 </div><!-- end .row -->
 <?php endif; ?>
<?php endif ; ?>

<?php 
  if(isset($_GET['active_id']) && isset($_GET['status'])):
       $active_id = intval( $_GET['active_id']  );
       $status = intval( $_GET['status']  );
       $acton = BDTASKCRM_Leads::bdtaskcrm_mas_booking_action(  $active_id  ,  $status );
endif;  
if(isset($_GET['inactive_id']) && isset($_GET['status'])):
       $active_id = intval( $_GET['inactive_id']  );
       $status = intval( $_GET['status']  );
       $acton = BDTASKCRM_Leads::bdtaskcrm_mas_booking_action(  $active_id  ,  $status );
endif;      

?>

<div class="row">
    <div class='col-sm-12' >
      <div class="lead_button" style="display: inline-block;width: 100%">
          <div class='form-group' style="float: right;">
            <button type='button' class='btn btn-success' data-toggle='modal' data-target='#myModal' style="margin-top: 10px;"><i class='glyphicon glyphicon-plus'></i><?php echo esc_html('New Lead','bdtaskcrm');?></button>
          </div>
        </div>
    </div>
</div> 
  <form action="" method="post" class="conver_customer">
<table class="table table-bordered textColorForAllPage" 
                        id = "displaysd">
                  <thead>
                    <tr>
                      <th><?php echo esc_html('SRL','bdtaskcrm');?></th> 
                      <th><?php echo esc_html('Name','bdtaskcrm');?></th>
                      <th><?php echo esc_html('Email','bdtaskcrm');?></th>
                      <th><?php echo esc_html('Phone','bdtaskcrm');?></th>
                      <th><?php echo esc_html('Address','bdtaskcrm')?></th >
                      <th><?php echo esc_html('Create By','bdtaskcrm');?></th>
                      <th ><?php echo esc_html('Create Date','bdtaskcrm');?></th>
                      <th class="none"><?php echo esc_html('Status','bdtaskcrm');?></th>
                      <th><?php echo esc_html('Action','bdtaskcrm');?></th>
                    </tr>
                  </thead>
                  <tbody> 
                       
                     <?php 
                        if(method_exists('BDTASKCRM_Leads','bdtaskcrm_process_category_select_data')) :
                        global $wpdb ;
                        $category = BDTASKCRM_Leads::bdtaskcrm_process_category_select_data();    
                        $categories = $wpdb->get_results( $category['query']['select_all'], OBJECT ) ;
                        endif ;
                          
                        $serial_no = 0;
                        $categories= array_filter($categories); 
                        foreach ($categories as $cat):
                        if($cat->client_type==1){?>
                    <tr>
                      
                      <td><?php echo esc_html(++$serial_no); ?></td>
                      <td>
                        <?php echo esc_html($cat->first_name.' '.$cat->last_name); ?>
                      </td>
                      <td><?php echo esc_html($cat->email);?></td>
                      <td><?php echo esc_html($cat->phone);?></td>
                      <td><?php echo esc_html($cat->address);?></td>
                      
                      <td><?php 
                      $create_bys=$cat->create_by;
                      $us=get_user_by('id', $create_bys);
                      echo esc_html($us->user_nicename);
                      ?></td>
                      <td >
                        <?php 
                        $date=$cat->createDate;
                        $create_date = date("M-d-Y", strtotime($date));
                        echo esc_html($create_date);
                      ?>
                      </td>
                      <td>
                        <?php $active=$cat->is_active;
                          $nonce= wp_create_nonce('active_deactive');
                         if($active==0){
                         ?>
                          <a class='btn btn-danger' style="margin-top:10px; " href="?page=bdtaskcrm_invoice&status=1&active_id=<?php echo $cat->client_id; ?>&_wpnonce=<?php echo $nonce; ?>">
                               <?php esc_html_e('Inactive','bdtaskcrm')?></a>
                          <?php } else{?>    
                               <a class='btn btn-success' style="margin-top:10px; " href="?page=bdtaskcrm_invoice&status=0&inactive_id=<?php echo $cat->client_id; ?>&_wpnonce=<?php echo $nonce; ?>">
                               <?php esc_html_e('Active','bdtaskcrm')?></a>
                         <?php }?>
                      </td>
                      <td>
                      
                        <button type="submit" class="btn btn-warning "  data-toggle="tooltip" title="Convert To Customer!" name="conver_customer" style="margin-top:10px; "><i class="glyphicon glyphicon-check"></i></button> 
                      

                        <button type="button" class="btn btn-success" data-toggle='modal' data-target='#myModal<?php echo $cat->client_id ; ?>' style="margin-top: 10px;"><i class="glyphicon glyphicon-edit " data-toggle="tooltip" title="Edit Lead"></i></button>

                         <?php  bdtaskcrm_edit_lead_form($cat);?>

                       <button type="button" class="btn btn-danger" data-toggle='modal' data-target='#delete<?php echo $cat->client_id ; ?>' style="margin-top: 10px;"><i class="glyphicon glyphicon-trash" data-toggle="tooltip" title="Delete Lead"></i></button>
                          <?php   bdtaskcrm_lead_delete($cat)?>
                      </td>
                          
                       <?php }?>
                    </tr> 
                        <?php 
                        endforeach ;
                        ?>
                  </tbody>
                  <tfoot>
                  
                  </tfoot>
                </table>
 </form>

        <?php bdtaskcrm_add_category_form('4') ; ?>  
</div> 

<?php 
function bdtaskcrm_add_category_form($col_label){

?>
 <form method = "post" action = ""  id="bookingform">

<!-- nonce security token  field-->
<?php wp_nonce_field("lead_action_nonce","lead_name_nonce");?>
<!-- nonce security token field -->

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><h2><?php echo esc_html('New Lead','bdtaskcrm');?></h2></h4>
        </div>
        <div class="modal-body">

            <div class="form-group">
            <label for="first_name"><?php echo esc_html('First Name:','bdtaskcrm');?><i class="text-danger">*</i></label>
            <input type="text" name="first_name" class="form-control"  minlength="2" id="first_name" >
           
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
            <textarea class="form-control" cols="50" rows="5" id="address" name="address">
            </textarea>
            </div>
           
            <button type="submit" class="btn btn-success" name="cat_submit"><?php echo esc_html('Submit','bdtaskcrm');?></button>
   


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo esc_html('Close','bdtaskcrm');?></button>
        </div>
      </div>
      
    </div>
  </div>
</form>

<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery('#date').datepicker({
  dateFormat: 'yy-mm-dd'
  });
});


//insert validation 
jQuery().ready(function() {
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

<?php 
}
function bdtaskcrm_edit_lead_form($cat){?>

   <div class="modal fade" id="myModal<?php echo $cat->client_id ; ?>" role="dialog">
    <div class="modal-dialog">

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo esc_html('Edit Lead','bdtaskcrm');?></h4>
        </div>
        <div class="modal-body">
           <form method = "post" action = "" id="editbookingform"> 
          
           <input type="hidden" name="client_id" value="<?php echo $cat->client_id ; ?>">
            <div class="row">
            <div class="col-md-12">
            <label for="first_name"><?php echo esc_html('First Name:','bdtaskcrm');?></label>
            <input type="text" name="first_name" class="form-control" id="first_name" value="<?php echo esc_html($cat->first_name);?>">
            <label for="last_name"><?php echo esc_html('Last Name:','bdtaskcrm');?></label>
            <input type="text" name="last_name" id="last_name"  class="form-control" value="<?php echo esc_html($cat->last_name);?>" required>
          </div>
          </div>
          <br>
          <br>
          <div class="row">
           <div class="col-md-12">
            <label for="phone"><?php echo esc_html('Phone No:','bdtaskcrm');?></label>
            <input type="text" name="phone" id="phone" value="<?php echo esc_html($cat->phone);?>" class="form-control">
            &nbsp;&nbsp;
            <label for="email"><?php echo esc_html('Email :','bdtaskcrm');?></label>
            <input type="email" name="email" class="form-control" id="email" value="<?php echo esc_html($cat->email);?>" required>
          </div>
          </div>
         
           <br>
           <br>
          <div class="row">
            <div class="col-md-12">
            <textarea type="text" class="form-control" cols="70" rows="5" id="address" name="address" placeholder="Lead Address"><?php echo esc_html($cat->address);?>
            </textarea>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">
              <button type="submit" class="btn btn-success" name="cat_submit_for_change"><?php echo esc_html('Update');?></button>
            <?php if($cat->client_type==1):?> 
             <button type="submit" class="btn btn-warning " name="conver_customer"><?php echo esc_html('Convert To Customer','bdtaskcrm');?></button>
              <?php endif;?>

            </div>
          </div>
          </form>
          <br><br>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo esc_html('Close','bdtaskcrm');?></button>
          </div>
          </div>
             
          <!-- nonce security token  field-->
          <?php wp_nonce_field("edit_lead_action_nonce","edit_lead_name_nonce");?>
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
function bdtaskcrm_lead_delete($cat){?>

   <div class="modal fade" id="delete<?php echo $cat->client_id ; ?>" role="dialog">
    <div class="modal-dialog">

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo esc_html('Delete Lead','bdtaskcrm');?></h4>
        </div>
        <div class="modal-body">
             <div class="row">
             <div class="col-md-12">
            <form method = "post" action = "">

             <input type="hidden" name="client_id" value="<?php echo $cat->client_id;?>">

            <div class="row">
            <div class="col-sm-6 form-group">
              <?php echo esc_html('Are you Sure you want to delete?','bdtaskcrm');?>
            </div>
            </div> 
            <div class="row">
            <div class="col-sm-12 form-group">
              <input type="submit" name="cat_submit_for_delete" class="btn btn-danger" value="Delete">

              <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo esc_html('Close','bdtaskcrm');?></button>
            </div>
            </div>
            
          <!-- nonce security token  field-->
          <?php wp_nonce_field("delete_lead_action_nonce","delete_lead_name_nonce");?>
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
jQuery(document).ready(function(){
  jQuery('#datef').datepicker({
  dateFormat: 'yy-mm-dd'
  });
});
jQuery(document).ready(function(){
  jQuery('[data-toggle="tooltip"]').tooltip();   
});
</script>

               <script type="text/javascript">

                jQuery("#displaysd").DataTable({ 
                  dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp", 
                       "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],     
                  buttons: [ 
                            {extend: 'copy', className: 'btn-sm'},

                            {
                              extend: 'csv', 
                              title: 'Lead',
                              className: 'btn-sm',
                              exportOptions: {columns:[0,1,2,3,4,5,6,7], modifier: {page: 'current'} }
                            },

                            {
                            extend: 'excel', 
                            title: 'Lead',
                            className: 'btn-sm',
                            exportOptions: {columns:[0,1,2,3,4,5,6,7],modifier: {page: 'current'} }

                            }, 

                            {
                            extend: 'pdf', 
                            title: 'Lead',
                            className: 'btn-sm',
                            exportOptions: { columns:[0,1,2,3,4,5,6,7],modifier: {page: 'current'} }
                            },

                           {
                            extend: 'print',className: 'btn-sm',
                            exportOptions: {columns:[0,1,2,3,4,5,6,7], modifier: { page: 'current'}}
                           } 

                     ]

                      });



              </script>

