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

if (!isset($_GET['id'])) {
    die(header("Location: sistema.inserir.evento.php"));
} else {
    $id_evento = $_GET['id'];
}

if (isset($_POST['id_evento'])) {


# médio em teologia
$sql = "INSERT INTO modulo (
        id_curso,
        id_evento,
        modulo,
        sequencia,
        valor,
        valor_inscricao_previa
    ) VALUES (
        '1', 
        '" . $id_evento . "', 
        '" . $_POST['medio_modulo'] . "', 
        '" . $_POST['medio_numero'] . "', 
        '" . $_POST['medio_valor'] . "', 
        '" . $_POST['medio_inscricao'] . "'
    )";

if(!$result = $con->query($sql)){
    $_SESSION['msg'] = "Ha um erro ao executar a pesquisa na base de dados alunos: [' . $con->error . ']";
    die(header("Location: sistema.inserir.modulos.php?id={$id_evento}&p=1"));
    }


# pastoral infanto
$sql = "INSERT INTO modulo (
        id_curso,
        id_evento,
        modulo,
        sequencia,
        valor,
        valor_inscricao_previa
    ) VALUES ( 
        '2', 
        '" . $id_evento . "',
        '" . $_POST['infanto_modulo'] . "', 
        '" . $_POST['infanto_numero'] . "', 
        '" . $_POST['infanto_valor'] . "', 
        '" . $_POST['infanto_inscricao'] . "'
    )";

if(!$result = $con->query($sql)){
    $_SESSION['msg'] = "Ha um erro ao executar a pesquisa na base de dados alunos: [' . $con->error . ']";
    die(header("Location: sistema.inserir.modulos.php?id={$id_novo_evento}&p=2"));
    }

# superior
$sql = "INSERT INTO modulo (
        id_curso,
        id_evento,
        modulo,
        sequencia,
        valor,
        valor_inscricao_previa
    ) VALUES ( 
        '3', 
        '" . $id_evento . "',
        '" . $_POST['superior_modulo'] . "', 
        '" . $_POST['superior_numero'] . "', 
        '" . $_POST['superior_valor'] . "', 
        '" . $_POST['superior_inscricao'] . "'
    )";

if(!$result = $con->query($sql)){
    $_SESSION['msg'] = "Ha um erro ao executar a pesquisa na base de dados alunos: [' . $con->error . ']";
    die(header("Location: sistema.inserir.modulos.php?id={$id_novo_evento}&p=3"));
    }

# pos
$sql = "INSERT INTO modulo (
        id_curso,
        id_evento,
        modulo,
        sequencia,
        valor,
        valor_inscricao_previa
    ) VALUES (
        '4', 
        '" . $id_evento . "', 
        '" . $_POST['pos_modulo'] . "', 
        '" . $_POST['pos_numero'] . "', 
        '" . $_POST['pos_valor'] . "', 
        '" . $_POST['pos_inscricao'] . "'
    )";

if(!$result = $con->query($sql)){
    $_SESSION['msg'] = "Ha um erro ao executar a pesquisa na base de dados alunos: [' . $con->error . ']";
    die(header("Location: sistema.inserir.modulos.php?id={$id_novo_evento}&p=4"));
    }

$_SESSION['msg'] = "Modulos inbseridos com sucesso";
$_SESSION['msg_tipo']="alert-success";
echo header("Location: sistema.inserir.modulos.php?id=aqui");

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
                                   
                                   <form name="evento" class="form-inline" method="post" action="sistema.inserir.modulos.php?id=<?= $_GET['id'] ?>">

                                        <input type="hidden" id="id_evento" name="id_evento" value="<?= $id_evento ?>" /> 

                                        <div class="control-group">
                                            <label class="control-label" for="medio">Medio em Teologia</label>
                                            <div class="controls ">
                                              <input class='input-mini' type="text" id="medio_modulo" name="medio_modulo" placeholder="Modulo" /> 
                                              <input  class='input-mini'type="text" id="medio_numero" name="medio_numero" placeholder="Numero" /> 
                                              <input class="input-medium" type="text" id="medio_valor" name="medio_valor" placeholder="Valor do Curso" /> 
                                              <input class="input-medium" type="text" id="medio_inscricao" name="medio_inscricao" placeholder="inscrição" /> 
                                            </div>
                                        </div>

                                       <div class="control-group">
                                            <label class="control-label" for="infanto">Pastoral Infanto Juvenil </label>
                                            <div class="controls ">
                                              <input class='input-mini' type="text" id="infanto_modulo" name="infanto_modulo" placeholder="Módulo" /> 
                                              <input class='input-mini' type="text" id="infanto_numero" name="infanto_numero" placeholder="Módulo" /> 
                                              <input class="input-medium" type="text" id="infanto_valor" name="infanto_valor" placeholder="Valor do cruso" /> 
                                              <input class="input-medium" type="text" id="infanto_inscricao" name="infanto_inscricao" placeholder="Valor da inscrição" /> 
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="superior">Superior em Teologia </label>
                                            <div class="controls ">
                                              <input class='input-mini' type="text" id="superior_modulo" name="superior_modulo" placeholder="Modulo" /> 
                                              <input class='input-mini' type="text" id="superior_numero" name="superior_numero" placeholder="Modulo" /> 
                                              <input class="input-medium" type="text" id="superior_valor" name="superior_valor" placeholder="Valor do Curso" /> 
                                              <input class="input-medium" type="text" id="superior_inscricao" name="superior_inscricao" placeholder="Valor da inscrição" /> 
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="pos">Pos </label>
                                            <div class="controls ">
                                              <input  class='input-mini' type="text" id="pos_modulo" name="pos_modulo" placeholder="Modulo" /> 
                                              <input class='input-mini' type="text" id="pos_numero" name="pos_numero" placeholder="Modulo" /> 
                                              <input class="input-medium" type="text" id="pos_valor" name="pos_valor" placeholder="Valor do curso" /> 
                                              <input class="input-medium" type="text" id="pos_inscricao" name="pos_inscricao" placeholder="Valor da inscrição" /> 
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

                        <?php 
                            include './pagina/sistema.modulos.atual.php'; 
                        ?>

                    </div> <!-- /span4 -->

                </div> <!-- /row -->

            </div> <!-- /container -->

        </div> <!-- /main-inner -->

    </div> <!-- /main -->


<?php
// inserir rodapé da página agrupado.
include ('./inc/botton.php');
?>