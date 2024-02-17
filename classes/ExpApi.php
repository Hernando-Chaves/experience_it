<?php 
if (!defined('ABSPATH')) die;

if (!class_exists('ExpApi')) :

    class ExpApi extends WP_REST_Controller 
    {
        public function __construct() 
        {
            $this->namespace = 'eits/v1';
            $this->rest_base = 'user';
            add_action( 'rest_api_init', [$this, 'eits_register_routes'] );
        }
    
        /**
         * Create custom endpoint to show user json
         *
         * @return void
         */
        public function eits_register_routes() 
        {
            register_rest_route(
                $this->namespace,
                $this->rest_base,
                array(
                    array(
                        'methods'             => \WP_REST_Server::READABLE,
                        'callback'            => [ $this, 'eits_get_items' ],
                        'permission_callback' => [ $this, 'eits_get_route_access' ],
                    ),
                )
            );
        }
    
        /**
         * Set access
         *
         * @return void
         */
        public function eits_get_route_access() 
        {
            return true;
        }
    
        /**
         * Get data from table
         *
         * @return void
         */
        public function eits_get_items() 
        {
            global $wpdb;
    
            $table_name = $wpdb->prefix . 'eits_table';
            $query      = "SELECT * FROM $table_name";
            $results    = $wpdb->get_results( $query, ARRAY_A );
            
            if ( empty( $results ) ) {
                return new WP_REST_Response( array(), 200 );
            }
    
            return new WP_REST_Response( $results, 200 );
        }
    }
    
endif;