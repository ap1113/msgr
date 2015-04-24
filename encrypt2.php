<?php
//msgr copy

?>
<?php
function encrypt2($key, $iv, $message) {

    $td = mcrypt_module_open('tripledes', '', 'ecb', '');
   
   mcrypt_generic_init($td, $key, $iv);
   
    $cyphertext = mcrypt_generic($td, $message);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
	
	return $cyphertext;
}

?>