<?php
require('./fpdf/fpdf.php');
require('./inc/iniciar.php');

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('./img/h150.png',10,6,20);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(30);
    // Title
    $this->Cell(150,10,'Pagamento por aluno',0,0,'L');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// conectar na base de dados para criar relatorio
$sql = "SELECT 
			alunos.id_aluno AS aluno_id, 
			alunos.nome AS nome,
			alunos.sobrenome AS sobrenome, 
			cursos.nome_curso AS nome_curso, 
			modulo.modulo AS modulo,
			modulo.valor AS valor_curso,
			matricula.id_matricula AS id_matricula,
			matricula.desconto AS desconto,
			matricula.status AS status
	    FROM `matricula` 
		    INNER JOIN alunos ON matricula.id_aluno = alunos.id_aluno
		    INNER JOIN modulo ON matricula.id_modulo = modulo.id_modulo
		    INNER JOIN cursos ON modulo.id_curso = cursos.id_curso
		WHERE matricula.id_evento = ".$_SESSION['evento']."
	    GROUP BY matricula.id_matricula
		ORDER BY alunos.nome";


$tabela = mysqli_query($con,$sql);

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',8);
$pdf->SetFillColor(204,215,235);

$fill = true;
$n = 0;
$ll = 0;

// Linha de titulo
//$pdf->Cell(180, 6, " ",1,1,'C',true);

while ($dados = mysqli_fetch_array($tabela)) {

    $sql_contar = "SELECT COUNT(*) AS contar FROM pagamento 
				WHERE id_matricula = ".$dados['id_matricula']."
				GROUP BY id_matricula";
	
	$tabelacontar = mysqli_query($con,$sql_contar);
	
	if (isset($tabelacontar)) {
		$resultcontar = mysqli_fetch_array($tabelacontar);
		$contar = $resultcontar['contar'];
	}
	if (!$contar > 0) {
		$contar = 0;
	}
	
	$compara = $ll + $contar + 3;
	if ($compara >=41) {
		$pdf->Cell(180,6,'','T',1);
		$pdf->AddPage();
		$ll = 0;
	}
	
	$n = $n+1;
	
	$total_pg = 0; // zerar o total de pagamento a cada novo aluno
			
    $nome = $dados['nome'].' '.$dados['sobrenome'];# juntando nome e sobrenome
    $cursonome = utf8_decode($dados['nome_curso']).' | '.$contar.'+'.$compara;
	$id_aluno = $dados['aluno_id'];
	$id_matricula = $dados['id_matricula'];
	$valor_curso = $dados['valor_curso'] - $dados['desconto'];
	$status = $dados['status'];
	
	$ll = $ll+1;
	// mudar a cor do fundo pelo satatus
	switch ($status) {
		case 0:
			$pdf->SetFillColor(100,100,100);
			break;
		case 1:
			$pdf->SetFillColor(255,0,0);
			break;
		case 2:
			$pdf->SetFillColor(230,200,40);
			break;
		default:
			$pdf->SetFillColor(224,224,224);
	}
    $pdf->Cell(10, 6,$n, 'LT', 0, 'R', $fill);
    $pdf->Cell(85,6,strtoupper(utf8_decode($nome)),'T',0,'L',$fill);
    $pdf->Cell(85,6,$cursonome,'TR',1,'R',$fill);
	
		
	$total_pg = 0; // zerar o total de pagamento a cada novo aluno
	// Conectar a base de dados pagamento para listar os pagamento realizados por esse aluno
		$sql_pg = "SELECT * FROM `pagamento` 
				WHERE id_matricula = ".$id_matricula."
				ORDER BY data_pg";
				
		if ($tabela_pg = mysqli_query($con,$sql_pg)) {
		
			if (mysqli_num_rows($tabela_pg) > 0) {
				while ($dados_pg = mysqli_fetch_array($tabela_pg)) {
					$ll = $ll+1;
					$pdf->SetFillColor(255,255,255);
					$pdf->Cell(10, 6,'', 'L', 0, 'L', $fill);
					$pdf->Cell(20,6,$dados_pg['data_pg'],'',0,'L',$fill);
					$pdf->Cell(20,6,number_format($dados_pg['valor'],2,',','.'),'',0,'R',$fill);
					$pdf->Cell(130,6,utf8_decode($dados_pg['descricao']),'R',1,'L',$fill);
					$total_pg = $total_pg + $dados_pg['valor'];
				}  // fim do while de pagamentos do aluno
			}
			else {
				$ll = $ll+1;
				$pdf->Cell(180,6,'','LR',1);
			}
		}
		// fim da pesquisa de pagamentos do aluno
		
	// linha do total
	$ll = $ll+1;
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(10, 6,'', 'L', 0, 'L', $fill);
	$pdf->Cell(20,6,'','',0,'L',$fill);
	$pdf->Cell(20,6,number_format($total_pg,2,',','.'),'T',0,'R',$fill);
	$pdf->Cell(130,6,'Valor do Curso: '.number_format($dados['valor_curso']).' | Desconto: '.number_format($dados['desconto']).' | Valor com desconto: '.number_format($valor_curso),'R',1,'R',$fill);

}
$ll = $ll+1;
$pdf->Cell(180,1,'','T',1,'C',0);
$pdf->Output();
?>
