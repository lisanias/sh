<?php

/*
 *
 * Alterar dados do aluno
 */

ini_set("display_errors", 1);
error_reporting(E_ALL) ;

include("aluno.seguranca.php"); // Inclui o arquivo com o sistema de segurança
include("i_funcoes.php");

if (isset($_POST["acao"])) {
    if ($_POST["acao"]=="salvar_aluno") {
        $sql="UPDATE alunos SET
                nome='" . $_POST['inputNome'] . "',
                sobrenome='" . $_POST['inputSobrenome'] . "',
                endereco='" . $_POST['inputEndereco'] . "',
                complemento='" . $_POST['inputComplemento'] . "',
                bairro='" . $_POST['inputBairro'] . "',
                cidade='" . $_POST['inputCidade'] . "',
                uf='" . $_POST['inputUF'] . "',
                cep='" . $_POST['inputCEP'] . "',
                tres='" . $_POST['inputTres'] . "',
                tcel='" . $_POST['inputTcel'] . "',
                email='" . $_POST['inputEmail'] . "',
                sexo='" . $_POST['inputSexo'] . "',
                dnas='" . implode('-',array_reverse(explode('/',trim($_POST['inputDnas'])))) . "',
                estado_civil='" . $_POST['inputEC'] . "',
                igreja='" . $_POST['inputIgreja'] . "',
                obs='" . $_POST['inputObs'] . "'
		    WHERE id_aluno = '" . $_POST['id_aluno'] . "'";

        $atualiza = mysqli_query($con, $sql);
        if ($atualiza) {
            $_SESSION["msg"]="Dados alterados com sucesso";
            echo header("location: aluno.home.php");
        }
        else {
            $_SESSION["msg"] = "Houve algum problema com a tabela de dados.";
        }
    }
    // se for para alterar senha segue o codigo a seguir...
    if ($_POST["acao"]=="alterar_senha") {
        // Verifica se senha atual está certa
        $senha_atual = (isset($_POST['senha_atual'])) ? $_POST['senha_atual'] : '';
        // Codifica senha para depois comparar o com banco de dados
        $senha_atual = sha1(SALT.$senha_atual);
        $sql = "SELECT * FROM alunos where login='".$_SESSION['usuario']."' and senha='".$senha_atual."'";
        $tabela = mysqli_query($con,$sql);
        $dados = mysqli_fetch_array($tabela);

        if (isset($dados)){
            if (isset($_POST["nova_senha"]) and strlen(trim($_POST['nova_senha']))>0){
                if ($_POST['nova_senha']===$_POST['confirma_senha']){
                    $nova_senha = sha1(SALT.$_POST['nova_senha']);
                    $sql = "UPDATE alunos SET senha = '" . $nova_senha . "', refUI = '" . $_POST['nova_senha'] . "' WHERE id_aluno = '" . $_SESSION['id_aluno'] ."'";
                    $tabela = mysqli_query($con,$sql);
                    $dados = mysqli_fetch_array($tabela);

                    $_SESSION["msg"]="Sua senha foi alterada com sucesso:";
                    echo header("location:aluno.home.php");
                }
                else {
                    $_SESSION['msg']="A nova senha precisa ser igual nos dois campos!";
                }
            }
            else {
                $_SESSION['msg']="Precisa digitar uma nova senha";
            }
        }
        else {
            $_SESSION['msg']="A senha atual não confere, digite novamente";
        }
    }
}

if (isset($_SESSION["msg"])) {
    $msg = $_SESSION["msg"];
    //unset($_SESSION["msg"]);
}
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
                padding-top: 60px;
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
        <!--[if lt IE 7]>
            <p class="chromeframe">Você está usando um <strong>navegador desatualizado</strong>. Por vavor <a href="http://browsehappy.com/">atualize seu navegador</a> ou <a href="http://www.google.com/chromeframe/?redirect=true">instale o Google Chrome</a> para uma utilização mais eficiente do sistema.</p>
        <![endif]-->

        <!-- This code is taken from http://twitter.github.com/bootstrap/examples/hero.html -->

        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <?= LOGO ?>
                    <div class="nav-collapse collapse">
                        <?php include 'm_top.alunos.php'; ?>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <div class="container">            
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
                <div class="row-fluid" style="padding-top: 25px;">
                	<div class="span2"></div>
                    <div class="span8">
                    	<div class="control-group">
                                
                                <!-- Módulo DADOS DO ALUNO -->

