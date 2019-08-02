<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lisanias Loback
 * Date: 24/05/13
 * Time: 20:35
 * Programa Hosana.SiS by WebiG.SiS
 *
 * Página para alterar os dados de pagamento dos alunos.
 */

// definir variáveis da página
$pg_titulo = "Pagamentos: Alterar - Hosana SiS";
$pg_nome = "pagamento.edit.php";
$pg_menu = "financeiro";

// incluir arquivo com parte inicial agrupadas
include_once('./inc/iniciar.php')

?>


    <div class="main">

        <div class="main-inner">

            <div class="container">

                <div class="row">

                    <div class="span8">

                        <div class="widget ">

                            <div class="widget-header">
                                <i class="icon-barcode"></i>
                                <h3>Editar Pagamento</h3>
                            </div> <!-- /widget-header -->

                            <div class="widget-content">



                                <div class="tabbable">
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#pagamento" data-toggle="tab">Pagamento</a>
                                        </li>
                                        <li><a href="#imagem" data-toggle="tab">Imagem</a></li>
                                    </ul>

                                    <br />

                                    <div class="tab-content">
                                        <div class="tab-pane active" id="pagamento">



                                        </div>

                                        <div class="tab-pane" id="imagem">

                                        </div>

                                    </div>


                                </div>





                            </div> <!-- /widget-content -->

                        </div> <!-- /widget -->

                    </div> <!-- /span8 -->


                    <div class="span4">


                        <div class="widget widget-box">

                            <div class="widget-header">
                                <h3>Matriculas para <?= $_SESSION['evento_nome'] ?></h3>
                            </div> <!-- /widget-header -->

                            <div class="widget-content">




                            </div> <!-- /widget-content -->

                        </div> <!-- /widget-box -->

                        <div class="widget widget-box">

                            <div class="widget-header">
                                <h3>Pagamentos: </h3>
                            </div> <!-- /widget-header -->

                            <div class="widget-content">




                            </div> <!-- /widget-content -->

                        </div> <!-- /widget-box -->

                    </div> <!-- /span4 -->

                </div> <!-- /row -->

            </div> <!-- /container -->

        </div> <!-- /main-inner -->

    </div> <!-- /main -->


<?php
// inserir rodapé da página agrupado.
include ('./inc/botton.php');
?>