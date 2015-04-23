<?php
//msgr copy
?>

<?php
function decrypt($key, $iv, $message) {
    $td = mcrypt_module_open('tripledes', '', 'ecb', '');
   
   mcrypt_generic_init($td, $key, $iv);
   
    $plaintext = mdecrypt_generic($td, $message);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
	
	return $plaintext;
}
?>