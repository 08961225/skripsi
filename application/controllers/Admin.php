<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('General_model');
    }


    public function index()
    {
        $data['title'] = 'Halaman Guru';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        //echo 'selamatt ' . $data['user']['name'];


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get('user_role')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer');
    }


    public function roleAccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role_access', $data);
        $this->load->view('templates/footer');
    }

    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!</div>');
    }

    public function editrole($role_idd)
    {
        $data['title'] = 'Role Edit';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['role'] = $this->db->get_where('user_role', ['id' => $role_idd])->row_array();

        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_role')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/editrole', $data);
        $this->load->view('templates/footer');
    }

    public function chanceeditrole()
    {
        $id = $this->input->post('id');
        $role = $this->input->post('role');

        $where = ['id' => $id];
        $data = [
            'role' => $role
        ];

        // $this->form_validation->set_rules('name', 'Full Name', 'required|trim');

        // if ($this->form_validation->run() == false) {
        //     $this->load->view('templates/header', $data);
        //     $this->load->view('templates/sidebar', $data);
        //     $this->load->view('templates/topbar', $data);
        //     $this->load->view('admin/editrole', $data);
        //     $this->load->view('templates/footer');
        // } else {
        //     $role = $this->input->post('role');
        // }
        $update = $this->General_model->update($data, $where, 'user_role');
        if($update){
            $msg =  "update berhasil";
        } else {
            $msg =  "update gagal";
        }
            echo '<script>
            alert("'.$msg.'");
            window.location = "' . base_url('Admin/role') . '";
            </script>
            ';
        // $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!</div>');
    }
    public function deleterole($id) {
        $where = ['id' => $id];
        $delete = $this->General_model->delete('user_role', $where);

        if($delete){
            $msg =  "hapus berhasil";
        } else {
            $msg =  "hapus gagal";
        }
            echo '<script>
            alert("'.$msg.'");
            window.location = "' . base_url('Admin/role') . '";
            </script>
            ';
    }
}
