<!DOCTYPE html >
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php echo $titre; ?></title>
  <meta name="Robots" content="all"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="<?php //echo img_url('logo.png'); ?>">
  <link rel="stylesheet" media="screen" type="text/css" title="Design" href="<?php echo css_url('bouton_style'); ?>" /> 
  <link href="<?php echo css_url('bootstrap.min')?>" rel="stylesheet" type="text/css">
    
</head>
<body >
  <br/>
  <br/>
  <br/>
  <div class="content">
            <div class="container-fluid">
                <div class="row">
                        <!--<p>Tout le contenu ici</p>-->
                  <div class="col-md-4">  
                    <a href="<?php echo site_url('ifoni/rapport/?d=').date('Y-m-d') ;?>"><button class="btn btn-primary">Aujourd'hui</button></a>               
                  </div>
                  <div class="col-md-4">
                     <form method="GET" action="<?php echo site_url('ifoni/rapport') ?>">
                        <div class="form-group">
                          <p>Ou choisissez une date</p>
                          <label for="exampleInputEmail1">Date</label>
                          <input type="date" class="form-control" name="d" placeholder="JJ/MM/AAAA">
                        </div>
                          <button type="submit" class="btn btn-success">Submit</button>
                      </form>                
                  </div>
                  <div class="col-md-4">                 
                  </div>
                    
                </div>

                <div class="row">
                        <!--<p>Tout le contenu ici</p>-->
                  <div class="col-md-4">                 
                  </div>
                  <div class="col-md-4">
                                     
                  </div>
                  <div class="col-md-4">                 
                  </div>
                    
                </div>


            </div>
        </div>

</body>
</html>