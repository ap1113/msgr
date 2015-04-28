<?php
//msgr copy
?>

<?php
function decryptN($key, $iv, $message) {
    $td = mcrypt_module_open('tripledes', '', 'ecb', '');
   
   mcrypt_generic_init($td, $key, $iv);
   
    $plaintext = mdecrypt_generic($td, $message);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
	
	return $plaintext;
}
function decrypt($key,$message){
	return decryptit($message, $key, $salt='!kQm*fF3pXe1Kbm%9');
}

function decryptit($encrypted, $password, $salt='!kQm*fF3pXe1Kbm%9') {
// Build a 256-bit $key which is a SHA256 hash of $salt and $password.
$key = hash('SHA256', $salt . $password, true);
// Retrieve $iv which is the first 22 characters plus ==, base64_decoded.
$iv = base64_decode(substr($encrypted, 0, 22) . '==');
// Remove $iv from $encrypted.
$encrypted = substr($encrypted, 22);
// Decrypt the data.  rtrim won't corrupt the data because the last 32 characters are the md5 hash; thus any \0 character has to be padding.
$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($encrypted), MCRYPT_MODE_CBC, $iv), "\0\4");
// Retrieve $hash which is the last 32 characters of $decrypted.
$hash = substr($decrypted, -32);
// Remove the last 32 characters from $decrypted.
$decrypted = substr($decrypted, 0, -32);
// Integrity check.  If this fails, either the data is corrupted, or the password/salt was incorrect.
if (md5($decrypted) != $hash) return false;
// Yay!
return $decrypted;
}
?>