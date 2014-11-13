<?php
/**
 * Helper used in the platform, but just contain functions
 * that need to in the part of the user. Moreover this helper
 * will be call once load the controllers of users or
 * the movil makes a request.
 *
 * @platformName QR FZT
 * @created_at November 7, 2012
 **/

 /**
  * Helper that need to use for make the process
  * of decode the string that receive the function. This
  * is important because the system will receive the data
  * by GET encoded
  *
  * @params string value encode
  * @return string value decode
  **/
 function decode_strings($str)
 {
    $str = str_replace("%28", "(", $str);
    $str = str_replace("%29", ")", $str);
    $str = str_replace("%24", "$", $str);
    $str = str_replace("%FA", "œ", $str);
    $str = str_replace("%F3", "—", $str);
    $str = str_replace("%ED", "’", $str);
    $str = str_replace("%E9", "Ž", $str);
    $str = str_replace("%E1", "‡", $str);
    $str = str_replace("%C1", "ç", $str);
    $str = str_replace("%C9", "ƒ", $str);
    $str = str_replace("%CD", "ê", $str);
    $str = str_replace("%D3", "î", $str);
    $str = str_replace("%DA", "ò", $str);
    $str = str_replace("%D1", "„", $str);
    $str = str_replace("%F1", "–", $str);
    $str = str_replace("%E4", "Š", $str);
    $str = str_replace("%EB", "‘", $str);
    $str = str_replace("%EF", "•", $str);
    $str = str_replace("%F6", "š", $str);
    $str = str_replace("%FC", "Ÿ", $str);
    $str = str_replace("%C4", "€", $str);
    $str = str_replace("%CB", "è", $str);
    $str = str_replace("%CF", "ì", $str);
    $str = str_replace("%D6", "…", $str);
    $str = str_replace("%DC", "†", $str);
    $tamano = strlen($str);
    $decode = '';
    $i = 0;
    while($i < $tamano)
    {
        if($str[$i] == '%')
        {
            $cut = substr($str, $i+1, 2);
            $hextodec = hexdec($cut);
            $final_string = chr($hextodec);
            $decode.= $final_string;
            $i = $i + 3;
        }
        else
        {
            $decode.= $str[$i];
            $i++;
        }
    }
    return $decode;
 }
 
 /**
  * Method where the system can count the data
  * of the users for know if the user is registered
  * or is new. The helper return an int value for know
  * if is new the user or the user was registered
  *
  * @param string facebook ID
  * @return int total
  **/
 function count_users($fbId)
 {
     $CI =& get_instance();
     $CI->db->select('*')
            ->from('users')
            ->where('userFacebookId', $fbId);
     $totalUsers = $CI->db->count_all_results();
     return $totalUsers;
 }
 
 /**
  * Method for can encrypt the values of the user for
  * create the password of the company. This function receives
  * 3 functions, the key secret, the password and the email
  * for create the key but with help to sha1 function
  *
  * @param string $key
  * @param string $pass
  * @param string $email
  **/
 function encrypt_password($key, $pass, $email)
 {
     $encrypt = sha1($key.$email.$pass);
     return $encrypt;
 }
 
 /**
  *
  **/
 function type_campain($id)
 {
     $msg = "";
     if($id == 1 || $id == '1')
     {
          $msg = "Publicacion en Facebook.";
     }
     else if($id == 2 || $id == '2'){
          $msg = "Envio de correo electronico.";
     }
     else if($id == 3 || $id == '3'){
          $msg = "Envio de correo electronico y publicacion en facebook.";
     }
     else if($id == 4 || $id == '4'){
          $msg = "Compatir un video";
     }
     return $msg;
 }