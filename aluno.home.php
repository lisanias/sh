<?php
/*
 * 
 * Área do aluno:
 * Ver os cursos que fez, em que curso está matriculado.
 * Mandar comprovante de pagamento da iscrição e mensalidades.
 * Fazer incrição para cursos, para quem ja esta cadastrado.
 * 
 */
error_reporting(E_ALL) ;

include("aluno.seguranca.php"); // Inclui o arquivo com o sistema de segurança
include("i_funcoes.php");
include './aluno./config.ini.php';
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
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="icon" href="img/favicon.png">

        <!-- UIkit -->
        <link rel="stylesheet" href="css/uikit-3.1.6/css/uikit-rtl.min.css">
        
        
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
                        <p><a href="aluno.logout.php"><i class="icon-off"></i> SAIR</a>
                    </div>
                </div>
                <div class="row-fluid">
                	<div class="alert alert-info" style=" padding:10px 0;margin:10px 0; text-align:center; ">
                        <h4 class="text-info">Próximo Modulo: <?= $_SESSION['evento_atual_nome'] ?> (<?= date("d/m/Y", strtotime($_SESSION['evento_data_ini'])); ?> a <?= date("d/m/Y", strtotime($_SESSION['evento_data_fim'])); ?>)</h4>
                    </div>
                </div>

                <?php if ($ambiente == 'sandbox') { ?>
                    <!-- AVISO AOS pela base de dados -->
                    <div class="alert alert-danger text-center">
                        <strong>Pagamento em plataforma de teste!</strong>
                    </div>
                <?php } ?>

                <div class="row-fluid" style="padding-top: 25px;">
                	<div class="span4">
                    	<div class="control-group">
                                
                                <!-- Módulo DADOS DO ALUNO -->
                                <legend>
                                	<a href="aluno.edit.php" id="editar" class="btn btn-small btn-primary pull-right" type="button" >Editar Perfil</a>
                                    <i class="icon24" style="background-image:url(img/icon_contact_card_&24.png);"></i> Meu perfil
                                </legend>
                                
                                <div class="contorno-fundo dpesoalcss">
                                	<table class="table">
<?php

$sql = "SELECT * FROM alunos WHERE id_aluno = " . $_SESSION['id_aluno'];
$consulta = mysqli_query($con,$sql);
$dados = mysqli_fetch_array($consulta);

echo "<tr><td class='tdd'>NOME:</td><td>" . $dados['nome'] . " " . $dados['sobrenome'] . "</td></tr>";
echo "<tr><td class='tdd'>E-MAIL:</td><td>" . $dados['email'] . "</td></tr>";
echo "<tr><td class='tdd'>CPF:</td><td>" . $dados['cpf'] . "</td></tr>";
echo "<tr><td class='tdd'>ENDEREÇO:</td><td>" . $dados['endereco'] . "</td></tr>";
echo "<tr><td class='tdd'>COMPLEMENTO:</td><td>" . $dados['complemento'] . "</td></tr>";
echo "<tr><td class='tdd'>BAIRRO:</td><td>" . $dados['bairro'] . "</td></tr>";
echo "<tr><td class='tdd'>CIDADE:</td><td>" . $dados['cidade'] . "</td></tr>";
echo "<tr><td class='tdd'>ESTADO:</td><td>" . $dados['uf'] . "</td></tr>";
echo "<tr><td class='tdd'>CEP:</td><td>" . $dados['cep'] . "</td></tr>";
echo "<tr><td class='tdd'>TEL. RESIDENCIAL:</td><td>" . $dados['tres'] . "</td></tr>";
echo "<tr><td class='tdd'>TEL. CELULAR:</td><td>" . $dados['tcel'] . "</td></tr>";
echo "<tr><td class='tdd'>DATA NASCIMENTO:</td><td>" . implode('/',array_reverse(explode('-',$dados['dnas']))) . "</td></tr>";
echo "<tr><td class='tdd'>ESTADO CIVIL:</td><td>" . ec($dados['estado_civil']). "</td></tr>";
echo "<tr><td class='tdd'>IGREJA:</td><td>" . $dados['igreja'] . "</td></tr>";
echo "<tr><td class='tdd'>OBS</td><td>" . $dados['obs'] . "</td></tr>";
?>
								</table>
                                </div>
                        </div>
                    </div>
                    <div class="span4">
                    	<div class="control-group">
                        	<!-- Módulo do histórico escolar - não pode ser alterado pelo aluno -->
                            <!-- Curso que está inscrito, se estiver inscrito para algum -->


      	
