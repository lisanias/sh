 	<table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Valor</th>
                    <th>Status</th>
                </tr>
<?php

$sql = "SELECT * FROM pagamento WHERE id_matricula = ". $id_matricula;

$consulta = mysqli_query($con,$sql);

while ($dados = mysqli_fetch_array($consulta)) {
	echo "<tr><td>". $dados['data_pg'] ."</td><td>". $dados['valor'] ."</td><td>".function_pg_status_icon($dados['status'])." <a href='".$dados['comprovante']."' class='btn btn-mini btn-primary'><i class='icon-picture'></i></a></td></tr>";
}

?>
	</table>