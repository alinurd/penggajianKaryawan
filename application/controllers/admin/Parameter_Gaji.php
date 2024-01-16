<?php
class Parameter_Gaji extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('ModelPotongan_Gaji');

        if($this->session->userdata('hak_akses') != '1'){
            $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Anda Belum Login!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>');
                redirect('login');
        }
    }

	function index()
	{
        $data['title'] = "Setting Parameter Gaji";
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('admin/parameter_gaji/list_potonganGaji', $data);
        $this->load->view('template_admin/footer');
    }

    function TampilPotongan()
    {
        $data['hasil']=$this->ModelPotongan_Gaji->TampilPotongan();
        $this->load->view('admin/parameter_gaji/data_potonganGaji',$data);
    }

    function tambah_potonganGaji()
    {
        $aksi=$this->input->post('aksi');
        $this->load->view('admin/parameter_gaji/tambah_potonganGaji',$aksi);
    }

    function edit_potonganGaji()
    {
        $potongan=$this->input->post('potongan');
        $data['hasil']=$this->ModelPotongan_Gaji->Getpotongan($potongan);
        $this->load->view('admin/parameter_gaji/edit_potonganGaji',$data);
    }
    function hapus_potonganGaji()
    {
        $potongan=$this->input->post('potongan');
        $data['hasil']=$this->ModelPotongan_Gaji->Getpotongan($potongan);
        $this->load->view('admin/parameter_gaji/hapus_potonganGaji',$data);
    }

    function simpanPotongan()
    {
        var_dump($this->input->post());
        $data = array(
            'jenis'=>$this->input->post('potongan'),
            'potongan'=>$this->input->post('potongan'),
            'jml_potongan'=>$this->input->post('jml_potongan')
            );
            $this->db->insert('parameter_gaji',$data);
    }

    function editPotongan()
    {
        $data = array(
            'potongan'=>$this->input->post('potongan_baru'),
            'jml_potongan'=>$this->input->post('jml_potongan')
		);
        $potongan = $this->input->post('potongan_lama');
        $this->db->where('id', $potongan);
        $this->db->update('parameter_gaji',$data);
    }
    function hapusPotongan()
    {
        $potongan=$this->input->post('potongan');
        var_dump($potongan);
        $this->db->delete('parameter_gaji',array('id' => $potongan));
    }
}
?>