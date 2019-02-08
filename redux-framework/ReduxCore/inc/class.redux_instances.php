<?php
defined('ABSPATH') or die();
    /**
     * Redux Framework Instance Container Class
     * Automatically captures and stores all instances
     * of ReduxFramework at instantiation.
     *
     * @package     Redux_Framework
     * @subpackage  Core
     */
    class ThemegumReduxFrameworkInstances {

        /**
         * ThemegumReduxFrameworkInstances
         *
         * @var object
         */
        private static $instance;

        /**
         * ReduxFramework instances
         *
         * @var array
         */
        private static $instances;

        /**
         * Get Instance
         * Get ThemegumReduxFrameworkInstances instance
         * OR an instance of ReduxFramework by [opt_name]
         *
         * @param  string $opt_name the defined opt_name
         *
         * @return object                class instance
         */
        public static function get_instance( $opt_name = false ) {

            if ( is_null( self::$instance ) ) {
                self::$instance = new self();
            }

            if ( $opt_name && ! empty( self::$instances[ $opt_name ] ) ) {
                return self::$instances[ $opt_name ];
            }

            return self::$instance;
        }

        /**
         * Get all instantiated ReduxFramework instances (so far)
         *
         * @return [type] [description]
         */
        public static function get_all_instances() {
            return self::$instances;
        }

        private function __construct() {

            add_action( 'redux/construct', array( $this, 'capture' ), 5, 1 );

            $hash = md5( trailingslashit( network_site_url() ) . '-redux' );
            add_action( 'wp_ajax_nopriv_' . $hash, array( $this, 'tracking_arg' ) );
            add_action( 'wp_ajax_' . $hash, array( $this, 'tracking_arg' ) );

        }

        function tracking_arg() {
            echo md5( AUTH_KEY . SECURE_AUTH_KEY . '-redux' );
            die();
        }


        function capture( $ThemegumReduxFramework ) {
            $this->store( $ThemegumReduxFramework );
        }

        private function store( $ThemegumReduxFramework ) {
            if ( $ThemegumReduxFramework instanceof ThemegumReduxFramework ) {
                $key                     = $ThemegumReduxFramework->args['opt_name'];
                self::$instances[ $key ] = $ThemegumReduxFramework;
            }
        }
    }
