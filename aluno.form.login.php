<form id='login' action='aluno.login.valida.php' method='post' accept-charset='UTF-8'>
    <fieldset >
        <legend>Login</legend>
        <input type='hidden' name='submitted' id='submitted' value='1'/>

        <label for='usuario' >Usuário:</label>
        <input type='text' name='usuario' id='username'  maxlength="50" required />

        <label for='senha' >Senha:</label>
        <input type='password' name='senha' id='password' maxlength="50" required />

        <br><input type='submit' name='Submit' value='Entrar' />
    </fieldset>
</form>

<a href="aluno.recuperar.senha.php">Esqueceu a sua senha? </a>
