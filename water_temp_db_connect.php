<?php

/**
 * @file water_temp_db_connect.php
 * defines function for returning
 * database handle to stand-alone water temperatures db
 */
  
// Make path to txt_db_api.php, relative to this file
$path = sprintf("%s/data/php_txt_db/txt-db-api.php", dirname(__FILE__));

// Require the txt_db_api.php file  
require_once($path);

/**
 * Get a database handle
 * @returns a database handle object
 */

function get_db_handle(){
  
  return new Database("water_temps");
}
