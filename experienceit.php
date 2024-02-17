<?php 

/**
*
*Plugin Name:       Experience IT Solutions
*Plugin URI:        bogotawebcompany.com
*Description:       Plugin desarrollado para prueba de conocimientos de wordpress. 
*Version:           1.0.0
*Author:            Hernando j Chaves
*Author URI:        bogotawebcompany.com
*License:           GPL-2.0+
*License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
*Text Domain:       eits
*/

require_once __DIR__ . '/vendor/autoload.php';

if( !class_exists( 'Eits_run_app' ) ):

    final class Eits_run_app
    {
        public function __construct()
        {
            $this->eits_define_constants();
            add_action( 'plugins_loaded', [$this, 'eits_plugins_loaded'] );
            register_activation_hook( __FILE__, [ $this, 'eits_add_data' ] );
        }

        /**
         * Load all the classes
         *
         * @return void
         */
        public function eits_plugins_loaded()
        {
            new ExpSettingsClass();
            new ExpApi();
        }

        /**
         * load all the comnstants
         *
         * @return void
         */
        public function eits_define_constants()
        {
            $constants = [
                'EITS_DOMAIN'  => 'eits_',
                'EITS_VERSION' => '1.0.0',
                'EITS_PATH'    => untrailingslashit( plugin_dir_path( __FILE__ ) ),
                'EITS_URL'     => untrailingslashit( plugins_url( '/', __FILE__ ) ),
            ];   
            foreach( $constants as $constant => $value ):
                $this->eits_define( $constant, $value );
            endforeach;
        }

        /**
         * Define the constants to use them
         *
         * @param [type] $constant
         * @param [type] $value
         * @return void
         */
        public function eits_define( $constant, $value)
        {
            !defined($constant) ? define( $constant, $value ) : '';
        }

        public function eits_add_data()
        {
            new ExpActivated();
        }

        /**
         * Implement singleton pattern
         *
         * @return void
         */
        public static function eits_init()
        {
            static $instance = null;
            if( is_null( $instance ) ):
                $instance = new self();
            endif;
            return $instance;
        }
    }

    /**
     * Run the app
     *
     * @return void
     */
    function eits_run()
    {
        return Eits_run_app::eits_init();
    }
    eits_run();
endif;

