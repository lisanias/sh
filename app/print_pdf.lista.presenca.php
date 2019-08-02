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
    $this->SetFont('Arial','B',14);
    // Move to the right
    $this->Cell(30);
    $this->Cell(75,0,utf8_decode('Lista de Presença'),0,1,'L');
	
	$this->SetFont('Arial','I',10);
	
	$sql = "SELECT * FROM cursos WHERE id_curso = {$_POST['id_curso']}";
	$con = mysqli_connect('localhost', 'sagra213_hosana', 'lucas#3$1', 'sagra213_hosana');
	mysqli_set_charset( $con, 'utf8');
	$tabela = mysqli_query($con,$sql);
	$dados = mysqli_fetch_array($tabela);
	$curso = $dados['nome_curso'];
	
	$this->Cell(180,4,'',0,1,'L');
	
	$this->Cell(30);
    $this->Cell(75,9,utf8_decode($curso),0,0,'L');
	$this->Cell(75,9,utf8_decode('Matéria: '.$_POST['aula']),0,1,'L');
	
	$this->Cell(30);
	$this->Cell(75,0,utf8_decode($_POST['data'].' - '.$_POST['hora']),0,0,'L');
	$this->Cell(75,0,utf8_decode('Prof.: '.$_POST['prof']),0,1,'L');
    // Line break
    $this->Ln(5);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-19);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // aviso
	$this->Cell(0,7,utf8_decode('Se o seu nome não estiver na lista, por favor procure a secretaria.'),0,1,'C');
	// Page number
    $this->Cell(0,0,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// conectar na base de dados para criar relatorio
$sql = "SELECT 
			alunos.nome AS nome,
			alunos.sobrenome AS sobrenome,
			cursos.nome_curso AS curso_nome,
			cursos.id_curso AS curso_id, 
			modulo.modulo AS modulo
	    FROM matricula
		    INNER JOIN alunos ON matricula.id_aluno = alunos.id_aluno
		    INNER JOIN modulo ON matricula.id_modulo = modulo.id_modulo
		    INNER JOIN cursos ON modulo.id_curso = cursos.id_curso
		WHERE matricula.id_evento = ".$_SESSION['evento']."
			AND matricula.status = 5
			AND cursos.id_curso = {$_POST['id_curso']}
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
$pdf->Cell(10, 6, " ",1,0,'C',true);
$pdf->Cell(85,6,'Nome',1,0,'C',true);
$pdf->Cell(85,6,'Assinatura',1,1,'C',true);

$pdf->SetFillColor(224,235,255);//250,240,230

while ($dados = mysqli_fetch_array($tabela)) {

    $n = $n+1;
	
	$nome = utf8_decode(strtoupper($dados['nome'].' '.$dados['sobrenome']));
    
    
	
    $pdf->Cell(10, 6, $n, 1, 0, 'R', $fill);
    $pdf->Cell(85,6,$nome,1,0,'L',$fill);
	$pdf->Cell(85,6,'',1,1,'L',0);

}
    
$pdf->Cell(10, 6,' ', 1, 0, 'R', $fill);
$pdf->Cell(85,6,' ',1,0,'L',$fill);
$pdf->Cell(85,6,'',1,1,'L',0);

$pdf->Cell(10, 6,' ', 1, 0, 'R', $fill);
$pdf->Cell(85,6,' ',1,0,'L',$fill);
$pdf->Cell(85,6,' ',1,1,'L',0);

$pdf->Cell(10, 6,' ', 1, 0, 'R', $fill);
$pdf->Cell(85,6,' ',1,0,'L',$fill);
$pdf->Cell(85,6,' ',1,1,'L',0);

$pdf->Cell(10, 6,' ', 1, 0, 'R', $fill);
$pdf->Cell(85,6,' ',1,0,'L',$fill);
$pdf->Cell(85,6,' ',1,1,'L',0);




$pdf->Output();


?>
