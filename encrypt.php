<?php
include('decrypt.php');
//msgr copy
?>
<?php

function encrypt($key, $message) {
	
    $td = mcrypt_module_open('tripledes', '', 'ecb', '');
    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
	setiv($iv);
   
   mcrypt_generic_init($td, $key, $iv);
   
    $cyphertext = mcrypt_generic($td, $message);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
	
	return $cyphertext;
}
?>
