<?php
/*
 *
 * Ficha de inscrição para o congresso hosana
 */

// ir para index de sistema offline
die(header("Location: index.html"));

// Comentar esta linha depois de testado
error_reporting(E_ALL);

 //timezone
date_default_timezone_set('America/Sao_Paulo');

// salt para segurança das senhas com 12 caracteres!
const SALT2 = 'qyW2rPk59iI1';

include 'i_secao.evento.default.php';

// verifica se veio do sistema ou do próprio
$logado = isset($_SESSION["congresso"]) ? TRUE : FALSE ;

// Acao do botao sair - log out
if (!empty($_GET['sair'])) {

    //$_SESSION = array();
    //session_destroy();
    $_SESSION["congresso"] = null;
    
    die(header("Location: congresso.add.php?out"));
}

// Alterar pagamento
if (!empty($_GET['pid'])) {
    $id = base64_decode($_GET['pid']);
    $nome = base64_decode($_GET['pn']);
    $acao = $_GET['pa'];
    $acaoTxt = $_GET['pa']=="TRUE" ? 'PAGO' : 'NÃO PAGO';

    $sql = "UPDATE congresso
            SET pago=$acao
            WHERE ID=$id
    ";

    if(!$result = $con->query($sql)){
        $_SESSION['msg'] = "Ha um erro ao executar a pesquisa na base de dados matricula: [' . $con->error . ']";
        die(header("Location: congresso.add.php"));        
        }
    
    $_SESSION['msg'] = "A inscrição de {$nome} foi mudada para {$acaoTxt}.";
    $_SESSION['msg_tipo'] = 'alert-success';
    die(header("Location: congresso.add.php"));
}

// login
if (!empty($_POST['login']))
{
    $usuario = (isset($_POST['user'])) ? $_POST['user'] : '';
    $senha = (isset($_POST['senha'])) ? $_POST['senha'] : '';

    // Codifica senha para depois comparar o com banco de dados
    $senha = sha1(SALT2.$senha);

    // Monta a consulta para buscar os dados que serão comparados
    $sql = "SELECT * FROM user where login='".$usuario."' and senha='".$senha."'";
    
    $tabela = mysqli_query($con,$sql);
    $dados = mysqli_fetch_array($tabela);
    
    // se o resultado retornar uma linha é porque temos um usuário valido
    if (isset($dados)) {
        $_SESSION['nome_user'] = $dados['nome'];
        $_SESSION["usuario"] = $dados['login'];

        $_SESSION['msg'] = "Bem-vindo {$_SESSION['nome_user']}, voce esta logado. ";
        $_SESSION['msg_tipo'] = 'alert-success';
        $_SESSION['congresso'] = '1726gdfhjhcbd5Fdc3Ds';

        header("Location: congresso.add.php");
        die();
    } else {
        $_SESSION = array();
        session_destroy();
        
        header("Location: congresso.add.php");
        die();
    }
}

// Inserir dados do formulário na BD
if (!empty($_POST['btnenviar']))
{
    #var_dump($_POST);
    

    if ( strlen(trim($_POST['inputNome'])) == 0 ) {
		$_SESSION['focus']="inputNome";
        echo header("Location: congresso.add.php");
        die();
    }
    if (!$logado) {
        if ( strlen(trim($_POST['inputEmail'])) == 0 ) {
            $_SESSION['focus']="inputEmail";
            echo header("Location: congresso.add.php");
            die();
        } 
    }

    $nome = "'".$_POST["inputNome"]."'";

    $email = empty($_POST['inputEmail']) ? "NULL" : "'".$_POST['inputEmail']."'";
    $cidade = empty($_POST['inputCidade']) ? "NULL" : "'".$_POST['inputCidade']."'" ;
    $cel = empty($_POST['inputTcel']) ? "NULL" : "'".$_POST['inputTcel']."'";
    $igreja = empty($_POST['inputIgreja']) ? "NULL" : "'".$_POST['inputIgreja']."'";
    $pago = isset($_POST['inputPag']) ? "TRUE" : "FALSE";

    $sql = "INSERT INTO congresso (
        nome,
        email,
        cidade,
        cel,
        igreja,
        pago
    )
    VALUES (
        $nome,
        $email,
        $cidade,
        $cel,
        $igreja,
        $pago
    )";


    // executa a acao adicionando os dados na base de dados e verifica os erros
	if(!$result = $con->query($sql)){
        $_SESSION['msg'] = "Ha um erro ao executar a pesquisa na base de dados matricula: [' . $con->error . ']";
        die(header("Location: congresso.add.php"));
        
        }    

    $_SESSION['msg'] = "A inscrição de {$nome} foi inserida com sucesso.";
    die(header("Location: congresso.add.php"));
}

