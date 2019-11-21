<?php
define('PUBPATH',str_replace(SELF,'',FCPATH)); // added
defined('BASEPATH') OR exit('No direct script access allowed');

class panitiaModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function doLogin($user_real, $pwd)
	{
		$user = $this->db
			->where('username', $user_real)
			->get('user');
			
		$match = password_verify($pwd , $user->row()->password);
		$id = $user->row()->id_user;
		$nama = $user->row()->nama;
		$num2 = $user->row()->id_lomba;
		$username = $user->row()->username;

		if (!isset($num2)) {
			return 0;
		}
		else
		{
			if ($match) 
			{
				$this->session->set_userdata([
					'username' =>  $username,
					'status' => 'login-panitia',
					'name' => $nama,
					'panitia-id' => $num2,
				]);
				$this->LogLoginPanitia();
				return 1;
			}
			else{
				return 0;
				}				
		}
	}

	public function LogLoginPanitia(){
		$ip = $this->getIP();
		$user = $this->session->userdata('username');
		$query = $this->db
			->where('username', $user)
			->get('user');
		$id_panitia = $query->row()->id_user;
		$data = array('ip_address' => $ip,
			'keterangan' => 'Login Panitia',
			'waktu' => time(),
			'id_panitia' => $id_panitia
		 );
		$this->db->insert('log_panitia', $data);

	}

	public function getIP(){
		$ip = getenv('HTTP_CLIENT_IP')?:
		getenv('HTTP_X_FORWARDED_FOR')?:
		getenv('HTTP_X_FORWARDED')?:
		getenv('HTTP_FORWARDED_FOR')?:
		getenv('HTTP_FORWARDED')?:
		getenv('REMOTE_ADDR');
		return $ip;
	}

	public function getKompetisiinfo()
	{	
		$var = $this->session->userdata('panitia-id');
		return $this->db->where('id_lomba', $var)->get('lomba')->result();
	}

	public function getKompetisiTahap(){
		$var = $this->session->userdata('panitia-id');
		return $this->db->where('id_lomba', $var)->get('tahap_lomba')->result();
	}

	public function kompetisi_tahapTambah($file,$desk,$id)
	{
		$data = array('file_tahap' => $file,
			'deskripsi_tahap' => $desk,
			'id_lomba' => $id
		);
		$this->db->insert('tahap_lomba', $data);
	}

	public function delDatabyid($datab,$kol,$id){
		$this->db->where($kol, $id)->delete($datab);
		return 1;
	}

	public function getTahap($id)
	{
		$this->db->where('id_lomba', $id)->get('lomba_tahap');
	}

	public function getSingkat($id)
	{
		$query = $this->db->query("CALL report_lomba('.$id.')");
        return $query->result();
	}
}
?>