<?php
/**
 * Plugin Name:         Ultimate Member - Multi Step Registration Form
 * Description:         Extension to Ultimate Member for Multi Step Registration Form.
 * Version:             1.0.0
 * Requires PHP:        7.4
 * Author:              Miss Veronica
 * License:             GPL v3 or later
 * License URI:         https://www.gnu.org/licenses/gpl-2.0.html
 * Author URI:          https://github.com/MissVeronica
 * Text Domain:         ultimate-member
 * Domain Path:         /languages
 * UM version:          2.6.7
 */

if ( ! defined( 'ABSPATH' ) ) exit; 
if ( ! class_exists( 'UM' ) ) return;
 
class UM_Multi_Step_Registration {

    public $page_titles = array();

    function __construct() {

        add_shortcode( 'um_multi_step_registration',   array( $this, 'um_multi_step_registration' ));

        add_filter( 'um_core_fields_hook',             array( $this, 'um_core_fields_hook_multi_step' ), 10, 1 );
        add_filter( 'um_fields_without_metakey',       array( $this, 'um_fields_without_metakey_multi_step' ), 10, 1 ); 
        add_filter( 'um_edit_field_register_msr_page', array( $this, 'um_edit_field_register_page_metakey_multi_step' ), 10, 2 );
        add_action( 'um_after_form',                   array( $this, 'um_display_all_form_errors' ), 10, 1 );

    }

    public function um_display_all_form_errors( $args = array() ) {

        if ( ! empty( UM()->form()->errors ) ) {

            foreach ( UM()->form()->errors as $key => $error_text ) {
                echo UM()->fields()->field_error( $error_text );
            }
        }
    }

    public function um_edit_field_register_page_metakey_multi_step( $output, $data ) {

        if ( empty( $this->page_titles )) {
            $key = str_replace( ' ', '_', strtolower( $data['label'] ));
            $output .= '<section id="msr_page_' . esc_attr( $key ) . '" style="display:block">';

        } else {

            $key = str_replace( ' ', '_', strtolower( $data['label'] ));
            $output .= '</section>';
            $output .= '<section id="msr_page_' . esc_attr( $key ) . '" style="display:none">';
        }

        $this->page_titles[$key]['button'] = isset( $data['label'] ) ? $data['label'] : '';
        $this->page_titles[$key]['help']   = isset( $data['help'] )  ? $data['help']  : '';

        return $output;
    }

    public function um_core_fields_hook_multi_step( $core_fields ) {

        $core_fields['msr_page'] = array(
                            'name' => 'Page',
                            'col1' => array( '_title', '_page_text', '_visibility' ),
                            'col2' => array( '_label', '_help' ),
                            'form_only' => true,
                            'validate' => array(
                                '_title' => array(
                                    'mode' => 'required',
                                    'error' => __( 'You must provide a title','ultimate-member' )
                                ),
                                '_label' => array(
                                    'mode' => 'required',
                                    'error' => __( 'You must provide a label for the page button','ultimate-member' )
                                ),

                            )
                        );

        return $core_fields;
    }

    public function um_fields_without_metakey_multi_step( $fields_without_metakey ) {

        $fields_without_metakey[] = 'msr_page';
        return $fields_without_metakey;
    }

    public function um_multi_step_registration( $args = array(), $content = '' ) {

        if ( isset( $args['form_id'] )) {
            $form_id = trim( sanitize_text_field( $args['form_id'] ));

            if ( ! isset( $_REQUEST['message'] )) {

                if ( version_compare( get_bloginfo('version'),'5.4', '<' ) ) {
                    echo do_shortcode( '[ultimatemember form_id="' . $form_id . '"/]' );
                } else {
                    echo apply_shortcodes( '[ultimatemember form_id="' . $form_id . '"/]' );
                }

                echo '</section>';
                echo '<div class="um-center">';

                foreach( $this->page_titles as $key => $title ) { ?>
                    <button class="msk-button" title="<?php echo esc_attr( $title['help'] );?>" onclick="multi_step_page( '<?php echo esc_attr( $key ); ?>' )"><?php echo esc_attr( $title['button'] );?></button><?php
                }

                echo '</div>';
?>

<script>

var multi_step_page_last="<?php echo esc_attr( array_key_first( $this->page_titles ));?>";
function multi_step_page(id){

    var x = document.getElementById("msr_page_"+multi_step_page_last);
    x.style.display = "none";

    var x = document.getElementById("msr_page_"+id);    
    x.style.display = "block";
    multi_step_page_last=id;
};
</script>
<?php

            } else {
                echo do_shortcode( '[ultimatemember form_id="' . $form_id . '"]');
            }
        }
    }

}

new UM_Multi_Step_Registration();

