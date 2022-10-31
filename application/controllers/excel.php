<?php
class excel extends CI_Controller
{	
public function __construct()
{
	// Obligatoire
	parent::__construct();
	// Maintenant, ce code sera exécuté chaque fois que ce contrôleur sera appelé.
	$this->load->helper('url');
	$this->load->database();
	$this->load->model('zekri_model');
	//define('FPDF_FONTPATH',$this->config->item('fonts_path'));
	$this->load->library('PHPExcel');
	$data = array();
}


public function newfile()
{
	$data['titre']='Extraction Zekri';
	$base=$this->input->get('c');
	$idcampagne=$this->input->get('id');
	$daterdv=$this->input->get('seance');
	$secteur=$this->input->get('secteur');

	error_reporting(E_ALL);
	ini_set('display_errors', TRUE); 
	ini_set('display_startup_errors', TRUE);
	
	if (PHP_SAPI == 'cli')
		die('Utiliser un navigateur svp');

	/** Include PHPExcel */
	//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';


	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();

	// Set document properties
	$objPHPExcel->getProperties()->setCreator("Informatique BPO")
								 ->setLastModifiedBy("Informatique BPO")
								 ->setTitle("Extraction zekri")
								 ->setSubject("Office 2007 XLSX")
								 ->setDescription("Extraction ".$base." ".$daterdv)
								 ->setKeywords("office 2007 openxml php")
								 ->setCategory("Result file");

	$style1 = array(
	  'font'  => array(
	  	'bold'  => true,
	  	'name'  => 'Calibri',
	  	'size'  => 11,
	  	'color' => array('rgb' => 'FFFFFFFF'),
	  ),
	  'fill' => array(
	  	'type' => PHPExcel_Style_Fill::FILL_SOLID, 
	  	'color' => array('rgb' => '58ACFA')
	  ),
	  'alignment' => array( 
	  	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	  	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	  	'wrap' => true // retour à la ligne automatique
	  )
	);

	$stylecolor=array(
	 	'font'  => array(
		  	'bold'  => true,
		  	'name'  => 'Calibri',
		  	'size'  => 11,
		  	'color' => array('rgb' => 'FFFFFFFF'),
	  ),
		'fill' => 
         array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => 
             array('rgb' => 'F7FE2E') 
         ));


	$sheet=$objPHPExcel->getActiveSheet();

	$sheet->getRowDimension('1')->setRowHeight(35);                

	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'DATE APPEL')
	            ->setCellValue('B1', 'AGENTS')
	            ->setCellValue('C1', 'STATUT')
	            ->setCellValue('D1', 'CIV')
	            ->setCellValue('E1', 'NOM')
	            ->setCellValue('F1', 'PRENOM')
	            ->setCellValue('G1', 'ADRESSE')
	            ->setCellValue('H1', 'CP')
	            ->setCellValue('I1', 'VILLE')
	            ->setCellValue('J1', 'TEL')
	            ->setCellValue('K1', 'MOBILE')
	            ->setCellValue('L1', 'NAISSANCE MR')
	            ->setCellValue('M1', 'NAISSANCE MME')
	            ->setCellValue('N1', 'FAIRE LIVRER CADEAU')
	            ->setCellValue('O1', 'PRESENCE DU COUPLE')
	            ->setCellValue('P1', 'DATE RDV')
	            ->setCellValue('Q1', 'COMMENTAIRES')
	            ->setCellValue('R1', 'SECTEUR');

	/*style des cellules*/
	$sheet->getStyle('A1:R1')->applyFromArray($style1);

	$exec_query=$this->zekri_model->get_client_extraction($base,$idcampagne,$daterdv,$secteur);

	$i=2;
	while ($data = mysql_fetch_array($exec_query))
	{
		# code...
		$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A'.$i, $data['DATE_APPEL'])
		            ->setCellValue('B'.$i, $data['AGENT'])
		            ->setCellValue('C'.$i, $data['STATUS'])
		            ->setCellValue('D'.$i, $data['CIV'])
		            ->setCellValue('E'.$i, $data['NOM'])
		            ->setCellValue('F'.$i, $data['PRENOM'])
		            ->setCellValue('G'.$i, $data['ADRESSE'])
		            ->setCellValue('H'.$i, $data['CP'])
		            ->setCellValue('I'.$i, $data['VILLE'])
		            ->setCellValue('J'.$i, $data['TEL'])
		            ->setCellValue('K'.$i, $data['MOBILE'])
		            ->setCellValue('L'.$i, $data['MR'])
		            ->setCellValue('M'.$i, $data['MME'])
		            ->setCellValue('N'.$i, $data['LIVRAISON'])
		            ->setCellValue('O'.$i, $data['COUPLE'])
		            ->setCellValue('P'.$i, $data['DATE_RDV'])
		            ->setCellValue('Q'.$i, $data['COM'])
		            ->setCellValue('R'.$i, $data['SECTEUR']);
		$i++;            			
	}	

	$sheet->getColumnDimension('A')->setWidth(17);
	$sheet->getColumnDimension('B')->setWidth(26);
	$sheet->getColumnDimension('C')->setWidth(10);
	$sheet->getColumnDimension('D')->setWidth(8);
	$sheet->getColumnDimension('E')->setWidth(25);
	$sheet->getColumnDimension('F')->setWidth(28);
	$sheet->getColumnDimension('G')->setWidth(43);
	$sheet->getColumnDimension('H')->setWidth(12);
	$sheet->getColumnDimension('I')->setWidth(18);
	$sheet->getColumnDimension('J')->setWidth(15);
	$sheet->getColumnDimension('K')->setWidth(18);
	$sheet->getColumnDimension('L')->setWidth(17);
	$sheet->getColumnDimension('M')->setWidth(18);
	$sheet->getColumnDimension('N')->setWidth(25);
	$sheet->getColumnDimension('O')->setWidth(23);
	$sheet->getColumnDimension('P')->setWidth(31);
	$sheet->getColumnDimension('Q')->setWidth(50);
	$sheet->getColumnDimension('R')->setWidth(10);
		
		// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle("extraction zekri");

	/*$sheet->getStyle('C3:C6')->applyFromArray(array('alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
       )
    ));*/

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);


	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Extraction '.$base.' '.$daterdv.'.xls"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('pj/Extraction_'.$base.' '.$daterdv.'.xls');

	//$objWriter->save('php://output');

	$this->testmail($base,$daterdv);
	exit;
}



