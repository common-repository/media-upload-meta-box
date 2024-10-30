<?php
/**
  * Plugin Name: Media Upload Meta Box
  * Plugin URI: http://mywebsiteadvisor.com/tools/wordpress-plugins/media-upload-meta-box/
  * Description: Adds a Meta Box for Drag and Drop Media Upload to the edit page/post screens
  * Version:  1.0.2
  * Author: MyWebsiteAdvisor
  * Author URI: http://MyWebsiteAdvisor.com/
  **/


class Media_Upload_Meta_Box{
	
		private $plugin_name = "";
	
	/**
	 * Initialize plugin
	 */
	public function __construct(){

		$this->plugin_name = basename(dirname( __FILE__ ));
		
		// add links for plugin help, donations,...
		add_filter('plugin_row_meta', array(&$this, 'add_plugin_links'), 10, 2);
			
		//hook onto add_meta_boxes action
		add_action( 'add_meta_boxes', array($this, 'add_media_upload_meta_boxes') );
  
	}
	

	
	
	/**
	 * Add links on installed plugin list
	 */
	public function add_plugin_links($links, $file) {
		if($file == plugin_basename( __FILE__ )) {
			$upgrade_url = 'http://mywebsiteadvisor.com/tools/wordpress-plugins/' . $this->plugin_name . '/';
			$links[] = '<a href="'.$upgrade_url.'" target="_blank" title="Click Here to Upgrade this Plugin!">Upgrade Plugin</a>';
			
			$install_url = admin_url()."plugins.php?page=MyWebsiteAdvisor";
			$links[] = '<a href="'.$install_url.'" target="_blank" title="Click Here to Install More Free Plugins!">More Plugins</a>';
			
			$rate_url = 'http://wordpress.org/support/view/plugin-reviews/' . $this->plugin_name . '?rate=5#postform';
			$links[] = '<a href="'.$rate_url.'" target="_blank" title="Click Here to Rate and Review this Plugin on WordPress.org">Rate This Plugin</a>';
		}
		
		return $links;
	}
	
	
	
	//build meta boxes
	function build_media_upload_meta_box(){
			global $post;
			
			wp_enqueue_script('plupload-handlers');
			
			$form_class='media-upload-form type-form validate';
			$post_id = $post->ID;
			$_REQUEST['post_id'] = $post_id;
			?>
			<style>#media-items { width: auto; }</style>
		
			<?php media_upload_form(); ?>
		
			<script type="text/javascript">
			var post_id = <?php echo $post_id; ?>;
			var shortform = 3;
			</script>
            
			
    
			<div id="media-items" class="hide-if-no-js"></div>
		
	 <?php	 
	 }
	  
	  
	//add meta boxes to post types
	function add_media_upload_meta_boxes(){
		
		if(current_user_can('upload_files')){
	
			$id = "image_upload";
			$title= "Upload Image";
			$callback = "build_media_upload_meta_box";
			$context = "side";
			$screens = array( 'post', 'page' );
			
			foreach ($screens as $screen) {
				add_meta_box(
					$id,
					__( $title, $id),
					array($this, $callback),
					$screen,
					$context
				);
			}
		}
	}


}

$media_upload_meta_box = new Media_Upload_Meta_Box;

 
?>