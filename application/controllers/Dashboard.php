<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('pages_model');
    }

    public function index() {
        $this->load->helper('url');
        $this->load->view('dashboard');
    }

    public function page() {
        $this->load->helper('url');
        $this->load->library('session');
        $data['results'] = $this->pages_model->get_all_data();
        $this->load->view('page', $data);
    }

    public function add() {
        $this->load->helper(array('url'));
        $this->load->library('form_validation');
        //Rules
        $config = array(
            array(
                'field' => 'txt_url',
                'label' => 'URL',
                'rules' => 'trim|required|min_length[5]|max_length[150]|valid_url|callback_check_url'
            ),
            array(
                'field' => 'txt_name',
                'label' => 'Name',
                'rules' => 'trim|required|min_length[5]|max_length[50]'
            ),
            array(
                'field' => 'txt_title',
                'label' => 'Title',
                'rules' => 'trim|required|min_length[5]|max_length[50]'
            ),
            array(
                'field' => 'txt_area_content',
                'label' => 'Content',
                'rules' => 'trim|required|min_length[5]'
            )
        );
        $this->form_validation->set_rules($config);
        $this->load->library('session');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('success_message', '');
            $this->session->set_flashdata('error_message', '');
            $this->load->view('add');
        } else {
            try {
                //Setting values for table columns
                $data = array(
                    'url' => $this->input->post('txt_url'),
                    'name' => $this->input->post('txt_name'),
                    'title' => $this->input->post('txt_title'),
                    'content' => $this->input->post('txt_area_content')
                );
                //Transfering data to Model
                $data['image_id'] = $this->pages_model->save($data);
                $data['results'] = $this->pages_model->get_all_data();
                if (isset($_FILES['uploaded_photo']) &&
                        $_FILES['uploaded_photo']['tmp_name'] != '' &&
                        !is_null($_FILES['uploaded_photo']['tmp_name'])) {

                    $upload_path_banner = $this->config->item('upload_path_banner');
                    $file = 'uploaded_photo';
                    //Set upload restrictions
                    $config['file_name'] = $data['image_id'];
                    $config['upload_path'] = $upload_path_banner;
                    $config['allowed_types'] = 'jpg';
                    $config['min_width'] = '600';
                    $config['min_height'] = '600';
                    $config['max_width'] = '600';
                    $config['max_height'] = '600';

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload($file)) {
                        $array_upload_data = $this->upload->data();
                        $ext = $array_upload_data['file_ext'];
                        if ($this->generate_thumbnail($upload_path_banner, $data['image_id'] . $ext) == true) {
                            $data['message'] = 'Data added successfully!';
                            $this->session->set_flashdata('success_message', $data['message']);
                            $this->load->view('page', $data);
                        } else {
                            $message = 'Error creating thumbnail!';
                            unlink($upload_path_banner . '/' . $data['image_id'] . $ext);
                            $this->session->set_flashdata('error_message', $message);
                            $this->load->view('add');
                        }
                    } else {
                        $message = 'Error uploading banner!';
                        $this->session->set_flashdata('error_message', $message);
                        $this->load->view('add');
                    }
                } else {
                    $data['message'] = 'Data added successfully!';
                    $this->session->set_flashdata('success_message', $data['message']);
                    $this->load->view('page', $data);
                }
            } catch (Exception $ex) {
                $this->session->set_flashdata('error_message', $ex);
                $this->load->view('add');
            }
        }
    }

    public function edit() {
        $this->load->helper(array('url'));
        $this->load->library('form_validation');
        //Rules
        $config = array(
            array(
                'field' => 'txt_url',
                'label' => 'URL',
                'rules' => 'trim|required|min_length[5]|max_length[150]|valid_url|callback_check_url'
            ),
            array(
                'field' => 'txt_name',
                'label' => 'Name',
                'rules' => 'trim|required|min_length[5]|max_length[50]'
            ),
            array(
                'field' => 'txt_title',
                'label' => 'Title',
                'rules' => 'trim|required|min_length[5]|max_length[50]'
            ),
            array(
                'field' => 'txt_area_content',
                'label' => 'Content',
                'rules' => 'trim|required|min_length[5]'
            )
        );
        $this->form_validation->set_rules($config);
        $this->load->library('session');
        $id = (int) $this->uri->segment('4');
        $data['image_id'] = $id;
        //Transfering data to Model
        $data['result'] = $this->pages_model->get_data_by_id($id);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('success_message', '');
            $this->session->set_flashdata('error_message', '');
            $this->load->view('edit', $data);
        } else {
            try {
                //Setting values for table columns
                $update_data = array(
                    'url' => $this->input->post('txt_url'),
                    'name' => $this->input->post('txt_name'),
                    'title' => $this->input->post('txt_title'),
                    'content' => $this->input->post('txt_area_content')
                );

                if ($this->pages_model->edit($id, $update_data)) {
                    if (isset($_FILES['uploaded_photo']) &&
                            $_FILES['uploaded_photo']['tmp_name'] != '' &&
                            !is_null($_FILES['uploaded_photo']['tmp_name'])) {

                        $upload_path_banner = $this->config->item('upload_path_banner');
                        $file = 'uploaded_photo';
                        //Set upload restrictions
                        $config['file_name'] = $data['image_id'];
                        $config['upload_path'] = $upload_path_banner;
                        $config['allowed_types'] = 'jpg';
                        $config['min_width'] = '600';
                        $config['min_height'] = '600';
                        $config['max_width'] = '600';
                        $config['max_height'] = '600';

                        $this->load->library('upload', $config);

                        if ($this->upload->do_upload($file)) {
                            $array_upload_data = $this->upload->data();
                            $ext = $array_upload_data['file_ext'];
                            if ($this->generate_thumbnail($upload_path_banner, $id . $ext) == true) {
                                $data['message'] = 'Data added successfully!';
                                $this->session->set_flashdata('success_message', $data['message']);
                                $this->load->view('edit', $data);
                            } else {
                                $message = 'Error updating thumbnail!';
                                unlink($upload_path_banner . '/' . $id . $ext);
                                $this->session->set_flashdata('error_message', $message);
                                $this->load->view('edit', $data);
                            }
                        } else {
                            $message = 'Error updating banner!';
                            $this->session->set_flashdata('error_message', $message);
                            $this->load->view('edit', $data);
                        }
                    } else {
                        $data['message'] = 'Data updated successfully!';
                        $this->session->set_flashdata('success_message', $data['message']);
                        $data['results'] = $this->pages_model->get_all_data();
                        $this->load->view('page', $data);
                    }
                } else {
                    $data['message'] = 'There was an error updating the data!';
                    $this->session->set_flashdata('error_message', $data['message']);
                    $this->load->view('edit', $data);
                }
            } catch (Exception $ex) {
                $this->session->set_flashdata('error_message', $ex);
                $this->load->view('edit', $data);
            }
        }
    }

    public function delete() {
        if (isset($_POST['id'])) {
            if ($this->pages_model->delete((int) $_POST['id'])) {
                $status = 1;
                $message = 'Record has been deleted successfully!';
            } else {
                $status = 0;
                $message = 'There was an error deleting the record!';
            }
        } else {
            $status = 0;
            $message = 'There was an error deleting the record!';
        }

        $return_data = array('status' => $status, 'message' => $message);
        echo json_encode($return_data);
    }

    public function generate_thumbnail($upload_path, $filename) {
        $config = array(
            'source_image' => $upload_path . '/' . $filename, //get original image
            'new_image' => $this->config->item('upload_path_thumbnail'), //save as new image //need to create thumbs first
            'maintain_ratio' => true,
            'height' => 200 //no value for width since we have checking of height and width for banner
        );
        $this->load->library('image_lib', $config); //load library
        if (!$this->image_lib->resize()) {  //generating thumb
            return false;
        } else {
            return true;
        }
    }

    public function check_url($url) {
        $ctr_url = $this->pages_model->is_url_exists($url);
        if ($ctr_url >= 1) {
            $this->form_validation->set_message('check_url', 'The url already exists!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
