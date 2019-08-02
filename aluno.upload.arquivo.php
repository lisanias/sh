<?php
// #################         UPLOAD DA IMAGEM      #################

// inclui arquivos com configurações iniciais, acesso a base de dados e com as rotinas.
include("aluno.seguranca.php"); // Inclui o arquivo com o sistema de segurança
include("i_funcoes.php");

// verifica se tem algum arquivo
if (isset($_FILES['arquivo']))
{
  // Verificar o tipo de arquivo
  // ceita jpg gif e png
  $arquivo = $_FILES['arquivo'];

  $check = getimagesize($arquivo["tmp_name"]);
  if($check !== false)

  //if ($arquivo['type'] == "image/jpeg" || $arquivo['type']== "image/pjpeg" || $arquivo['type']== "image/png" || $arquivo['type']== "image/gif" )
  {
	// arquivo aceito - continua 
  } else{
		// arquivo de tipo diferente, não aceito. Define a mensagem a ser enviada para o usuário e envia para a pagina home de novo.
		$_SESSION["msg"] = "Arquivo inválido. Voce precisa enviar uma foto ou imagem escaneada do comprovante.";
		exit(header("Location: aluno.home.php"));
  }
  
  // verificar se o tamanho do arquivo é menor que 4Mb
  if ($arquivo['size']>4194304)
  {
		$_SESSION["msg"] = "Arquivo muito grande. Tamanho máximo permitido 4Mb. O arquivo que está tentando enviar tem ".round($arquivo['size']/1024)."Kb<br><br>";
		exit(header("Location: aluno.home.php"));
  }
  
  // dar um novo nome ao arquivo
  $novonome = $_SESSION['id_aluno'] . "." . md5(uniqid(time())).'.jpg';
 

  // envia para o servidor
  $dir = "upload/pg/" . $_SESSION['evento_atual'] . "/";
  //$dir_real = '/home/lisanias/sites/hosana/upload/pg/' . $_SESSION['evento_atual'] . '/'; // funcionando no site online
  $dir_real = 'upload/pg/' . $_SESSION['evento_atual'] . '/'; // Posição relativa...
  if (!file_exists($dir_real))
  {
    mkdir($dir_real, 0755);  
  }
  $caminho = $dir.$novonome;
  $caminho_real = $dir_real.$novonome;
  move_uploaded_file($arquivo['tmp_name'],$caminho_real);
  
  // arquivo envido

}
else {
$cmsg = base64_encode("Precisa escolher um arquivo contendo uma copia do comprovante para enviar para o SH");
exit(header("Location: aluno.home.php?msg=$cmsg"));
}

// função para formatar o valor coretamente para PHP e SQL
function valor_ok($num_work)
{
    if ((strpos($num_work,".") > "-1") | (strpos($num_work,",") > "-1")) {
        if ((strpos($num_work,".") > "-1") & (strpos($num_work,",") > "-1")) {
            if (strpos($num_work,".") > strpos($num_work,",")){
                return str_replace(",","",$num_work);
            } else {
                return str_replace(",",".",str_replace(".","",$num_work));
            }
        } else {
            if (strpos($num_work,".") > "-1") {
                if (strpos($num_work,".") == strrpos($num_work,".")) {
                    return $num_work;
                } else {
                    return str_replace(".","",$num_work);
                }
            } else {
                if (strpos($num_work,",") == strrpos($num_work,",")) {
                    return str_replace(",",".",$num_work);
                } else {
                    return str_replace(",","",$num_work);
                }
            } }
    } else {
        return $num_work;
    } }



// ################      INSERIR DADOS     #################

// inserir os dados do aluno
// continuar arrumando os VALUESs

// segurança

$input_id_matricula = (int)$_POST['inp_id_matricula'];

	$sql = "INSERT INTO pagamento ( 
		id_matricula, 
		data_add_pg, 
		data_pg, 
		descricao, 
		valor, 
		forma_pg, 
		comprovante, 
		status,
		ref_a, 
		complemento) 

	VALUES ( 
		'" . $input_id_matricula . "',
		now(), 
		'" . implode('-',array_reverse(explode('/',$_POST['inp_data']))) . "', 
		'" . $_POST['inp_descricao'] . "', 
		'" . valor_ok($_POST['inp_valor']) . "',
		'" . $_POST['inp_forma_pg'] . "', 
		'" . $caminho . "', 
		'2', 
		'" . $_POST['inp_ref'] . "', 
		'" . $_POST['inp_obs'] . "')";
		
	if(!$result = $con->query($sql)){
 		$cmsg = base64_encode("Erro ao inserir dados: [' . $con->error . ']");
		//die(header("Location: aluno.home.php?msg=$cmsg"));
		die("Dados não inserido na base de dados devido a um erro interno. Erro: [' . $con->error . ']");
		}
	  else {
		header("Location: aluno.home.php?msg=$cmsg");
		//echo "<h3>Ok</h3>";
	  }
	  
// ################      ALTERAR DADOS DA MATRICULA - inscrição enviada     #################

/* 
	Depois de enviada o pagamento, e se for da inscrição e a inscrição ainda não 
	tiver sido confimada de outra forma, mudar o status para comprovante enviado (3)
*/
if ($_POST['inp_status_matricula'] == 2  && ($_POST['inp_ref'] == 1 or $_POST['inp_ref'] == 2)) {
	$sql = "UPDATE matricula SET status = 3 WHERE id_matricula = $input_id_matricula";
	if(!$result = $con->query($sql)){
			$cmsg = base64_encode("Erro ao atualizar Dados: [' . $con->error . ']");
			die(header("Location: aluno.home.php?msg=$cmsg"));
			}
	$cmsg = base64_encode("Comprovante de pagamento enviado");
	die(header("Location: aluno.home.php?msg=$cmsg"));
}

?>