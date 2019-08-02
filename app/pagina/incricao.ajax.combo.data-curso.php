<?php
	/**
	 * função que retorna o select
	 */
	function montaSelect()
	{
		$con = mysqli_connect('localhost', 'root', 'lucas#3$1', 'hosana');
		$sql = "SELECT * FROM evento WHERE data_ini > NOW()";
		$query = mysqli_query( $con, $sql );
 
		if( mysqli_num_rows( $query ) > 0 )
		{
			while( $dados = mysql_fetch_assoc( $query ) )
			{
				$opt .= '<option value="'.$dados['id_evento'].'">'.$dados['descricao'].'</option>';
			}
		}
		else
			$opt = '<option value="0">Selecione um evento</option>';
 
		return $opt;
	}
 
	/**
	 * função que devolve em formato JSON os dados do cliente
	 */
	function retorna( $id )
	{
		$id = (int)$id;
 
		$sql = "SELECT * FROM modulo
			INNER JOIN cursos AS modulo.id_curso = cursos.id_curso
			WHERE 'id_evento' = {$id} ";
		$query = mysql_query( $sql );
 
 
		$arr = Array();
		if( mysql_num_rows( $query ) )
		{
			while( $dados = mysql_fetch_object( $query ) )
			{
				$arr['id_curso'] = $dados->id_curso;
				$arr['modulo'] = $dados->modulo. $dados->apelido;
				$arr['valor'] = $dados->valor;
			}
		}
		else
			$arr[] = 'Nenhum modulo cadastrado para essa data.';
 
		return json_encode( $arr );
	}
 
/* só se for enviado o parâmetro, que devolve o combo */
if( isset($_GET['id_evento']) )
{
	echo retorna( $_GET['id_evento'] );
}

?>