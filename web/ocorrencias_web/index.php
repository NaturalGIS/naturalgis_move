<?php
ini_set('session.gc_maxlifetime', 36000);
session_set_cookie_params(36000);
session_start(); // Starting Session

//include('login.php'); // Includes Login Script

if(!isset($_SESSION['login_user'])){
header("location: start.php");
}
?>

<!DOCTYPE html>
<html lang="pt">
	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="Ocorrências de espécies">
	    <meta name="author" content="Ocorrências de espécies">
	    <!--  <meta name="keywords" content="biologia">-->
	    <!--  <link rel="shortcut icon" type="image/png" href="images/favicon.png">-->
	
	    <title>Ocorrências de espécies</title>
	    
	    <link href="//fonts.googleapis.com/css?family=Roboto:400,300,100,100italic,300italic,400italic,700,700italic" rel="stylesheet" type='text/css'>
	
	    <!-- Bootstrap core CSS -->
	    <link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	    <link href="libs/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	    <link href="libs/datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
	    <link href="libs/touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
	    <link href="libs/select2/select2.min.css" rel="stylesheet"/>
	    
	    <link rel="stylesheet" href="libs/file-upload/css/jquery.fileupload.css">
	    
	    <!-- Leaflet CSS -->
	    <link rel="stylesheet" href="libs/leaflet/leaflet.css" />
	    
	    <!-- Custom CSS -->
	    <link href="resources/custom.css" rel="stylesheet"/>
	    
	</head>
	<body>
		<div class="modal fade" id="dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body">
						<div id="dialog-info" class="alert alert-info">A obter dados. Por favor aguarde...</div>
						<div id="dialog-success" class="alert alert-success">Os seus dados foram submetidos com sucesso</div>
						<div id="dialog-error" class="alert alert-danger"></div>
			            <div id="dialog-progress" class="progress">
							<div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
						</div>
						
					</div>
					<div class="modal-footer" id="dialog-btn">
							<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
						</div>
				</div>
			</div>
		</div>
		<div class="container title-cont">
    		<div class="row title-row">
    			<h2>Formulário de registo de ocorrência de espécie</h2>
    		</div>
    	</div>
    	
    	<div class="container base-cont">
    		<div class="row obs-row">
    			<form id="observation" role="form-horizontal">
 						<label for="obs" class="right-space">Tipo de observação: </label>
 						<label class="radio-inline">
							<input type="radio" name="obs" value="exacta" checked>Exacta
						</label>
						<label class="radio-inline">
							<input type="radio" name="obs" value="aproximada">Aproximada
						</label>
    			</form>
    		</div>
    		<div class="row tab-row">
    			<ul id='form-tabs' class="nav nav-pills " role="tablist">
  					<li class="active"><a href="#identification" role="tab" data-toggle="tab">Identificação</a></li>
  					<li><a href="#characterization" role="tab" data-toggle="tab">Caracterização</a></li>
  					<li><a href="#geography" role="tab" data-toggle="tab">Localização</a></li>
  					<li><a href="#move" role="tab" data-toggle="tab">Move</a></li>
				</ul>
				
				<!-- TAB CONTENT -->
				<div class="tab-content tab-content-row">
			  		<div class="tab-pane active" id="identification">
			  			<!-- EXACT FORM -->
				  		<div id='exact-form'>
				  			<!-- 1st row -->
				  			<div class="row">
				  				<div class="col-md-6">
				  					<div class="row form-row">
				  						<div class="col-xs-4">
				  							<label>Espécie: </label>
				  						</div>
				  						<div class="col-xs-4">
				  							<div id="especie" class="combo-width"></div>
				  						</div>
				  					</div>
				  				</div>
				  				<div class="col-md-6">
				  					<div class="row form-row">
				  						<div class="col-xs-4">
				  							<label>Fenologia: </label>
				  						</div>
				  						<div class="col-xs-4">
				  							<div id="phenology" class="combo-width"></div>
				  						</div>
				  					</div>
					  			</div>
				  			</div>
				  			<!-- 2nd row -->
				  			<div class="row">
				  				<div class="col-md-6">
				  					<div class="row form-row">
				  						<div class="col-xs-4">
				  							<label>Idade: </label>
				  						</div>
				  						<div class="col-xs-4">
				  							<div id="age" class="combo-width"></div>
				  						</div>
				  					</div>
				  				</div>
				  				<div class="col-md-6">
				  					<div class="row form-row">
				  						<div class="col-xs-4">
				  							<label>Sexo: </label>
				  						</div>
				  						<div class="col-xs-4">
				  							<div id="sex" class="combo-width"></div>
				  						</div>
				  					</div>
					  			</div>
				  			</div>
				  			<!-- 3rd row -->
				  			<div class="row">
				  				<div class="col-md-6">
				  					<div class="row form-row">
				  						<div class="col-xs-4">
				  							<label>Comportamento: </label>
				  						</div>
				  						<div class="col-xs-4">
				  							<div id="behavior" class="combo-width"></div>
				  						</div>
				  					</div>
				  				</div>
				  				<div class="col-md-6">
				  					<div class="row form-row">
				  						<div class="col-xs-4">
				  							<label>Nº: </label>
				  						</div>
				  						<div class="col-xs-4">
				  							<!-- <div id="individuals" class="combo-width"></div> -->
				  							<div class="input-group">
				  								<input id="individuals" type="text" value="1" name="individuals" class="input-sm">
				  								<div class="input-group-btn">
				  									<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
									                    <span class="caret"></span>
									                    <span class="sr-only">Toggle Dropdown</span>
									                </button>
									                <ul class="dropdown-menu pull-right" role="menu">
									                    <li><label class="radio-inline radio-space"><input type="radio" name="individuals_type" value="0" checked>Exacto</label></li>
									                    <li><label class="radio-inline radio-space"><input type="radio" name="individuals_type" value="1">Aproximado</label></li>
									                </ul>
				  								</div>
				  							</div>
				  						</div>
				  					</div>
					  			</div>
				  			</div>
				  			<!-- 4th row -->
				  			<div class='row'>
								<div class="col-md-6">
									<span class="btn btn-success fileinput-button">
										<i class="glyphicon glyphicon-plus"></i>
										<span>Seleccionar imagem</span>
										<!-- The file input field used as target for the file upload widget -->
										<input id="fileupload" name="files[]" type="file" data-url="libs/file-upload/server/php/">
									</span>
								</div>
								<!-- <div class="col-md-6">
									<div id="files" class="files"></div>
								</div -->
								<br>
								<br>
								<div class="col-md-12">
									<!-- The global progress bar -->
									<div id="progress" class="progress">
										<div class="progress-bar progress-bar-success"></div>
									</div>
					  			</div>
				  			</div>
				  		</div>
				  		
				  		
				  		<!-- APROXIMATE FORM -->
				  		<div id='aproximate-form'>
				  			<!-- 1st row -->
				  			<div class="row">
				  				<div class="col-md-6">
				  					<div class="row form-row">
				  						<div class="col-xs-4">
				  							<label>Classe: </label>
				  						</div>
				  						<div class="col-xs-4">
				  							<div id="sys_class" class="combo-width"></div>
				  						</div>
				  					</div>
				  				</div>
				  				<div class="col-md-6">
				  					<div class="row form-row">
				  						<div class="col-xs-4">
				  							<label>Valor: </label>
				  						</div>
				  						<div class="col-xs-4">
				  							<div id="sys_class_val" class="combo-width"></div>
				  						</div>
				  					</div>
					  			</div>
				  			</div>
				  			<!-- 2nd row -->
				  			<div class="row">
				  				<div class="col-md-6">
				  					<div class="row form-row">
				  						<div class="col-xs-4">
				  							<label>Fenologia: </label>
				  						</div>
				  						<div class="col-xs-4">
				  							<div id="phenology_aproximate" class="combo-width"></div>
				  						</div>
				  					</div>
				  				</div>
				  				<div class="col-md-6">
				  					<div class="row form-row">
				  						<div class="col-xs-4">
				  							<label>Idade: </label>
				  						</div>
				  						<div class="col-xs-4">
				  							<div id="age_aproximate" class="combo-width"></div>
				  						</div>
				  					</div>
					  			</div>
				  			</div>
				  			<!-- 3rd row -->
				  			<div class="row">
				  				<div class="col-md-6">
				  					<div class="row form-row">
				  						<div class="col-xs-4">
				  							<label>Sexo: </label>
				  						</div>
				  						<div class="col-xs-4">
				  							<div id="sex_aproximate" class="combo-width"></div>
				  						</div>
				  					</div>
				  				</div>
				  				<div class="col-md-6">
				  					<div class="row form-row">
				  						<div class="col-xs-4">
				  							<label>Comportamento: </label>
				  						</div>
				  						<div class="col-xs-4">
				  							<div id="behavior_aproximate" class="combo-width"></div>
				  						</div>
				  					</div>
					  			</div>
				  			</div>
				  			<!-- 4th row -->
				  			<div class="row">
				  				<div class="col-md-6">
				  					<div class="row form-row">
				  						<div class="col-xs-4">
				  							<label>Nº: </label>
				  						</div>
				  						<div class="col-xs-4">
				  							<div class="input-group">
				  								<input id="individuals_aproximate" type="text" value="1" name="individuals_aproximate" class="input-sm">
				  								<div class="input-group-btn">
				  									<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
									                    <span class="caret"></span>
									                    <span class="sr-only">Toggle Dropdown</span>
									                </button>
									                <ul class="dropdown-menu pull-right" role="menu">
									                    <li><label class="radio-inline radio-space"><input type="radio" name="individuals_type_aproximate" value="0" checked>Exacto</label></li>
									                    <li><label class="radio-inline radio-space"><input type="radio" name="individuals_type_aproximate" value="1">Aproximado</label></li>
									                </ul>
				  								</div>
				  							</div>
				  						</div>
				  					</div>
				  				</div>
				  			</div>
				  			<!-- 4th row -->
				  			<div class='row'>
								<div class="col-md-6">
									<span class="btn btn-success fileinput-button">
										<i class="glyphicon glyphicon-plus"></i>
										<span>Seleccionar imagem</span>
										<!-- The file input field used as target for the file upload widget -->
										<input id="fileupload" name="files[]" type="file" data-url="libs/file-upload/server/php/">
									</span>
								</div>
								<!-- <div class="col-md-6">
									<div id="files" class="files"></div>
								</div -->
								<br>
								<br>
								<div class="col-md-12">
									<!-- The global progress bar -->
									<div id="progress" class="progress">
										<div class="progress-bar progress-bar-success"></div>
									</div>
					  			</div>
				  			</div>				  			
				  		</div>
			  		</div>
			  		<div class="tab-pane" id="characterization">
			  			<div id='characterization-form'>
				  			<!-- 1st row -->
				  			<div class="row">
				  				<div class="col-md-6">
				  					<div class="row form-row">
				  						<div class="col-xs-4">
				  							<label>Projecto: </label>
				  						</div>
				  						<div class="col-xs-4">
				  							<div id="project" class="combo-width"></div>
				  						</div>
				  					</div>
				  				</div>
				  				<div class="col-md-6">
				  					<div class="row form-row">
				  						<div class="col-xs-4">
				  							<label>Método: </label>
				  						</div>
				  						<div class="col-xs-4">
				  							<div id="method" class="combo-width"></div>
				  						</div>
				  					</div>
					  			</div>
				  			</div>
				  			<!-- 2nd row -->
				  			<div class="row">
				  				<div class="col-md-6">
				  					<div class="row form-row">
				  						<div class="col-xs-4">
				  							<label>Tipo: </label>
				  						</div>
				  						<div class="col-xs-4">
				  							<div id="type" class="combo-width"></div>
				  						</div>
				  					</div>
				  				</div>
				  				<div class="col-md-6">
				  					<div class="row form-row">
				  						<div class="col-xs-4">
				  							<label>Data: </label>
				  						</div>
				  						<div class="col-xs-4">
				  							<div class='input-group date' id='data'>
												<input type='text' class="form-control date-width" data-date-format="DD/MM/YYYY" />
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
											</div>
				  						</div>
				  					</div>
					  			</div>
				  			</div>
				  			<!-- 2nd row -->
				  			<div class="row">
				  				<div class="col-md-6">
				  					<div class="row form-row">
				  						<div class="col-xs-4">
				  							<label>Hora: </label>
				  						</div>
				  						<div class="col-xs-4">
				  							<div class="form-group">
								                <div class='input-group date' id='time'>
								                    <input type='text' class="form-control date-width"/>
								                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
								                    </span>
								                </div>
								            </div>
				  						</div>
				  					</div>
				  				</div>
				  			</div>
				  			<!-- 3rd row -->
				  			<div class="row">
				  				<div class="col-md-12">
				  					<label>Notas: </label>
				  				</div>
				  				<div class="col-md-12">
				  					<textarea id="notas" class="form-control textarea-width" rows="5"></textarea>
				  				</div>
				  			</div>
			  			</div>
			  		</div>
			  		<div class="tab-pane" id="geography">
			  			<div id="gps" class="row map-form">
			  				<div class="alert alert-warning" role="alert">Acesso à sua geolocalização não disponível ou ainda não autorizado.</div>
			  			</div>
			  			<div class="row">
			  				<div id="map"></div>
			  			</div>
			  			<div class="row map-form ">
			  				<form id="local" role="form-horizontal form-row">
		 						<label for="local-method" class="right-space">Método de introdução de coordenadas: </label>
		 						<label class="radio-inline right-space">
									<input type="radio" name="local-method" value="click" checked>Click
								</label>
								<label class="radio-inline right-space">
									<input type="radio" name="local-method" value="manual">Manual
								</label>
								<label class="radio-inline">
									<input type="radio" name="local-method" value="grid">Quadrícula
								</label>
		    				</form>
			  			</div>
			  			<div id='map-aproximate' class="row space-top">
			  				<div class="col-md-6">
			  					<div class="row form-row">
			  						<div class="col-xs-4">
			  							<label>Grelha: </label>
			  						</div>
			  						<div class="col-xs-4">
			  							<div id="grid" class="combo-width"></div>
			  						</div>
			  					</div>
			  				</div>
			  				<div class="col-md-6">
			  					<div class="row form-row">
			  						<div class="col-xs-4">
			  							<label>Folha: </label>
			  						</div>
			  						<div class="col-xs-4">
			  							<input type="text" class="form-control combo-width input-height" id="folha" placeholder="quadrícula UTM" disabled>
			  						</div>
			  					</div>
				  			</div>
			  			</div>
			  			<div class="row space-top">
			  				<div class="col-md-6">
			  					<div class="row form-row">
			  						<div class="col-xs-4">
			  							<label>X: </label>
			  						</div>
			  						<div class="col-xs-4">
			  							<input type="text" class="form-control combo-width input-height" id="xcoord" disabled>
			  						</div>
			  					</div>
			  				</div>
			  				<div class="col-md-6">
			  					<div class="row form-row">
			  						<div class="col-xs-4">
			  							<label>Y: </label>
			  						</div>
			  						<div class="col-xs-4">
			  							<input type="text" class="form-control combo-width input-height" id="ycoord" disabled>
			  						</div>
			  					</div>
				  			</div>
			  			</div>
			  			<div id="biotopo-section" class="row space-top">
			  				<div class="col-md-6">
			  					<div class="row form-row">
			  						<div class="col-xs-4">
			  							<label>CLC3: </label>
			  						</div>
			  						<div class="col-xs-4">
			  							<div id="biotopo" class="combo-width"></div>
			  						</div>
			  					</div>
				  			</div>
				  			<div class="col-md-6"></div>
			  			</div>
			  			<div id="biotopo-sectionclc5" class="row space-top">
			  				<div class="col-md-6">
			  					<div class="row form-row">
			  						<div class="col-xs-4">
			  							<label>CLC5: </label>
			  						</div>
			  						<div class="col-xs-4">
			  							<div id="biotopoclc5" class="combo-width"></div>
			  						</div>
			  					</div>
				  			</div>
				  			<div class="col-md-6"></div>
			  			</div>
			  			<div class="row space-top left-space">
			  				<div class="col-md-6">
			  					<div class="row">
			  						<button id="update-map" type="button" class="btn btn-default btn-space">Actualizar mapa</button>
			  					</div>
				  			</div>
			  			</div>
			  		</div>
			  		<div class="tab-pane" id="move">
						<div class='row'>
							<div class="col-md-6">
								<div class="row form-row">
									<div class="col-xs-4">
										<label>Km: </label>
									</div>
									<div class="col-xs-4">
										<div class="input-group">
											<input id="km" type="text" value="5.0" name="km" class="input-sm" style="width: 120px;">
										</div>
									</div>
								</div>
							</div>
							<div class='col-md-6'>
								<div class="row form-row">
									<div class="col-xs-4">
										<label>Estado: </label>
									</div>
									<div class="col-xs-4">
										<div id="cons" class="combo-width"></div>
									</div>
								</div>
							</div>
						</div>
					  	<div class='row'>
							<div class='col-md-6'>
								<div class="row form-row">
									<div class="col-xs-4">
										<label>Zona: </label>
									</div>
									<div class="col-xs-4">
										<div id="zona_atr" class="combo-width"></div>
									</div>
								</div>
							</div>					  	
							<div class='col-md-6'>
								<div class="row form-row">
									<div class="col-xs-4">
										<label>Antiguidade: </label>
									</div>
									<div class="col-xs-4">
										<div id="anti" class="combo-width"></div>
									</div>
								</div>
							</div>	
					  	</div>
					  	<div class='row'>
							<div class='col-md-6'>
								<div class="row form-row">
									<div class="col-xs-4">
										<label>Estrada: </label>
									</div>
									<div class="col-xs-4">
										<div id="estrada" class="combo-width"></div>
									</div>
								</div>
							</div>					  	
							<div class='col-md-6'>
								<div class="row form-row">
									<div class="col-xs-4">
										<label>ID ADN: </label>
									</div>
									<div class="col-xs-4">
										<textarea id="adn" class="form-control textarea-width" rows="1" style="width: 200px;"></textarea>
									</div>
								</div>
							</div>	
					  	</div>
					</div>
				</div>
    		</div>
    	</div>
    	<div id="msg-alert" class="container messages">
    		<div class="alert alert-success" role="alert">Área de mensagens validação e submissão</div>
    	</div>
    	
    	<div class="container form-btns">
    		<div class="row pull-right">
    			<button id="validate" type="button" class="btn btn-success">Validar</button>
    			<button id="submit" type="button" class="btn btn-success" disabled="disabled">Submeter</button>
    			<!-- <button id="submit" type="button" class="btn btn-success">Submeter</button> -->
    		</div>
    	</div>



        	<div class="container form-btns">
                <div class="row pull-right" style="text-align: right;">
		<strong>
		<?php
		echo $_SESSION['estrada'] . ' ';
		echo $_SESSION['project_method_default'] . ' ';
		echo $_SESSION['project_id'] . ' ';
		echo $_SESSION['project'] . ': ';
                echo $_SESSION['name_user'];
                echo " (";
		echo $_SESSION['login_user'];
                echo ") ";
                ?>
		</strong>
                <a href="logout.php"><strong>[LOGOUT]</strong></a>
                <br>
                <a href="upload.php"><strong>[Envio de ocorrências múltiplas]</strong></a>
                <br>                
                <a href="move_daily.php"><strong>[Dados diarios MOVE]</strong></a>
                </div>
        	</div>

		
		<!-- Core JavaScript -->
	    <script src="libs/jquery.min.js"></script>
	    <script src="libs/moment/moment.js"></script>
	    <script src="libs/moment/locale/pt.js"></script>
	    <script src="libs/select2/select2.min.js"></script>
	    <script src="libs/select2/select2_locale_pt-PT.js"></script>
	    <script src="libs/bootstrap/js/bootstrap.min.js"></script>
	    <script src="libs/datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
	    <script src="libs/touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
	    <script src="libs/file-upload/js/vendor/jquery.ui.widget.js"></script>
		<script src="libs/file-upload/js/jquery.iframe-transport.js"></script>
		<script src="libs/file-upload/js/jquery.fileupload.js"></script>
	    <script src="libs/proj4js/dist/proj4.js"></script>
	    <script src="libs/leaflet/leaflet.js"></script>
	    <script src="//maps.google.com/maps/api/js?v=3&sensor=false"></script>
		<script src="libs/leaflet/plugins/shramov/layer/tile/Google.js"></script>
		<script src="libs/leaflet/plugins/accurate-position/Leaflet.AccuratePosition.js"></script>
		<script src="libs/leaflet/plugins/easy-button/easy-button.js"></script>
            <script type="text/javascript">
            <?php echo 'var projectidjs = "'. $_SESSION['project_id'] .'";'; ?>
            <?php echo 'var projectjs = "'. $_SESSION['project'] .'";'; ?>
            <?php
            if (isset($_SESSION['estrada'])) {
            $estradamove=$_SESSION['estrada'];
            $conn = pg_connect("host=localhost dbname=*** user=*** password=***");
	    $query = pg_query($conn,"SELECT id,nome FROM estradas_move.estradas_move WHERE nome='$estradamove'");
	    $rows = pg_num_rows($query);
	    while ($row = pg_fetch_row($query)) {
	    $_SESSION['estrada_id']=$row[0];
	    }
            echo 'var estradamoveid = "'. $_SESSION['estrada_id'] .'";';
            //echo 'alert(estradamoveid);';
            }
            ?>
	    </script>
	    <script src="utils.js"></script>
	</body>
</html>
