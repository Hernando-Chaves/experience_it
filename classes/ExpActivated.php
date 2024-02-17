<?php
if (!defined('ABSPATH')) die;

if (!class_exists('ExpActivated')) :

    class ExpActivated
    {
        private $table_name;

        public function __construct()
        {
            global $wpdb;
            $this->table_name = $wpdb->prefix . 'eits_table';
            $this->eits_create_table();
            $this->eits_insert_records();
        }

        /**
         * Create table eits_table in the database
         *
         * @return void
         */
        public function eits_create_table()
        {
            global $wpdb;
            $charset_collate = $wpdb->get_charset_collate();

            // Define the table structure
            $sql = "CREATE TABLE $this->table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                nickname varchar(50) NOT NULL,
                nombre varchar(50) NOT NULL,
                apellido varchar(50) NOT NULL,
                apellido2 varchar(50) NOT NULL,
                correo varchar(100) NOT NULL,
                PRIMARY KEY  (id)
            ) $charset_collate;";

            // Include upgrade.php for dbDelta function
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

            // Create or update the table
            dbDelta($sql);
        }

        /**
         * Insert data in the database
         *
         * @return void
         */
        public function eits_insert_records()
        {
            global $wpdb;
            
            // Check if records already exist
            $records_exist = $wpdb->get_var("SELECT COUNT(*) FROM $this->table_name");

            if (!$records_exist) {
                // Insert 30 random user records
                $data = $this->eits_create_users();
                foreach ($data as $user) {
                    $wpdb->insert($this->table_name, $user);
                }
            }
        }

        /**
         * Load user data
         *
         * @return void
         */
        private function eits_create_users()
        {
            $names     = ["Juan", "María", "Carlos", "Ana", "Luis", "Gloria", " Raul"];
            $apellidos = ["Gómez", "Rodríguez", "Fernández", "López", "Martínez", "García", "Pérez", "Sánchez", "Díaz", "Torres", "Ramírez", "Hernández"];
            $numbers   = range(1, 100);
            $user      = $this->eits_generate_data($names, $apellidos, $numbers, 30);

            $users = [];
            for ($i = 0; $i < 30; $i++) {
                $user_data = [
                    'nickname'  => $user['nicknames'][$i],
                    'nombre'    => $user['nombre'][$i],
                    'apellido'  => $user['apellido'][$i], 
                    'apellido2' => $user['apellido2'][$i], 
                    'correo'    => $user['emails'][$i],
                ];

                $users[] = $user_data;
            }

            return $users;
        }

        /**
         * Create random user data to insert in database
         *
         * @param [type] $names
         * @param [type] $apellidos
         * @param [type] $numbers
         * @param [type] $cantidad
         * @return void
         */
        private function eits_generate_data($names, $apellidos, $numbers, $cantidad)
        {
            $emails  = $last_names = $last_names2 = $name_rand = $nicknames = []; 
            $domains = ["gmail.com", "outlook.com", "hotmail.com", "experienceis.com"];           

            for ($i = 0; $i < $cantidad; $i++) {
                $nombreAleatorio    = $names[array_rand($names)];
                $apellidoAleatorio  = $apellidos[array_rand($apellidos)];
                $apellidoAleatorio2 = $apellidos[array_rand($apellidos)];
                $numeroAleatorio    = $numbers[array_rand($numbers)];
                $dominioAleatorio   = $domains[array_rand($domains)];

                $name_rand[]   = $nombreAleatorio;
                $last_names[]  = $apellidoAleatorio;
                $last_names2[] = $apellidoAleatorio2;

                $nickname = strtolower($nombreAleatorio . $numeroAleatorio);
                $nicknames[] = $nickname;

                $email = strtolower($nombreAleatorio . $numeroAleatorio . "@" . $dominioAleatorio);
                $emails[] = $email;
            }

            return [
                'nicknames' => $nicknames,
                'nombre'    => $name_rand,
                'apellido'  => $last_names,
                'apellido2' => $last_names2,
                'emails'    => $emails,
            ];
        }
    }

endif;
