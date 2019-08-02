<?php
require('./fpdf/fpdf.php');
require('./inc/iniciar.php');

// Pegar o id da matricula
$id_matricula = base64_decode($_GET["id"]);

setlocale(LC_MONETARY, 'pt_BR');

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('./img/h150.png',10,6,20);
    // Arial bold 15
    $this->SetFont('Arial','B',14);
    // Move to the right
    $this->Cell(25);
    // Title
    $this->Cell(135,0,utf8_decode('SEMINÁRIO TEOLÓGICO HOSANA'),0,1,'C');
    
    $this->SetFont('Arial','',8);
    $this->Cell(25);
    $this->Cell(135,8,'C.G.C. 080.888.431/0001-75',0,0,'C');
    $this->Ln(9);
    
    $this->SetFont('Arial','I',7);
    $this->Cell(25);
    $this->Cell(135,0,utf8_decode('Registrado no 2º Cartório de Registro Civil de Pessoas Jurídicas, no livro A-009, nº0006154/01'),0,0,'C');
    $this->Ln(4);
    
    $this->SetFont('Arial','',8);
    $this->Cell(25);
    $this->Cell(135,0,utf8_decode('SECRETARIA: Rua Tupiniquins, 502 - Vila Casoni - CEP 86025-170'),0,0,'C');
    $this->Ln(4);
    
    $this->SetFont('Arial','',8);
    $this->Cell(25);
    $this->Cell(135,0,utf8_decode('E-mail: secretaria@seminariohosana.com.br - Tel. (43) 3325-1424'),0,0,'C');
        
    // Line break
    $this->Ln(6);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'',0,0,'C');
}
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->SetRightMargin(20);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$pdf->SetFillColor(200,200,200);


$fill = true;
$n = 0;
$cor = 1;

// Linha de titulo
$pdf->ln(5);
$pdf->Cell(180,10,utf8_decode('DECLARAÇÃO'),'B',1,'C',true);

$pdf->SetFillColor(255,255,255);

// conectar na base de dados para criar relatorio
$sql = "SELECT *
		FROM matricula
		INNER JOIN modulo
			ON matricula.id_modulo = modulo.id_modulo
		INNER JOIN cursos
			ON modulo.id_curso = cursos.id_curso
	        INNER JOIN evento
			ON matricula.id_evento = evento.id_evento
		INNER JOIN alunos
			ON matricula.id_aluno = alunos.id_aluno
		WHERE matricula.id_matricula = ".$id_matricula."
		ORDER BY nome ";

$tabela = mysqli_query($con,$sql);
while ($dados = mysqli_fetch_array($tabela)) {
	
	 $pdf->ln(30);

	 // verificar o genero
	 if ($dados['sexo']=="F") {
	 	$artigo = "a";
	 	$txaluno = "aluna";
	 } else {
	 	$artigo = "o";
	 	$txaluno = "aluno";
	 }
	 
	 	
	// DECLARAÇÃO

	$txt = 'Declaramos para os devidos fins que '.$artigo.' '.$txaluno. ' ';
	$txt = utf8_decode($txt);
	$pdf->Write(6,$txt);

	$txt = $dados['nome'].' '.$dados['sobrenome'].' ';
	$txt = utf8_decode($txt);
	$pdf->SetFont('Arial','B',12);
	$pdf->Write(6,$txt);

	$txt = 'participou da jornada modular do '.$dados['nome_curso'];
	$txt = $txt . ' no seminário acima identificado nos dias ';
	$txt = $txt . date('d/m/Y',strtotime($dados['data_ini'])).' a '.date('d/m/Y',strtotime($dados['data_fim']));
	$txt = $txt . ' no período das 8h às 13h e das 15h às 23h.';
	$txt = utf8_decode($txt);
	$pdf->SetFont('Arial','',12);
	$pdf->Write(6,$txt);

	$pdf->ln(12);

	$txt = 'Por ser expressão, da verdade, firmamos a presente declaração e nos colocamos a disposição para maiores esclarecimentos.';
	$txt = utf8_decode($txt);
	$pdf->Write(6,$txt);
	
	$pdf->ln(80);
	$pdf->Cell(180,6,utf8_decode('_________________________________'), 0, 1, 'C',true);
	$pdf->Cell(180,6,utf8_decode('Londrina, ').date('d/m/Y'), 0, 1, 'C',true);
	$pdf->Cell(180,6,utf8_decode('Seminário Hosana'), 0, 1, 'C',true);
}

$pdf->Output();
?>
