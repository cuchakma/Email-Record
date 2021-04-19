<?php

namespace Em\Re;


class Installer{

    public function Initializer() {

    }

    public function add_version() {
        $installed = get_option( 'email_recorder_installed' );

        if( !$installed ) {
            update_option( 'email_recorder_installed', time() );
        }

        update_option('email_recorder_version', PLUGIN_VERSION );
    }
}