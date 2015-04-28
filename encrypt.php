<?php
//msgr copy
$iv;
?>
<?php
function encryptN($key, $message) {
	global $iv;
    $td = mcrypt_module_open('tripledes', '', 'ecb', '');
    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
	//setiv($iv);
   
   mcrypt_generic_init($td, $key, $iv);
   
    $cyphertext = mcrypt_generic($td, $message);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
	
	return $cyphertext;
}
function getiv(){
	global $iv;
	return $iv;
}
function encrypt($key, $message){
	return encryptit($message, $key, $salt='!kQm*fF3pXe1Kbm%9');
}
function encryptit($decrypted, $password, $salt='!kQm*fF3pXe1Kbm%9') { 
// Build a 256-bit $key which is a SHA256 hash of $salt and $password.
$key = hash('SHA256', $salt . $password, true);
// Build $iv and $iv_base64.  We use a block size of 128 bits (AES compliant) and CBC mode.  (Note: ECB mode is inadequate as IV is not used.)
srand(); $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_RAND);
if (strlen($iv_base64 = rtrim(base64_encode($iv), '=')) != 22) return false;
// Encrypt $decrypted and an MD5 of $decrypted using $key.  MD5 is fine to use here because it's just to verify successful decryption.
$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $decrypted . md5($decrypted), MCRYPT_MODE_CBC, $iv));
// We're done!
return $iv_base64 . $encrypted;
}
?>
