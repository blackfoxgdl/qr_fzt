<?php
/**
 * Controller where the client or the company can
 * load or create new campains with specific messages. With
 * that information can create the url and the qr code and
 * print for put in specific spaces for the users can check
 * and load the code and publish a message or receive and
 * information by email
 *
 * @platformName QR FZT
 * @created November 11, 2012
 * @package Clients
 **/

class Clients extends MX_Controller{
    
    /**
     * Method for load all the libraries, helpers
     * and the model to use in the admin client
     *
     * @return void
     **/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Client', '', TRUE);
        $this->load->helper(array('url', 'form', 'html', 'qrfzt'));
        $this->load->library(array('session'));
    }
    
    /**
     * Method for load the form of the login clients
     * where the users can login once create an account.
     * This method will be the main for the clients account
     * and once login, can create some campains and message
     * to post it
     *
     * @return void
     **/
    public function index()
    {
        $content = $this->load->view('clients/index', '', TRUE);
        $this->load->view('template', array('content'=>$content));
    }
    
    /**
     * Methor for take all the values typed by the
     * user and the authenticate the account. If the
     * account is correct, so go ahead to the next step,
     * this is the next view, where can see the menus
     *
     * @return void
     **/
    public function login()
    {
        $post = $this->input->post('Login');
        if(isset($post))
        {
            $password = encrypt_password($this->config->item('encryption_key'),
                                         $post['clientPassword'],
                                         $post['clientEmail']);
            $data = $this->Client->get_data_client($post['clientEmail'], $password);
            $array = array('id'=>$data->clientId);
            $this->session->set_userdata($array);
            //$this->home_page();
            redirect('clients/home_page');
        }
        else{
            redirect('clients');
        }
    }
    
    /**
     * Method used for check all the values of the register or
     * the data that typed the user. Once click submit or login
     * button the system check in this function if is correct the
     * data or are incorrect, and return an int value
     *
     * @params string $email
     * @params string $pass
     * @return int $val
     **/
    public function check_email_pass()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('pass');
        if(isset($email) && isset($password))
        {
            $pass = encrypt_password($this->config->item('encryption_key'),
                                     $password,
                                     $email);
            $val = $this->Client->check_login($email, $pass);
            echo $val;
        }
        else{
            redirect('clients');
        }
    }
    
    /**
     * Method where load the view of the home page. This
     * page will be the view that watch the user once
     * login to the account and from here can select
     * the require option
     *
     * @return void
     **/
    public function home_page()
    {
        if($this->session->userdata('id'))
        {
            $data['specific_data'] = $this->Client->get_specific_client($this->session->userdata('id'));
            $content = $this->load->view('clients/home_page', $data, TRUE);
            $this->load->view('template', array('content'=>$content,
                                                'included_js'=>array('statics/js/campain.js',
                                                                     'statics/js/view_campain.js')));
        }
        else{
            redirect('clients');
        }
    }
    
    /**
     * View where the client will create a campain or the tecnique
     * that use for promove their business. This form will be load
     * in the bottom of the main view
     *
     * @return void
     **/
    public function campaigns()
    {
        if($this->session->userdata('id'))
        {
            $this->load->view('clients/campain');
        }
        else{
            redirect('clients');
        }
    }
    
    /**
     * Method where the user can create the user depending
     * if the user paid or not, we can create and give them
     * access to the platform for create the differents campains
     * that need the client
     *
     * @return void
     **/
    public function create_client()
    {
        $this->load->view('clients/create_client');
    }
    
    /**
     * Method for save all the data of the user where can
     * return the if of the client will we created once
     * finish this process. Once finish the user can login
     * to the platform
     *
     * @return void
     **/
    public function save_client()
    {
        $post = $this->input->post('Cliente');
        if(isset($post) && !empty($post))
        {
            $pass = encrypt_password($this->config->item('encryption_key'),
                                     $post['clientPassword'],
                                     $post['clientEmail']);
            $letter = substr($post['clientName'], 0, 2);
            $post['clientPassword'] = $pass;
            $post['clientCode'] = $letter.date('His');
            $post['clienteCreation'] = date('d-m-Y');
            $post['clientDateEnd'] = date('d-m-Y');
            
            $id = $this->Client->save_client($post);
            echo $id;
        }
        else{
            redirect('clients/create_client');
        }
    }
    
    /**
     * Method for save all the data of the campain, with that
     * function fill all the data in the different tables depending
     * what is the information will be saved
     **/
    public function save_campaign()
    {
        if($this->session->userdata('id'))
        {
            $post = $this->input->post('Campain');
            $post1 = $this->input->post('Message');
            $postYT = $this->input->post('videoYT');
            if(isset($post) && !empty($post))
            {
                $letter = substr($post['campainName'], 0, 2);
                $post['campainCode'] = $letter.date('His');
                $post['campainCompanyId'] = $this->session->userdata('id');
                $post['campainCreation'] = date('d-m-Y');
                
                $id = $this->Client->saveCampain($post);
                
                $c1 = substr($post1['messageFacebook'], 0, 1);
                if(empty($post1['messageTwitter']))
                {
                    $c2 = 'T';
                }
                else{
                    $c2 = substr($post1['messageTwitter'], 0, 1);
                }
                $c3 = substr($post1['messageMail'], 0, 1);
                $post1['messageClientId'] = $this->session->userdata('id');
                $post1['messageCampainId'] = $id;
                $post1['messageCodeMsj'] = $c1.$c2.$c3.date('His');
                $idM = $this->Client->save_messages($post1);
                
                if(isset($postYT) && !empty($postYT) && $postYT != '')
                {//you tube
                    $arrayVI = array('imagesVideosCampainId' => $id,
                                     'imagesVideosPath' => $postYT,
                                     'imagesVideosClientId' => $this->session->userdata('id'),
                                     'imagesVideosStatus' => 1);
                    
                    $idVideos = $this->Client->save_images_videos($arrayVI);
                }//you tube
                else
                {//not you tube
                  /* if(!empty($_FILES['video']['name']) || $_FILES['video']['name'] != '')
                    {//videos
                        $pathVideo = './statics/videos/';
                        $pathVideo2 = 'statics/videos/';
                        $nameV = trim($_FILES['video']['name']);
                        $final_nameV = date('dmY').'_'.$nameV;
                        $final_path_complete = $pathVideo2.$final_nameV;
                        
                        move_uploaded_file($_FILES['video']['tmp_name'], $final_path_complete);
                        $arrayVI = array('imagesVideosCampainId' => $id,
                                         'imagesVideosPath' => $final_path_complete,
                                         'imagesVideosClientId' => $this->session->userdata('id'),
                                         'imagesVideosStatus' => 1);
                        
                        $idVideos = $this->Client->save_images_videos($arrayVI);
                    }//videos
                    else*/
                    if(!empty($_FILES['imagen']['name']) || $_FILES['imagen']['name'])
                    {//images
                        //load library and image
                        $this->load->library('image_lib');
                        
                        //create the directory
                        $file_path = "./statics/images/";
                        @mkdir($file_path, 0777, true);
                        
                        //option for upload images
                        $uploaded_settings = array('upload_path' => $file_path,
                                                   'allowed_types' => 'gif|jpg|jpeg|png',
                                                   'max_size' => '10000000000000000000000000000000000000000',
                                                   'max_width' => '13000000000000000000000000000000000000000',
                                                   'max_height' => '130000000000000000000000000000000000000000',
                                                   'remove_spaces' => true,
                                                   'encrypt_name' => true);
                        
                        $this->load->library('upload', $uploaded_settings);
                        if($this->upload->do_upload('imagen'))
                        {//upload image
                            $info = $this->upload->data();
                            
                            if($info['image_width'] < $info['image_height'])
                            {//if
                                if($info['image_width'] >= 800 || $info['image_height'] >= 800)
                                {
                                    unset($config);
                                    $config['source_image'] = 'statics/images/'.$info['file_name'];
                                    $config['maintain_ratio'] = 'TRUE';
                                    $config['width'] = 480;
                                    $config['height'] = 640;
                                    $config['new_image'] = 'statics/images/'.$info['file_name'];
                                    $this->image_lib->initialize($config);
                                    $this->image_lib->resize();
                                }
                                else{
                                    unset($config);
                                    $config['source_image'] = 'statics/images/'.$info['file_name'];
                                    $config['maintain_ratio'] = 'TRUE';
                                    $config['width'] = 169;
                                    $config['height'] = 225;
                                    $config['new_image'] = 'statics/images/'.$info['file_name'];
                                    $this->image_lib->initialize($config);
                                    $this->image_lib->resize();
                                }
                            }//if
                            else
                            { //else
                                if($info['image_width'] >= 800)
                                {
                                    unset($config);
                                    $config['source_image'] = 'statics/images/'.$info['file_name'];
                                    $config['maintain_ratio'] = 'TRUE';
                                    $config['width'] = 800;
                                    $config['height'] = 598;
                                    $config['new_image'] = 'statics/images/'.$info['file_name'];
                                    $this->image_lib->initialize($config);
                                    $this->image_lib->resize();
                                }
                                else{
                                    unset($config);
                                    $config['source_image'] = 'statics/images/'.$info['file_name'];
                                    $config['maintain_ratio'] = 'TRUE';
                                    $config['width'] = 225;
                                    $config['height'] = 169;
                                    $config['new_image'] = 'statics/images/'.$info['file_name'];
                                    $this->image_lib->initialize($config);
                                    $this->image_lib->resize();
                                }
                            }//else
                        }//upload image
                        
                        $arrayVI = array('imagesVideosCampainId' => $id,
                                         'imagesVideosPath' => 'statics/images/'.$info['file_name'],
                                         'imagesVideosClientId' => $this->session->userdata('id'),
                                         'imagesVideosStatus' => 1);
                        
                        $idVideos = $this->Client->save_images_videos($arrayVI);
                    }//images
                }//not you tube
                echo $id;
            }
            else{
                redirect('clients');
            }
        }
        else{
            redirect('clients');
        }
    }
    
    /**
     * Method for show all the campains created by the user where can
     * check what is the information that typed and then edit if
     * is necessary do it.
     *
     * @param int user id
     * @return void
     **/
    public function view_all_campaigns($id)
    {
        if($this->session->userdata('id'))
        {
            $data['all'] = $this->Client->get_all_campains($id);
            /*$content =*/ $this->load->view('clients/view_campain', $data);//, TRUE);
            //$this->load->view('template', array('content'=>$content));
        }
        else{
            redirect('clients');
        }
    }
    
    /**
     * Update the messages with relation to the messages
     * where the user admin can check all the values with
     * the id of the campain and the id of the message
     *
     * @params int $id1
     * @params int $id2
     **/
    public function update_campain($id1, $id2)
    {
        if($this->session->userdata('id'))
        {
            $post = $this->input->post('CampainEdit');
            $post2 = $this->input->post('MessageEdit');
            $video = $this->input->post('videoYT');
            $id_hidden = $this->input->post('id_company_campain');
            if(isset($post) && isset($post2))
            {
                //SAVE CAMPAIN
                $arrayC = array('campainName'=>$post['campainName'],
                                'campainType'=>$post['campainType']);
                $this->Client->editCampain($id1, $arrayC);
                
                //SAVE MESSAGES
                $arrayM = array('messageFacebook'=>$post2['messageFacebook'],
                                'messageMail'=>$post2['messageMail']);
                $this->Client->editMessage($id2, $arrayM);
                
                if(isset($video))
                {
                    $this->Client->update_video($video, $id1, $id_hidden);
                }
                
                echo $id1;
            }
            else{
                redirect('clients');
            }
        }
        else{
            redirect('clients');
        }
    }
    
    /**
     * Method for destroy the sessions vars and logout
     * session of the platform QR FZT. Once click in
     * logout, the user need to login again for inside
     * to the platform and the admin panel
     **/
    public function logout()
    {
       /* $this->session->unset_userdata('id');
        $this->session->sess_destroy();
        redirect('clients');*/
    }
    
    /**
     * Function that create the qr-code image where the user can
     * create the qr code in the browser and then can save it for
     * then print the image and make it the size of the final user
     * or client wants to show it.
     *
     * @param int $id_campain
     **/
    public function qr_code($id_campain)
    {
        if($this->session->userdata('id'))
        {
            //load a ar code library
            $this->load->library('Ciqrcode');
            
            //make the query for get the data to use
            $campain = $this->Client->get_campain_specific($id_campain);
            $name = str_replace(" ", "", $campain->campainName);
            
            //make all the process of save the image once generate the
            //qr code with the content
            header("Content-Type: image/png");
            header("Content-Disposition: attachment; filename=".$name.".png\n");
            $path = base_url().'index.php/users/QRCliente_Generic/'.$id_campain;
            $params['data'] = $path;
            $params['level'] = 'H';
            $params['size'] = 10;
            //$params['savename'] = 'qr.png';
            $this->ciqrcode->generate($params);
        }
        else{
            redirect('clients');
        }
    }
    
    public function hola(){
    //load a ar code library
            $this->load->library('Ciqrcode');
            
            //make the query for get the data to use
            /*$campain = $this->Client->get_campain_specific($id_campain);
            $name = str_replace(" ", "", $campain->campainName);
            */
            //make all the process of save the image once generate the
            //qr code with the content
            header("Content-Type: image/png");
            header("Content-Disposition: attachment; filename=nombre.png\n");
            $path = "hola_http://www.google.com";//base_url().'index.php/users/QRCliente_Generic/'.$id_campain;
            $params['data'] = $path;
            $params['level'] = 'H';
            $params['size'] = 10;
            //$params['savename'] = 'qr.png';
            $this->ciqrcode->generate($params);
    }
}