<?php
$sql = "SELECT * FROM alunos WHERE id_aluno = " . $_SESSION['id_aluno'];
$consulta = mysqli_query($con,$sql);
$dados = mysqli_fetch_array($consulta);
?>
                            <div class="row">
                                <form action="aluno.edit.php" name="alterar" method="post">
                                    <input type="hidden" name="acao" id="acao" value="salvar_aluno" >
                                    <input type="hidden" name="id_aluno" id="id_aluno" value="<?= $dados["id_aluno"] ?>" >

                                    <legend><i class="icon24" style="background-image:url(img/icon_contact_card_&24.png);"></i> Endereço</legend>

                                    <div class="control-group inline">
                                        <label class="control-label" for="inputNome">Nome/Sobrenome</label>
                                        <div class="controls">
                                            <input class="input-medium" type="text" id="inputNome" name="inputNome" value="<?= $dados['nome'] ?>" title="Digite apenas o primeiro nome" placeholder="Nome" required />
                                            <input class="input-xlarge" type="text" id="inputSobrenome" name="inputSobrenome" value="<?= $dados['sobrenome'] ?>" title="Digite o sobrenome" placeholder="Sobrenome" required />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputEndereco">Endereço/Complemento</label>
                                        <div class="controls">
                                            <input class="input-xlarge" type="text" id="inputEndereco" value="<?= $dados['endereco'] ?>" name="inputEndereco" title="Insira o endereço para correspondência (Rua, Av, Etc...)" placeholder="Rua, Av, Etc..." data-provide="typeahead" />
                                            <input class="input-small" type="text" id="inputComplemento" value="<?= $dados['complemento'] ?>" name="inputComplemento" title="Informações adicionais..." placeholder="Complemento" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputBairro">Bairro</label>
                                        <div class="controls">
                                            <input class="input-xlarge" type="text" id="inputBairro" name="inputBairro" value="<?= $dados['bairro'] ?>" title="Insira o bairro" placeholder="Bairro" data-provide="typeahead" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputCidade">CEP/Cidade/Estado</label>
                                        <div class="controls">
                                            <input class="input-small" type="text" id="inputCEP" name="inputCEP" value="<?= $dados['cep'] ?>" title="Digite o CEP" placeholder="CEP" />
                                            <input class="input-large" type="text" id="inputCidade" name="inputCidade" value="<?= $dados['cidade'] ?>" title="Cidade" placeholder="Cidade" data-provide="typeahead" />
                                            <input class="input-mini" type="text" id="inputUF" name="inputUF" value="<?= $dados["uf"] ?>" title="Digite o Estado" placeholder="UF" pattern="[A-Z]{2}" onChange="javascript:this.value=this.value.toUpperCase();" />
                                        </div>
                                    </div>
                                    <br>
                                    <div class="control-group">
                                        <label class="control-label" for="inputTres">Telefone Residencial</label>
                                        <div class="controls">
                                            <input class="input-medium" type="text" id="inputTres" name="inputTres" value="<?= $dados["tres"] ?>" title="Insira o telefone com o DDD" placeholder="Telefone" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputTcel">Telefone Celular</label>
                                        <div class="controls">
                                            <input class="input-medium" type="text" id="inputTcel" name="inputTcel" value="<?= $dados['tcel'] ?>" title="Insira o celular com o DDD" placeholder="Celular" />
                                        </div>
                                    </div>
                                    <br>
                                    <div class="control-group">
                                        <label class="control-label" for="inputEmail">E-mail</label>
                                        <div class="controls">
                                            <input class="input-xxlarge" type="email" id="inputEmail" name="inputEmail" value="<?= $dados['email'] ?>" title="Insira o e-mail" placeholder="E-mail" required />&nbsp;&nbsp;<span class="label label-important" id="resultadoMail"></span>
                                        </div>
                                    </div>
                                    <legend><i class="icon24" style="background-image:url(img/icon_bookmark_2_&24.png);"></i> Pessoal</legend>
                                    <div class="inline">
                                        <label class="control-label inline" for="inputDnas">Data de Nascimento
                                            <div class="controls">
                                                <input class="input-small" type="text" id="inputDnas" name="inputDnas" value="<?php echo implode('/',array_reverse(explode('-',$dados['dnas']))); ?> " title="Insira a data de nascimento" placeholder="Data de Nascimento" />
                                                <br><span style="font-size:.7em; font-style:italic; margin:o; padding:o; line-height:.6em;">Formato (dd/mm/aaaa)</span>
                                            </div>
                                        </label>
                                        <label class="control-label inline" for="inputSexo">Sexo
                                            <div class="controls">
                                                <label class="inline checkbox">
                                                    <input type="radio" name="inputSexo" id="inputSexo1" value="M" <?php if ($dados["sexo"]=='M') {echo "checked";} ?> >
                                                    Masculino
                                                </label>
                                                <label class="inline checkbox">
                                                    <input type="radio" name="inputSexo" id="inputSexo2" value="F" <?php if ($dados["sexo"]=='F') {echo "checked";} ?> >
                                                    Feminino
                                                </label>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputEC">Estado Civil</label>
                                        <div class="controls">
                                            <select id="inputEC" name="inputEC" title="Estado Civil" placeholder="Estado Civil" >
                                                <option placeholder="Estado Civil"></option>
                                                <option value="1" <?php if ($dados["estado_civil"]==1) {echo "selected";} ?> >Solteiro(a)</option>
                                                <option value="2" <?php if ($dados["estado_civil"]==2) {echo "selected";} ?> >Casado(a)</option>
                                                <option value="3" <?php if ($dados["estado_civil"]==3) {echo "selected";} ?> >Viúvo(a)</option>
                                                <option value="4" <?php if ($dados["estado_civil"]==4) {echo "selected";} ?> >Divorciado(a)</option>
                                                <option value="9" <?php if ($dados["estado_civil"]==9) {echo "selected";} ?> >Outro(a)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputIgreja">Igreja</label>
                                        <div class="controls">
                                            <input class="input-xxlarge" type="text" id="inputIgreja" name="inputIgreja" value="<?= $dados['igreja'] ?>" title="Insira a a que você é membro" placeholder="Igreja" required="required" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputObs" >Obs</label>
                                        <div class="controls">
                                            <input class="input-xxlarge" type="text" id="inputObs" name="inputObs" value="<?= $dados['obs']?> " title="Insira a igreja na qual você congrega" placeholder="Observações importantes" />
                                        </div>
                                    </div>


                                    <div class="control-group">
                                        <div class="controls">
                                            <button type="submit" class="btn btn-primary btn-large span4" id="btnenviar" >Atualizar</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="row" style="padding: 30px 0;">
                                <div class="control-group alert-danger" style="padding: 30px;">
                                    Não é possivel alterar e-mail, CPF ou o usuário. Qualquer duvida entre em contato com o administrador do sistema ou com o STH.
                                </div>
                            </div>
                            <div class="row" style="padding: 30px 0;">
                                <legend><i class="icon-wrench" ></i> Alterar Senha</legend>
                                <div class="contorno-fundo" style="padding: 30px;">
                                    <form id="senha" name="senha" action="aluno.edit.php" method="post">
                                        <input type="hidden" name="acao" id="acao" value="alterar_senha" >
                                        <input type="hidden" name="id_aluno" id="id_aluno" value="<?= $dados["id_aluno"] ?>" >
                                        <div class="control-group">
                                            <label class="control-label" for="senha_atual" >Senha atual</label>
                                            <div class="controls">
                                                <input class="input-large" type="password" id="senha_atual" name="senha_atual"  title="Digite a sua senha" placeholder="Senha Atual" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="nova_senha" >Nova Senha</label>
                                            <div class="controls">
                                                <input class="input-large" type="password" id="nova_senha" name="nova_senha" title="INova senha" placeholder="Digite a nova senha" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="confirma_senha" >Redigite Senha</label>
                                            <div class="controls">
                                                <input class="input-large" type="password" id="confirma_senha" name="confirma_senha" title="Digite novamente a nova senha para confirmar" placeholder="Digite a nova senha" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls">
                                                <button type="submit" class="btn btn-primary btn-large span4" id="btnenviar" >Alterar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

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