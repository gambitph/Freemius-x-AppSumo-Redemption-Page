<?php
/**
 * Verification
 */

// Freemus Plugin ID.
define( 'FS_PLUGIN_ID', 1748 );
// Freemius API.
define( 'FS_SCOPE', 'developer' );
define( 'FS_DEV_ID', 12345 );
define( 'FS_PUBLIC_KEY', 'YOUR_PUBLIC_KEY' );
define( 'FS_SECRET_KEY', 'YOUR_SECRET_KEY' );

if ( empty( $_POST ) ) {
    http_response_code( 404 );
    return;
}

require_once( './lib/freemius/Freemius.php' );

/**
 * Grab the incoming form data
 */
function sanitize( $str, $filter = FILTER_SANITIZE_STRING ) {
    if ( empty( trim( $str ) ) ) {
        return false;
    }
    $str = filter_var( trim( $str ), $filter );
    if ( empty( $str ) ) {
        return false;
    }
    return $str;
}

$license_key = empty( $_POST['code'] ) ? '' : sanitize( $_POST['code'] );
if ( empty( $license_key ) ) {
    http_response_code( 400 ); // Bad request
    echo 'Invalid AppSumo code. Please try again.';
    return;
}

$first = sanitize( $_POST['first'] );
if ( empty( $first ) ) {
    http_response_code( 400 ); // Bad request
    echo 'Invalid first name. Please try again.';
    return;
}

$last = sanitize( $_POST['last'] );
if ( empty( $last ) ) {
    http_response_code( 400 ); // Bad request
    echo 'Invalid last name. Please try again.';
    return;
}

$email = sanitize( $_POST['email'], FILTER_VALIDATE_EMAIL );
if ( empty( $email ) ) {
    http_response_code( 400 ); // Bad request
    echo 'Invalid email address. Please try again.';
    return;
}

if ( empty( $_POST['agree_terms'] ) ) {
    http_response_code( 400 ); // Bad request
    echo 'You need to agree to our terms and conditions. Please try again.';
    return;
}

$is_marketing_allowed = ! empty( $_POST['agree_email'] );
           
/**
 * Freemius claim license.
 */

// Init SDK.
$api = new Freemius_Api( FS_SCOPE, FS_DEV_ID, FS_PUBLIC_KEY, FS_SECRET_KEY );

$license = $api->Api( "/plugins/" . FS_PLUGIN_ID . "/licenses.json", 'PUT', array(
    'license_key'          => urlencode( $license_key ), // urlencode if the license key doesn't have special characters 
    'email'                => $email,
    'name'                 => $first . ' ' . $last,
    // Add an opt-in checkbox: "[ ] Send me security & feature updates, educational content and offers."
    'is_marketing_allowed' => $is_marketing_allowed,
));

if (is_object($license) && !empty($license->user_id) && is_numeric($license->user_id)) {
    // Successful activation, email sent. Redirect user to success page or show some message.
} else if (!empty($license->error)) {
    $error = $license->error->message;
    http_response_code(400); // Bad request
    echo $license->error->message . ' Please try again.';
    return; // Don't proceed.
} else {
    http_response_code(403); // Forbidden.
    echo 'Unknown error, please try again.';
    return; // Don't proceed.
}