<?php
class Peserta_Model extends CI_Model {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function login($data){
		$result = $this->db->get_where('tim',$data)->result();
		if(is_null($result))
			return 0;
		else{	
			$this->session->set_userdata('nama_tim',$result[0]->nama_team);
			$this->session->set_userdata('id_tim',$result[0]->id_tim);
			return 1;
		}
	}

	public function ambil_data_tim($id_team){
		return $this->db->where('id_tim',$id_team)->get('data_tim')->result();
	}
	public function ambil_info_tim($id_team){
		return $this->db->where('id_tim',$id_team)->get('tim')->result();
	}
	public function getDatafullTable($table){
		$data = $this->db->get($table)->result();
		return $data;
	}
}
?>