<div class="navbar navbar-fixed-top">
	
	<div class="navbar-inner">
		
		<div class="container">
			
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			
			<a class="brand" href="../">
				Hosana.SiS
			</a>
			<span class="brand" style="color: #F90">
				<?php
				if(isset($_SESSION['usuario'])){
					$sql = "SELECT * FROM evento WHERE id_evento = {$_SESSION['evento']}";
					$consulta = mysqli_query($con,$sql);
					$dados = mysqli_fetch_array($consulta);
					echo $dados['descricao'];
					$modulodescricao = $dados['descricao'];
				}
				?>	
			</span> 
			<span  class="brand data" style="color: #FFF; font-size:10px;">
				<?php 
					$modulodatafim = strtotime($_SESSION['dataini']);
					$modulodatafim = $modulodatafim + 345600;
					echo date('d', strtotime($_SESSION['dataini']));
					echo " a ";
					echo date('d', $modulodatafim);
					echo "<br>";
					echo date('M Y', strtotime($_SESSION['dataini']))


				?>
			</span>
<?php
if (!isset($_SESSION['logado'])) {
?>
			<!-- Menu sem login -->
            <div class="nav-collapse">
				<ul class="nav pull-right">
					
					<li class="">						
						<a href="../" class="">
							<i class="icon-chevron-left"></i>
							Voltar para home
						</a>
						
					</li>
				</ul>
				
			</div><!--/.nav-collapse -->
            <!-- /menus sem login -->
<?php } ?>
            <!-- Menu com login -->
<?php
if (isset($_SESSION['logado'])) {
?>
            <div class="nav-collapse">
				<ul class="nav pull-right">
					
                    <li class="dropdown">
						
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-cog"></i>
							Evento
							<b class="caret"></b>
						</a>
						
						<ul class="dropdown-menu">
                        	
<?php
$sql="SELECT * FROM evento";
$consulta = mysqli_query($con,$sql);

$id_link = isset($_GET["id"])? "&id=".$_GET["id"]: '';

if ($linhas = mysqli_num_rows($consulta)) {
	while ($dados = mysqli_fetch_array($consulta)) {
		echo "<li><a href='?eventosession=".$dados['id_evento']."&evento_nome=".$dados['descricao']."&evento_dataini=".$dados['data_ini'].$id_link."'>" . $dados['descricao'] . "</a></li>";
	}
}
?>
							
						</ul>
						
					</li>
                    
			
					<li class="dropdown">
						
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-user"></i> 
							<?= nome2($_SESSION['nome_user']) ?>
							<b class="caret"></b>
						</a>
						
						<ul class="dropdown-menu">
							<li><a href="javascript:;" title="Ainda não disponível!" >Editar Perfil</a></li>
							<li class="divider"></li>
							<li><a href="logout.php">Sair</a></li> 
						</ul>
						
					</li>
				</ul>
			
				<form action="./aluno.procurar.php" class="navbar-search pull-right" method="post" />
					<input type="text" class="search-query" id="procurar_aluno" name="procurar_aluno" placeholder="<?=$TEXT['procurar_placeholder']?>" alt="<?=$TEXT['procurar_alt']?>"  />
				</form>
				
			</div><!--/.nav-collapse -->
            <!-- /Menu com login  -->
<?php } ?>
	
		</div> <!-- /container -->
		
	</div> <!-- /navbar-inner -->
	
</div> <!-- /navbar -->
