<?php
require('./fpdf/fpdf.php');
require('./inc/iniciar.php');



$sql = "SELECT * FROM alunos";
$tabela = mysqli_query($con,$sql);

// Variaveis de Tamanho

$mesq = "10"; // Margem Esquerda (mm)
$mdir = "8"; // Margem Direita (mm)
$msup = "18"; // Margem Superior (mm)
$leti = "101.6"; // Largura da Etiqueta (mm)
$aeti = "25.4"; // Altura da Etiqueta (mm)
$ehet = "5"; // Espaço horizontal entre as Etiquetas (mm)
$pdf=new FPDF('P','mm','Letter'); // Cria um arquivo novo tipo carta, na vertical.
$pdf->Open(); // inicia documento
$pdf->AddPage(); // adiciona a primeira pagina
$pdf->SetMargins('5','12'); // Define as margens do documento
$pdf->SetAuthor("Lisanias Loback"); // Define o autor
$pdf->SetFont('helvetica','',7); // Define a fonte
//$pdf->SetDisplayMode();

$coluna = 0;
$linha = 0;

//MONTA A ARRAY PARA ETIQUETAS
while($dados = mysqli_fetch_array($tabela)) {
	$nome = utf8_decode(strtoupper(substr($dados["nome"].' '.$dados["sobrenome"],0,40)));
	$ende = utf8_decode(strtoupper(substr($dados["endereco"].' '.$dados["complemento"],0,50)));
	$bairro = $dados["bairro"];
	$estado = $dados["uf"];
	$cida = $dados["cidade"];
	$local = utf8_decode(strtoupper(substr($bairro . " - " . $cida . " - " . $estado,0,50)));
	$cep = "CEP: " . $dados["cep"];

	if($linha == "10") {
		$pdf->AddPage();
		$linha = 0;
	}

	if($coluna == "2") { // Se for a segunda coluna
		$coluna = 0; // $coluna volta para o valor inicial
		$linha = $linha +1; // $linha é igual ela mesma +1
	}

	if($linha == "10") { // Se for a última linha da página
		$pdf->AddPage(); // Adiciona uma nova página
		$linha = 0; // $linha volta ao seu valor inicial
	}

	$posicaoV = $linha*$aeti;
	$posicaoH = $coluna*$leti;

	if($coluna == "0") { // Se a coluna for 0
		$somaH = $mesq; // Soma Horizontal é apenas a margem da esquerda inicial
	} else { // Senão
		$somaH = $mesq+$posicaoH+$ehet; // Soma Horizontal é a margem inicial mais a posiçãoH
	}

	if($linha =="0") { // Se a linha for 0
		$somaV = $msup; // Soma Vertical é apenas a margem superior inicial
	} else { // Senão
		$somaV = $msup+$posicaoV; // Soma Vertical é a margem superior inicial mais a posiçãoV
	}

	$pdf->Text($somaH,$somaV,$nome); // Imprime o nome da pessoa de acordo com as coordenadas
	$pdf->Text($somaH,$somaV+4,$ende); // Imprime o endereço da pessoa de acordo com as coordenadas
	$pdf->Text($somaH,$somaV+8,$local); // Imprime a localidade da pessoa de acordo com as coordenadas
	$pdf->Text($somaH,$somaV+12,$cep); // Imprime o cep da pessoa de acordo com as coordenadas

	$coluna = $coluna+1;
}

$pdf->Output();
?>