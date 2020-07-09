<?php
/**
 * Área do aluno:
 * 
 * Ver os cursos que fez, em que curso está matriculado.
 * Mandar comprovante de pagamento da iscrição e mensalidades.
 * Fazer incrição para cursos, para quem ja esta cadastrado.
 */

ini_set("display_errors", 1);
error_reporting(E_ALL) ;

include("aluno.seguranca.php"); // Inclui o arquivo com o sistema de segurança
include("i_funcoes.php");
include("./app/lang/pt-br.php");
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="Área do aluno, onde acompanha os modulos feitos, pagamentos, etc...">
        <meta name="viewport" content="width=device-width">
        <!--[if IE]><link rel="shortcut icon" href="img/favicon.ico"><![endif]-->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="icon" href="img/favicon.png">
        
        
        <style>
            body {
                padding-bottom: 40px;
            }
        </style>        
        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <!-- mascaras de entradas dos campos de formulário -->
		<script src="js/jquery/jquery.inputmascara.js" type="text/javascript"></script>
        
        <script type="text/javascript" src="js/jquery/jquery-1.3.2.js"></script>
        <script>
            function vermsg($msg)
            {
                if ( $msg.length > 0 ) {
                $('#myModal').modal('show');
                }
            };

        </script>
<script type="text/javascript" src="js/jquery/jquery-1.3.2.js"></script>

        <style type="text/css">
			dl.dl-horizontal dt {width:100px;}
			dl.dl-horizontal dd { padding-left: 0}
		</style>
	</head>
     <body onload="vermsg('<?=$msg?>')">
        
        <div class="container">       
            <?php include 'm_top.alunos.php'; ?>     
            <div class="row">
                <div class="row-fluid" style="background-image:url(img/h48.png); background-position: left center; background-repeat:no-repeat;">
                	<div class="span8" style="height:48px;">
                        <div style="padding-left:55px; padding-top:7px; font-size:1.5em;">Oi <?= $_SESSION["nome"]; ?></div>
                        <div style="padding-left:55px; font-size:0.7em">BEM-VINDO AO SISTEMA HOSANA.SIS (by WebiG.SiS).</div>
                    </div>
                    <div class="span4" style="text-align:right; font-size:0.8em; line-height:1em;">
                    	<small>NOME:</small> <strong><?=  $_SESSION["nome"]. " " . $_SESSION["sobrenome"] ; ?></strong><br>
                        <small>Ultimo acesso em:</small><strong> <?= date("d/m/Y H:i", strtotime($_SESSION['ultimo_acesso'])); ?></strong><br>
                        <p><a href="aluno.logout.php"><i class="icon-off"></i> SAIR</a> - <?= $_SESSION["id_aluno"]; ?>
                    </div>
                </div>
                <div class="row-fluid" style="padding-top: 25px;">
                <!-- Conteúdo da página a partir daqui -->
                	
                    <?php
						// verficar vagas
						$sql = "SELECT * FROM  matricula WHERE id_evento = ". $_SESSION['evento_atual'] . " AND status >= 2 AND hospedagem = 1"  ;
						if(!$result = $con->query($sql)){
							die('Há um erro ao executar a pesquisa na base de dados [' . $con->error . ']');
						}
						$vagas = $_SESSION['evento_iw'] - mysqli_num_rows( $result );
						// modificar botão conforme disponibilidade de vagas
						if ($vagas > 10) {
							$vagas_disponivel = "muitas";
						} else {
							$vagas_disponivel = "poucas";
						}
						if ($vagas < 1) {
							$vagas_msg = "<span class='label label-important'>No momento estamos sem vagas para hospedagem!</span><br>
										Você poderá fazer a iscrição sem hospedagem, optado por dormir em outro lugar, por conta própria, ou poderá colocar sua inscrição em lista de espera.<br>
										Quem não ficar hospedado no Seminário Hosana terá um desconto de R$ 80,00.";
							$vagas_hospedagem_lista1 = "<option value='1' >Lista de espera</option>";
							$vagas_hospedagem_lista2 = "<option value='0' selected >Sem hospedagem</option>";
						} else {
							$vagas_msg = "<div>Temos {$vagas_disponivel} vagas para hospedagem</div>";
							$vagas_hospedagem_lista1 = "<option value='1' selected >Sim</option>";
							$vagas_hospedagem_lista2 = "<option value='0' >Não</option>";
						}
					?>
                    
                    <div class="widget ">
                	
                    <div class="widget-header">
	      				
	      				<h3><?=$TEXT['nova_inscricao']?></h3>
	  				</div> <!-- /widget-header -->

					<div class="widget-content">

                        <form id="add_inscricao" action="reinscricao.acao.php" class="form-horizontal" method="post"   enctype="multipart/form-data" />
                          <fieldset>

							
							<div class="control-group">
                                <label class="control-label" for="complemento"><?= $TEXT['aluno'] ?></label>
                                <div class="controls"><p style="padding-top:5px;">
									<?php
                                    	echo $_SESSION['nome']." ".$_SESSION['sobrenome'];
									?>
                                </p></div> <!-- /controls -->
                            </div> <!-- /control-group -->
							
							<!-- hidden inputs -->
                            <input type="hidden" id="id_aluno" name="id_aluno" value="<?=$id_aluno?>" />
                            <input type="hidden" id="vagas" name="vagas" value="<?=$vagas?>" />
			    
							<div class="control-group">
								<label class="control-label" for="id_evento"><?= $TEXT['sel_evento'] ?></label>
								<div class="controls">
									<select name="id_evento" id="id_evento" >
										<?php
                                        # Selecionar o evento padrão e comparar datas para ver se tem um evento futuro
                                        
                                        # $sql = 'SELECT evento_padrao FROM config WHERE id = 1';
										$sql = "SELECT * FROM evento WHERE data_fim > NOW() ORDER BY data_ini DESC";
										
										$tabela = mysqli_query($con,$sql);
										
										while ($dados = mysqli_fetch_array($tabela)) {
											echo "<option value={$dados['id_evento']} >{$dados['descricao']}</option>";
										}
										?>
									</select> 
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="id_curso"><?= $TEXT['curso'] ?></label>
								<div class="controls">
									<select name="id_curso" id="id_curso">
                                        <option value=''></option>
										<?php
										// Buscar o modulo que o aluno estára fazendo a matricula
										$sql = "SELECT * FROM cursos;";
										
										$tabela = mysqli_query($con,$sql);
										
										while ($dados = mysqli_fetch_array($tabela)) {
                                            #$disabled = ($dados['id_curso'] == 7 ? 'disabled': ''); #desabilita algum curso pelo id...
											echo "<option value={$dados['id_curso']} {$disabled} >{$dados['nome_curso']}</option>";
										}
										?>
									</select>
								</div>
							</div>
							
                            <div class="control-group">
                                <label class="control-label" for="hospedagem">Hospedagem:</label>
                                <div class="controls">
                                    <select name="hospedagem" id="hospedagem">
                                    	<?= $vagas_hospedagem_lista1 ?>
                                        <?= $vagas_hospedagem_lista2 ?>
                                    </select>
                                    <br><span class='dicas'><?= $vagas_msg ?></span>
                                </div> <!-- /controls -->
                            </div> <!-- /control-group -->                            
							
                            <div class="control-group">
                                <label class="control-label" for="complemento"><?= $TEXT['obs'] ?></label>
                                <div class="controls">
                                    <textarea name='obs' id='obs'></textarea><br>
									Escrever observões especiais quanto a hospedagem e quaisquer outra informação que o SH precise saber antecipadamente.
                                </div> <!-- /controls -->
                            </div> <!-- /control-group -->

                            <div class="control-group">
                                <div class="controls">
                                    <input type='submit' class='btn btn-large btn-success' >
                                    <a class="btn btn-primary" href="aluno.home.php">Voltar</a>
                                </div> <!-- /controls -->
                            </div> <!-- /control-group -->

                          </fieldset>
                        </form>
                        
                        
                        


                    </div><!-- /widget-content -->

                
				</div><!-- /widget -->
                    
                    
                <!-- /COnteúdo -->
            	</div> 
            </div>
        </div>
        
        
        <!-- RODAPÉ E MODAL -->
        <div class="main-footer container">
        	<div class="row">
                <hr>
                <footer>
                    <?= BOTTON_A ?>
                </footer>
            </div>
        </div>
        
        
        <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
        <script src="js/vendor/jquery-1.9.1.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.js"><\/script>')</script>
        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
        
        <!-- Mensagem de aviso aos usuário tipo MODAL -->
       <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="myModalLabel">Atenção</h3>
          </div>
          <div class="modal-body">
            <p><?=$msg?></p>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Fechar</button>
         </div>
       </div>
        
	</body>
</html>