public function testmail($base,$daterdv)
{
		/*$file_name = "pj.xls";
		$path = $_SERVER['DOCUMENT_ROOT']."ReportZeop/pj/";*/
		
		$mail = 'r.rakotomalala@bpooceanindien.com'; // Déclaration de l'adresse de destination.
		$copie = 's.rasolofoarimino@bpooceanindien.com, a.nantenaina@bpooceanindien.com, f.andrianiaina@bpooceanindien.com, raphael@oceancallcentre.com, lalaina@bpooceanindien.com, informatique@bpooceanindien.com';
		//$copie = '';
		//$copie = 'lalaina@bpooceanindien.com, informatique@bpooceanindien.com';
		$copie_cachee ='';
		if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui présentent des bogues.
		{
		    $passage_ligne = "\r\n";
		}
		else
		{
		    $passage_ligne = "\n";
		}
		//=====Déclaration des messages au format texte et au format HTML.
		$message_txt = "Bonjour, Ci-joint l'extaction zekri demandé pour ".$base." ,séance : ".$daterdv;
		$message_html = "<html><head></head><body><b>Bonjour</b>, Ci-joint l'extraction zekri demandé pour <b>".$base."</b><br/>
		Séance : ".$daterdv."<i></i></body></html>";
		//==========
		  
		//=====Lecture et mise en forme de la pièce jointe.
		$fichier   = fopen('pj/Extraction_'.$base.' '.$daterdv.'.xls', "r");
		$attachement = fread($fichier, filesize('pj/Extraction_'.$base.' '.$daterdv.'.xls'));
		$attachement = chunk_split(base64_encode($attachement));
		fclose($fichier);
		//==========
		  
		//=====Création de la boundary.
		$boundary = "-----=".md5(rand());
		$boundary_alt = "-----=".md5(rand());
		//==========
		  
		//=====Définition du sujet.
		$sujet = "Extraction zekri ";
		//=========
		  
		//=====Création du header de l'e-mail.
		$header = "From: \"Informatique BPO\"<informatiqueocc@mail.com>".$passage_ligne;
		$header.= "Reply-to: \"Informatique BPO\" <informatique@bpooceanindien.com>".$passage_ligne;
		$header.= 'Cc: '.$copie.$passage_ligne; // Copie Cc
		$header.= 'Bcc: '.$copie_cachee.$passage_ligne; // Copie cachée Bcc 
		$header.= "MIME-Version: 1.0".$passage_ligne;
		$header.= "Content-Type: multipart/mixed;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
		//==========
		  
		//=====Création du message.
		$message = $passage_ligne."--".$boundary.$passage_ligne;
		$message.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary_alt\"".$passage_ligne;
		$message.= $passage_ligne."--".$boundary_alt.$passage_ligne;
		//=====Ajout du message au format texte.
		$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
		$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
		$message.= $passage_ligne.$message_txt.$passage_ligne;
		//==========
		  
		$message.= $passage_ligne."--".$boundary_alt.$passage_ligne;
		  
		//=====Ajout du message au format HTML.
		$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
		$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
		$message.= $passage_ligne.$message_html.$passage_ligne;
		//==========
		  
		//=====On ferme la boundary alternative.
		$message.= $passage_ligne."--".$boundary_alt."--".$passage_ligne;
		//==========
		  
		$message.= $passage_ligne."--".$boundary.$passage_ligne;
		  
		//=====Ajout de la pièce jointe.
		$message.= "Content-Type: application/vnd.ms-excel; name=\"pj/Extraction_".$base." ".$daterdv.".xls\"".$passage_ligne;
		$message.= "Content-Transfer-Encoding: base64".$passage_ligne;
		$message.= "Content-Disposition: attachment; filename=\"Extraction_".$base." ".$daterdv.".xls\"".$passage_ligne;
		$message.= $passage_ligne.$attachement.$passage_ligne.$passage_ligne;
		$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
		//==========
		//=====Envoi de l'e-mail.
		if (mail($mail,$sujet,$message,$header)) // Envoi du message
		{
		    echo 'Votre message a bien été envoyé ';
		    $res=$this->zekri_model->set_seance_inactif($base,$daterdv);
		    //$this->load->view('redirection/redirectzekri');
		    redirect('zekri');
		}
		else // Non envoyé
		{
		    echo "Votre message n'a pas pu être envoyé";
		}				  
		//==========	
}





}
