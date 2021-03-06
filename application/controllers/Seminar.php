<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Time Zone GMT+7
date_default_timezone_set('Asia/Jakarta');

class Seminar extends CI_Controller { 
        
        //Ganti Variabel di View
        protected $judul_seminar = '[Seminar Nasional & Talkshow Interaktif]';
        protected $nama_pembicara = '';
        protected $tulisan_seminar = "
                

IT Fest USU 2020 hadir kembali di tahun ini dengan bertemakan “Impactful Technology for Social Culture Awereness”. Nantinya bakalan ada Seminar Nasional, Talkshow inspiratif, dan hiburan lhoo! And here they are...
Para pembicara-pembicara kece dan expert dibidangnya bakalan ada di acara ini.
So, tunggu apalagi? Now ticket is open!!
Grab on your ticket on tiket.itfestusu.id and see you guys on April 05th!
        ";
        
        public function __construct()
	{
		parent::__construct();
		$this->load->model('Seminar_model');
        $this->load->library('session');
        }
        
	public function index()
	{
                $this->session->unset_userdata('identitas');
                redirect('Seminar/register');
                

	}
        
        //Pengguna baru yg mau daftar
        public function register()
        {
                //Generate kode_seminar
                $huruf_random = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 4);
                $tanggal_waktu = date('dmHis');
                                
                if($this->input->post('submit'))
                {
                        $kode_seminar = "ITF-".$huruf_random."".$tanggal_waktu;
                        $a = $kode_seminar;
                        $p = password_hash($a, PASSWORD_DEFAULT);
                        $data = array(
                                'kode_seminar' => $kode_seminar,
                                'nama' => $this->input->post('nama'),
                                'email' => $this->input->post('email'),
                                'telepon' => $this->input->post('telepon'),
                                'identitas' => $this->input->post('identitas'),
                                'tgl_lahir' => $this->input->post('tgl_lahir'),
                                'path_bukti' => NULL,
                                'random' => $p,
                                'qr' => md5($kode_seminar),
                                'status_pembayaran' => '0'
                        );
                        //Buat nomor identitas ke session
                        $this->session->set_userdata(['identitas' => $this->input->post('identitas') ]);
                        
                        if($this->Seminar_model->register_data($data))
                        {
                                $this->load->model('Seminar_email');
                                // $this->Seminar_email->kirim1($this->input->post('nama'),$this->input->post('email'),$kode_seminar);
                                $email = $this->input->post('email');
                                $this->session->set_flashdata('regis_berhasil','Registrasi Berhasil');
                                // $kode_seminar_en = ;
                                redirect('Seminar/bayar?id='.urlencode($kode_seminar).'&email='.urlencode($email));
                        }
                }
                else
                {
                        $data = [
                                'judul_seminar' => $this->judul_seminar,
                                'nama_pembicara' => $this->nama_pembicara,
                                'tulisan_seminar' => $this->tulisan_seminar
                        ];
                        $this->load->view('seminar/form_register', $data);
                }
                
        }
        
        //Page 'Bayar Sekarang' atau 'Bayar Nanti'
        public function bayar()
        {       
                $id = $this->input->get('id');
                $email = $this->input->get('email');
                $data = array( 'judul_seminar' => $this->judul_seminar,
                                'nama_pembicara' => $this->nama_pembicara,
                                'tulisan_seminar' => $this->tulisan_seminar,
                                'id' => $id,
                                'email' => $email)
                ;
                $this->load->view('seminar/page_bayar', $data);
        }
        
       //Page 'Masukkan Nomor Identitas'
        public function registered()
        {        
            $da = $this->input->get('id');
            if (isset($da)) {
                $id = $this->input->get('id');
                $data = [
                        'judul_seminar' => $this->judul_seminar,
                        'nama_pembicara' => $this->nama_pembicara,
                        'tulisan_seminar' => $this->tulisan_seminar,
                        'id' => $id
                ];
            }
            else{
                $data = [
                        'judul_seminar' => $this->judul_seminar,
                        'nama_pembicara' => $this->nama_pembicara,
                        'tulisan_seminar' => $this->tulisan_seminar
                ];
            }

                $this->load->view('seminar/form_registered', $data);             
        }
        
        //Page upload bukti pembayaran
        public function upload_bukti()
        {
                $kode_seminar = $this->input->post('identitas');
                // $kode_seminar = $this->Seminar_model->getKode($data['identitas'];
                $dbapi = $this->load->database('api', TRUE); 
                $ver = $dbapi->where('kode_seminar', 'ITF-'.$kode_seminar)->get('seminar')->num_rows();
                if ($ver!=0) {

                $config['upload_path']       = './public/seminar/pembayaran/';
                $config['allowed_types']    = 'jpg|png|bmp|jpeg';
                $config['file_name']            = 'ITF-'.$kode_seminar;
                $config['overwrite']        = true;
                $config['max_size']             = 1024; // 1MB
                
                $this->load->library('upload', $config);
                
                if ( !$this->upload->do_upload('path_bukti') )
                {
                        $this->session->set_flashdata('error_upload', $this->upload->display_errors());
                        redirect('Seminar/registered');
                }
                else
                {
                        $file = $this->upload->data('file_name');  
                        $this->Seminar_model->registered_update($kode_seminar,$file);
                        $this->session->set_flashdata('upload_berhasil','Upload Berhasil - Berkas akan diverifikasi');
                        $this->session->unset_userdata(['identitas' => $this->input->post('identitas') ]);
                        redirect('Seminar/register');
                        //echo "Bayar Berhasil";
                }
                }
                else{
                    $this->session->set_flashdata('error_upload', 'Kode Seminar tidak valid');
                        redirect('Seminar/registered');
                }
        }
        
        
}
