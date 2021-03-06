<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Access_denied extends CI_Controller {
    function __Construct(){
      parent::__Construct ();
         if($this->session->userdata('login')){
            $this->load->model('Language_model');
             $this ->load-> model('Customer_create_model');
             $this->load->model('Dashboard_model');
            //get language id from session 
            // $language=$this->session->userdata('language');
            // $this->data['usermenu']=$this->session->userdata('user_menu');

            $language=$this->session->userdata('language');
            $user_id=$this->session->userdata('fld_user_id');

            $this->data['usermenu']       ='Menus/UserMenu.php';
            $this->data['user_menu_datas_main'] =$this->Dashboard_model->user_menu_data_main($user_id,$language); //menu data
            $this->data['user_menu_datas_sub'] =$this->Dashboard_model->user_menu_data_sub($user_id,$language); //menu data


            //didine labeles and message array 
            $labels_array=array();
            $messages_array=array();
            $page_text_array=array();
            $unic_texts=array();
            //$page=6;
            //$form=6;
            $this->data['languages']=$this->Language_model->languages();
            $this->data['language']=$this->Language_model->get_language($language);
            //$this->data['forms']=$this->Language_model->get_form_name($language,$form);
              $this->data['menu_flag']=$this->Customer_create_model->get_menu_typr();
            /*$labels=$this->Language_model->get_label_name($language,$form);
            foreach($labels as $lebel){
                $labels_array[$lebel->fld_label_id]=$lebel->fld_label;
            }*/

            /*$messages=$this->Language_model->get_message($language,$form);
            foreach($messages as $message){
                $messages_array[$message->fld_message_id]=$message->fld_message;
            }*/

            $texts=$this->Language_model->get_text($language);
            foreach($texts as $text){
                $page_text_array[$text->fld_text_no]=$text->fld_text;
            }

            /*$unic_text=$this->Language_model->get_text_unic($language,$page);
            foreach($unic_text as $unic_text){
                $unic_texts[$unic_text->fld_text_no]=$unic_text->fld_text;
            }*/

            $this->data['lables']=$labels_array;
            $this->data['messages']=$messages_array;
            $this->data['text']=$page_text_array;
            $this->data['unic_texts']=$unic_texts;
            $this->data['h1title']="MSG";
              $color=$this->Dashboard_model->get_color_code();
                 $this->data['color']="#00000";
                  foreach($color as $color1){
                        $this->data['color'] =$color1->color;
                    }  
        }
        else{
            redirect('Logout');
        }
        
    }
    
    function index(){
        $this->load->view('Template/Header_view',$this->data);
        $this->load->view('Template/Nav_view',$this->data);
        $this->load->view('Access_denied_view',$this->data);
    }
    
    //change language function 
    function chanege_language($language_id){
        $session= array(
                        'language' =>$language_id,
                        );
        $this->session->set_userdata($session);
        redirect('Access_denied');
    }
}