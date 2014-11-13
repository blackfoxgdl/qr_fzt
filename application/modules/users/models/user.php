<?php
/**
 * Model where the system saves all the data of
 * the users and can get the data for know specific
 * information of the user. Maybe all the things is just
 * querys for know data and get the data of social
 * network for post messages in facebook
 *
 * @platformName QR FZT
 * @created_at November 6, 2012
 **/
class User extends CI_Model
{
    /**
     * Construct where can declare all the needed
     * information, or some name of table to user for get
     * data or insert data
     *
     * @return void
     **/
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Method that save the data of the user once push the
     * buttons register. With that informations the user can
     * linked the app to his account and every time that scan
     * the qr code post something in facebook
     *
     * @param mixed array
     * @return int id
     **/
    public function save_data_user($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Method where save all the tokens used for post in the part
     * of facebook. This tokens will be used for show some message in
     * the social network
     *
     * @param mixed array
     * @return int id
     **/
    public function save_data_social_network($data)
    {
        $this->db->insert('social_media', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Method for get all the data of the user once pass the id
     * by 'GET' parameter. With that the system check the data
     * from database and the return and array with the value
     * that match
     *
     * @param int id
     * @return mixed array
     **/
    public function get_personal_data($id)
    {
        $this->db->where('userId', $id);
        $data = $this->db->get('users');
        return $data->row();
    }
    
    /**
     * Method for get all the data of the users but just the
     * part of the social media, get all the data of the user
     * for post in facebook
     *
     * @param int id user
     * @return mixed array
     **/
    public function get_socialmedia_data($id)
    {
        $this->db->where('socialMediaUserId', $id);
        $data = $this->db->get('social_media');
        return $data->row();
    }
    
    /**
     * Method for get the information or messages to post in social
     * media. Moreover the system know what is the message to
     * post in social media. This is important because the
     * message will be showed in the social networks
     *
     * @param int id message
     * @return mixed array
     **/
    public function get_message_to_post($id)
    {
        $this->db->where('messageCampainId', $id);
        $data = $this->db->get('messages');
        return $data->row();
    }
    
    /**
     * Method for get all the information about the company. This
     * function get the id like parameter and then check the database
     * and make a query for recovery the data of the company. Once will
     * takes this information return for the manipulation
     *
     * @param int id company
     * @return mixed array
     **/
    public function get_company_data($id)
    {
        $this->db->where('clientId', $id);
        $data = $this->db->get('clients');
        return $data->row();
    }
    
    /**
     * Method for get all the values of the user once try to login
     * again in the platform. With tis function the user won't register
     * again and won't create or repeat information about the same user.
     * So this function will use for check and don't repeat users with same
     * information
     *
     * @param string facebook ID
     * @return mixed array
     **/
    public function get_user_by_facebookId($fbId)
    {
        $this->db->where('userFacebookId', $fbId);
        $data = $this->db->get('users');
        return $data->row();
    }
    
    /**
     * Function that requires the id of the campain for can take
     * the value of the kind of campain, this is important because
     * this values is important for know what is the process to
     * make the system
     *
     * @param int $idC
     **/
    public function get_type_campain($idC)
    {
        $this->db->where('campainId', $idC);
        $data = $this->db->get('campain');
        return $data->row();
    }
    
    /**
     * Method for get all the values where the user
     * can check or make all the process of get the data
     * for then manipulate in the part of post a video
     * in facebook from QR_FZT
     *
     * @param int $idC
     **/
    public function get_video_image_to_post($idC)
    {
        $this->db->where('imagesVideosCampainId', $idC);
        $data = $this->db->get('images_videos');
        return $data->row();
    }
    
    /**
     * Methos used for save all the data once the user scan
     * the qr code. If the user want to get a conversation just
     * read the code with the phone and then in a few minutes will
     * chat with another person of different gender
     *
     * @params mixed $array
     **/
    public function save_data_conversation($array)
    {
        $this->db->insert('conversations', $array);
        return $this->db->insert_id();
    }
    
    /**
     *
     **/
    public function update_conversation($id)
    {
        $this->db->update('conversations', array('conversationStatus'=>0), array('conversationUserId'=>$id));
    }
    
    /**
     *
     **/
    public function get_all_conversations()
    {
        $this->db->where('conversationStatus', 1);
        $data = $this->db->get('conversations');
        return $data->result();
    }
    
    /**
     * Method where the system will update all the information about the
     * tokens of the user and can make all the process of the update the token
     * every the user login in the app
     *
     * @param string token
     * @param int id
     **/
    public function update_tokenFB($token, $id)
    {
        $this->db->update('social_media', array('socialMediaTokenFacebook'=>$token), array('socialMediaUserId'=>$id));
    }
}