<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Controller extends CI_Controller{
    public function __construct() {
      parent::__construct();
      // date_default_timezone_set('Asia/Colombo');
    }

    function get_encrypted_password($password) {
      $options = ['cost' => 10];
      return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    function encrypt($data, $key) {
      // Generate a random IV.
      $iv = openssl_random_pseudo_bytes(16);
    
      // Encrypt the data using the AES-256 algorithm.
      $encrypted_data = openssl_encrypt($data, "AES-256-CBC", $key, true, $iv);
    
      // Return the encrypted data and IV.
      return array($encrypted_data, $iv);
    }
    
    function decrypt($encrypted_data, $key, $iv) {
      // Decrypt the data using the AES-256 algorithm.
      $decrypted_data = openssl_decrypt($encrypted_data, "AES-256-CBC", $key, true, $iv);
    
      // Return the decrypted data.
      return $decrypted_data;
    }
    
    // example of using
    /* $data = "This is a string to encrypt.";
		$key = "This is a key.";

		$encrypted_data_and_iv = $this->encrypt($data, $key);

		print '<pre>';
		print_r($encrypted_data_and_iv);


		$encrypted_data = $encrypted_data_and_iv[0];
		$iv = $encrypted_data_and_iv[1];

		$decrypted_data = $this->decrypt($encrypted_data, $key, $iv);

		echo $decrypted_data."\n";


		$serialized_array = serialize($encrypted_data_and_iv);
		echo $serialized_array."\n";

		$unserialized_array = unserialize($serialized_array);
		print_r($unserialized_array); */
}