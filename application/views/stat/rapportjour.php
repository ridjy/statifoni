
<!DOCTYPE html >
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html" />
   <meta charset="ISO-8859-1">
  <title><?php echo $titre; ?></title>
  <meta name="Robots" content="all"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="<?php //echo img_url('logo.png'); ?>">
  <link rel="stylesheet" media="screen" type="text/css" title="Design" href="<?php echo css_url('bouton_style'); ?>" /> 
  <link href="<?php echo css_url('bootstrap.min')?>" rel="stylesheet" type="text/css">
    
</head>

<body >
  <br/>
  <div class="content">
            <div class="container-fluid">
            	<div class="row">
            		<div class="col-md-2">
                	</div>
                	<div class="col-md-8">
                	<h5>Rapport IFONI du jour :  <p class="text-primary"><?php echo $date; ?></p> Heure du stat. : <p class="text-primary"><?php echo date('H:i'); ?></p></h5>		
                	</div>
            		<div class="col-md-2">
                	</div>
            	</div>	

                <div class="row">
                	<div class="col-md-6">
                    <table class="table table-sm">
                      <thead class="thead-dark">
                        <tr>
                          <th scope="col">Etiquettes de ligne</th>
                          <th scope="col">Nombre</th>
                          <th scope="col">%</th>
                        </tr>
                      </thead>
                      <tbody>

                	</div>

                      
						    
						  