<?php
// verificar se tem vagas
$sql = "SELECT * FROM  matricula WHERE id_evento = ". $_SESSION['evento_atual'] . " AND status >= 2 AND hospedagem = 1"  ;
if(!$result = $con->query($sql)){
	die('Ha um erro ao executar a pesquisa na base de dados [' . $con->error . ']');
}
$vagas = $_SESSION['evento_iw'] - mysqli_num_rows( $result );
// modificar botão conforme disponibilidade de vagas
if ($vagas > 0) {
	$vagas_class = "btn-primary";
	$vagas_txt = "Inscrição";
	$vagas_title = "Faça sua inscrição para o próximo módulo";
} else {
	$vagas_class = "btn-danger";
	$vagas_txt = "Inscrição";
	$vagas_title = "Incrição sem hospedagem ou em lista de espera";
}

// mostrar matricula para proximo modulo se houver.
// ou mostra o boão para nova matricula.
$sql = "SELECT * FROM matricula 
		INNER JOIN 
			modulo ON matricula.id_modulo = modulo.id_modulo 
		INNER JOIN 
			cursos ON modulo.id_curso = cursos.id_curso 
		WHERE id_aluno = {$_SESSION['id_aluno']} AND matricula.id_evento = {$_SESSION['evento_atual']}";
$consulta = mysqli_query($con,$sql);
$dados = mysqli_fetch_array($consulta);

?>
                            	
                                <legend>                                	
                                    <?php
  	                                	if (!$dados) {
											echo "<a class='btn {$vagas_class} btn-small pull-right' href='./reinscricao.php' title='$vagas_title' >{$vagas_txt}</a>";
										}
									?>
                                    <i class="icon24" style="background-image:url(img/icon_student_24.png);"></i>Cursos
                                </legend>
                                 
                                
                            <!-- Histórico escolar dos mádulos ja feitos pelo aluno - não pode ser alterado pelo aluno -->
