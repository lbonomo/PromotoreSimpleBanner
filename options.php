<?php

/* 
 * Este archivo contiene el codigo necesario para mostrar el menu y la pagina
 * de configuracion (dentro del panel de control de Wordpress)
 */

// Agrego el Menu "Ajustes -> Simple Banner"
function ptr_banner_custom_admin_menu() {
    add_options_page(
        __( 'Simple Banner (by Promotore)', 'ptr_banner' ), // page title
        __( 'Simple Banner', 'ptr_banner' ),                // menu title
        'manage_options',                                   // capability required to see the page
        'ptr_banner_options',                               // admin page slug, e.g. options-general.php?page=ptr_banner_options
        'ptr_banner_options_page'                           // callback function to display the options page options.php
    );
}
add_action( 'admin_menu', 'ptr_banner_custom_admin_menu' );

// La pagina de opsiones
function ptr_banner_options_page() {

    // Salvo el ID de la imagen
    if ( isset( $_POST['ptr_submit_image_selector'] ) && isset( $_POST['ptr_image_attachment_id'] ) ) :
        # Guardo el ID de la imagen en wp_options
        update_option( 'ptr_banner_id', absint( $_POST['ptr_image_attachment_id'] ) );
    endif;
        
    # Cargo todos los scripts, estilos, configuraciones y plantillas 
    # necesarias para usar todas las API de JavaScript de medios.
    # https://codex.wordpress.org/Function_Reference/wp_enqueue_media
    wp_enqueue_media();

    ?>
    <div style="">
        <h1>Simple Banner (by <a href="https://promotore.com.ar">Promotore</a>)</h1>
        <form method='post'>
            <div class='image-preview-wrapper'>
                    <img id='image-preview' src='<?php echo wp_get_attachment_url( get_option( 'ptr_banner_id' ) ); ?>' height='300'>
            </div>
            <input id="upload_image_button" type="button" class="button" value="Subir imagen" />
            <input type='hidden' name='ptr_image_attachment_id' id='ptr_image_attachment_id' value='<?php echo get_option( 'ptr_banner_id' ); ?>'>
            <input type='hidden' name='my_saved_attachment_post_id' id='my_saved_attachment_post_id' value='<?php echo $my_saved_attachment_post_id; ?>; ?>'>

            <input type="submit" name="ptr_submit_image_selector" value="Guardar" class="button-primary">
        </form>
    </div>
    <?php
 
}

# TODO
add_action( 'admin_enqueue_scripts', 'promotore_options_register_script' ); 
function promotore_options_register_script( $page ) { 
    
    $my_saved_attachment_post_id = get_option( 'ptr_banner_id', 0 );
    # Se ejecuta solo en la pagina options-general.php?page=ptr_banner_options
    # para evitar errores.
    if ($page == "settings_page_ptr_banner_options") {
        wp_enqueue_script( 'ptr_banner_script', plugins_url('assets/js/promotore.js' , __FILE__ ), array('jquery'), '0.1' );
    }
    
}

