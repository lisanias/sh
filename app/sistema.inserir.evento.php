<?php
/**
 *
 * Cadatrar eventos
 */

// definir variáveis da página
$pg_titulo = "Adminstrativo: inserir eventos - Hosana SiS";
$pg_nome = "sistema.inserir.evento.php";
$pg_menu = "sistema";

// incluir arquivo com parte inicial agrupadas
include_once('./inc/iniciar.php');

if (isset($_POST['evento'])) {
    $dataini = $_POST['dataini'];
    $datafim = $_POST['datafim'];
    $descricao = $_POST['descricao'];
    $vagas = $_POST['vagas'];

$sql = "INSERT INTO evento (
        id_local,
        data_ini,
        data_fim,
        descricao,
        insc_web
    ) VALUES (
        3,
        '" . implode('-',array_reverse(explode('/',$dataini))) . "', 
        '" . implode('-',array_reverse(explode('/',$datafim))) . "', 
        '" . $descricao . "', 
        '" . $vagas . "'
    )";

if(!$result = $con->query($sql)){
    $_SESSION['msg'] = "Ha um erro ao executar a pesquisa na base de dados alunos: [' . $con->error . ']";
    die(header("Location: sistema.inserir.evento.php"));
    }

// Pegar o id do modulo que o aluno está fazendo a matricula
$id_novo_evento = mysqli_insert_id($con);
$_SESSION['msg'] = "Evento adicionado com sucesso. Insira agora os módulos.";
$_SESSION['msg_tipo']="alert-success";
echo header("Location: sistema.inserir.modulos.php?id={$id_novo_evento}");

}

include_once ('./inc/grupo.topo.php');

?>



    <div class="main">

        <div class="main-inner">

            <div class="container">

                <div class="row">

                    <div class="span8">

                        <div class="widget ">

                            <br>

                            <div class="widget-header">
                                <i class="icon-cogs"></i>
                                <h3>Inserir Evento</h3>
                            </div> <!-- /widget-header -->

                            <div class="widget-content">
                                <div class="tabbable">
                                   
                                   <form name="evento" class="form-inline" method="post" action="sistema.inserir.evento.php">

                                        <input type="hidden" id="evento" name="evento" value="evento" /> 

                                        <div class="control-group">
                                            <label class="control-label" for="dataini"><i class="icon-calendar"></i> Data inicio </label>
                                            <div class="controls ">
                                              <input type="date" id="dataini" name="dataini" /> 
                                            </div>
                                        </div>

                                       <div class="control-group">
                                            <label class="control-label" for="datafim"><i class="icon-calendar"></i> Data final </label>
                                            <div class="controls ">
                                              <input type="date" id="datafim" name="datafim" /> 
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="descricao"><i class="icon-ticket"></i> Descrição </label>
                                            <div class="controls ">
                                              <input class="input-xxlarge" type="text" id="descricao" name="descricao" /> 
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="vagas"><i class="icon-group"></i> Vagas </label>
                                            <div class="controls ">
                                              <input type="text" id="vagas" name="vagas" /> 
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <div class="controls ">
                                              <input class="btn" type="submit" value="Enviar"> 
                                            </div>
                                        </div>

                                       
                                   </form>

                                </div>
                            </div> <!-- /widget-content -->

                        </div> <!-- /widget -->

                    </div> <!-- /span8 -->


                    <div class="span4">


                    </div> <!-- /span4 -->

                </div> <!-- /row -->

            </div> <!-- /container -->

        </div> <!-- /main-inner -->

    </div> <!-- /main -->


<?php
// inserir rodapé da página agrupado.
include ('./inc/botton.php');
?>