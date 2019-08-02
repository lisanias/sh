<?php
/**
 * Módulo DADOS DO ALUNO
 * 
 */

$idaluno = base64_decode($_GET["id"]);

$sql = "SELECT * FROM alunos WHERE id_aluno = " . $idaluno;
$consulta = mysqli_query($con,$sql);
$dados = mysqli_fetch_array($consulta);
?>

<legend xmlns="http://www.w3.org/1999/html">
    <?php echo nome2($dados['nome']." ".$dados['sobrenome']) ?>
</legend>


<form action="./aluno.acao.php?atp=<?=base64_encode('editar_dados_do_aluno')?>" method="post" id="edit-profile" class="form-horizontal" />
<fieldset>

    <input type="hidden" id="id_aluno" name="id_aluno" value="<?= $dados['id_aluno'] ?>">
    <?= $dados['id_aluno'] ?>-<?= base64_encode($dados['id_aluno']) ?>
    <div class="control-group ">
        <label class="control-label" for="inputNome">Nome/Sobrenome</label>
        <div class="controls">
            <input class="input-medium" type="text" id="inputNome" name="inputNome" value="<?= $dados['nome'] ?>" onblur="this.value=this.value.toUpperCase()" title="Digite apenas o primeiro nome" placeholder="Nome" required />
            <input class="input-xlarge" type="text" id="inputSobrenome" name="inputSobrenome" value="<?= $dados['sobrenome'] ?>" onblur="this.value=this.value.toUpperCase()" title="Digite o sobrenome" placeholder="Sobrenome" required />
        </div>
    </div><!-- /control-group -->

    <div class="control-group">
        <label class="control-label" for="inputEndereco">Endereço/Complemento</label>
        <div class="controls">
            <input class="input-xlarge" type="text" id="inputEndereco" value="<?= $dados['endereco'] ?>" name="inputEndereco" onblur="this.value=this.value.toUpperCase()" title="Insira o endereço para correspondência (Rua, Av, Etc...)" placeholder="Rua, Av, Etc..." data-provide="typeahead" />
            <input class="input-small" type="text" id="inputComplemento" value="<?= $dados['complemento'] ?>" name="inputComplemento" onblur="this.value=this.value.toUpperCase()" title="Informações adicionais..." placeholder="Complemento" />
        </div>
    </div><!-- /control-group -->

    <div class="control-group">
        <label class="control-label" for="inputBairro">Bairro</label>
        <div class="controls">
            <input class="input-xlarge" type="text" id="inputBairro" name="inputBairro" value="<?= $dados['bairro'] ?>" title="Insira o bairro" onblur="this.value=this.value.toUpperCase()" placeholder="Bairro" data-provide="typeahead" />
        </div>
    </div><!-- /control-group -->

    <div class="control-group">
        <label class="control-label" for="inputCidade">CEP/Cidade/Estado</label>
        <div class="controls">
            <input class="input-small" type="text" id="inputCEP" name="inputCEP" value="<?= $dados['cep'] ?>" onblur="this.value=this.value.toUpperCase()" title="Digite o CEP" placeholder="CEP" />
            <input class="input-large" type="text" id="inputCidade" name="inputCidade" value="<?= $dados['cidade'] ?>" title="Cidade" onblur="this.value=this.value.toUpperCase()" placeholder="Cidade" data-provide="typeahead" />
            <input class="input-mini" type="text" id="inputUF" name="inputUF" value="<?= $dados["uf"] ?>" title="Digite o Estado" onblur="this.value=this.value.toUpperCase()" placeholder="UF" pattern="[A-Z]{2}" onChange="javascript:this.value=this.value.toUpperCase();" />
        </div>
    </div><!-- /control-group -->

    <br>

    <div class="control-group">
        <label class="control-label" for="inputTres">Telefone Residencial</label>
        <div class="controls">
            <input class="input-medium" type="text" id="inputTres" name="inputTres" value="<?= $dados["tres"] ?>" title="Insira o telefone com o DDD" placeholder="Telefone" />
        </div>
    </div><!-- /control-group -->

    <div class="control-group">
        <label class="control-label" for="inputTcel">Telefone Celular</label>
        <div class="controls">
            <input class="input-medium" type="text" id="inputTcel" name="inputTcel" value="<?= $dados['tcel'] ?>" title="Insira o celular com o DDD" placeholder="Celular" />
        </div>
    </div><!-- /control-group -->

    <br>

    <div class="control-group">
        <label class="control-label" for="inputEmail">E-mail</label>
        <div class="controls">
            <input class="input-xxlarge" type="email" id="inputEmail" name="inputEmail" value="<?= $dados['email'] ?>" title="Insira o e-mail" placeholder="E-mail" required />
        </div>
    </div><!-- /control-group -->

    <div class="control-group">
        <label class="control-label" for="inputCPF">CPF</label>
        <div class="controls">
            <input class="input-small" type="text" id="inputCPF" name="inputCPF" value="<?= $dados['cpf'] ?>" title="CPF: digite apenas os números" placeholder="E-mail" required disabled />
        </div>
    </div><!-- /control-group -->

    <div class="control-group">
        <label class="control-label" for="inputDnas">Data de Nascimento</label>
        <div class="controls">
            <input class="input-small" type="text" id="inputDnas" name="inputDnas" value="<?php echo implode('/',array_reverse(explode('-',$dados['dnas']))); ?> " title="Insira a data de nascimento" placeholder="Data de Nascimento" />
            <br><span style="font-size:.7em; font-style:italic; margin:o; padding:o; line-height:.6em;">Formato (dd/mm/aaaa)</span>
        </div>
    </div><!-- /control-group -->

    <div class="control-group">
        <label class="control-label inline" for="inputSexo">Sexo</label>
        <div class="controls">
            <label class="inline checkbox">
                <input type="radio" name="inputSexo" id="inputSexo1" value="M" <?php if ($dados["sexo"]=='M') {echo "checked";} ?> >
                Masculino
            </label><!-- /inline -->
            <label class="inline checkbox">
                <input type="radio" name="inputSexo" id="inputSexo2" value="F" <?php if ($dados["sexo"]=='F') {echo "checked";} ?> >
                Feminino
            </label><!-- /inline -->
        </div><!-- /controls -->
    </div><!-- /control-group -->

    <div class="control-group">
        <label class="control-label" for="inputEC">Estado Civil</label>
        <div class="controls">
            <select id="inputEC" name="inputEC" title="Estado Civil" placeholder="Estado Civil" >
                <option placeholder="Estado Civil"></option>
                <option value="1" <?php if ($dados["estado_civil"]==1) {echo "selected";} ?> >Solteiro(a)</option>
                <option value="2" <?php if ($dados["estado_civil"]==2) {echo "selected";} ?> >Casado(a)</option>
                <option value="3" <?php if ($dados["estado_civil"]==3) {echo "selected";} ?> >Viúvo(a)</option>
                <option value="4" <?php if ($dados["estado_civil"]==4) {echo "selected";} ?> >Divorciado(a)</option>
                <option value="9" <?php if ($dados["estado_civil"]==9) {echo "selected";} ?> >Outro(a)</option>
            </select>
        </div><!-- /controls -->
    </div><!-- /control-group -->

    <div class="control-group">
        <label class="control-label" for="inputIgreja">Igreja</label>
        <div class="controls">
            <input class="input-xxlarge" type="text" id="inputIgreja" name="inputIgreja" value="<?= $dados['igreja'] ?>" onblur="this.value=this.value.toUpperCase()" title="Insira a a que você é membro" placeholder="Igreja" required="required" />
        </div>
    </div><!-- /control-group -->

    <div class="control-group">
        <label class="control-label" for="inputObs" >Obs</label>
        <div class="controls">
            <input class="input-xxlarge" type="text" id="inputObs" name="inputObs" value="<?= $dados['obs']?> " title="Insira a igreja na qual você congrega" placeholder="Observações importantes" />
        </div>
    </div><!-- /control-group -->

    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn btn-primary btn-large span4" id="btnenviar" >Atualizar</button>
        </div>
    </div><!-- /control-group -->

</fieldset>
</form>

                        