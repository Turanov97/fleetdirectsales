<?php


function add_custom_editor_metabox()
{
    add_meta_box(
        'custom_editor_metabox',
        'Descriptions',
        'render_custom_editor_metabox',
        'listings', // Здесь указываем тип записей, к которому применяется метабокс
        'normal',
        'high'
    );
}

add_action('add_meta_boxes', 'add_custom_editor_metabox');

function render_custom_editor_metabox($post)
{
    $editor1_content = get_post_meta($post->ID, '_custom_editor1_content', true);
    $editor2_content = get_post_meta($post->ID, '_custom_editor2_content', true);
    $editor3_content = get_post_meta($post->ID, '_custom_editor3_content', true);

    wp_nonce_field('custom_editor_nonce', 'custom_editor_nonce');
    ?>
    <div class="custom-editor-tabs">
        <ul class="tab-buttons">
            <li><a href="#tab1"><?php esc_html_e('Chassis', 'motors-child'); ?></a></li>
            <li><a href="#tab2"><?php esc_html_e('Horse Area', 'motors-child'); ?></a></li>
            <li><a href="#tab3"><?php esc_html_e('Living Area', 'motors-child'); ?></a></li>
        </ul>

        <div class="tab-content" id="tab1">
            <?php
            wp_editor(
                $editor1_content,
                'custom_editor1_content',
                array(
                    'media_buttons' => true,
                    'textarea_name' => 'custom_editor1_content',
                    'textarea_rows' => 10,
                )
            );
            ?>
        </div>

        <div class="tab-content" id="tab2">
            <?php
            wp_editor(
                $editor2_content,
                'custom_editor2_content',
                array(
                    'media_buttons' => true,
                    'textarea_name' => 'custom_editor2_content',
                    'textarea_rows' => 10,
                )
            );
            ?>
        </div>

        <div class="tab-content" id="tab3">
            <?php
            wp_editor(
                $editor3_content,
                'custom_editor3_content',
                array(
                    'media_buttons' => true,
                    'textarea_name' => 'custom_editor3_content',
                    'textarea_rows' => 10,
                )
            );
            ?>
        </div>
    </div>
    <?php
}


function save_custom_editor_content($post_id)
{

    if (!isset($_POST['custom_editor_nonce']) || !wp_verify_nonce($_POST['custom_editor_nonce'], 'custom_editor_nonce')) {
        return;
    }

    if (isset($_POST['custom_editor1_content'])) {
        update_post_meta($post_id, '_custom_editor1_content', wp_kses_post($_POST['custom_editor1_content']));
    }

    if (isset($_POST['custom_editor2_content'])) {
        update_post_meta($post_id, '_custom_editor2_content', wp_kses_post($_POST['custom_editor2_content']));
    }

    if (isset($_POST['custom_editor3_content'])) {
        update_post_meta($post_id, '_custom_editor3_content', wp_kses_post($_POST['custom_editor3_content']));
    }
}

add_action('save_post', 'save_custom_editor_content');


function custom_editor_output_shortcode($atts)
{
    // Получаем ID текущей записи
    $post_id = get_the_ID();

    // Получаем значения метаполей
    $seller_not = wp_kses_post(stm_get_listing_seller_note($post_id));
    $editor1_content = get_post_meta($post_id, '_custom_editor1_content', true);
    $editor2_content = get_post_meta($post_id, '_custom_editor2_content', true);
    $editor3_content = get_post_meta($post_id, '_custom_editor3_content', true);

    write_log($seller_not);
    write_log($editor1_content);
    write_log($editor2_content);
    write_log($editor3_content);

    // Возвращаем HTML-код с вкладками и содержимым
    $output = '<div class="custom-editor-tabs">';
    $output .= '<ul class="tab-buttons">';

    if (!empty($seller_not)) {
        $output .= '<li><a href="#tab1">General Spec</a></li>';
    }
    if (!empty($editor1_content)) {
        $output .= '<li><a href="#tab2">Chassis</a></li>';
    }
    if (!empty($editor2_content)) {
        $output .= '<li><a href="#tab3">Horse Area</a></li>';
    }
    if (!empty($editor3_content)) {
        $output .= '<li><a href="#tab4">Living Area</a></li>';
    }

    $output .= '</ul>';
    if (!empty($seller_not)) {
        $output .= '<div class="tab-content" id="tab1">' . wpautop($seller_not) . '</div>';
    }
    if (!empty($editor1_content)) {
        $output .= '<div class="tab-content" id="tab2">' . wpautop($editor1_content) . '</div>';
    }
    if (!empty($editor2_content)) {
        $output .= '<div class="tab-content" id="tab3">' . wpautop($editor2_content) . '</div>';
    }
    if (!empty($editor3_content)) {
        $output .= '<div class="tab-content" id="tab4">' . wpautop($editor3_content) . '</div>';
    }

    $output .= '</div>';

    return $output;
}

add_shortcode('custom_editor_output', 'custom_editor_output_shortcode');
