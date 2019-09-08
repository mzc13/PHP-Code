<?php
require 'vendor/autoload.php';

/**
* Your Square application ID
*/
if (!defined('_SQ_APP_ID')) {
    define('_SQ_APP_ID', "omitted") ;
}
/**
* Your Square application secret
*/
if (!defined('_SQ_APP_SECRET')) {
    define('_SQ_APP_SECRET', "omitted") ;
}
/**
* Square domain for REST API calls
*/
if (!defined('_SQ_DOMAIN')) {
    define('_SQ_DOMAIN', "connect.squareup.com") ;
}
// }}}
// {{{ functions
/**
 * Returns an access token for Square API calls
 *
 * By default, the function below returns sandbox credentials for testing and
 * development.For production, replace the function implementation with a valid
 * OAuth flow to generate OAuth credentials. See the OAuth Setup Guide for more
 * information on implementing OAuth.
 *
 * @return string a valid access token
 */
function getAccessToken() {
  $accessToken = _SQ_SANDBOX_TOKEN;
  return $accessToken;
}
/**
 * Returns an application Id for Square API calls
 *
 * By default, the function below returns a sandbox application ID for testing
 * and development. For production, replace the function implementation with a
 * valid production credential.
 *
 * @return string a valid application ID token
 */
function getApplicationId() {
  $accessToken = _SQ_SANDBOX_APP_ID;
  return $accessToken;
}
/**
 * Returns a location ID for Square API calls
 *
 * By default, the function below returns a hardcoded location ID from the
 * Application Dashboard. For production, update the function implementation
 * to fetch a valid location ID programmtically.
 *
 * @return string a valid location ID
 */
function getLocationId() {
  // Replace the string with a sandbox location ID from the Application Dashboard
  return "0WYHARHMM5PP2" ;
}

if (!defined('_SQ_AUTHZ_URL')) {
    define('_SQ_AUTHZ_URL', "/oauth2/authorize") ;
}
?>