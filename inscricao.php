<?php
error_reporting(E_ALL);
ini_set('display_errors','On');

include './i_secao.evento.default.php';

// verificar se tem algum campo predefinido para focar
$campo_cursor = '';

if(isset($_SESSION['focus'])){
		$campo_cursor = $_SESSION['focus'];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <!--[if IE]><link rel="shortcut icon" href="img/favicon.ico"><![endif]-->
		<link rel="icon" href="./img/favicon.png">

        <link rel="stylesheet" href="./css/bootstrap.css">
        <style>
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        </style>
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="./js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        
        <!-- mascaras de entradas dos campos de formulário -->
	    <script type="text/javascript" src="./js/jquery/jquery-3.3.1.js"></script>
        <script src="./js/jquery/jquery.inputmascara.js" type="text/javascript"></script>
        <script src="./js/jquery/jquery.mask.min.js" type="text/javascript"></script>

        <script type="text/javascript"> 
            jQuery.noConflict(); 
            jQuery(function($){ 
            $("#inputDnas").mask("99/99/9999"); 
            $("#inputTres").mask("(99) 9999-9999");
            $("#inputCPF").mask("999.999.999-99", {placeholder:" "}); 
            $("#inputCEP").mask("99999-999");
            
            var SaoPauloCelphoneMask = function(phone, e, currentField, options){
                return phone.match(/^(\(?11\)? ?9(5[0-9]|6[0-9]|7[01234569]|8[0-9]|9[0-9])[0-9]{1})/g) ? '(00) 00000-0000' : '(00) 00000-0000';
                };
            
            $("#inputTcel").mask(SaoPauloCelphoneMask, { onKeyPress: function(phone, e, currentField, options){
                $(currentField).mask(SaoPauloCelphoneMask(phone), options);
                }});
                
                $('pre').each(function(i, e) {hljs.highlightBlock(e)});
            });
        </script> 

        <script>
                function vermsg($msg)
                {
                        $('#<?=$campo_cursor?>').focus();
						if ( $msg.length > 0 ) {
                                $('#myModal').modal('show');
                        }
                }
        </script>
                       
        <script type="text/javascript" src="./js/jquery/jquery-3.3.1.js"></script>
        <script>
            // verificar e-mail
            $(document).ready(function(){
            $("#inputEmail").blur(function(){
                $.ajax({
                url : 'inscricao.verifica.raj.php',
                type : 'GET',
                data : 'pesquisa=email&input='+ $("#inputEmail").val(),
                dataType  : 'html',
                success: function(data){
                    msg = data.split("##");
                    if( msg[0] === "ok" )
                    {
                        $("#resultadoMail").html(msg[1]);
                        $("#inputEmail").val("");
                        $("#inputEmail").focus();
                    }
                    else 
                        {
                            $("#resultadoMail").html('');	
                        } 
                }
                })
            });
            
            // verificar se o login é unico  
            $("#inputLogin").blur(function(){
                $.ajax({
                url : 'inscricao.verifica.raj.php',
                type : 'GET',
                data : 'pesquisa=login&input='+ $("#inputLogin").val(),
                dataType  : 'html',
                success: function(data){
                    msg = data.split("##");
                    if( msg[0] === "ok" )
                    {
                        $("#resultadoLogin").html(msg[1]);
                        $("#inputLogin").val("");
                        $('#inputLogin').attr('placeholder', 'Escolha outro login!');
                        $("#inputLogin").focus();
                    }
                    else 
                        {
                            $("#resultadoLogin").html('');	
                        } 
                }
                })
            });
            
            // verificar se o CPF é unico  
            $("#inputCPF").blur(function(){
                $.ajax({
                url : 'inscricao.verifica.raj.php',
                type : 'GET',
                data : 'pesquisa=cpf&input='+ $("#inputCPF").val(),
                dataType  : 'html',
                success: function(data){
                    msg = data.split("##");
                    if( msg[0] === "ok" )
                    {
                        $("#resultadoCPF").html(msg[1]);
                        $("#inputCPF").val("");
                        $('#inputCPF').attr('placeholder', 'Faça a sua rematrícula');
                    }
                    else 
                        {
                            $("#resultadoCPF").html('');	
                        } 
                }
                })
            });
            
            $("#<?=$campo_cursor?>").focus();
            
            });
        </script>
        
    </head>
    <body>

 	<div class="container">

        <?php include 'm_top.alunos.php'; ?>

            <!-- Seção pricipal do conteúdo - 3 colunas -->
            
            <div class="row">
                <div class="row-fluid  media">
                    <a class="pull-left" href="#">
                        <img src="img/h48.png" class="img-rounded">
                    </a>
                    <div class="media-body" style="padding-left:10px">
                        <h3 class="media-heading">Cadastro <small>de novos alunos</small></h3>
                        <p class="muted"></p>
                    </div>                	
                </div>

                <div class="row-fluid">
                    
                    <!-- Coluna Formulario da esquerda -->
                    <div class="span3">
                    	
                        <div class="hero-unit hide" >
                        	<legend><i class="icon24" style="background-image:url(img/icon_cama&24.png);"></i>Vagas...</legend>
                            <div style="font-size:.85em; line-height:120%">
                            
                            <?php 
							/*
							include 'r_vagas_disponiveis.php'; 
							if ($vagas > 25) {
									echo "Estamos com vagas.";
									$vagas_disponivel = '';
							}	else if ($vagas <= 40 && $vagas > 20) {
									echo "Estamos com algumas vagas. Faça logo a sua inscrição.";
									$vagas_disponivel = 'algumas';
							}	else if ($vagas <= 20 && $vagas > 0) {
									echo "Estamos com poucas vagas. Faça <strong style='color:red'>AGORA</strong> a sua inscrição.";
									$vagas_disponivel = 'poucas';
							} 	else {
									echo "Infelizmente estamos sem vagas. Você pode fazer sua pré-inscrição que ficará em uma lista de espera ou entre em contato com a secretaria do SH.";
									$vagas_disponivel = '0';
							}
							
							
							/ definir qual está selecionado e se for reixibição exibir o mesmo selecionado anteriormente...
							$valor_opcao = (isset($_SESSION['input_hospedagem']))? $_SESSION['input_hospedagem'] : '';
							
							// opções para o campo hospedagem
							if ($vagas < 1) {
								$vagas_msg = "<span class='label label-important'>No momento estamos sem vagas para hospedagem!</span><br>&nbsp;<br>
											Você poderá fazer a iscrição sem hospedagem, optado por dormir em outro lugar, por conta própria, ou poderá colocar sua inscrição em lista de espera.<br>
											Quem não ficar hospedado no Seminário Hosana terá um desconto de R$ 80,00.";
								if ($valor_opcao == 1){
									$selecionado1 = "selected";
									$selecionado2 = "";
								} else {
									$selecionado1 = "";
									$selecionado2 = "selected";
								}
								$vagas_hospedagem_lista1 = "<option value='1' {$selecionado1} >Lista de espera</option>";
								$vagas_hospedagem_lista2 = "<option value='0' {$selecionado2} >Sem hospedagem</option>";
							} else {
								if ($valor_opcao === 0){
									$selecionado1 = "";
									$selecionado2 = "selected";
								} else {
									$selecionado1 = "selected";
									$selecionado2 = "";
								}
								$vagas_msg = "<div>Temos {$vagas_disponivel} vagas para hospedagem</div>";
								$vagas_hospedagem_lista1 = "<option value='1' {$selecionado1} >Sim</option>";
								$vagas_hospedagem_lista2 = "<option value='0' {$selecionado2} >Não</option>";
							}
							
							*/
							?>
                            </div>

                            <span class="clearfix"></span>
                            
                        </div>

                        <div class="hero-unit">
                            
                            <legend><i class="icon-info-sign" ></i> Informações</legend>
                            
                            <li>A inscrição só estará efetivada após o pagamento da valor minimo (inscrição).
                            <li>O valor da inscrição faz parte do valor total do módulo.
                            <li>Em caso de não comparecimento na data do evento sem avivo prévio de 7 dias úteis, o aluno perde o valor da inscrição já pago.

                            <li>Inscrição para o Congresso Hosana. 
                            <span class="clearfix"></span>
                        </div>
                       
                    </div>
                    
                    <!-- Coluna formulario da direita -->
                    <div class="span6">
                        
                      <!-- Conteúdo principal -->
                    
                        <div class="hero-unit form-horizontal">

                            <div class='alert' style="font-size: 1em; line-height: 120%;">
                                <p><strong>Cadastro para inscrição de novos alunos.</strong></p> 
                                <p>Se você fez ou está fazendo algum curso, 
                                participou de algum congresso e etc, já tem cadastro no Seminário Hosana.
                                Nesse caso, faça login na <a href="aluno.login.php">Área do Aluno</a>.</p>
                            </div>
                        	
                            <!-- Formulario de inscrição -->                                   
                            <form name="aluno" class="form-inline" method="post" action="inscricao.acao.php" onsubmit="document.getElementById('btnenviar').disabled = 1;">
                               
                                <legend><i class="icon24" style="background-image:url(img/icon-diploma&24.png);"></i> Curso</legend>
                                
                                <input type="hidden" name="hidden_vagas" value="<?=$vagas?>">
                                
                                <div class="control-group">
                                    <label class="control-label" for="inputCurso">Selecione um curso </label>
                                    <div class="controls">
                                       <select class="input-large" id="inputCurso" name="inputCurso"  placeholder="Selecione um curso...">
                                       		<option selected></option>
                                            <?php
												//faço a conexão com o banco
												$con_curso = mysqli_connect('localhost', 'sagra213_hosana', 'lucas#3$1', 'sagra213_hosana');
												// verificar a conexão
												if (mysqli_connect_error($con_curso))
												  {
												  echo "Falha ao conectar com o banco de dados, erro: " . mysqli_connect_error() . "(" . mysqli_connect_errno() . ")<br>";
                                                  }
                                                  
                                                  mysqli_set_charset( $con_curso, 'utf8');
												
												//  selecionar tablea
												$sql = "SELECT * FROM  cursos";
												  if(!$result = $con_curso->query($sql)){
														die('Ha um erro ao executar a pesquisa na base de dados [' . $con_curso->error . ']');
													}
													
												// mostrar os dados	
												$tabela = mysqli_query($con_curso,$sql);								
												$selecionado = '';
												while ( $dados = mysqli_fetch_array($tabela) ) {
                                                        if($dados['id_curso']>3){
                                                            continue;
                                                        }
														if (isset($_SESSION['input_curso'])){
															$selecionado = ($_SESSION['input_curso'] == $dados['id_curso'])?'selected':'';
														}
														# $disabled = ($dados['id_curso'] == 7? 'disabled': ''); # para o caso de algum curso não estar disponivel
														
														echo '<option value="'.$dados['id_curso'].'" '. $selecionado .' '. $disabled .' >'.$dados['id_curso'] .' - <abbr title="'. $dados['nome_curso'] .'">'. $dados['apelido'] .'</abbr></option>';
													}
												mysqli_close($con_curso);
											?>
                                       </select>
                                       <span class="label label-info"><?=$_SESSION['evento_atual_nome'];?></span>
                                       <i class="icon-fire"></i>
                                       <br><?php echo($campo_cursor=='inputCurso'?"<span class='label label-warning'>Preenchimento Obrigatório</span>":''); ?> 
                                    </div>
                                </div>
                                
                                <div class="control-group hide">
                                    <label class="control-label" for="inputHospedagem">Hospedagem </label>
                                    <div class="controls">
                                      <select id="inputHospedagem" name="inputHospedagem" />
                                      	<?= $vagas_hospedagem_lista1 ?>
                                        <?= $vagas_hospedagem_lista2 ?>
                                      </select>
                                      <i class="icon-fire"></i><br>
                                      <?php echo($campo_cursor=='inputHospedagem'?"<span class='label label-warning'>Preenchimento Obrigatório</span><br>":''); ?> 
                                      <div style="font-size: 0.6em; font-style:italic; margin:0; padding:20px 0 0 0; line-height:1.3em"><?= $vagas_msg ?></div>
                                    </div>
                                </div>
                                
                                <legend><i class="icon24" style="background-image:url(img/icon_user2_24.png);"></i> Informações básicas e Login</legend>
                                
                                <div class="control-group">
                                    <label class="control-label" for="inputNome">Nome </label>
                                    <div class="controls">
                                      <input type="text" id="inputNome" name="inputNome" title="Digite apenas o primeiro nome" value="<?php echo(isset($_SESSION['input_nome'])?$_SESSION['input_nome']:''); ?>" placeholder="Nome" onblur="this.value=this.value.toUpperCase()" /> 
                                      <i class="icon-fire"></i>
                                      <br><?php echo($campo_cursor=='inputNome'?"<span class='label label-warning'>Preenchimento Obrigatório</span>":''); ?>
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="inputSobrenome">Sobrenome</label>
                                    <div class="controls">
                                      <input type="text" id="inputSobrenome" name="inputSobrenome" title="Digite o sobrenome" value="<?php echo(isset($_SESSION['input_sobrenome'])?$_SESSION['input_sobrenome']:''); ?>" onblur="this.value=this.value.toUpperCase()" placeholder="Sobrenome" /> 
                                      <i class="icon-fire"></i>
                                      <br><?php echo($campo_cursor=='inputSobrenome'?"<span class='label label-warning'>Preenchimento Obrigatório</span>":''); ?>
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="inputEmail">E-mail</label>
                                    <div class="controls">
                                      <input type="email" id="inputEmail" name="inputEmail" title="Insira o e-mail"  value="<?php echo(isset($_SESSION['input_email'])?$_SESSION['input_email']:''); ?>" placeholder="E-mail" /> 
                                      <i class="icon-fire"></i>&nbsp;&nbsp;
                                      <span class="label label-important" id="resultadoMail"></span>
                                      <br><?php echo($campo_cursor=='inputEmail'?"<span class='label label-warning'>Preenchimento Obrigatório</span>":''); ?>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="inputLogin">Usuário</label>
                                    <div class="controls">
                                      <input type="text" id="inputLogin" name="inputLogin" title="Escolha o seu login"  value="<?php echo(isset($_SESSION['input_login'])?$_SESSION['input_login']:''); ?>" pattern="[a-z0-9_-]{5,15}" placeholder="Usuário para fazer login na área do aluno" /> 
                                      <i class="icon-fire"></i>&nbsp;&nbsp;
                                      <span class="label label-important" id="resultadoLogin"></span>
                                      <br><?php echo($campo_cursor=='inputLogin'?"<span class='label label-warning'>Preenchimento Obrigatório</span><br>":''); ?>
                                      <div style="font-size: 0.6em;  font-style:italic; line-height:1.3em; padding-top:10px;">Nome para logar na área do aluno.<br />(Letras ou números com no mínimo 5 caracteres)</div>
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="inputSenha">Senha</label>
                                    <div class="controls">
                                      <input type="password" id="inputSenha" name="inputSenha"  value="<?php echo(isset($_SESSION['input_senha'])?$_SESSION['input_senha']:''); ?>" pattern="[a-zA-Z0-9][a-zA-Z0-9!@#$&,.;_-]{5,20}" placeholder="Senha do usuário" > 
                                      <i class="icon-fire"></i>
                                      <br><?php echo($campo_cursor=='inputSenha'?"<span class='label label-warning'>Preenchimento Obrigatório</span><br>":''); ?>
                                      <span style="font-size: 0.6em;  font-style:italic; line-height:.6em">(Letras, números e alguns simbolos com no mínimo 6 caracteres)</span>
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="inputCPF"><abbr title="Cadastro de Pessoa Física">CPF</abbr></label>
                                    <div class="controls">
                                      <input type="text"  id="inputCPF" name="inputCPF" title="Insira o seu CPF"  value="<?php echo(isset($_SESSION['input_cpf'])?$_SESSION['input_cpf']:''); ?>" pattern="^(\d{3}\.\d{3}\.\d{3}-\d{2})|(\d{11})$" placeholder="CPF (Digite apenas os números)" /> 
                                      <i class="icon-fire"></i>
                                      <br><?php echo($campo_cursor=='inputCPF'?"<span class='label label-warning'>Preenchimento Obrigatório</span><br>":''); ?>
                                      <span class="label label-important" id="resultadoCPF"></span>
                                      <span class="label label-important" id="resultadoCPF2"></span><br>
                                      <span style="font-size: 0.6em;  font-style:italic; line-height:.6em">(Digite apenas os números)</span>
                                    </div>
                                </div>
                                
                                <legend><i class="icon24" style="background-image:url(img/icon_contact_card_&24.png);"></i> Endereço</legend>
                                
                                <div class="control-group">
                                    <label class="control-label" for="inputEndereco">Endereço</label>
                                    <div class="controls">
                                      <input type="text" id="inputEndereco" name="inputEndereco" title="Insira o endereço para correspondência (Rua, Av, Etc...)"  value="<?php echo(isset($_SESSION['input_endereco'])?$_SESSION['input_endereco']:''); ?>" onblur="this.value=this.value.toUpperCase()" placeholder="Rua, Av, Etc..." data-provide="typeahead" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputComplemento">Complemento</label>
                                    <div class="controls">
                                      <input type="text" id="inputComplemento" name="inputComplemento" onblur="this.value=this.value.toUpperCase()" title="Informações adicionais..."  value="<?php echo(isset($_SESSION['input_complemento'])?$_SESSION['input_complemento']:''); ?>" placeholder="Complemento" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputBairro">Bairro</label>
                                    <div class="controls">
                                      <input type="text" id="inputBairro" name="inputBairro" title="Insira o bairro"  value="<?php echo(isset($_SESSION['input_bairro'])?$_SESSION['input_bairro']:''); ?>" onblur="this.value=this.value.toUpperCase()" placeholder="Bairro" data-provide="typeahead" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputCidade">Cidade</label>
                                    <div class="controls">
                                      <input type="text" id="inputCidade" name="inputCidade"  value="<?php echo(isset($_SESSION['input_cidade'])?$_SESSION['input_cidade']:''); ?>" onblur="this.value=this.value.toUpperCase()" title="Cidade" placeholder="Cidade" data-provide="typeahead" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputUF">Estado</label>
                                    <div class="controls">
                                      <input type="text" id="inputUF" name="inputUF" title="Digite o Estado" value="<?php echo(isset($_SESSION['input_uf'])?$_SESSION['input_uf']:''); ?>" placeholder="UF" pattern="[a-zA-Z]{2}" onChange="javascript:this.value=this.value.toUpperCase();" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputCEP">CEP</label>
                                    <div class="controls">
                                      <input type="text" id="inputCEP" name="inputCEP" title="Digite o CEP"  value="<?php echo(isset($_SESSION['input_cep'])?$_SESSION['input_cep']:''); ?>" placeholder="CEP" />
                                        <br><span style="font-size: 0.6em; font-style:italic; line-height:.6em">(Digite apenas números)</span>
                                    </div>
                                </div>
                                <br>
                                <div class="control-group">
                                    <label class="control-label" for="inputTres">Telefone Residencial</label>
                                    <div class="controls">
                                      <input type="text" id="inputTres" name="inputTres" title="Insira o telefone com o DDD"  value="<?php echo(isset($_SESSION['input_tres'])?$_SESSION['input_tres']:''); ?>" placeholder="Telefone" />
                                        <br><span style="font-size: 0.6em; font-style:italic; line-height:.6em">(Digite apenas os numeros com o DDD)</span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputTcel">Telefone Celular</label>
                                    <div class="controls">
                                      <input type="text" id="inputTcel" name="inputTcel" title="Insira o celular com o DDD" value="<?php echo(isset($_SESSION['input_tcel'])?$_SESSION['input_tcel']:''); ?>" placeholder="Celular" />
                                        <br><span style="font-size: 0.6em; font-style:italic; line-height:.6em">(Digite apenas os numeros com o DDD)</span>
                                    </div>
                                </div>
                                
                                <legend><i class="icon24" style="background-image:url(img/icon_bookmark_2_&24.png);"></i> Pessoal</legend>
                                
                                <div class="control-group">     
                                <label class="control-label" for="inputDnas">Data de Nascimento</label>
                                    <div class="controls">
                                      <input type="text" id="inputDnas" name="inputDnas" value="<?php echo(isset($_SESSION['input_dnas'])?$_SESSION['input_dnas']:''); ?>" title="Insira a data de nascimento" placeholder="Data de Nascimento" />
                                      <i class="icon-fire"></i>
                                      <br><?php echo($campo_cursor=='inputDnas'?"<span class='label label-warning'>Preenchimento Obrigatório</span><br>":''); ?>
                                      <span style="font-size:.7em; font-style:italic; line-height:.6em;">Formato (dd/mm/aaaa)</span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputSexo">Sexo</label>
                                    <div class="controls">
                                      <?php
									  	$selecionado_m = "";
										$selecionado_f = "";
										if(isset($_SESSION['input_sexo'])){
											if($_SESSION['input_sexo']=="M"){
												$selecionado_m = "checked";
												$selecionado_f = "";
											} elseif($_SESSION['input_sexo']=="F"){
												$selecionado_m = "";
												$selecionado_f = "checked";
											} else {
												$selecionado_m = "";
												$selecionado_f = "";
											}
										}
									  ?>
                                      <label class="radio" >
                                        <input name="inputSexo" type="radio" id="inputSexo1" value="M"  <?=$selecionado_m?> >
                                        Masculino
                                      </label><br>
                                      <label class="radio" >
                                        <input type="radio" name="inputSexo" id="inputSexo2" value="F" <?=$selecionado_f?> >
                                        Feminino
                                      </label>
                                      <br><?php echo($campo_cursor=='inputSexo'?"<span class='label label-warning'>Preenchimento Obrigatório</span>":''); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputEC">Estado Civil</label>
                                    <div class="controls">
                                	<?php
										$defalt_ec_value = (isset($_SESSION['input_ec']))?$_SESSION['input_ec']:'';
									?>
                                    <select id="inputEC" name="inputEC" title="Estado Civil" placeholder="Estado Civil" >
                                          <option placeholder="Estado Civil"></option>
                                          <option value="1" <?php echo ($defalt_ec_value==1)?'selected':''; ?> >Solteiro(a)</option>
                                          <option value="2" <?php echo ($defalt_ec_value==2)?'selected':''; ?> >Casado(a)</option>
                                          <option value="3" <?php echo ($defalt_ec_value==3)?'selected':''; ?> >Viúvo(a)</option>
                                          <option value="4" <?php echo ($defalt_ec_value==4)?'selected':''; ?> >Divorciado(a)</option>
                                          <option value="9" <?php echo ($defalt_ec_value==9)?'selected':''; ?> >Outro(a)</option>
                                      </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputIgreja">Igreja</label>
                                    <div class="controls">
                                      <input type="text" id="inputIgreja" name="inputIgreja" value="<?php echo(isset($_SESSION['input_igreja'])?$_SESSION['input_igreja']:''); ?>" onblur="this.value=this.value.toUpperCase()" title="Insira a a que você é membro" placeholder="Igreja" /> 
                                      <i class="icon-fire"></i>
                                      <br><?php echo($campo_cursor=='inputIgreja'?"<span class='label label-warning'>Preenchimento Obrigatório</span>":''); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputObs" >Obs</label>
                                    <div class="controls">
                                      <input type="text" id="inputObs" name="inputObs" value="<?php echo(isset($_SESSION['input_obs'])?$_SESSION['input_obs']:''); ?>" title="Insira a igreja na qual você congrega" placeholder="Observações importantes" />
                                    </div>
                                </div>
                                
                                
                                <div class="control-group">
                                <div class="controls">
                                    <button type="submit" class="btn" id="btnenviar" >Enviar</button> <a href="./session.zerar.php" class="btn">Limpar</a>
                                </div>
                                </div>
                                              
                            </form>
                            
                            <div class="alert alert-info" style="font-size:.7em; font-style:italic; line-height:120%;" >
                            	<i class="icon-fire"></i> Campos obrigatórios!<br><br>
                                Envie o comprovante de depósito/pagamento de sua incrição pelo sistema, mesmo que opte por enviar por outro meio.<br>
                                Faça login no sistema com seu usuário e sua senha e siga as instruções.  
                            </div>
                            <!-- / Formulário de inscrição -->       
                        </div>
                    </div>
                    <div class="span3">
                      <!-- Coluna principal da Direita - Para informações e ajuda ao sistema -->
                      
                      <div class="alert alert-info">
                            <img src="img/h150.png">
                            <p><br>Você está se inscrevendo para o módulo de <strong><span style="color: #FF0000; "><?=$_SESSION['evento_atual_nome']?></span></strong><br />
                            	(<?= date("d/m", strtotime($_SESSION['evento_data_ini'])); ?> a <?= date("d/m", strtotime($_SESSION['evento_data_fim'])); ?>)
                            </p>
                      </div>
                      
                    </div>
                </div>
            </div>
            
            <!-- Linha com colunas para informações auxiliares  -->
            <div class="row">
                <div class="span4">
                    <address>
                      <i class="icon-home"></i><strong> Escritório Administrativo</strong><br>
                      Rua Caraíbas, nº 424<br>
                      Vila Casoni - 86026-560 - Londrina - PR<br>
                    </address>
                </div>
                <div class="span4">
                    <address>
                      <i class="icon-info-sign"></i><strong> Contato</strong><br>
                      <abbr title="Phone">Tel:</abbr> (43) 3325 1424<br>
                      <a href="mailto:secretaria@seminariohosana.com.br">secretaria@seminariohosana.com.br</a><br>
                    </address>
                </div>
                <div class="span4">
                    <address>
                    	<i class="icon-question-sign"></i><strong> Suporte Técnico</strong><br>
                    	<abbr title="Telefone Celular">Tel:</abbr> (43) 9152-2015 <br />
                        <a href="mailto:pastorlisanias@gmail.com">pastorlisanias@gmail.com</a>
                    </address>
                </div>
            </div>

            <hr>

            <footer>
                <?= BOTTON_A ?>
            </footer>

        </div> <!-- /container -->


        <!-- MODAL -->
        <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
        <script src="js/vendor/jquery-1.9.1.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>

        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>

	  <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-3218464-2']);
        _gaq.push(['_trackPageview']);
      
        (function() {
          var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
          ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
          var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
     </script>
      
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Atenção</h3>
  </div>
  <div class="modal-body">
    <p><?=$msg?></p>
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Fechar</button>
  </div>
</div>

    </body>
</html>