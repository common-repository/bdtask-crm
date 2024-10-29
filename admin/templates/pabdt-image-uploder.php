<?php 
if ( ! defined( 'WPINC' ) ) {
	die;// Exit if accessed directly.
}
// Save attachment ID
if( isset( $_POST['submit_image_selector'] ) && 
    isset( $_POST['image_attachment_id'] ) ) :
  if(isset( $_POST['bdtaskcrm_name_nonce'] ) && wp_verify_nonce($_POST['bdtaskcrm_name_nonce'], 'bdtaskcrm_image_action_nonce')){
	update_option( 'media_selector_attachment_id', 
		           absint( $_POST['image_attachment_id'] ) );
  }else{?>
 <p><strong> <?php esc_html_e('Your nonce is not  verified ! .','bdtaskcrm') ;?></strong></p>
<?php    	
  }
endif;
wp_enqueue_media();?>
<div class="pabdt"> 
<form method='post'>		
          <!-- nonce security token  field-->
          <?php wp_nonce_field("bdtaskcrm_image_action_nonce","bdtaskcrm_name_nonce");?>
          <!-- nonce security token field -->
<div class='image-preview-wrapper'>
 <img id='image-preview'src='<?php echo wp_get_attachment_url( get_option( 'media_selector_attachment_id' ) ); ?>' style="margin-bottom:20px;height: 55px;">
</div>
<input id="upload_image_button" type="button" class="button" 
    value="<?php _e( 'Upload image' ); ?>" />
<input type='hidden' name='image_attachment_id' id='image_attachment_id'
      value='<?php echo get_option( 'media_selector_attachment_id' ); ?>'>
<input type="submit" name="submit_image_selector" value="Save" class="button-primary">
</form>
</div>
<?php
add_action( 'admin_footer', 'media_selector_print_scripts' );
remove_image_size( 'medium_large' );
function media_selector_print_scripts() {
$my_saved_attachment_post_id = get_option( 'media_selector_attachment_id', 0 );?>
<script type='text/javascript'>
		jQuery( document ).ready( function( $ ) {
			// Uploading files
			var file_frame;
			var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
			var set_to_post_id = <?php echo $my_saved_attachment_post_id; ?>; // Set this

			jQuery('#upload_image_button').on('click', function( event ){
				event.preventDefault();
				// If the media frame already exists, reopen it.
				if ( file_frame ) {
					// Set the post ID to what we want
					file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
					// Open frame
					file_frame.open();
					return;
				} else {
					// Set the wp.media post id so the uploader grabs the ID we want when initialised
					wp.media.model.settings.post.id = set_to_post_id;
				}
				// Create the media frame.
				file_frame = wp.media.frames.file_frame = wp.media({
					title: 'Upload your profile picture',
					button: {
						text: 'Use this image',
					},
					multiple: false	// Set to true to allow multiple files to be selected
				});
				// When an image is selected, run a callback.
				file_frame.on( 'select', function() {
					// We set multiple to false so only get one image from the uploader
					attachment = file_frame.state().get('selection').first().toJSON();
					// Do something with attachment.id and/or attachment.url here
					jQuery( '#image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
					jQuery( '#image_attachment_id' ).val( attachment.id );
					// Restore the main post ID
					wp.media.model.settings.post.id = wp_media_post_id;
				});
					// Finally, open the modal
					file_frame.open();
			});
			// Restore the main ID when the add media button is pressed
			jQuery( 'a.add_media' ).on( 'click', function() {
				wp.media.model.settings.post.id = wp_media_post_id;
			});
		});
	</script><?php
}