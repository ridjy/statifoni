<?php
class ifoni extends CI_Controller
{
	
	public function __construct()
	{
		// Obligatoire
		parent::__construct();
		// Maintenant, ce code sera exécuté chaque fois que ce contrôleur sera appelé.
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->database();
		$this->load->model('ifoni_model');
		$this->load->library('form_validation');

	}

	public function index()
	{
		$data['titre']='Statistique IFONI';
		$this->load->view('stat/index',$data);
		
	}

	//fonctions utiles
	private function get_year_du_mois_prec($m)
	{
		//$m=date('n');
		//$mois est le num de mois
		$y = date('Y');
		if ($m==1) {
			return $y-1;
		} else { 
			return $y;
		}
	}

	private function get_mois_prec($m)
	{
		if ($m==1) {
			return 12;
		} else {
			return $m-1;
		}
	}

	public function pourcentage($total,$valeur)
	{
		$retour=($valeur*100)/$total;
		return round($retour,2).'%';
	}

	public function rapport()
	{
		$data['titre']='Rapport IFONI';
		//$base='statistic';
		$data['date']=$this->input->get('d');

		//integrer le choix de base de données
		/*on détecte les dates d'archivages par rapport à la date du jour*/
			/*si nous n'avons pas encore passé le 1er lundi or qu'on est dans le mois encours*/
			$mois_du_debut=date('n',strtotime($data['date']));
			$year_du_debut=date('Y',strtotime($data['date']));
			$mois_de_fin=date('n',strtotime($data['date']));
			$year_de_fin=date('Y',strtotime($data['date']));
			$mois_en_cours=date('n');
			$year_en_cours=date('Y'); 
			$mois_prec_debut=$this->get_mois_prec($mois_du_debut);
			$year_mois_prec_debut=$this->get_year_du_mois_prec($mois_du_debut);
			$mois_prec=$this->get_mois_prec($mois_en_cours);
			$year_mois_prec=$this->get_year_du_mois_prec($mois_en_cours);
			
			$time = mktime(0, 0, 0, $mois_du_debut, 1, $year_du_debut);//1er du mois du début
			$time_mois_prec= mktime(0, 0, 0, $mois_prec_debut, 1, $year_mois_prec);//1er du mois prec du début
			$str_firstmonday = strtotime('monday', $time);//moisdudebut
			$premier_mois_prec= strtotime('monday', $time_mois_prec);//1er lundi du mois prec

			$timestamp=strtotime($_GET['d']);
			$premier_mois_encours=mktime(0, 0, 0, date('n'), 1, date('Y'));
			$str_firstmonday_mois=strtotime('monday', $premier_mois_encours);
			if(time()<$str_firstmonday_mois)
			{
				$archivage1=strtotime('monday', $premier_mois_prec);//archivage du mois dernier
				$mois2=$this->get_mois_prec($mois_prec);
				$year2=$this->get_year_du_mois_prec($mois_prec);		
				$premier_mois_prec=mktime(0, 0, 0, $mois2, 1, $year2); 
				$archivage2=strtotime('monday', $premier_mois_prec);
			}
			else
			{
				$archivage1=strtotime('monday', $premier_mois_encours);//archivage le plus récent
				$premier_mois_prec=mktime(0, 0, 0, $mois_prec, 1, $year_mois_prec); 
				$archivage2=strtotime('monday', $premier_mois_prec);//archivage du mis dernier	
			}
			/**/
		//

		//timestamp est la date choisie du get
		/*if($timestamp>$archivage1)
		{
			$base='statistic';
		}else if ($timestamp>$archivage2)
		{
			$base='statistichisto';
		}else
		{
			$base='statictic2017';
		}*/

		$base='statistic';

		$exec_query=$this->ifoni_model->get_stat_libelle($base,$data['date']);
		$this->load->view('stat/rapportjour',$data);
		$TOTAL_GLOBAL=0;
		$data['somme']=$this->ifoni_model->get_sum($base,$data['date']);
		while($result = mysql_fetch_array($exec_query))
		{	
			/*****fin pourcentage*****/
			$result['pce']=$this->pourcentage($data['somme'],$result['NBRE']);
			$this->load->view('stat/contenu_stat',$result);
			//$compteur++;
		}
		//vaut mieux boucler en php pour alléger la bdd
		$this->load->view("stat/footer",$data);
	}

}