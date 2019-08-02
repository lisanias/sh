<?php 
// definir variáveis da página
$pg_titulo = "Hospedagem - Hosana SiS";
$pg_nome = "hospedagem.quartos.php";
$pg_menu = "hospedagem";

// codigo a ser executado depois de iniciar a pagina e antes de terminar os includes
// esta função é chamada atomaticamente pelo include_once ('./inc/grupo.topo.php')
//function executar () {
//}

// Incluir informações iniciais agrupadas
include_once ('./inc/grupo.topo.php');
?>

<!-- #########     CONTEÚDO PRINCIPAL     ########## -->
<br />
<div class="main">

	
	
	
<!-- LISTAR QUARTOS COM OS ALUNOS ALOJADOS EM CADA QUARTO -->
<?php
// permissão secretaria - id 2 

if ($_SESSION['permissao'][2]>0) { // inicia viasualização do modulo

// conectar a base com a lista dos quartos dispooniveis no local do evento 
// para mostrar em uma tabela
$sql = "SELECT * 
		FROM quarto
		WHERE id_local = {$_SESSION['local']}
		ORDER BY quarto ASC
 		"; 
		
$tabela = mysqli_query($con,$sql);

?>


	
	<div class="main-inner">

	    <div class="container">
	
			<?php
				// se a consulta resultar em uma ou mais linhas continuar
				if ($linhas = mysqli_num_rows($tabela)) {
					// para calcular colunas e acrescentar linhas
					/*
					 *toda vez que atinge 3 volta para zero
					 */
					$n=0;
					
					// executar enquanto tiver linhas de dados
					while ($dados = mysqli_fetch_array($tabela)) {
						
						// se for o está no inicio de uma nova linha acrescenta a linha 'row'
						if ($n == 0) {
							echo "<div class='row'>";
						}
						
						switch ($dados['sexo']) {
							case 'M':
								$icons_sexo = "<i class='icon-male icon-large' style='color:#2E9AFE'></i>";
								break;
							case 'F':
								$icons_sexo = "<i class='icon-female icon-large' style='color:#FA58F4'></i>";
								break;
						}
						
						// verificar se o quarto está disponivel (1) ou se está reservdo para staff ou com algum problema que não possa ser utilizado (0)
						if ($dados['disponivel']==0){
							echo "
								<div class='span3'>
					
									<div class='widget widget-table action-table'>
										
										<div class='widget-header'>
											<i class='icon-key'></i>
											<h3 style='color: red;'>Quarto ".$dados['quarto']." ".$icons_sexo."</h3>
										</div> <!-- /widget-header -->
										
										<br>Quarto Reservado ou Indisponivel
										
									</div><!-- /div widget -->
									
								</div><!-- /div span4 -->
							";
						} else {
						
			?>
		  
				
				
				<div class="span3">
					
					<div class="widget widget-table action-table">
						
						<div class="widget-header">
							<i class="icon-key"></i>
							<h3>Quarto <?= $dados['quarto'] ?> <?= $icons_sexo ?></h3>
						</div> <!-- /widget-header -->
						
						<?php
							include ('./pagina/hospedagem.quartos.alunos.php');
						?>
						
					</div><!-- /div widget -->
					
				</div><!-- /div span4 -->
				
			<?php
						}
						
						$n = $n + 1;
						if ($n == 3) {
							$n = 0;
						}
						
						// se for 0 precisa fechar a linha
						if ($n == 0) {
							echo "</div><!-- /div row -->";
						}
						
					} # fim: while ($dados = mysqli_fetch_array($tabela))
					
					/*
					 * verifica se fechou a linha dentro do loop senão fecha aqui
					 * se o contaro $n estiver em 0 (zerando o con) fechou a linha, se for menor precisa fechar
					 */
					if ($n <> 0) {
						echo "</div><!-- /div row -->";
					}
					
				} # fim: if($linhas = mysqli_num_rows($tabela))
			?>
			
		</div><!-- /div container -->
	    
	</div> <!-- /main-inner -->
	
<?php
}
?>
    
</div> <!-- /main -->
<!-- /########     /contúdo principal     ########## -->

<?php
  include ('./inc/botton.php');
?>