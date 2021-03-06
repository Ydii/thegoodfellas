<?php
require_once 'dbConnect.php';
header('Content-Type: application/json');
global $jdb;
$data = array();
$result = "";
$neverExpire = "";

if ( !empty ( $_POST ) ) {

        //Clean our form data

        //The username and password submitted by the user
        $subName = mysql_real_escape_string(filter_input(INPUT_POST, 'username'));
        $subPass = mysql_real_escape_string(filter_input(INPUT_POST, 'password'));
        $neverExpire = mysql_real_escape_string(filter_input(INPUT_POST, 'neverExpire'));

        //The name of the table we want to select data from
        $table = 'users';

        /*
         * Run our query to get all data from the users table where the user 
         * login matches the submitted login.
         */
        
        $sql = "SELECT * FROM $table WHERE USER_NAME = '" . $subName . "'";
        $results = $jdb->select($sql);
        if (!$results) {
            $result = utf8_encode("username");
            
        }else{

        //Fetch our results into an associative array
        
        $results = mysql_fetch_assoc( $results );

        //The registration date of the stored matching user
        $stoReg = $results['USER_REGISTERED'];

        //The hashed password of the stored matching user
        $stoPass = $results['USER_PASS'];
        
        //Recreate our NONCE used at registration
        $nonce = md5('registration-' . $subName . $stoReg . NONCE_SALT);

        //Rehash the submitted password to see if it matches the stored hash
        $subPass = $jdb->hash_password($subPass, $nonce);

        //Check to see if the submitted password matches the stored password
        
        if ( $subPass == $stoPass ) {

                //If there's a match, we rehash password to store in a cookie
                $authNonce = md5('cookie-' . $subName . $stoReg . AUTH_SALT);
                $authID = $jdb->hash_password($subPass, $authNonce);

                //Set our authorization cookie
                if($neverExpire){
                setcookie('theGoodfellasAuth[user]', $subName, time() + (10 * 365 * 24 * 60 * 60), '', '', '', true);
                setcookie('theGoodfellasAuth[authID]', $authID, time() + (10 * 365 * 24 * 60 * 60), '', '', '', true);
                } else {
                    setcookie('theGoodfellasAuth[user]', $subName, 0, '', '', '', true);
                    setcookie('theGoodfellasAuth[authID]', $authID, 0, '', '', '', true);
                }
                $result = utf8_encode(true);
                
        } else {
                $result = utf8_encode(false);
        }
        }
        
} else {
        $result = utf8_encode("empty");
}
$data[] = array('result' => $result);
echo json_encode($data);

