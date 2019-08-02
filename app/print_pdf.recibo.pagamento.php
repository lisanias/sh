<?php
require('./fpdf/fpdf.php');
require('./inc/iniciar.php');

// classe de escrita por extenço
class extenso {
    private static $unidades = array("um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove", "dez", "onze", "doze",
                                     "treze", "quatorze", "quinze", "dezesseis", "dezessete", "dezoito", "dezenove");
    private static $dezenas = array("dez", "vinte", "trinta", "quarenta","cinquenta", "sessenta", "setenta", "oitenta", "noventa");
    private static $centenas = array("cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", 
                                     "seiscentos", "setecentos", "oitocentos", "novecentos");
    private static $milhares = array(
        array("text" => "mil", "start" => 1000, "end" => 999999, "div" => 1000),
        array("text" => "milhão", "start" =>  1000000, "end" => 1999999, "div" => 1000000),
        array("text" => "milhões", "start" => 2000000, "end" => 999999999, "div" => 1000000),
        array("text" => "bilhão", "start" => 1000000000, "end" => 1999999999, "div" => 1000000000),
        array("text" => "bilhões", "start" => 2000000000, "end" => 2147483647, "div" => 1000000000)        
    );
    const MIN = 0.01;
    const MAX = 2147483647.99;
    const MOEDA = " real ";
    const MOEDAS = " reais ";
    const CENTAVO = " centavo ";
    const CENTAVOS = " centavos ";    
     
    static function numberToExt($number, $moeda = true) {
        if ($number >= self::MIN && $number <= self::MAX) {
            $value = self::conversionR((int)$number);       
            if ($moeda) {
                if (floor($number) == 1) {
                    $value .= self::MOEDA;
                }
                else if (floor($number) > 1) $value .= self::MOEDAS;
            }
 
            $decimals = self::extractDecimals($number);            
            if ($decimals > 0.00) {
                $decimals = round($decimals * 100);
                $value .= " e ".self::conversionR($decimals);
                if ($moeda) {
                    if ($decimals == 1) {
                        $value .= self::CENTAVO;
                    }   
                    else if ($decimals > 1) $value .= self::CENTAVOS;
                }
            }
        }
        return trim($value);
    }
     
    private static function extractDecimals($number) {
        return $number - floor($number);
    }
     
    static function conversionR($number) {
        if (in_array($number, range(1, 19))) {
            $value = self::$unidades[$number-1];
        }
        else if (in_array($number, range(20, 90, 10))) {
             $value = self::$dezenas[floor($number / 10)-1]." ";           
        }     
        else if (in_array($number, range(21, 99))) {
             $value = self::$dezenas[floor($number / 10)-1]." e ".self::conversionR($number % 10);           
        }     
        else if (in_array($number, range(100, 900, 100))) {
             $value = self::$centenas[floor($number / 100)-1]." ";           
        }          
        else if (in_array($number, range(101, 199))) {
             $value = ' cento e '.self::conversionR($number % 100);         
        }   
        else if (in_array($number, range(201, 999))) {
             $value = self::$centenas[floor($number / 100)-1]." e ".self::conversionR($number % 100);        
        }  
        else {
            foreach (self::$milhares as $item) {
                if ($number >= $item['start'] && $number <= $item['end']) {
                    $value = self::conversionR(floor($number / $item['div']))." ".$item['text']." ".self::conversionR($number % $item['div']);
                    break;
                }
            }
        }        
        return $value;
    }
}
// fim de classe escrita por extenço



// Pegar o id da matricula
$id_pagamento = base64_decode($_GET["id"]);

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
$pdf->SetFillColor(200,200,200);

$fill = true;
$n = 0;
$cor = 1;

// conectar na base de dados para criar relatorio
$sql = 	"SELECT 
				*,
				pagamento.valor AS valorpagamento,
				pagamento.complemento AS obspg,
				modulo.valor AS valormodulo
		FROM pagamento
		INNER JOIN matricula
			ON pagamento.id_matricula = matricula.id_matricula
		INNER JOIN alunos
			ON matricula.id_aluno = alunos.id_aluno
		INNER JOIN modulo
			ON matricula.id_modulo = modulo.id_modulo
        INNER JOIN cursos
			ON modulo.id_curso = cursos.id_curso
	    INNER JOIN evento
			ON matricula.id_evento = evento.id_evento
		WHERE pagamento.id_pagamento = ".$id_pagamento."";

