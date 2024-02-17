<?php 
if ( !defined( 'ABSPATH' ) )  die;

if( !class_exists( 'ExpSettingsClass' ) ):

    class ExpSettingsClass
    {
        public function __construct()
        {
            add_shortcode( 'usuarios', [ $this, 'eits_user_shortcode' ] );
            add_action( 'wp_enqueue_scripts', [ $this, 'eits_add_scripts' ] );
            add_action( 'wp_ajax_eits_custom_search', [ $this, 'eits_custom_search' ] );
            add_action( 'wp_ajax_nopriv_eits_custom_search', [ $this, 'eits_custom_search' ] );
        }

        /**
         * create the shortcode
         *
         * @return void
         */
        public function eits_user_shortcode()
        {
            ob_start();
            wp_enqueue_script('custom_js');
            wp_enqueue_style( 'custom_css' );
            require_once EITS_PATH . '/inc/shortcode_view.php';
            return ob_get_clean();
        }

        /**
         * enqueue all scripts
         *
         * @return void
         */
        public function eits_add_scripts()
        {
            wp_register_script( 'custom_js', EITS_URL . '/assets/js/custom.js', ['jquery'], \filemtime( EITS_PATH . '/assets/js/custom.js' ), true );
            wp_register_style( 'custom_css', EITS_URL . '/assets/css/custom.css', [], \filemtime( EITS_PATH . '/assets/css/custom.css' ), 'all' );            
            wp_localize_script( 'custom_js', 'AJAX_URL', [
                'url' => admin_url('admin-ajax.php'),
            ] );
        }

        /**
         * make query to db
         *
         * @return void
         */
        public function eits_custom_search()
        {
            if( defined( 'DOING_AJAX' ) && DOING_AJAX ):
                global $wpdb;
                $filter = isset($_POST['filter']) ? sanitize_text_field( $_POST['filter'] ) : '';
                $search = isset($_POST['search']) ? sanitize_text_field( $_POST['search'] ) : '';
                $allowed_filters = ['nombre', 'apellido', 'apellido2', 'correo'];

                if(!in_array( $filter, $allowed_filters ) ):
                    wp_send_json_error( 'Filtro no valido' );
                endif;

                $table = $wpdb->prefix .'eits_table';
                $query = $wpdb->prepare(
                    "SELECT * FROM {$table} WHERE {$filter} LIKE %s",
                    '%' . $wpdb->esc_like($search) . '%'
                );
                $results = $wpdb->get_results( $query );
                wp_send_json( $results );
            endif;
            exit;
        }     

    }

endif;