<?php
if ($dados) {
	$curso_nome = $dados['nome_curso'];
	$curso_abrev = $dados['abreviatura'];
    $valor = $dados['valor'];
    $aVista = $dados['aVista'];
    $desconto = $dados['desconto'];
	
	// opção de texto alternativo para diferentes status
	$status_alt_texto = '';
	if ($dados['status'] == 2) {
		$status_alt_texto = "Voce tem até ". implode('/',array_reverse(explode('-',$dados['data_comprovante']))) ." para efetuar o pagamento e enviar o comprovante";
	}
	if ($dados['status'] == 0) {
		$status_alt_texto = "O prazo para efetuar o pagamento da sua inscrição terminou em ". implode('/',array_reverse(explode('-',$dados['data_comprovante']))) .".<br />Para reativar sua inscrição, entre em contato com a secretaria, que verificará a disponibilidade de vaga.";
	}
	if ($dados['status'] == 1) {
		$status_alt_texto = "Você está na lista de espera do SH. Se surgir uma vaga, estaremos entrando em contato com você por telefone e e-mail para dar novas instruções quanto a sua matricula.";
	}
	
	// mostrar calculo do valor final caso haja desconto
	//if (
	
	echo "<p><i class=' icon-play-circle' ></i> Incrição/Matricula: {$_SESSION['evento_atual_nome']}</p>";
	echo "<div class='contorno-fundo'><table class='table'>";
	echo 	"<tr><td class='tdd'>CURSO:</td><td>" . $dados['nome_curso'] . " (" . $dados['abreviatura'] . ")</td></tr>";
	echo	"<tr><td class='tdd'>MÓDULO:</td><td>" . $dados['modulo'] . "</td></tr>";
	echo	"<tr><td class='tdd'>HOSPEDAGEM:</td><td>" . ($dados['hospedagem']==1?'Sim':'Não') . "</td></tr>";
	echo 	"<tr><td class='tdd'>VALOR:</td><td>";
	echo 	"<tr><td class='tdd'>A prazo:</td><td>" . number_format($valor,2,",",".") . "</td></tr>";
	echo 	"<tr><td class='tdd'>A vista:</td><td>" . number_format($aVista,2,",",".") . "</td></tr>";
	if ($dados['desconto']>0){
		echo "<br><span style='font-size:9px;'>Outros descontos concedidos: " . number_format($desconto,2,",",".") . "</span></td></tr>";
    }
    
    /*
	echo 	"<tr><td class='tdd'>SITUAÇÃO:</td><td>";
    echo statusf ($dados['status']) . "<br><em>". $status_alt_texto;    
    echo "</em></td></tr>  ";
    */
	echo "</table>";
    
    echo "<div><a href='aluno/public/checkout.php' class='btn btn-small btn-success btn-block'>Pagar com Cartão</a></div>";

    if ($dados['status'] >= 3 and $dados['id_curso']==8) {
        
        echo "<div class='uk-card uk-card-default uk-card-body'>";
        echo "<p>Click no link abaixo para proseguir</p>";
        echo "<a href='https://capelaniacrista.org.br/agradece5.htm' class='uk-button uk-button-primary'>Curso de Capelania</a>";
        echo "</div>";
    }

    echo "</div>";
	if (!$dados['status'] || $dados['status']==1) {
		$modulo_financas = "off";
	} else {
		$modulo_financas = "on";
	}
	$inscricao_valor = number_format($dados['valor_inscricao_previa'],2,",",".") ;
	$valor_final = number_format($dados['valor'],2,",",".") ;
	$id_matricula = (int)$dados['id_matricula'];
	$prazo_pag = $dados['data_comprovante'];
	$matricula_status = $dados['status'];
}
else {
	$modulo_financas = "off";
}

?>
                            	
                                
<?php
// SESSAO MODULOS REALIZADOS...

$sql = "SELECT * FROM 
				matricula 
			INNER JOIN 
				modulo 
				ON matricula.id_modulo = modulo.id_modulo 
			INNER JOIN 
				cursos 
				ON modulo.id_curso = cursos.id_curso 
			INNER JOIN 
				evento 
				ON matricula.id_evento = evento.id_evento 
			WHERE 
				id_aluno = " . $_SESSION['id_aluno'] . " 
				AND (status = 5 OR status = 6)
			ORDER BY evento.data_ini";
			
$consulta = mysqli_query($con,$sql);
$hr = 0;
if ($linhas = mysqli_num_rows($consulta)) {
	echo "<p><i class='icon-list' ></i> Módulos Realizados:</p><div class='contorno-fundo'><ul>  ";
	while ($dados = mysqli_fetch_array($consulta)) {
	  if ($hr <> $dados['id_curso']) {
		  echo "<div style='background-color:#CCC; width:80%; height:1px; display:block; margin:5px 0;'></div>";
		  $hr = $dados['id_curso'];
	  }
  	  echo "<li>" . $dados['nome_curso'] . " | " . $dados['modulo'] . " | " . $dados['descricao'] . "</li>";
	}
	echo "</ul></div>";
	}
?>		

<?php
// SESSAO MODULOS REALIZADOS...

$sql = "SELECT * FROM 
				matricula 
			INNER JOIN 
				modulo 
				ON matricula.id_modulo = modulo.id_modulo 
			INNER JOIN 
				cursos 
				ON modulo.id_curso = cursos.id_curso 
			INNER JOIN 
				evento 
				ON matricula.id_evento = evento.id_evento 
			WHERE 
				id_aluno = " . $_SESSION['id_aluno'] . " 
				AND status = 7
			ORDER BY evento.data_ini";
			
