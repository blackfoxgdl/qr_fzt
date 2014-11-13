<?php
/**
 * Controller for all the process and the things need
 * to make in part of users. With that the users can
 * make many things and the app ios can conect to this
 * part for recovery and send data of users that are registers
 * or need to register for use the platform
 *
 * @platformName QR FZT
 * @created_at November 6, 2011
 **/
class Users extends MX_Controller{
    
    /**
     * Construct where need to declare all the helpers,
     * libraries and model for use in this class
     *
     * @return void
     **/
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('qrfzt', 'html', 'url'));
        $this->load->model('User', '', TRUE);
    }
    
    /**
     * Method where the user will be redirect once scan the QR Code
     * with another app different to the our app. This view show a
     * images and two links for download the app and the can scan the
     * code and can get the benefit
     *
     * @return void
     **/
    public function index()
    {
       /* $this->load->add_package_path(APPPATH.'third_party/social_media_user/');
        $this->load->library('facebooklib2');
        
        $user_link = $this->facebooklib2->get_user();
        
        $arreglo_pass = array(
            'user_link'=>$user_link,
            'facebook'=>$this->facebooklib2);
        
        $this->load->view('users/index1', $arreglo_pass);*/
        $this->load->view('users/index');
    }
    
    /**
     * Function used for save all the data of the user
     * that register the data in the application of the
     * QR FZT. This is important make it because this is the form
     * where will be modify the funcionality of the QR Code, all this
     * by the app.
     *
     * @param string name
     * @param string last name
     * @param string email
     * @param string birthday
     * @param string gender
     * @param string facebook Id
     * @param string token Facebook
     * @param string token Twitter OAuth null
     * @param string token Twitter Secret null
     *
     * @return int id user
     **/
    public function QRNew_User($nameC, $lastC, $emailC, $birthdayC, $genderC, $facebookIdC, $tokensFC, $tokenTAC = null, $tokenTSC = null)
    {
        if(isset($nameC) && isset($lastC) && isset($emailC) && isset($birthdayC) && isset($genderC) && isset($facebookIdC) && isset($tokensFC))
        {
            $name = decode_strings($nameC);
            $last = decode_strings($lastC);
            $email = decode_strings($emailC);
            $birthday = $birthdayC;
            $gender = $genderC;
            $facebookID = $facebookIdC;
            
            $existeUsuario = count_users($facebookID);
            
            if($existeUsuario == 0)
            {
                $array_save = array('userName' => $name,
                                    'userLastName' => $last,
                                    'userEmail' => $email,
                                    'userBirthday' => $birthday,
                                    'userGender' => $gender,
                                    'userFacebookId' => $facebookID,
                                    'userCreationAt' => date('d-m-Y H:i:s'));
                $id = $this->User->save_data_user($array_save);
                
                if(empty($tokenTAC))
                {
                    $tokenTwitterOAuth = '0';
                }
                else{
                    $tokenTwitterOAuth =$tokenTAC;
                }
                
                if(empty($tokenTSC))
                {
                    $tokenTwitterSecret = '0';
                }
                else{
                    $tokenTwitterSecret = $tokenTSC;
                }
                
                $array_social = array('socialMediaTokenFacebook' => $tokensFC,
                                      'socialMediaOauthTwitter' => $tokenTwitterOAuth,
                                      'socialMediaOauthSecretTwitter' => $tokenTwitterSecret,
                                      'socialMediaUserId' => $id);
                $idC = $this->User->save_data_social_network($array_social);
                
                echo $id;
            }
            else{
                $user_exists = $this->User->get_user_by_facebookId($facebookID);
                $this->User->update_tokenFB($tokensFC, $user_exists->userId);
                echo $user_exists->userId;
            }
        }
        else{
            redirect('');
        }
    }
    
    /**
     * Method used for send the email to the user with
     * information about the campain of the company. Once
     * scan the QR Code will send the email and then print
     * a bool value
     *
     * @param int id info
     * @param int id client
     * @param int id user
     * @param int status
     *
     * @return bool flag
     **/
    public function QRSend_Mail($idI, $idC, $idU = null, $status=null)
    {
        if(!empty($status) && !empty($idU))
        {
            if(isset($idI) && isset($idC) && isset($idU))
            {
                $dataUser = $this->User->get_personal_data($idU);
                $data_message = $this->User->get_message_to_post($idI);
                $data_company = $this->User->get_company_data($idC);
                
                //MAKE THE EMAIL
                $this->load->library('email');
                $config['mailtype'] = 'html';
                $config['charset'] = 'utf-8';
                $this->email->initialize($config);
                
                $this->email->from('qr-fzt@divestis.com');
                $this->email->to($dataUser->userEmail, $dataUser->userName . ' ' . $dataUser->userLastName);
                $this->email->subject($data_message->messageMail);
                $this->email->message($data_message->messageMail);
                $this->email->send();
                //echo $this->email->print_debugger();
                $this->email->clear();
                
                echo "TRUE";
            }
            else{
                redirect('');
             //echo "";
            }
        }
        else
        {
            redirect('');
        }
    }
    
    /**
     * Method for post in facebook a message that the company
     * want to show like marketing. This is a message that publish
     * in the social network for the another users can watch
     * the promotion or information
     *
     * @param int id message
     * @param int id user
     * @param int status
     *
     * @return bool flag
     **/
    public function QRPublish_WallFacebook($idM, $idU = null, $statusId = null)
    {
        if(!empty($statusId) && !empty($idU))
        {
            if(isset($idM) && isset($idU))
            {
                $data_socialmedia = $this->User->get_socialmedia_data($idU);
                $data_messages = $this->User->get_message_to_post($idM);
                
                //PUBLISH THE MESSAGE IN THE SOCIAL MEDIA
                $this->load->add_package_path(APPPATH.'third_party/social_media_user/');
                $this->load->library('facebooklib2');
                
                $this->facebooklib2->post_wall_new($data_socialmedia->socialMediaTokenFacebook, $data_messages->messageFacebook);//"Acabas de usar QR FZT, tan sencillo como presionar un boton");
                
                echo "TRUE";
            }
            else{
                redirect('');
            }
        }
        else
        {
            redirect('');
        }
    }
    
    /**
     * Method for post in facebook a message that the company
     * want to show like marketing. This is a message that publish
     * in the social network for the another users can watch
     * the promotion or information
     *
     * @param int id campain
     * @param int id user
     *
     * @return bool flag
     **/
    protected function QRPublish_WallFacebook_V2($idC, $idU, $statusId)
    {
        if(!empty($statusId) && !empty($idU))
        {
            if(isset($idC) && isset($idU))
            {
                $data_socialmedia = $this->User->get_socialmedia_data($idU);
                $data_messages = $this->User->get_message_to_post($idC);
                
                //PUBLISH THE MESSAGE IN THE SOCIAL MEDIA
                $this->load->add_package_path(APPPATH.'third_party/social_media_user/');
                $this->load->library('facebooklib2');
                
                $this->facebooklib2->post_wall_new($data_socialmedia->socialMediaTokenFacebook, $data_messages->messageFacebook);//"Acabas de usar QR FZT, tan sencillo como presionar un boton");
                
                return "TRUE";
            }
            else{
                redirect('');
            }
        }
        else
        {
            redirect('');
        }
    }
    
    /**
     * Method used for send the email to the user with
     * information about the campain of the company. Once
     * scan the QR Code will send the email and then print
     * a bool value
     *
     * @param int $idC
     * @param int $idU
     * @param int $status
     *
     * @return bool flag
     **/
    protected function QRSend_Mail_V2($idC, $idU = null, $status=null)
    {
        if(!empty($status) && !empty($idU))
        {
            if(isset($idC) && isset($idU))
            {
                $dataUser = $this->User->get_personal_data($idU);
                $data_message = $this->User->get_message_to_post($idC);
                //$data_company = $this->User->get_company_data($idC);
                
                //MAKE THE EMAIL
                $this->load->library('email');
                $config['mailtype'] = 'html';
                $config['charset'] = 'utf-8';
                $this->email->initialize($config);
                
                $this->email->from('qr-fzt@divestis.com');
                $this->email->to($dataUser->userEmail, $dataUser->userName . ' ' . $dataUser->userLastName);
                $this->email->subject($data_message->messageMail);
                $this->email->message($data_message->messageMail);
                $this->email->send();
                //echo $this->email->print_debugger();
                $this->email->clear();
                
                return "TRUE";
            }
            else{
                redirect('');
             //echo "";
            }
        }
        else
        {
            redirect('');
        }
    }
    
    /**
     * Method for post in facebook a message that the company
     * want to show like marketing. This is a message that publish
     * in the social network for the another users can watch
     * the promotion or information
     *
     * @param int id campain
     * @param int id user
     *
     * @return bool flag
     **/
    protected function QRPublish_WallFacebookVideoImage_V2($idC, $idU, $statusId)
    {
        if(!empty($statusId) && !empty($idU))
        {
            if(isset($idC) && isset($idU))
            {
                $data_socialmedia = $this->User->get_socialmedia_data($idU);
                $data_messages = $this->User->get_message_to_post($idC);
                $data_video = $this->User->get_video_image_to_post($idC);
                
                //PUBLISH THE MESSAGE IN THE SOCIAL MEDIA
                $this->load->add_package_path(APPPATH.'third_party/social_media_user/');
                $this->load->library('facebooklib2');
                
                $this->facebooklib2->post_wall_new($data_socialmedia->socialMediaTokenFacebook, $data_messages->messageFacebook, $data_video->imagesVideosPath);
                
                return "TRUE";
            }
            else{
                redirect('');
            }
        }
        else
        {
            redirect('');
        }
    }
    
    /**
     * Method for save all the data of the user once scan
     * the qr code, if the user make this, the data save in a
     * database and then by another functionality of the app,
     * the user can has a conversation with another user of
     * different gender
     *
     * @param int $id
     **/
    protected function QRSaveDataConversation_V2($id)
    {
        if(isset($id))
        {
            $this->User->update_conversation($id);
            $data = $this->User->get_personal_data($id);
            $data2 = $this->User->get_socialmedia_data($id);
            $array = array('conversationUserId'=>$data->userId,
                           'conversationUserFBId'=>$data->userFacebookId,
                           'conversationUsername'=>$data->userName . ' ' . $data->userLastName,
                           'conversationGender'=>$data->userGender,
                           'conversationToken'=>$data2->socialMediaTokenFacebook,
                           'conversationStatus'=>1);
            $id = $this->User->save_data_conversation($array);
            return $id;
        }
        else{
            redirect('');
        }
    }
    
    /**
     * Function generic for make all the process depending
     * the status that send once scan the QR Code. This data is
     * important because can send the different message to the
     * user that scan the QR Code
     *
     * @param int $id_campain
     * @param int $status
     * @param int $id_user
     * @param int $statisActivate
     **/
    public function QRCliente_Generic($id_campain, $id_user=null, $statusActivate = null)
    {
        if(isset($statusActivate) || $statusActivate != '')
        {
            $status = $this->User->get_type_campain($id_campain);   
            switch($status->campainType)
            {
                case 1:
                    if($status->campainType == 1 || $status->campainType == '1')//POST IN FACEBOOK
                    {
                        $val = $this->QRPublish_WallFacebook_V2($id_campain, $id_user, 1);
                        if($val == 'TRUE')
                        {
                            echo "Acabas de publicar un mensaje en tu muro de Facebook";
                        }
                    }
                    break;
                case 2:
                    if($status->campainType == 2 || $status->campainType == '2')//SENDING EMAIL
                    {
                        $val = $this->QRSend_Mail_V2($id_campain, $id_user, 1);
                        if($val == 'TRUE')
                        {
                            echo "Un correo se ha enviado a tu cuenta. Revisa tu buz—n";
                        }
                    }
                    break;
                case 3:
                    if($status->campainType == 3 || $status->campainType == '3')//POST IN FACEBOOK AND SENDING AND EMAIL
                    {
                        $val1 = $this->QRPublish_WallFacebook_V2($id_campain, $id_user, 1);
                        $val2 = $this->QRSend_Mail_V2($id_campain, $id_user, 1);
                        if($val1 == 'TRUE' && $val2 == 'TRUE')
                        {
                            $val = "Acabas de publicar en tu muro y de recibir un correo";
                            echo $val;
                        }
                        echo $val;
                    }
                    break;
                case 4:
                    if($status->campainType == 4 || $status->campainType == '4')//POST A VIDEO IN FACEBOOK
                    {
                        $val = $this->QRPublish_WallFacebookVideoImage_V2($id_campain, $id_user, 1);
                        if($val == 'TRUE')
                        {
                            echo "Acabas de compartir un video en tu muro de Facebook";
                        }
                    }
                    break;
                case 5:
                    if($status->campainType == 5 || $status->campainType == '5')//POST AN IMAGE IN FACEBOOK
                    {
                        $val = $this->QRSaveDataConversation_V2($id_user);
                        if($val)
                        {
                            echo 'Ahora agrega en Facebook a: "Jimador Botella Gratis" y gana la tuya!';
                        }
                        /*$val = $this->QRPublish_WallFacebookVideoImage_V2($id_campain, $id_user, 1);
                        if($val == 'TRUE')
                        {
                            echo "Acabas de compartir una fotograf’a en tu muro de Facebook";
                        }*/
                    }
                    break;
            }
        }
        else{
            redirect('');
        }
    }
    
    /**
     *
     **/
    public function QRGet_Conversation()
    {
        $data = $this->User->get_all_conversations();
        echo json_encode($data);
    }
    
    /************************** parte de demostraciones *******************************/
    
    /**
     * demo para publicacion
     **/
    public function publicar()
    {
        $this->load->add_package_path(APPPATH.'third_party/social_media_user/');
        $this->load->library('facebooklib2');
        
        $this->facebooklib2->post_wall_new('AAAAALvSA42gBAIVodT99EG7mjETUlEFpqaFuw9yXc8hVItrVJmlZBnoMYY5qxmsqSX6XxV9WDw8yCxC90VZCcrQ5BW6tcZD',
                                           'prueba de posteo');
    }
    
    /**
     * DEMO TEST GET FACEBOOK TOKENS
     **/
    public function index1()
    {
        $this->load->add_package_path(APPPATH.'third_party/social_media_user/');
        $this->load->library('facebooklib2');
        
        $user_link = $this->facebooklib2->get_user();
        
        $arreglo_pass = array(
            'user_link'=>$user_link,
            'facebook'=>$this->facebooklib2);
        
        $this->load->view('users/index', $arreglo_pass);
    }
    
    /**
     *
     **/
    public function checkin()
    {
        $this->load->add_package_path(APPPATH.'third_party/social_media_user/');
        $this->load->library('facebooklib2');
        $this->facebooklib2->check_in_place('AAAAALvSA42gBAIVodT99EG7mjETUlEFpqaFuw9yXc8hVItrVJmlZBnoMYY5qxmsqSX6XxV9WDw8yCxC90VZCcrQ5BW6tcZD');
    }
}