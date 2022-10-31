<?php if ( ! defined('BASEPATH')) exit('No direct script access
allowed');
 
class df_model extends CI_Model
{
	protected $table = 'at_user';
	public function __construct()
	{
		// Obligatoire
		parent::__construct();
		$this->load->database('default',TRUE);	
	}
	
	public function test_login($login,$mdp)
	{
		//$query = $this->db->query("SELECT * FROM at_user WHERE user_login='".$login."' AND user_mdp='".$mdp."' LIMIT 0,1");
		$array = array('user_login' => $login, 'user_mdp' => $mdp);
		$this->db->select('*');
		$this->db->from('at_user');
		$this->db->where($array);
		$this->db->limit(1);

		$query = $this->db->get();
		$row=$query->result();
		return $row;
	}

	public function delai_activite($id)
	{
		//le delai d'activite est dépassé
		$this->db->set('user_niveau','inactif');	
		$this->db->where('user_id',$id);
		$this->db->limit(1);
		return $this->db->update($this->table);
	}
	
	public function last_activite($id)
	{
		//le delai d'activite new
		$this->db->set('user_lastActivity',time());	
		$this->db->where('user_id',$id);
		$this->db->limit(1);
		return $this->db->update($this->table);
	}

	public function test1()
	{
		
	}


}