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
    $this->Cell(150,10,'Pagamento por Curso',0,0,'L');
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
			cursos.nome_curso AS curso_nome, 
			modulo.modulo AS modulo,
			SUM(pagamento.valor) AS totalvalor 
	    FROM `pagamento` 
		    INNER JOIN matricula ON pagamento.id_matricula = matricula.id_matricula
		    INNER JOIN alunos ON matricula.id_aluno = alunos.id_aluno
		    INNER JOIN modulo ON matricula.id_modulo = modulo.id_modulo
		    INNER JOIN cursos ON modulo.id_curso = cursos.id_curso
		WHERE matricula.id_evento = ".$_SESSION['evento']."
	    GROUP BY matricula.id_modulo
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
$cor = 1;
$totalpago = 0;

// Linha de titulo
$pdf->Cell(5, 6, " ",1,0,'C',true);
$pdf->Cell(115,6,'Curso',1,0,'C',true);
$pdf->Cell(30,6,'Modulo',1,0,'C',true);
$pdf->Cell(30,6,'Valor',1,1,'C',true);

$pdf->SetFillColor(224,235,255);//250,240,230

while ($dados = mysqli_fetch_array($tabela)) {

    $n = $n+1;
	
    switch ($cor) {
        case 0:
            $pdf->SetFillColor(224,235,255);
            $cor = 1;
            break;
        case 1:
            $pdf->SetFillColor(250,240,230);
            $cor = 0;
            break;
        case 2:
            $pdf->SetFillColor(217,217,25);
            $cor = $cor_sequencia;
            break;
    }
    
    $cursonome = utf8_decode($dados['curso_nome']);
	$totalpago = $totalpago + $dados['totalvalor'];
    $pdf->Cell(5, 6, $n, 'LR', 0, 'R', $fill);
    $pdf->Cell(115,6,$cursonome,'LR',0,'L',$fill);
	$pdf->Cell(30,6,$dados['modulo'],'LR',0,'L',$fill);
    $pdf->Cell(30,6,number_format($dados['totalvalor'],2,',','.'),'LR',1,'R',$fill);

}
$pdf->Cell(180,5,' ','T',1,'C',0);
$pdf->Cell(140,6,'TOTAL',0,0,'R',0);
$pdf->Cell(40,6,number_format($totalpago,2,',','.'),0,1,'R',0);
$pdf->Cell(180,1,' ','T',1,'C',0);
$pdf->Output();
?>
