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
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(200,200,200);

$fill = true;
$n = 0;
$cor = 1;

// Linha de titulo
$pdf->Cell(180,6,'Dados do aluno','B',1,'L',true);

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
	
	 $pdf->ln(5);
	 
	 // preencher linha 3 com bairro se ouver senão continuar
	 if (strlen($dados['bairro'])>0) {
		 $linha3 = $dados['bairro'];
		 $linha4 = $dados['cidade'].' - '.$dados['uf'];
		 $linha5 = $dados['cep'];
	 } else {
		 $linha3 = $dados['cidade'].' - '.$dados['uf'];
		 $linha4 = $dados['cep'];
		 $linha5 = " ";
	 }
	
	// colocar o nome e o endereço do aluno
	 
	$pdf->Cell(130, 5, utf8_decode(strtoupper($dados['nome'].' '.$dados['sobrenome'])), 0, 0, 'L', false);
	$pdf->Cell(50, 5, 'Telefone: '.$dados['tres'], 0, 1, 'R', false);
	
	$pdf->Cell(130, 5, utf8_decode(strtoupper($dados['endereco'].' '.$dados['complemento'])), 0, 0, 'L', false);
	$pdf->Cell(50, 5, 'Celular: '.$dados['tcel'], 0, 1, 'R', false);
	
	$pdf->Cell(90, 5, utf8_decode(strtoupper($linha3)), 0, 0, 'L', false);
	$pdf->Cell(90, 5, 'E-mail: '.$dados['email'], 0, 1, 'R', false);
	
	$pdf->Cell(90, 5, utf8_decode(strtoupper($linha4)), 0, 0, 'L', false);
	$pdf->Cell(90, 5, $dados['cpf'], 0, 1, 'R', false);
	
	$pdf->Cell(90, 5, utf8_decode($linha5), 0, 1, 'L', false);
	$pdf->ln(6);
	
	// dados sobre a matricula do aluno
	
	$pdf->Cell(150, 6, 'Matricula', 'B', 0, 'L', true);
	$pdf->Cell(30, 6, 'ID '.str_pad($dados['id_matricula'], 6, "0", STR_PAD_LEFT), 'B', 1, 'R', true);
	$pdf->ln(2);
	
	$pdf->Cell(90, 5, 'Curso: '.utf8_decode($dados['nome_curso']), 0, 0, 'L', '');
	$hospeda = utf8_decode(($dados['hospedagem']==1)?'SIM':'Não');
	$pdf->Cell(90, 5, 'Hospedagem: '.$hospeda, 0, 1, 'L', '');
	
	$pdf->Cell(90, 5, utf8_decode('Módulo: '.$dados['modulo']).' - '.utf8_decode($dados['descricao']), 0, 0, 'L', '');
	$pdf->Cell(90, 5, 'Valor do curso: '.utf8_decode($dados['valor']), 0, 1, 'L', '');
	
	$pdf->Cell(90, 5, utf8_decode('Data de inscrição: '.date("d.m.Y", strtotime($dados['data_matricula']))), 0, 0, 'L', '');
	$pdf->Cell(90, 5, 'Descontos/Abatimentos: '.utf8_decode($dados['desconto']), 0, 1, 'L', '');
	
	$pdf->ln(4);
		
	$pdf->Cell(5, 5, '', 0, 0, 'L', '');
	$pdf->Cell(25, 5, 'Data Pg.', 'B', 0, 'L', '');
	$pdf->Cell(25, 5, 'Dt. Env.', 'B', 0, 'L', '');
	$pdf->Cell(75, 5, 'Referente', 'B', 0, 'L', ''); //function_pg_ref
	$pdf->Cell(30, 5, 'Forma', 'B', 0, 'L', ''); //function_pg_forma
	$pdf->Cell(20, 5, 'Valor', 'B', 1, 'R', ''); 
	
	// conectar na base de dados pagamentos
	$sql_pg = "SELECT *
			FROM pagamento
			WHERE id_matricula = ".$id_matricula."
			ORDER BY data_add_pg ";
	
	$soma = 0;
	$tabela_pg = mysqli_query($con,$sql_pg);
	while ($dados_pg = mysqli_fetch_array($tabela_pg)) {
		$valor_pg = $dados_pg['valor'];
		$valor_pg = number_format($valor_pg, 2, ',', '.');
		$pdf->Cell(5, 5, '', 0, 0, 'L', '');
		$pdf->Cell(25, 5, date("d.m.Y", strtotime($dados_pg['data_pg'])), 0, 0, 'L', '');
		$pdf->Cell(25, 5, date("d.m.Y", strtotime($dados_pg['data_add_pg'])), 0, 0, 'L', '');
		$pdf->Cell(75, 5, utf8_decode(function_pg_ref($dados_pg['ref_a'])), 0, 0, 'L', ''); 
		$pdf->Cell(30, 5, utf8_decode(function_pg_forma($dados_pg['forma_pg'])), 0, 0, 'L', '');
		$pdf->Cell(20, 5, number_format($dados_pg['valor'],2,',','.'), 0, 1, 'R', true); 
		
		$soma = $soma + $dados_pg['valor'];
		
		if (strlen($dados_pg['descricao'])>0){
			$pdf->Cell(15, 5, '', 0, 0, 'L', '');
			$pdf->Cell(165, 5,'Descricao: '.utf8_decode($dados_pg['descricao']), 0, 1, 'L', ''); 
		}
		if (strlen($dados_pg['complemento'])>0){
			$pdf->Cell(15, 5, '', 0, 0, 'L', '');
			$pdf->Cell(165, 5,'Complemento: '.utf8_decode($dados_pg['complemento']), 0, 1, 'L', ''); 
		}
		if (strlen($dados_pg['obs_staff'])>0){
			$pdf->Cell(15, 5, '', 0, 0, 'L', '');
			$pdf->Cell(165, 5,'Obs do Staff: '.utf8_decode($dados_pg['obs_staff']), 0, 1, 'L', ''); 
		}
		$pdf->Cell(5, 5, '', 0, 0, 'L', '');
		$pdf->Cell(175, 2, '', 'T', 1, 'L', '');
			
	}
		
	// resumo financeiro
	$valor_curso = $dados['valor'];
	$desconto = $dados['desconto'];
	$pagar = $valor_curso - $desconto - $soma;
	
	$pdf->Cell(100, 5, '', 0, 0, 'L', '');
	$pdf->Cell(50, 5, 'Valor do curso: ', 0, 0, 'L', true);
	$pdf->Cell(30, 5,number_format(valor_ok($valor_curso),2,',','.'), 0, 1, 'R', true);
	
	$pdf->Cell(100, 5, '', 0, 0, 'L', '');
	$pdf->Cell(50, 5, 'Descontos: ', 0, 0, 'L', true);
	$pdf->Cell(30, 5,number_format(valor_ok($desconto),2,',','.'), 'B', 1, 'R', true); 
	
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(100, 10, '', 0, 0, 'L', '');
	$pdf->Cell(50, 10, 'Valor pago: ', 0, 0, 'L', true);
	$pdf->Cell(30, 10,number_format(valor_ok($soma),2,',','.'), 0, 1, 'R', true);
	
	$pdf->ln(20);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(40, 10,'', 0, 0, 'C', false);
	$pdf->Cell(100, 10,'Londrina, '.date('d/m/Y'), 'T', 0, 'C', false);
	$pdf->Cell(40, 10,'', 0, 1, 'C', false);
}

$pdf->Output();
?>
