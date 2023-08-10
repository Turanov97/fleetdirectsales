<?php
global $listing_id;

$listing_id = ( is_null( $listing_id ) ) ? get_the_ID() : $listing_id;
?>

<div class="post-content">
    <?php echo do_shortcode('[custom_editor_output]'); ?>
</div>



<?php
//if ( function_exists( 'stm_get_listing_seller_note' ) ) {
//    echo wp_kses_post( stm_get_listing_seller_note( $listing_id ) );
//} else {
//    echo wp_kses_post( get_the_content( null, null, $listing_id ) );
//}
//?>
