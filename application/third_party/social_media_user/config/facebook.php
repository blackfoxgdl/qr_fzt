<?php 
/**
* Configuration Files for social media connections
* Allow a separation between controller and external 
* logic in a nicely packaged thing
 *
 * @author axoloteDeAccion <mario.r.vallejo@gmail.com>
 * @version 0.1
 * @copyright ZavorDigital, 17 February, 2011
 * @package Social Media
 **/

//Facebook necesary info
$config['FB_appId'] = '201670583144';
$config['FB_secret'] = 'cf273674a80b7c6d723247df8332a50a';
$config['FB_cookie'] = FALSE;

//Facebook required permissions
$config['FB_req_perms'] = 'publish_stream,offline_access,email';//,user_checkins';

//Twitter necesary info
