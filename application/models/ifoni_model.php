<?php if ( ! defined('BASEPATH')) exit('No direct script access
allowed');

class ifoni_model extends CI_Model
{
	protected $table = 'campaign';
	public function __construct()
	{
		// Obligatoire
		parent::__construct();
		//$this->load->database('base1',TRUE);
		//$DB2=$this->load->database('default',TRUE);
		$host = "10.0.1.34";
		$user = "root";
		$pass = "";
		$db = "ireflet";
		$con = mysql_connect($host,$user,$pass);
		$select_bd = mysql_select_db($db);
	}
	
	public function extraction_fiche($base,$idcampagne,$date)
	{	
		$query='SELECT
				FROM_UNIXTIME(S.CreationDate/1000) AS "DATE",
				S.CalledAddress AS "TEL",
				Q.Label
				FROM statistic.sessiondigest AS S
				INNER JOIN ireflet.qualification AS Q ON Q.Id = S.QualificationId
				WHERE S.CampaignId = "360287970994947079"
				AND FROM_UNIXTIME(S.CreationDate/1000,"%d/%m/%Y") = "29/01/2018"';
		$exec_globale_query = mysql_query($query);
		return $exec_globale_query;

	}

	public function get_stat_libelle($base,$date)
	{
		$query='SELECT
				count(S.CalledAddress) AS "NBRE",
				Q.Label AS "LIB"
				FROM '.$base.'.sessiondigest AS S
				INNER JOIN ireflet.qualification AS Q ON Q.Id = S.QualificationId
				WHERE S.CampaignId = "360287970994947079"
				AND FROM_UNIXTIME(S.CreationDate/1000,"%Y-%m-%d") = "'.$date.'"
				GROUP BY Q.Label';
		mysql_query("SET NAMES 'utf8'");		
		$exec_globale_query = mysql_query($query);
		return $exec_globale_query;
	}
	
	
	public function get_campagneID($c)
	{
		$select_id_campagne = 'SELECT c.Id AS "id" FROM ireflet.campaign AS C WHERE C.`Name`="'.$c.'"';
		$id_campagne = mysql_query($select_id_campagne);
		$idcampagne = mysql_fetch_array($id_campagne);
		return $idcampagne['id'];
	}

	public function get_sum($base,$date)
	{
		$query='SELECT SUM(T.TEL) AS "SUM"
				FROM
				(SELECT
				count(S.CalledAddress) AS "TEL",
				Q.Label AS "LIB"
				FROM '.$base.'.sessiondigest AS S
				INNER JOIN ireflet.qualification AS Q ON Q.Id = S.QualificationId
				WHERE S.CampaignId = "360287970994947079"
				AND FROM_UNIXTIME(S.CreationDate/1000,"%Y-%m-%d") = "'.$date.'"
				GROUP BY Q.Label) T ';		
		$exec_query = mysql_query($query);
		$res = mysql_fetch_array($exec_query);
		return $res['SUM'];		
		//echo $query;

	}

} 