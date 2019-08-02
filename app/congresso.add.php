<?php
/*
 *
 * Ficha de inscrição para o congresso hosana
 */

// Comentar esta linha depois de testado
error_reporting(E_ALL);

// definir variáveis da página
$pg_titulo = "Congresso - Hosana SiS";
$pg_nome = "home.php";
$pg_menu = "home";

// Incluir informações iniciais agrupadas
include_once ('./inc/grupo.topo.php');

if (!empty($_POST))
{
    if ( strlen(trim($_POST['inputNome'])) == 0 ) {
		$_SESSION['focus']="inputNome";
        echo header('Location: congresso.add.php');
        die();
    }
    if ( strlen(trim($_POST['inputEmail'])) == 0 ) {
		$_SESSION['focus']="inputEmail";
        echo header('Location: congresso.add.php');
        die();
    } 

    $nome = "'".$_POST["inputNome"]."'";

    $email = empty($_POST['inputEmail']) ? "NULL" : "'".$_POST['inputEmail']."'";
    $cidade = empty($_POST['inputCidade']) ? "NULL" : "'".$_POST['inputCidade']."'" ;
    $cel = empty($_POST['inputTcel']) ? "NULL" : "'".$_POST['inputTcel']."'";
    $igreja = empty($_POST['inputIgreja']) ? "NULL" : "'".$_POST['inputIgreja']."'";

    $sql = "INSERT INTO congresso (
        nome,
        email,
        cidade,
        cel,
        igreja
    )
    VALUES (
        $nome,
        $email,
        $cidade,
        $cel,
        $igreja
    )";

    // executa a acao adicionando os dados na base de dados e verifica os erros
	if(!$result = $con->query($sql)){
        $_SESSION['msg'] = "Ha um erro ao executar a pesquisa na base de dados matricula: [' . $con->error . ']";
        die(header("Location: congresso.add.php"));
        
        }    

    $_SESSION['msg'] = "A inscrição de {$nome} foi inserida com sucesso.";
    die(header('Location: congresso.add.php'));
}

// verificar se tem algum campo predefinido para focar
$campo_cursor = '';

if(isset($_SESSION['focus'])){
		$campo_cursor = $_SESSION['focus'];
}

// verifica se veio do sistema ou do próprio

// Limpa todas as variaáveis de sessão
// $_SESSION = array()

?>

<!-- #########     CONTEÚDO PRINCIPAL     ########## -->
<div class="main">

    <div class="main-inner">
        <div class="container">
                
            <div class="row">
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
                        <form name="aluno" class="form-inline" method="post" action="congresso.add.php" onsubmit="document.getElementById('btnenviar').disabled = 1;">
                            
                            <legend><i class="icon24" style="background-image:url(img/icon-diploma&24.png);"></i> Curso</legend>
                    
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
                                    <br><span style="font-size: 0.6em; font-style:italic; line-height:.6em">(Digite apenas os numeros com o DDD)</span>
                                </div>
                            </div>
                            
                            
                            <div class="control-group">
                                <label class="control-label" for="inputIgreja">Igreja</label>
                                <div class="controls">
                                    <input type="text" id="inputIgreja" name="inputIgreja" value="<?php echo(isset($_SESSION['input_igreja'])?$_SESSION['input_igreja']:''); ?>" onblur="this.value=this.value.toUpperCase()" title="Insira a a que você é membro" placeholder="Igreja" /> 
                                </div>
                            </div>                      
                            
                            <div class="control-group">
                            <div class="controls">
                                <button type="submit" class="btn" id="btnenviar" >Enviar</button> <a href="./session.zerar.php" class="btn">Limpar</a>
                            </div>
                            </div>
                                            
                        </form>
                        <!-- / Formulário de inscrição -->

                    </div><!-- /hero-unit form-horizontal -->
                </div><!-- /span8 offset2 -->
            </div><!-- /Row -->

        </div>
    </div>           

</div> <!-- /main -->
<!-- /########     /contúdo principal     ########## -->

<?php
  include ('./inc/botton.php');
?>
