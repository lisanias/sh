<form id='login' action='aluno.login.valida.php' method='post' accept-charset='UTF-8'>
    <fieldset >
        <legend>Login</legend>
        <input type='hidden' name='submitted' id='submitted' value='1'/>

        
        <div class="control-group">
            <label class="control-label" for='usuario' >Usuário:</label>
            <div class="controls">
                <input type="text" id="usuario" name="usuario"  maxlength="50" required /> 
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for='senha' >Senha:</label>
            <div class="controls">
                <input type="password" id="senha" name="senha" maxlength="50" required /> 
            </div>
        </div>

        <br><input type='submit' name='Submit' value='Entrar' />
    </fieldset>
</form>

<a href="aluno.recuperar.senha.php">Esqueceu a sua senha? </a>