if (!empty($_POST['btndel']))
{
    #var_dump($_POST);

    $sql="DELETE FROM congresso WHERE id={$_POST['inputId']}";
    if ($con->query($sql) === TRUE) {
        
        $total = mysqli_affected_rows($con);

        if ($total<>0) {

            $_SESSION['msg'] = $total." registro apagado com sucesso";
            $_SESSION['msg_tipo'] = 'alert-success';

        } else {

            $_SESSION['msg'] = 'Nenhum registro excluído';  

        }        
        
    } else {
        $_SESSION['msg'] =  "Houve algum problema ao tentar apagar. Erro: " . $con->error;        
        
    }
    $con->close(); 
    die(header("Location: congresso.add.php"));
}

// verificar se tem algum campo predefinido para focar
$campo_cursor = '';

if(isset($_SESSION['focus'])){
        $campo_cursor = $_SESSION['focus'];
        unset($_SESSION['focus']);
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Congresso Hosana - Inscrição</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <!--[if IE]><link rel="shortcut icon" href="img/favicon.ico"><![endif]-->
	
        <link rel="icon" href="img/favicon.png">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <!-- mascaras de entradas dos campos de formulário -->
	    <script type="text/javascript" src="js/jquery/jquery-1.3.2.js"></script>
        <!--<script src="js/jquery/jquery.inputmascara.js" type="text/javascript"></script>-->
        <script src="js/jquery/jquery.mask.min.js" type="text/javascript"></script>

        <script>
            function vermsg($msg)
            {
                    if ( $msg.length > 0 ) {
                            $('#myModal').modal('show');
                    }
            }
	    </script>
    </head>
    <body>

 
        <div class="container" style='margin-top: 40px;'> 
        <?php include 'm_top.alunos.php'; ?>          

            <?php if (isset($msg)) { ?>
                <div class="row" style='padding-bottom: 20px'>
                    <div class="alert <?=$msg_tipo?> fade in">
                        <a class="close" data-dismiss="alert">×</a>
                        <?=$msg?>
                    </div>
                </div>
            <?php } ?>

            <div class="row" style='padding-bottom: 20px'>
                <div class="row-fluid" style="background-image:url(img/h48.png); background-position: left center; background-repeat:no-repeat;">
                        <h3 style="padding-left:55px">Congresso</h3>
                </div>
            </div>

            <div class="row">
                <!-- Coluna formulario da direita -->
                <div class="span8 offset2">
                    
                    <!-- Conteúdo principal -->
                
                    <div class="hero-unit form-horizontal">  
                        
                        <!-- Formulario de inscrição -->                                   
                        <form name="btnenviar" id="btnenviar" class="form-inline" method="post" action="congresso.add.php" onsubmit="document.getElementById('btnenviar').disabled = 1;">
                            
                            <legend><i class="icon24" style="background-image:url(img/icon-diploma&24.png);"></i> Inscrição</legend>
                    
                            <div class="control-group">
                                <label class="control-label" for="inputNome">Nome </label>
                                <div class="controls">
                                    <input type="text" id="inputNome" name="inputNome" title="Digite o nome" value="<?php echo(isset($_SESSION['input_nome'])?$_SESSION['input_nome']:''); ?>" placeholder="Nome" onblur="this.value=this.value.toUpperCase()" /> 
                                    <br><?php echo($campo_cursor=='inputNome'?"<span class='label label-warning'>Preenchimento Obrigatório</span>":''); ?>
                                </div>
                            </div> 
                            
                            <div class="control-group">
                                <label class="control-label" for="inputEmail">E-mail</label>
                                <div class="controls">
                                    <input type="email" id="inputEmail" name="inputEmail" title="Insira o e-mail"  value="<?php echo(isset($_SESSION['input_email'])?$_SESSION['input_email']:''); ?>" placeholder="E-mail" /> 
                                    <span class="label label-important" id="resultadoMail"></span>
                                    <br><?php echo($campo_cursor=='inputEmail'?"<span class='label label-warning'>Preenchimento Obrigatório</span>":''); ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="inputCidade">Cidade</label>
                                <div class="controls">
                                    <input type="text" id="inputCidade" name="inputCidade"  value="<?php echo(isset($_SESSION['input_cidade'])?$_SESSION['input_cidade']:''); ?>" onblur="this.value=this.value.toUpperCase()" title="Cidade" placeholder="Cidade" data-provide="typeahead" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inputTcel">Telefone Celular</label>
                                <div class="controls">
                                    <input type="text" id="inputTcel" name="inputTcel" title="Insira o celular com o DDD" value="<?php echo(isset($_SESSION['input_tcel'])?$_SESSION['input_tcel']:''); ?>" placeholder="Celular" />
                                </div>
                            </div>
                            
                            
                            <div class="control-group">
                                <label class="control-label" for="inputIgreja">Igreja</label>
                                <div class="controls">
                                    <input type="text" id="inputIgreja" name="inputIgreja" value="<?php echo(isset($_SESSION['input_igreja'])?$_SESSION['input_igreja']:''); ?>" onblur="this.value=this.value.toUpperCase()" title="Insira a a que você é membro" placeholder="Igreja" /> 
                                </div>
                            </div>

                            <?php if ($logado)
                                {
                            ?>
                            <div class="control-group">
                                <label class="control-label" for="inputPag">Pagamento</label>
                                <div class="controls">
                                    <input type="checkbox" id="inputPag" name="inputPag" value="TRUE">
                                    <label for="inputPag">Pago</label>
                                </div>
                            </div>
                            <?php 
                                }
                            ?>              
                            
                            <div class="control-group">
                            <div class="controls">
                                <button type="submit" class="btn" name="btnenviar" value='10' >Enviar</button> <a href="./session.zerar.php" class="btn">Limpar</a>
                            </div>
                            </div>
                                            
                        </form>
                        <!-- / Formulário de inscrição -->

                    </div><!-- /hero-unit form-horizontal -->
                </div><!-- /span8 offset2 -->
            </div><!-- /row -->
        
            <div class='row'>
                <?php if ($logado)
                {                    
                    $orderby = empty($_GET['orderby']) ? 'nome' : $_GET['orderby'];
                    $orderby = $con->real_escape_string($orderby);
                    
                    $sql = "SELECT * FROM congresso ORDER BY $orderby";

                    $tabela = $con->query($sql);

                    echo "<table class='table table-striped table-bordered'><thead><tr>
                        <th><a href='?orderby=id'>#</a></th>
                        <th><a href='?orderby=nome'>Nome</a></th>
                        <th><a href='?orderby=email'>E-mail</a></th>
                        <th><a href='?orderby=cel'>Celular</a></th>
                        <th><a href='?orderby=cidade'>Cidade</a></th>
                        <th><a href='?orderby=igreja'>Igreja</a></th>
                        <th><a href='?orderby=pago'>Pago</a></th>
                        </tr></thead><tbody>";

                    if ($tabela->num_rows > 0) {
                        $x = 0;
                        while($row = $tabela->fetch_assoc()) {
                            $x = $x+1;
                            $id64 = base64_encode($row['id']);
                            $nome64 = base64_encode($row['nome']);
                            $pagoStr = $row["pago"] ? "<a class='btn btn-mini' href='?pid={$id64}&pn={$nome64}&pa=FALSE'><i class='icon-ok'></i></a>" : "<a class='btn btn-mini btn-primary' href='?pid={$id64}&pn={$nome64}&pa=TRUE'>Pagar</a>";
                            echo "<tr><td>". $x ."</td><td>". $row["nome"]. " (". $row['id'] .")</td><td>" . $row["email"]. "</td><td>" . $row["cel"]. "</td><td>" . $row["cidade"] ."</td><td>" . $row["igreja"] . "</td><td style='text-align: center;'>" . $pagoStr. "</td><tr>";
                        }
                    } else {
                        echo "Sem incrições ainda";
                    }
                    $con->close();

                    echo "</table>";


                } else {
                
                ?>



                <!-- Linha com colunas para informações auxiliares  -->
                <div class="row">
                    <div class="span4">
                        <address>
                        <i class="icon-home"></i><strong> Escritório Administrativo</strong><br>
                        Rua Caraíbas, nº 424<br>
                        Vila Casoni - 86026-560 - Londrina - PR<br>
                        </address>
                    </div>
                    <div class="span4">
                        <address>
                        <i class="icon-info-sign"></i><strong> Contato</strong><br>
                        <abbr title="Phone">Tel:</abbr> (43) 3325 1424<br>
                        <a href="mailto:secretaria@seminariohosana.com.br">secretaria@seminariohosana.com.br</a><br>
                        </address>
                    </div>
                    <div class="span4">
                        <address>
                            <i class="icon-question-sign"></i><strong> Suporte Técnico</strong><br>
                            <abbr title="Telefone Celular">Tel:</abbr> (43) 9152-2015 <br />
                            <a href="mailto:pastorlisanias@gmail.com">pastorlisanias@gmail.com</a>
                        </address>
                    </div>
                </div>

                <div class='row' style='text-align:center;background-color:#eee'>  
                        
                    <!-- Formulario de inscrição --> 
                    <form name="login" id="login" class="form-inline" method="post" action="congresso.add.php" onsubmit="document.getElementById('btnenviar').disabled = 1;" style="margin-top:20px">
                        
                        <input type="text" class='input-small' id="user" name="user" title="Digite o usuario" placeholder="Login" /> 
                        <input type="password" class='input-small' id="senha" name="senha" title="Insira a senha" /> 
                        <button type="submit" class="btn" name="login" value='login' >Login</button>
                    </form>
                            
                </div><!-- /row form-horizontal -->

                <?php 
                    }
                ?>
                
            </div><!-- /row -->

            <?php if ($logado)
                {  
            ?>

            <div class="row">
                <form name="btndel" id='btndel' class="form-inline" method="post" action="congresso.add.php" onsubmit="document.getElementById('btndel').disabled = 1;">
                    
                    <input type="text" id="inputId" name="inputId" title="Digite o nome" placeholder="Id" onblur="this.value=this.value.toUpperCase()" />
                        
                    <button type="submit" class="btn" id='btndel' name="btndel" value="10" >Apagar</button>

                    <a href="congresso.add.php?sair=out" class="btn btn-alert" style="float: right;">Sair</a>
                        
                </form>
            </div>

            <?php 
                }
            ?>

            <hr>
            <footer>
                <p><img src="img/favicon.png" alt="WebiGSiS" width="24" height="24"> &copy; WebiGSiS 2019 </p>
            </footer>
        </div><!-- /container --> 
        
        
            
        <!-- MODAL -->
        <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
        <script src="js/vendor/jquery-1.9.1.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
        
        <!-- Mesagem de aviso que aperece por cima da pagina -->
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
        
    </body>
</html>
