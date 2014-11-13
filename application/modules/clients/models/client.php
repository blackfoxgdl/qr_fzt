<?php
/**
 * Model where the system can manipulate all the information
 * about the clients and all the interaction that could
 * have with the platform. So the system will extract data
 * from tables or can insert, in specific can make the
 * process called CRUD. This file do the interaction
 * between database and the platform
 *
 * @platformName QR FZT
 * @created November 11, 2012
 * @package Clients
 **/

class Client extends CI_Model{
    
    /**
     * Function or construct where can init
     * all the vars or something that will use
     * in all the class. Just this class and all
     * the methods content
     *
     * @return false
     **/
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Method for save all the data of the new client
     * that make the platform's super admin for that
     * he can create the accounts
     *
     * @param array $data
     **/
    public function save_client($data)
    {
        $this->db->insert('clients', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Method for save all the campains thta create the user
     * for promote the products or wherever they want to move
     * with this platform
     *
     * @param array $data
     **/
    public function saveCampain($data)
    {
        $this->db->insert('campain', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Save the messages that the user can use for
     * show in facebook's post or when send the
     * email to the final user
     *
     * @param array $data
     **/
    public function save_messages($data)
    {
        $this->db->insert('messages', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Function saves all the data of the images or videos
     * that will be used by the campain or in the promotion
     * that make it the user from to final user
     *
     * @param array $array
     **/
    public function save_images_videos($array)
    {
        $this->db->insert('images_videos', $array);
        return $this->db->insert_id();
    }
    
    /**
     * get all campains
     **/
    public function get_all_campains($id)
    {
        $this->db->select('*');
        $this->db->from('campain');
        $this->db->join('messages', 'messageCampainId = campainId', 'left');
        $this->db->where('campainCompanyId', $id);
        $data = $this->db->get();
        return $data->result();
    }
    
    /**
     *
     **/
    public function editCampain($id, $data)
    {
        $this->db->update('campain', $data, array('campainId'=>$id));
    }
    
    /**
     *
     **/
    public function editMessage($id, $data)
    {
        $this->db->update('messages', $data, array('messagesId'=>$id));
    }
    
    /**
     *
     **/
    public function get_data_client($email, $pass)
    {
        $this->db->where('clientEmail', $email);
        $this->db->where('clientPassword', $pass);
        $data = $this->db->get('clients');
        return $data->row();
    }
    
    /**
     * Method for check all the values of the login
     * for the clients. This method receive a request with
     * two parameters $email and $password and return and
     * value depending the return send by the DB
     *
     * @params string $email
     * @params string $pass
     **/
    public function check_login($email, $pass)
    {
        $this->db->where('clientEmail', $email);
        $this->db->where('clientPassword', $pass);
        $total = $this->db->count_all_results('clients');
        return $total;
    }
    
    /**
     * Method for return campain's data once save all the process and
     * appear the button of qr code generator. Once click and call to
     * the process to draw the QR Code, the system in to the function
     * for takes all the data and make the fill of vars and finish
     * the process
     *
     * @param int $id
     **/
    public function get_campain_specific($id)
    {
        $this->db->where('campainId', $id);
        $data = $this->db->get('campain');
        return $data->row();
    }
    
    /**
     * Method to takes all the companie's data for then
     * show in the main page. This function is just for specific
     * information of the client. Check the values with the companie's
     * ID, this unique value
     *
     * @params int $id
     **/
    public function get_specific_client($id)
    {
        $this->db->where('clientId', $id);
        $data = $this->db->get('clients');
        return $data->row();
    }
    
    /**
     * update video
     **/
    public function update_video($data, $id, $id2)
    {
        $this->db->update('images_videos', array('imagesVideosPath'=>$data), array('imagesVideosCampainId'=>$id,
                                                                                   'imagesVideosClientId'=>$id2));
    }
}