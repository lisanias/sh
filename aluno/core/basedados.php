<?php

// conectar com a base de dados pagamento

// sql para inserir dados

class db {

    public $sql;

    function sqlPagamentoAdd($dados)
    {
        
        $sql = "INSERT INTO pagamento ( 
            id_matricula, 
            data_pg, 
            descricao, 
            valor,
            forma_pg,
            parcelas,
            status,
            ref_a
            )

        VALUES ( 
            '" . $dados['id_matricula'] . "',
            '" . date("Y-m-d") . "', 
            'Pagamento online pela Cielo', 
            '" . $dados['valor'] . "',
            '6',
            '" . $dados['parcela'] ."',
            '" . $dados['status'] . "',
            '" . $dados['ref_a'] . "'
            )";
        return $sql;
    }


    function connect ($sql)
    {
        //faço a conexão com o banco  
        $con = mysqli_connect('localhost', 'sagra213_hosana', 'lucas#3$1', 'sagra213_hosana');
        mysqli_set_charset( $con, 'utf8');
        
        if(!$result = $con->query($sql)){
            //$_SESSION['msg'] = 'Ha um erro ao executar a pesquisa na base de dados [' . $con->error . ']';
            echo 'Ha um erro ao executar a pesquisa na base de dados [' . $con->error . ']';
            // Redireciona para home do aluno
            header("Location: ../aluno.home.php");
            die();
        }

        $id = $con->insert_id;

        return $id;
    }

    function sqlPagCartaoAdd($dados)
    {
        $sql = "INSERT INTO pag_cartao ( 
            pagamento_id, 
            paymentId,
            tid, 
            authorization_code, 
            card_number,
            holder,
            parcelas,
            customer,
            amount,
            brand
            )

        VALUES ( 
            '" . $dados['pagamento_id'] . "',
            '" . $dados['paymentId'] ."',
            '" . $dados['tid'] . "', 
            '" . $dados['authorization_code'] . "', 
            '" . $dados['card_number'] . "',
            '" . $dados['holder'] . "',
            '" . $dados['parcelas'] ."',
            '" . $dados['customer'] ."',
            '" . $dados['amount'] ."',
            '" . $dados['brand'] . "'
            )";
        return $sql;
    }

}