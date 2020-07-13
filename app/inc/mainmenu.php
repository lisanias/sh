<!-- Menu principal -->
<?php
    // definir variavel de menu caso ela não tenha sida atribuida ainda
    if (!isset($pg_menu)) {$pg_menu = "";}
?>
<div class="subnavbar">

	<div class="subnavbar-inner">
	
		<div class="container">

			<ul class="mainnav">
			
				<li <?php echo ($pg_menu=="home")? "class='active'": ''; ?> >
					<a href="home.php">
						<i class="icon-home"></i>
						<span>Home</span>
					</a>	    				
				</li>
                
                <li class="dropdown <?php echo ($pg_menu=="aluno")? "active": ''; ?>">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-user"></i>
                        <span>Aluno</span>
                        <b class="caret"></b>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a href="./pendencia_listar_all.php" >Pendências</a></li>
                    </ul>
                </li>

				<li class="dropdown <?php echo ($pg_menu=="academico")? "active": ''; ?>">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-book"></i>
                        <span>Secretaria</span>
                        <b class="caret"></b>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a href="./academico.php" >Inscrições</a></li>
                        <li><a href="./academico.cursos.php" >Cursos</a></li>
                        <li><a href="./relatorio.resumo.modulo.php" >Resumos</a></li>
                        <li><a href="./academico.formandos.php" >Formandos</a></li>
                        <li><a href="./audio.pen.php" >Pendrive - Encomendas</a></li>
                    </ul>
                </li>
                
                <li class="dropdown <?php echo ($pg_menu=="hospedagem")? "active": ''; ?>">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-glass"></i>
                        <span>Hospedagem</span>
                        <b class="caret"></b>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a href="hospedagem.php">Alunos</a></li>
                        <li><a href="hospedagem.quartos.php">Quartos</a></li>
                    </ul>
                </li>

                <li class="dropdown <?php echo ($pg_menu=="financeiro")? "active": ''; ?>">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-money"></i>
                        <span>Financeiro</span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="pagamento.php">Listagem de pagamento</a></li>
                        <li><a href="pagamento.resumo.php">Resumo do Evento</a></li>
                        <li><a href="pagamento.resumo.hoje.php">Resumo de hoje</a></li>
                    </ul>
                </li>

                <li class="dropdown <?php echo ($pg_menu=="sistema")? "active": ''; ?>">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-cog"></i>
                        <span>Sistema</span>
                        <b class="caret"></b>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a href="./lista.email.telefone.php"><i class="icon-tasks"></i> Listar todos os alunos</a></li>
                        <li><a href="#"><i class="icon-question-sign"></i> Ajuda</a></li>
                        <li><a href="sistema.sobre.php"><i class="icon-info-sign"></i> Sobre</a></li>
                        <li><a href="sistema.inserir.evento.php"><i class="icon-calendar"></i> Adicionar Evento e módulos</a></li>
                    </ul>
                </li>

<!--

-->
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-print"></i>
                        <span>Imprimir</span>
                        <b class="caret"></b>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a href="./print_lista_inscritos_pdf.php" target="_blank">Lista de Incritos</a></li>
                        <li><a href="./print_pdf.lista.hospedagem.php" target="_blank">Lista Alunos Hospedados</a></li>
                        <li><a href="./print_pdf.lista.hospedagem.sexo-nome.php" target="_blank">Lisata Alunos Hospedados por Sexo</a></li>
                        <li><a href="./print.lista.presenca.php" >Lisata de presença dos cursos</a></li>
                        <li class="divider"></li>
						<li><a href="./print_pdf.pagamento.por.aluno.php" target="_blank">Pagamentos por Aluno</a></li>
						<li><a href="./print_pdf.pagamentos.agrupado.por.aluno.php" target="_blank">Pagamentos detalhado por Aluno</a></li>
						<li><a href="./print_pdf.pagamento.aluno.por.curso.php" target="_blank">Pagamentos por Aluno e Curso</a></li>
						<li><a href="./print_pdf.pagamento.por.curso.php" target="_blank">Pagamentos por Curso</a></li>
                        <li class="divider"></li>
                        <li><a href="./print_pdf.etiquetas22.php" target="_blank">Etiquetas</a></li>
                        
                    </ul>
                </li><!-- / -->

            
			</ul>

		</div> <!-- /container -->
	
	</div> <!-- /subnavbar-inner -->

</div> <!-- /subnavbar -->
<!-- /Menu principal -->