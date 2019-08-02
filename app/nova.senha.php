<?php 
// definir variáveis da página
$pg_titulo = "Nova Senha - Hosana SiS";
$pg_nome = "nova.senha.php";
$pg_menu = "aluno";

// codigo a ser executado depois de iniciar a pagina e antes de terminar os includes
// esta função é chamada atomaticamente pelo include_once ('./inc/grupo.topo.php')
function executar () {
}

// Incluir informações iniciais agrupadas
include_once ('./inc/grupo.topo.php');

if (isset($_GET['session'])) {
	$default_session_id = $_GET['session'];
} else {
	$default_session_id = $_SESSION['evento'];
}
?>

<!-- #########     CONTEÚDO PRINCIPAL     ########## -->

</head>

<body>
<?php
// pegar dados do aluno
$idaluno_cod = $_GET["id"];
$idaluno = base64_decode($_GET["id"]);

$sql = "SELECT * FROM alunos WHERE id_aluno = " . $idaluno;
$consulta = mysqli_query($con,$sql);
$dados = mysqli_fetch_array($consulta);
?>
<div class="main">
    <div class="main-inner">
        <div class="container">
	      <div class="row">
	      	<div class="span12">
            	<br/>&nbsp;
                <div class="widget ">
                    <div class="widget-header">
	      				<i class='icon-user' ></i>
	      				<h3>Aluno</h3>
	  				</div> <!-- /widget-header -->

					<div class="widget-content">     
            			<h2><?= $dados['nome'] . " " . $dados['sobrenome'] ?></h2>
            		</div><!-- /widget-content -->
            	</div><!-- /widget -->
            </div><!-- /span12 -->
		  </div><!-- /row -->
          
         <div class="row">
	      	<div class="span6">
            	<div class="widget ">
                    <div class="widget-header">
	      				<i class='icon-edit' ></i>
	      				<h3>Nova Senha</h3>
	  				</div> <!-- /widget-header -->

					<div class="widget-content">    
<?php 
# definir senha para usuários do sistema
if (isset($_POST['senha'])) { 
	$senha = $_POST['senha'];
	$nova_senha = sha1('AjFqu8J8vC'.$senha);
	$sql_salvar = "UPDATE alunos SET senha = '" . $nova_senha . "' WHERE id_aluno = '" . $idaluno ."'";
	$tabela_salvar = mysqli_query($con,$sql_salvar);
	echo "<h4><br/>Senha: ".$senha."</h4>";
	echo "<p>Senha para o aluno (área do aluno): ".sha1('AjFqu8J8vC'.$senha)."</p>";
	echo "<br /><a class='btn btn-primary' href='aluno.php?id=". base64_encode($dados['id_aluno']) ."'>Ficha</a>";
} 
else {
	?>            
            <form action="nova.senha.php?id=<?=$idaluno_cod?>&id_no=<?=$idaluno?>" method="post">
            <br/>
            <div class="control-group ">
                <label class="control-label" for="inputNome">Digite a nova senha para o aluno</label>
	                <div class="controls">
    		            <p><input  class="input-medium" type="text" id='senha' name="senha" value="<?= gerasenha() ?>"><br /> 
                        <span class="small">Senha sugerida automaticamente, pode digitar outro valor pedido pelo aluno ou usar o CPF do aluno mostrado ai ao lado.<br />Não tem como sabermos a senha atual, tem sempre que criar uma nova.</span></p>
            		</div>    
            </div>
            
            <div class="control-group">
                <div class="controls">
                    <input type='submit' class='btn btn-large btn-success' value="Alterar" >
                    <a class="btn btn-primary" href="aluno.php?id=<?= base64_encode($dados['id_aluno']) ?>">Ficha</a>
                </div> <!-- /controls -->
            </div> <!-- /control-group -->
            </form>
   <?php
}
 
?>
		  			</div><!-- /widget-content -->
            	</div><!-- /widget -->
            </div><!-- /span6 -->
	      	<div class="span6">
            	<div class="widget ">
                    <div class="widget-header">
	      				<i class='icon-info' ></i>
	      				<h3>Info</h3>
	  				</div> <!-- /widget-header -->
                    <div class="widget-content">
                    	<div class="control-group ">
                            <label class="control-label" for="inputNome"><?=$TEXT['aluno']?></label>
                            <div class="controls">
                                <?= $dados['nome'] ?> <?= $dados['sobrenome'] ?>
                            </div>
                        </div><!-- /control-group -->
                        <div class="control-group ">
                            <label class="control-label" for="inputNome">ID | <?=$TEXT['login']?></label>
                            <div class="controls">
                                <?= $dados['id_aluno'] ?> / <?= base64_encode($dados['id_aluno']) ?> | <?= $dados['login'] ?><br/>
                            </div>
                        </div><!-- /control-group -->
                        <div class="control-group ">
                            <label class="control-label" for="inputNome"><?=$TEXT['cpf']?></label>
                            <div class="controls">
                                <?= $dados['cpf'] ?> (<?= limpaCPF_CNPJ($dados['cpf']) ?>)
                            </div>
                        </div><!-- /control-group -->
                    </div><!-- /widget-content -->
            	</div><!-- /widget -->
            </div><!-- /span6 -->
        </div>
        </div>
    </div>
 </div>

<!-- /########     /contúdo principal     ########## -->

<?php
  include ('./inc/botton.php');
?>

<?php
function limpaCPF_CNPJ($valor){
 $valor = trim($valor);
 $valor = str_replace(".", "", $valor);
 $valor = str_replace(",", "", $valor);
 $valor = str_replace("-", "", $valor);
 $valor = str_replace("/", "", $valor);
 return $valor;
}
?>