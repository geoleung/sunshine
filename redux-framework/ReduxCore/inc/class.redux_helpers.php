<?php
// Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

// Don't duplicate me!
    if ( ! class_exists( 'ThemegumRedux_Helpers' ) ) {

        /**
         * Redux Helpers Class
         * Class of useful functions that can/should be shared among all Redux files.
         *
         * @since       1.0.0
         */
        class ThemegumRedux_Helpers {

            public static function tabFromField( $parent, $field ) {
                foreach ( $parent->sections as $k => $section ) {
                    if ( ! isset( $section['title'] ) ) {
                        continue;
                    }

                    if ( isset( $section['fields'] ) && ! empty( $section['fields'] ) ) {
                        if ( ThemegumRedux_Helpers::recursive_array_search( $field, $section['fields'] ) ) {
                            return $k;
                            continue;
                        }
                    }
                }
            }

            public static function isFieldInUseByType( $fields, $field = array() ) {
                foreach ( $field as $name ) {
                    if ( array_key_exists( $name, $fields ) ) {
                        return true;
                    }
                }

                return false;
            }

            public static function isFieldInUse( $parent, $field ) {
                foreach ( $parent->sections as $k => $section ) {
                    if ( ! isset( $section['title'] ) ) {
                        continue;
                    }

                    if ( isset( $section['fields'] ) && ! empty( $section['fields'] ) ) {
                        if ( ThemegumRedux_Helpers::recursive_array_search( $field, $section['fields'] ) ) {
                            return true;
                            continue;
                        }
                    }
                }
            }

            public static function major_version( $v ) {
                $version = explode( '.', $v );
                if ( count( $version ) > 1 ) {
                    return $version[0] . '.' . $version[1];
                } else {
                    return $v;
                }
            }

            public static function isWpDebug() {
                return ( defined( 'WP_DEBUG' ) && WP_DEBUG == true );
            }

            public static function isParentTheme( $file ) {
                $file = self::cleanFilePath( $file );
                $dir  = self::cleanFilePath( get_template_directory() );

                $file = str_replace( '//', '/', $file );
                $dir  = str_replace( '//', '/', $dir );

                if ( strpos( $file, $dir ) !== false ) {
                    return true;
                }

                return false;
            }

            public static function isChildTheme( $file ) {
                $file = self::cleanFilePath( $file );
                $dir  = self::cleanFilePath( get_stylesheet_directory() );

                $file = str_replace( '//', '/', $file );
                $dir  = str_replace( '//', '/', $dir );

                if ( strpos( $file, $dir ) !== false ) {
                    return true;
                }

                return false;
            }

            private static function reduxAsPlugin() {
                return ThemegumReduxFramework::$_as_plugin;
            }

            public static function isTheme( $file ) {

                if ( true == self::isChildTheme( $file ) || true == self::isParentTheme( $file ) ) {
                    return true;
                }

                return false;
            }

            public static function array_in_array( $needle, $haystack ) {
                //Make sure $needle is an array for foreach
                if ( ! is_array( $needle ) ) {
                    $needle = array( $needle );
                }
                //For each value in $needle, return TRUE if in $haystack
                foreach ( $needle as $pin ) //echo 'needle' . $pin;
                {
                    if ( in_array( $pin, $haystack ) ) {
                        return true;
                    }
                }

                //Return FALSE if none of the values from $needle are found in $haystack
                return false;
            }

            public static function recursive_array_search( $needle, $haystack ) {
                foreach ( $haystack as $key => $value ) {
                    if ( $needle === $value || ( is_array( $value ) && self::recursive_array_search( $needle, $value ) !== false ) ) {
                        return true;
                    }
                }

                return false;
            }

            /**
             * Take a path and return it clean
             *
             * @param string $path
             *
             * @since    3.1.7
             */
            public static function cleanFilePath( $path ) {
                $path = str_replace( '', '', str_replace( array( "\\", "\\\\" ), '/', $path ) );

                if ( $path[ strlen( $path ) - 1 ] === '/' ) {
                    $path = rtrim( $path, '/' );
                }

                return $path;
            }

            /**
             * Take a path and delete it
             *
             * @param string $path
             *
             * @since    3.3.3
             */
            public static function rmdir( $dir ) {
                if ( is_dir( $dir ) ) {
                    $objects = scandir( $dir );
                    foreach ( $objects as $object ) {
                        if ( $object != "." && $object != ".." ) {
                            if ( filetype( $dir . "/" . $object ) == "dir" ) {
                                rrmdir( $dir . "/" . $object );
                            } else {
                                unlink( $dir . "/" . $object );
                            }
                        }
                    }
                    reset( $objects );
                    rmdir( $dir );
                }
            }

            /**
             * Field Render Function.
             * Takes the color hex value and converts to a rgba.
             *
             * @since ReduxFramework 3.0.4
             */
            public static function hex2rgba( $hex, $alpha = '' ) {
                $hex = str_replace( "#", "", $hex );
                if ( strlen( $hex ) == 3 ) {
                    $r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
                    $g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
                    $b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
                } else {
                    $r = hexdec( substr( $hex, 0, 2 ) );
                    $g = hexdec( substr( $hex, 2, 2 ) );
                    $b = hexdec( substr( $hex, 4, 2 ) );
                }
                $rgb = $r . ',' . $g . ',' . $b;

                if ( '' == $alpha ) {
                    return $rgb;
                } else {
                    $alpha = floatval( $alpha );

                    return 'rgba(' . $rgb . ',' . $alpha . ')';
                }
            }

            public static function makeBoolStr( $var ) {
                if ( $var == false || $var == 'false' || $var == 0 || $var == '0' || $var == '' || empty( $var ) ) {
                    return 'false';
                } else {
                    return 'true';
                }
            }


            private static function getReduxTemplates( $custom_template_path ) {
                $filesystem = ThemegumRedux_Filesystem::get_instance();
                $template_paths     = array( 'ReduxFramework' => ThemegumReduxFramework::$_dir . 'templates/panel' );
                $scanned_files      = array();
                $found_files        = array();
                $outdated_templates = false;

                foreach ( $template_paths as $plugin_name => $template_path ) {
                    $scanned_files[ $plugin_name ] = self::scan_template_files( $template_path );
                }

                foreach ( $scanned_files as $plugin_name => $files ) {
                    foreach ( $files as $file ) {
                        if ( file_exists( $custom_template_path . '/' . $file ) ) {
                            $theme_file = $custom_template_path . '/' . $file;
                        } else {
                            $theme_file = false;
                        }

                        if ( $theme_file ) {
                            $core_version  = self::get_template_version( ThemegumReduxFramework::$_dir . 'templates/panel/' . $file );
                            $theme_version = self::get_template_version( $theme_file );

                            if ( $core_version && ( empty( $theme_version ) || version_compare( $theme_version, $core_version, '<' ) ) ) {
                                if ( ! $outdated_templates ) {
                                    $outdated_templates = true;
                                }

                                $found_files[ $plugin_name ][] = sprintf( wp_kses( __( '<code>%s</code> version <strong style="color:red">%s</strong> is out of date. The core version is %s', 'lapindos' ),array('code'=>array(),'strong'=>array('style'=>array()))), str_replace( WP_CONTENT_DIR . '/themes/', '', $theme_file ), $theme_version ? $theme_version : '-', $core_version );
                            } else {
                                $found_files[ $plugin_name ][] = sprintf( '<code>%s</code>', str_replace( WP_CONTENT_DIR . '/themes/', '', $theme_file ) );
                            }
                        }
                    }
                }

                return $found_files;
            }


            private static function scan_template_files( $template_path ) {
                $files  = scandir( $template_path );
                $result = array();

                if ( $files ) {
                    foreach ( $files as $key => $value ) {
                        if ( ! in_array( $value, array( ".", ".." ) ) ) {
                            if ( is_dir( $template_path . DIRECTORY_SEPARATOR . $value ) ) {
                                $sub_files = redux_scan_template_files( $template_path . DIRECTORY_SEPARATOR . $value );
                                foreach ( $sub_files as $sub_file ) {
                                    $result[] = $value . DIRECTORY_SEPARATOR . $sub_file;
                                }
                            } else {
                                $result[] = $value;
                            }
                        }
                    }
                }

                return $result;
            }

            public static function get_template_version( $file  ) {
                $filesystem = ThemegumRedux_Filesystem::get_instance();
                // Avoid notices if file does not exist
                if ( ! file_exists( $file ) ) {
                    return '';
                }
                //
                // Make sure we catch CR-only line endings.

                $data = get_file_data( $file, array( 'version' ), 'plugin' );
                if ( ! empty( $data[0] ) ) {
                    return $data[0];
                } else {
                    $file_data = $filesystem->execute( 'get_contents', $file );

                    $file_data = str_replace( "\r", "\n", $file_data );
                    $version   = '';

                    if ( preg_match( '/^[ \t\/*#@]*' . preg_quote( '@version', '/' ) . '(.*)$/mi', $file_data, $match ) && $match[1] ) {
                        $version = _cleanup_header_comment( $match[1] );
                    }

                    return $version;
                }
            }

            private static function let_to_num( $size ) {
                $l   = substr( $size, - 1 );
                $ret = substr( $size, 0, - 1 );

                switch ( strtoupper( $l ) ) {
                    case 'P':
                        $ret *= 1024;
                    case 'T':
                        $ret *= 1024;
                    case 'G':
                        $ret *= 1024;
                    case 'M':
                        $ret *= 1024;
                    case 'K':
                        $ret *= 1024;
                }

                return $ret;
            }

        }
    }