$consulta = mysqli_query($con,$sql);
$hr = 0;
if ($linhas = mysqli_num_rows($consulta)) {
	echo "<p><i class='icon-list' ></i> Módulos Concluídos:</p><div class='contorno-fundo'><ul>  ";
	while ($dados = mysqli_fetch_array($consulta)) {
	  if ($hr <> $dados['id_curso']) {
		  echo "<div style='background-color:#CCC; width:80%; height:1px; display:block; margin:5px 0;'></div>";
		  $hr = $dados['id_curso'];
	  }
  	  echo "<li>" . $dados['nome_curso'] . " | " . $dados['modulo'] . " | " . $dados['descricao'] . "</li>";
	}
	echo "</ul></div>";
	}
?>	

	
                        </div>
                    </div>

                    <div class="span4"><!-- SESSÃO ENVIAR PAGAMENTOS - Ativo apenas para o próximo modulo (modulo ativo como padrão) -->
                    	<div class="control-group">
                            <legend>
                                <i class="icon24" style="background-image:url(img/icon_calc_&24.png);"></i> Pagamentos
                            </legend>
							<?php if ($modulo_financas == "on") { ?>
                            	
                          		<form action="aluno.upload.arquivo.php" id="form_pg" name="form_pg" method="post" enctype="multipart/form-data">
                                    <fieldset>
                                        <p><label for="Enviar arquivo"><i class="icon-upload"></i> Enviar comprovante: <?php echo "{$_SESSION['evento_atual_nome']} - <abbr title='{$curso_nome}'>{$curso_abrev}</abbr>"; ?></label></p>
                                        <div class="contorno-fundo">
                                        
                                            <input type="hidden" id="inp_id_matricula" name="inp_id_matricula" value="<?= $id_matricula ?>">
                                            <input type="hidden" id="inp_status_matricula" name="inp_status_matricula" value="<?= $matricula_status ?>">
                                            
                                            <div class="pull-left span6" style="padding:0; margin: 0;"><label for="inp_data">Data</label>
                                            <input class="span12" type="text" id="inp_data" name="inp_data" value="<?= date('d/m/Y'); ?>" required></div>
                                            
                                            <div class="pull-right span5" style="padding:0; margin: 0;" ><label for="inp_valor">Valor</label>
                                            <input class="span12" type="text" id="inp_valor" name="inp_valor" placeholder="R$" style="text-align: right;" required></div>
                                            
                                            <span class="clearfix"></span>
                                            
                                            <div class="pull-left span5" style="padding:0; margin: 0;">
                                                <label for="inp_forma_pg">Forma</label>
                                                <select id="inp_forma_pg" name="inp_forma_pg" class="span11" title="Forma de Pagamento" >
                                                    <option value="1">Crédito</option>
                                                    <option value="2">Débito</option>
                                                    <option value="3" disabled>Espécie</option>
                                                    <option value="4" selected>Depósito</option>
                                                    <option value="5">Cheque</option>
                                                    <option value="6" disabled>Boleto</option>
                                                    <option value="9" disabled>Outro</option>
                                                </select>
                                            </div>
                                            
                                            <div class="pull-right span7" style="padding:0; margin: 0;">
                                                <label for="inp_ref">Referente a</label>
                                                <select id="inp_ref" name="inp_ref" class="span12" >
                                                    <option value="1">Pg. valor total</option>
                                                    <option value="2" selected>Pg. Inscrição (R$ <?= $inscricao_valor ?>)</option>
                                                    <option value="3">Pg. de Parcela</option>
                                                </select>
                                            </div>
                                      		
                                            <div style="padding:0; margin: 0;">
                                                <label for="inp_descricao" class="span12">Descriçao</label>
                                                <input class="span12" type="text" id="inp_descricao" name="inp_descricao" >
                                            </div>
                                            <label for="arquivo">Envie uma foto do comprovante com no máximo 4Mb.</label>
                                            <input type="file" id="input_arquivo" name="arquivo" required />
                                            <input type="submit" min="btn_enviar" name="enviar" value="Enviar" class="btn btn-block btn-primary" />
                                            
                                            <div style="padding:25px 0 0 0; margin: 0;">
                                                <p style='font-weight:bold;'>Conta para depósito de inscrição prévia e parcelas:</p>
                                                <p><span style='color:red; font-weight:bold'>BANCO BRADESCO</span><br />
                                                Agência: <strong>0053-1</strong> C/C: <strong>121513-2</strong></p>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                             	
                            <?php } ?>
                            
                         </div>
                    </div>
                </div>
                
                <div class="row-fluid" style="padding-top: 25px;">
                	<div class="span12">
                    	<div class="control-group">
