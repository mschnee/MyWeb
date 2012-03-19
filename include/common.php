<?php
/**
 * @copyright 2012 Matthew Schnee <matthew.schnee@gmail.com>
 */

 ini_set("display_errors","Off");
 date_default_timezone_set("UTC");
 $config = array(
    
 );
function __autoload($classname) {
    $dr = $_SERVER['DOCUMENT_ROOT'];
    $class = str_replace("_",DIRECTORY_SEPARATOR, $classname);
    if(file_exists("${dr}/classes/${class}.php"))
        include "${dr}/classes/${class}.php";
    else 
        throw new Exception("Could not load $classname");
}

/**
 * Function debug() is for convenience as a wrapper for the trigger_error function
 * It will automatically check if the parameter is an array or not and use the appropriate command
 *
 * @param mixed $variable String or array to output to logs
 * @param mixed $wrap True means wrap output in 120 = signs. String does the same with provided string
 */
function debug( $variable, $wrap=null ) {
    $traces = debug_backtrace();
    $debugData = "";
    $dr = $_SERVER['DOCUMENT_ROOT'];
    if ( isset( $traces[0] ) ) {
        $debugData .= "on " . $file = str_replace( $dr, "", $traces[0]['file'] );
        if ( isset( $traces[1]['function'] ) )
            $debugData .= " inside " . $traces[1]['function'] . "()";
        $debugData .= " at line " . $line = $traces[0]['line'];
    }
    if (isset($GLOBALS["__log_file__"] ))
        $logFile = $dr."/logs/".$GLOBALS["__log_file__"];
    else {
        $logFile = $dr."/logs/php.log";
    }
    $date = date( "[d-M-Y H:i:s]" );
    if ( is_array( $variable ) ) {
        $logMessage = "$date DEBUG: [[ " . print_r( $variable, true ) . " ]] " . $debugData . "\n";
    } else {
        // quick shortcuts to make breaks when debugging.
        if ( $variable === '=' || $variable === '+' )
            $logMessage = str_repeat( $variable, 120 ) . " at line: $line of $file\n";
        else
            $logMessage = "$date DEBUG: [[ " . $variable . " ]] " . $debugData . "\n";
    }
    if ( $wrap === true )
        $wrap = "=";
    if ( $wrap )
        $logMessage = str_repeat( $wrap, 120 ) . "\n" . $logMessage . str_repeat( $wrap, 120 ) . "\n";
    error_log( $logMessage, 3, $logFile );
}

/* Whitelist of views */
static $known_views = array(
    "Index",
    "Login",
    "Projects"
);