$tabela = mysqli_query($con,$sql);
while ($dados = mysqli_fetch_array($tabela)) {
	
	 $pdf->ln(5);

	// recibo em si
	
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(140, 10,utf8_decode(' RECIBO'), 0, 0, 'L', true);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(40, 10, number_format($dados['valorpagamento'],2,',','.'), 0, 1, 'R', true);
	
	$pdf->ln(5);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(180, 6,utf8_decode('O Seminário Hosana recebeu no dia ').date("d.m.Y", strtotime($dados['data_pg'])), 0, 1, 'C', '');
	$pdf->Cell(180, 6,'a quantia de  '.extenso::numberToExt($dados['valorpagamento']).' (R$ '.number_format(valor_ok($dados['valorpagamento']),2,',','.').')', 0, 1, 'C', '');
	$pdf->Cell(180, 6,utf8_decode('referente a ').utf8_decode(function_pg_ref($dados['ref_a'])).' do', 0, 1, 'C', '');
	$pdf->Cell(180, 6,utf8_decode($dados['nome_curso']).' '.utf8_decode($dados['descricao']), 0, 1, 'C', '');
	$pdf->Cell(180, 6,utf8_decode('do aluno '.$dados['nome'].' '.$dados['sobrenome']), 0, 1, 'C', '');	 


	$pdf->SetFont('Arial','',9);

	// Linha de titulo
	$pdf->ln(10);
	$pdf->Cell(180,6,'Dados do aluno',0,1,'L',true);
	$pdf->ln(2);
	
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
	
	$pdf->Cell(150, 6, 'Dados do Curso', 0, 0, 'L', true);
	$pdf->Cell(30, 6, 'ID '.str_pad($dados['id_matricula'], 6, "0", STR_PAD_LEFT), 0, 1, 'R', true);
	$pdf->ln(2);
	
	$pdf->Cell(90, 5, 'Curso: '.utf8_decode($dados['nome_curso']), 0, 0, 'L', '');
	$hospeda = utf8_decode(($dados['hospedagem']==1)?'SIM':'Não');
	$pdf->Cell(90, 5, 'Hospedagem: '.$hospeda, 0, 1, 'L', '');
	
	$pdf->Cell(90, 5, utf8_decode('Módulo: '.$dados['modulo']).' - '.utf8_decode($dados['descricao']), 0, 0, 'L', '');
	$pdf->Cell(90, 5, 'Valor do curso: '.utf8_decode($dados['valormodulo']), 0, 1, 'L', '');
	
	$pdf->Cell(90, 5, utf8_decode('Data de inscrição: '.date("d.m.Y", strtotime($dados['data_matricula']))), 0, 0, 'L', '');
	$pdf->Cell(90, 5, 'Descontos/Abatimentos: '.utf8_decode($dados['desconto']), 0, 1, 'L', '');
	
	$pdf->ln(6);

	$pdf->Cell(180, 6, 'Dados do Pagamento', 0, 1, 'L', true);
	$pdf->ln(2);
	$pdf->Cell(25, 5, 'Data Pg.', '', 0, 'L', '');
	$pdf->Cell(25, 5, 'Dt. Env.', '', 0, 'L', '');
	$pdf->Cell(80, 5, 'Referente', '', 0, 'L', ''); //function_pg_ref
	$pdf->Cell(30, 5, 'Forma', '', 0, 'L', ''); //function_pg_forma
	$pdf->Cell(20, 5, 'Valor', '', 1, 'R', ''); 
	

	
		$valor_pg = $dados['valor'];
		$valor_pg = number_format($valor_pg, 2, ',', '.');
		$pdf->Cell(25, 5, date("d.m.Y", strtotime($dados['data_pg'])), 0, 0, 'L', '');
		$pdf->Cell(25, 5, date("d.m.Y", strtotime($dados['data_add_pg'])), 0, 0, 'L', '');
		$pdf->Cell(80, 5, utf8_decode(function_pg_ref($dados['ref_a'])), 0, 0, 'L', ''); 
		$pdf->Cell(30, 5, utf8_decode(function_pg_forma($dados['forma_pg'])), 0, 0, 'L', '');
		$pdf->Cell(20, 5, number_format($dados['valorpagamento'],2,',','.'), 0, 1, 'R', 0); 
		
		//$pdf->Cell(180, 2, '', 'T', 1, 'L', '');
		
		$pdf->ln(5);
		
		if (strlen($dados['obspg'])>0){
			$pdf->Cell(15, 5, '', 0, 0, 'L', '');
			$pdf->Cell(165, 5,'Complemento: '.utf8_decode($dados['obspg']), 0, 1, 'L', ''); 
		}
		if (strlen($dados['obs_staff'])>0){
			$pdf->Cell(15, 5, '', 0, 0, 'L', '');
			$pdf->Cell(165, 5,'Obs do Staff: '.utf8_decode($dados['obs_staff']), 0, 1, 'L', ''); 
		}
			
		
	
	$pdf->ln(20);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(40, 10,'', 0, 0, 'C', false);
	$pdf->Cell(100, 10,'Londrina, '.date('d/m/Y'), 'T', 0, 'C', false);
	$pdf->Cell(40, 10,'', 0, 1, 'C', false);
	
	// $pdf->AddPage();
	// $imglink = "../".$dados['comprovante'];
	// $pdf->Image($imglink,10,50);

	}

$pdf->Output();
?>