<!-- ######### LISTAGEM DOS PAGAMENTOS -->
<?php 
  	if ($modulo_financas == "on") { 
		$sql = "SELECT * FROM pagamento WHERE id_matricula = $id_matricula";
		$consulta = mysqli_query($con,$sql);

		if ($linhas = mysqli_num_rows($consulta)) {

		?>
<caption style="text-align:left"><i class='icon-shopping-cart' ></i> Histórico de pagamentos:</caption>
<div class="contorno-fundo">
<table class="table ">

  <thead>
    <tr>
      <th>Data</th>
      <th>Descrição</th>
      <th>Forma Pg.</th>
      <th>Referente a:</th>
      <th>Valor</th>
      <th>Status</th>
      <th>Cópia</th>
    </tr>
  </thead>
  <tbody>
<?php			
				$total_pago = 0;
				while ($dados = mysqli_fetch_array($consulta)) {
					echo "
						<tr><td>
							" . $dados['data_pg'] . " 
						</td><td>
							" . $dados['descricao'] . "
						</td><td>
							" . pg_formaf($dados['forma_pg']) ."
						</td><td>
							" . pg_reff($dados['ref_a']) . "
						</td><td>
							" . number_format($dados['valor'],2,",",".") . "
						</td><td>
							" . pg_statusf($dados['status']) . "
						</td><td>
							<a class='btn btn-success' href='aluno.img.comprovante.php?linkimg=". $dados['comprovante'] ."&datapg=" . $dados['data_pg'] . "&descricao=" . $dados['descricao'] . "&formapg=" . pg_formaf($dados['forma_pg']) . "&ref_a=" . pg_reff($dados['ref_a']) . "&valor=" . number_format($dados['valor'],2,",",".") . "&status=" . pg_statusf($dados['status']) . "' ><i class='icon-picture' ></i> Ver...</a>
						</td></tr>";
						$total_pago = $total_pago + $dados['valor'];
				}
				echo "</tbody></table>";
				// formatar numeros
				$total_pago_format = number_format($total_pago,2,",",".");
				echo "
					<table width='200px'>
						<tr>
							<td>Valor do curso</td>
							<td style='text-align:right;'>{$valor_final}</td>
						</tr>
						<tr>
							<td>TOTAL PAGO</td>
							<td style='text-align:right;'>{$total_pago_format}</td>
						</tr>
					";
				
				echo "</table>";
		}
		else {
			$prazo_pag_pt = implode('/',array_reverse(explode('-',$prazo_pag)));
			echo "Nenhum pagamento efetuado ainda.<br>Prazo para pagar e enviar o comprovante: {$prazo_pag_pt}.";
		}
?>


<?php
	}
?>

</div>
<!-- _________ /LISTAGEM DOS PAGAMENTOS -->
                        </div>
                    </div>
                 </div>
            </div>
        </div>
        <div class="main-footer container">
        	<div class="row">
                <hr>
                <footer>
                    <?= BOTTON_A ?>
                </footer>
            </div>
		</div>
		
		
		<!-- MODAL -->
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