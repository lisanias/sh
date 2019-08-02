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
    $this->Cell(150,10,'Listagem de inscritos on-line',0,0,'L');
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
$sql = "SELECT *
		FROM matricula
		INNER JOIN modulo
			ON matricula.id_modulo = modulo.id_modulo
		INNER JOIN cursos
			ON modulo.id_curso = cursos.id_curso
		INNER JOIN alunos
			ON matricula.id_aluno = alunos.id_aluno
		WHERE 
			matricula.id_evento = ".$_SESSION['evento']."
			AND alunos.cidade = 'Laranjeiras do Sul'
		ORDER BY nome ";

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

// Linha de titulo
$pdf->Cell(5, 6, " ",1,0,'C',true);
$pdf->Cell(70,6,"Nome",1,0,'C',true);
$pdf->Cell(40,6,'Cidade',1,0,'C',true);
$pdf->Cell(45,6,'Igreja',1,0,'C',true);
$pdf->Cell(20,6,'Status',1,1,'C',true);

$pdf->SetFillColor(224,235,255);//250,240,230

while ($dados = mysqli_fetch_array($tabela)) {

    if ($dados['status']< 2) {
        $cor_sequencia=$cor;
        $cor=2;
        $np="";
    } else {
        $n = $n+1;
        $np=$n;
    }
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
    $nome = $dados['nome'].' '.$dados['sobrenome'];# juntando nome e sobrenome
    $nome = utf8_decode(substr($nome,0,40));
    $igreja = utf8_decode(substr($dados['igreja'],0,25));
    $pdf->Cell(5, 6, $np, 'LR', 0, 'R', $fill);
    $pdf->Cell(70,6,strtoupper($nome) ,'LR',0,'L',$fill);
    $pdf->Cell(40,6,strtoupper(utf8_decode($dados['cidade'])),'LR',0,'L',$fill);
    $pdf->Cell(45,6,strtoupper($igreja),'LR',0,'L',$fill);
    $pdf->Cell(20,6,utf8_decode(fsr($dados['status'])),'LR',1,'L',$fill);

}
$pdf->Cell(180,1,' ','T',1,'C',0);
$pdf->Output();
?>
