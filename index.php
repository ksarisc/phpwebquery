<?php
// root
define( 'ROOTPATH', realpath(dirname(__FILE__)) );
// setup class loader
spl_autoload_register(function ( $className ) {
    if (!isset( $className ) || empty( $className )) {
        throw new Exception("Request a class to autoload.");
    }
    $fileName = ROOTPATH . '/inc/classes/' . strtolower( $className ) . '.php';
    if (file_exists( $fileName )) {
        require_once( $fileName );
    } else {
        throw new Exception("Unable to load $className.");
    }
}); // END __autoload

// includes
if (!file_exists( ROOTPATH . '/config.php' )) {
    file_put_contents(
        '<?php\ndefine("ODBC_DRIVER","");\ndefine("ODBC_SERVER","");\n' .
        'define("ODBC_PORTNO","");\ndefine("ODBC_DBASE","");\ndefine("ODBC_USER","");\n' .
        'define("ODBC_PASSWD","");\ndefine("ODBC_EXTRAS","");\n'
    );
    die('No configuration found\nDefault created\nPlease review!');
}
require_once( ROOTPATH . '/config.php' );

$page = new PageData();
$page->renderTemplate();
