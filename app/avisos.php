<?php

// definir variáveis da página
$pg_titulo = "Telefone e e-mails";
$pg_nome = "lista.email.telefone.php";
$pg_menu = "sistema";

include_once('./inc/iniciar.php');
include_once('./inc/seguranca.php');

if (!empty($_POST)){

  $dataIni = implode('-',array_reverse(explode('/',$_POST['dataini'])));

  $sql = "INSERT INTO avisos_modulo
	(
     modulo_id,
     data_ini,
     titulo,
     conteudo,
     link,
     link_titulo,
     tipo
    )
    VALUES
    (
      '{$_POST['curso']}',
      '{$dataIni}',
      '{$_POST['title']}',
      '{$_POST['message']}',
      '{$_POST['link']}',
      '{$_POST['buttonTitle']}',
      '{$_POST['cor']}'
    )";

    $inserir = mysqli_query($con, $sql);

    if( $inserir ){
      $_SESSION['msg'] = "Aviso inserido";
      die(header("Location: avisos.php"));
    } else {
      $_SESSION['msg'] = "ATENÇÃO - Por algum motivo não foi possivel inserir na base de dados";
      die(header("Location: avisos.php"));
    }
    die("fim");

  //echo 'foi enviado!<pre>';
  //var_dump($_POST);
  //die();
}


include_once ('./inc/grupo.topo.php');


// pegar os modulos deste eventos
$sqlModulos = "SELECT * FROM modulo INNER JOIN cursos ON modulo.id_curso = cursos.id_curso WHERE id_evento = " . $_SESSION["evento_atual"];
$consulta = mysqli_query($con, $sqlModulos);

// pegar os avisos deste modulo
$sqlAvisos = "SELECT * FROM avisos_modulo
                  INNER JOIN modulo ON modulo.id_modulo = avisos_modulo.modulo_id
                  INNER JOIN cursos ON modulo.id_curso = cursos.id_curso
                  WHERE id_evento = " . $_SESSION["evento_atual"];
$avisos = mysqli_query($con, $sqlAvisos);
?>

<div class="container">
    <div class="row hero-unit">
        <h1><i class="icon-info-sign"></i> Avisos aos alunos</h1>
    </div>

    <div class="row hero-unit">
        <div class="page-header">
            <h2>Inserir novo aviso</h2>
        </div>

        <form  class="span10" action="avisos.php" method="post">
          <fieldset>
            <div class="control-group">
                <label class="control-label" for="curso">Curso</label>
                <select id="curso" name="curso">
                  <option value=""></option>
                  <?php
                    foreach ($consulta as $modulo) {
                      echo "<option value=".$modulo['id_modulo'].">".$modulo['apelido']."</option>";
                    }

                  ?>
                  </select>
            </div>
            <div class="control-group">
                <label class="control-label" for="title">Titulo</label>
                <div class="controls">
                    <input class="input-block-level" type="text" id="title" name="title" placeholder="Título">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="message">Conteúdo</label>
                <div class="controls">
                    <textarea class="input-block-level" name="message" id="message" rows="8" cols="80" placeholder="Mensagem de aviso ao aluno..."></textarea>
                </div>
            </div>
            <div class="row">
                  <div class="control-group span5">
                      <label class="control-label" for="link">Link</label>
                      <div class="controls">
                          <input class="input-block-level" type="text" id="link" name="link" placeholder="Link...">
                      </div>
                  </div>
                  <div class="control-group span5">
                      <label class="control-label" for="cor">Cor</label>
                      <div class="controls">
                        <select id="cor" name="cor">
                          <option value="">Amarelo</option>
                          <option value="alert-error">Vermelho</option>
                          <option value="alert-success">Verde</option>
                          <option value="alert-info">Azul</option>
                          </select>
                      </div>
                  </div>
            </div>
            <div class="row">
                  <div class="control-group span5">
                      <label class="control-label" for="buttonTitle">Texto do botão para ação</label>
                      <div class="controls">
                          <input class="input-block-level" type="text" id="buttonTitle" name="buttonTitle" placeholder="Mensagem de aviso ao aluno...">
                      </div>
                  </div>
                  <div class="control-group span5">
                      <label class="control-label" for="dataini">Data para inicio do aviso (pode ficar em branco)</label>
                      <div class="controls">
                          <input class="input-block-level" type="date" id="dataini" name="dataini" placeholder="Mostrar a partir de">
                      </div>
                  </div>
            </div>

            <button class="btn btn-large btn-block btn-primary" type="submit" name="button"><i class="icon-check"></i> Salvar</button>

          </fieldset>
        </form>
    </div>

    <div class="row hero-unit">

        <div class="page-header">
            <h2>Visualizar Avisos</h2>
        </div>

      <?php
        foreach ($avisos as $aviso) {
          echo "<div class='alert  alert-block {$aviso['tipo']}'>";
          echo "<h3>",$aviso['titulo'],"</h3>";
          echo $aviso['conteudo'], "<br/></br>";
          echo "<a class='btn' href='{$aviso['link']}'>{$aviso['link_titulo']}</a>";
          echo "</div>";
      }
       ?>

        </div>
    </div>

</div> <!-- / Container -->

<?php
$consulta->close();
include ('./inc/botton.php');
?>
