<?php

Class Paket extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->Model('Model_paket');

        $this->load->library('pagination');
    }

    function index() {
        $config['base_url'] = site_url('Paket/index');
        $config['total_rows'] = $this->Model_paket->br()->num_rows();
        $config['per_page'] = 9;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';
        $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only"></span></span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close'] = '</span>Next</li>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close'] = '</span></li>';
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['pagination'] = $this->pagination->create_links();
        $data['testimoni'] = $this->db->get('testimoni')->result();

        $data['paket'] = $this->Model_paket->join_br($config["per_page"], $data['page'])->result();
        $this->load->view('paket', $data);
    }

    function pesan() {
        if (isset($_POST['submit'])) {
            $data = [
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'no_telpon' => $this->input->post('no_telpon'),
                'alamat' => $this->input->post('alamat'),
                'id_paket_umroh' => $this->input->post('id_paket'),
                'harga' => $this->input->post('harga_paket'),
                'password' => md5($this->input->post('password'))
            ];
            $this->db->insert('daftar_umroh',$data);
            $this->session->set_flashdata('berhasil', 'sukses mendaftar silahkan login menggunakan email dan password yang di sudah di buat');
            redirect('Login');
            
        } else {
            $id = $this->uri->segment(3);
            $data['paket'] = $this->db->get_where('paket', array('id_paket' => $id))->row_Array();
            $data['testimoni'] = $this->db->get('testimoni')->result();
            $this->load->view('pesan', $data);
        }
    }

}

?>