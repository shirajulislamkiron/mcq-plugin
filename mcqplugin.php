<?php
/**
* Plugin Name: test-plugin
* Plugin URI: https://www.your-site.com/
* Description: Test.
* Version: 0.1
* Author: your-name
* Author URI: https://www.your-site.com/
**/
function my_custom_post_product() {
  $labels = array(
    'name'               => _x( 'Quizes', 'post type general name' ),
    'singular_name'      => _x( 'Product', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'book' ),
    'add_new_item'       => __( 'Add New Product' ),
    'edit_item'          => __( 'Edit Product' ),
    'new_item'           => __( 'New Product' ),
    'all_items'          => __( 'All Quiz' ),
    'view_item'          => __( 'View Product' ),
    'search_items'       => __( 'Search Products' ),
    'not_found'          => __( 'No products found' ),
    'not_found_in_trash' => __( 'No products found in the Trash' ), 
    'parent_item_colon'  => ’,
    'menu_name'          => 'Quizes'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'Holds our products and product specific data',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
    'has_archive'   => true,
  );
  register_post_type( 'product', $args ); 
}
add_action( 'init', 'my_custom_post_product' );




function my_taxonomies_product() {
  $labels = array(
    'name'              => _x( 'Quiz Categories', 'taxonomy general name' ),
    'singular_name'     => _x( 'Quiz Category', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Quiz Categories' ),
    'all_items'         => __( 'All Quiz Categories' ),
    'parent_item'       => __( 'Parent Quiz Category' ),
    'parent_item_colon' => __( 'Parent Quiz Category:' ),
    'edit_item'         => __( 'Edit Quiz Category' ), 
    'update_item'       => __( 'Update Quiz Category' ),
    'add_new_item'      => __( 'Add New Quiz Category' ),
    'new_item_name'     => __( 'New Quiz Category' ),
    'menu_name'         => __( 'Quiz Categories' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
  );
  register_taxonomy( 'product_category', 'product', $args );
}
add_action( 'init', 'my_taxonomies_product', 0 );

add_action( 'save_post', 'product_price_box_save' );
function product_price_box_save( $post_id ) {

  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
  return;

  if ( !wp_verify_nonce( $_POST['product_price_box_content_nonce'], plugin_basename( __FILE__ ) ) )
  return;

  if ( 'page' == $_POST['post_type'] ) {
    if ( !current_user_can( 'edit_page', $post_id ) )
    return;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
    return;
  }
  $product_price = $_POST['product_price'];
  update_post_meta( $post_id, 'product_price', $product_price );
}

?>
