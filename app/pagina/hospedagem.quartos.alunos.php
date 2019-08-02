<?php

$sql_alunos = "SELECT *
                    FROM matricula
                    INNER JOIN cama
                        ON matricula.id_cama = cama.id_cama
                    INNER JOIN quarto
                        ON cama.id_quarto = quarto.id_quarto
                    INNER JOIN alunos
                        ON matricula.id_aluno = alunos.id_aluno
                    WHERE
                        matricula.id_evento = '".$_SESSION['evento']."'
                        AND quarto.id_quarto = '".$dados['id_quarto']."'
			";
		
		$tabela_alunos = mysqli_query($con,$sql_alunos);
        
        $n = 0;
        
        if ($linhas_alunos = mysqli_num_rows($tabela_alunos)) {
            
            while ($dados_alunos = mysqli_fetch_array($tabela_alunos)) {


                $anome = $dados_alunos['nome']." ".$dados_alunos['sobrenome'];
                echo fsc_ok($dados_alunos['status']);
				echo "<a class='icon-remove-sign' href='aluno.acao.php?atp=".base64_encode('tirar_do_quarto')."&id=".base64_encode($dados_alunos['id_matricula'])."' style='color:red' title='Tirar aluno do quarto (esta açao não pode ser desfeita)' ></a> ";
				echo "<abbr title='".$anome." - ".$dados_alunos['cidade']."/".$dados_alunos['igreja']."'>".nome2($anome)." </abbr><br>";
                $n = $n+1;
                
            }
            
        }
        
        while ($n < $dados['capacidade']) {
            echo "<span style='color: #C8C8C8'>Cama Livre</span><br>";
            $n = $n+1;
        }

?>