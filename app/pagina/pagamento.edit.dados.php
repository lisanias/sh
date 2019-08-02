<form action="aluno.acao.php" id="form_pg" name="form_pg" method="post" enctype="multipart/form-data">
    <fieldset>
        <p><label for="Enviar arquivo"><i class="icon-upload"></i> Editar dados do pagamento:</label></p>
        <div class="contorno-fundo">

            <input type="hidden" id="inp_id_matricula" name="inp_id_matricula" value="<?= $id_matricula ?>">
            <input type="hidden" id="inp_status_matricula" name="inp_status_matricula" value="<?= $matricula_status ?>">

            <div class="pull-left span6" style="padding:0; margin: 0;"><label for="inp_data">Data de Pagamento</label>
                <input class="span12" type="text" id="inp_data" name="inp_data" value="<?= date('d/m/Y'); ?>" required></div>

            <div class="pull-right span5" style="padding:0; margin: 0;" ><label for="inp_valor">Valor</label>
                <input class="span12" type="number" id="inp_valor" name="inp_valor" placeholder="RS" required></div>

            <label for="inp_descricao" class="span12">Descriçao</label>
            <input type="text" id="inp_descricao" name="inp_descricao" >

            <div class="pull-left span5" style="padding:0; margin: 0;">
                <label for="inp_forma_pg">Forma <abbr title="Pagamento">Pg</abbr>.</label>
                <select id="inp_forma_pg" name="inp_forma_pg" class="span11" title="Forma de Pagamento" >
                    <option value="1">Crédito</option>
                    <option value="2">Débito</option>
                    <option value="3" disabled>Espécie</option>
                    <option value="4" selected>Depósito</option>
                    <option value="5">Cheque</option>
                    <option value="6" disabled>Boleto</option>
                    <option value="9" disabled>Outro</option>
                </select>
            </div>

            <div class="pull-right span7" style="padding:0; margin: 0;">
                <label for="inp_ref">Referente a</label>
                <select id="inp_ref" name="inp_ref" class="span12" >
                    <option value="1">Pg. valor total</option>
                    <option value="2" selected>Pg. Inscrição (R$ <?= $inscricao_valor ?>)</option>
                    <option value="3">Pg. de Parcela</option>
                </select>
            </div>

            <label for="inp_obs">Obs. (qualquer informação que seja necessário enviar com este pagamento</label>
            <input type="text" id="inp_obs" name="inp_obs" placeholder="Informações diversas">

            <label for="arquivo">Envie uma cópia do comprovante nos formatos png, jpg ou gif com no máximo 1Mb.</label>
            <input type="file" id="input_arquivo" name="arquivo" required />
            <input type="submit" min="btn_enviar" name="enviar" value="Enviar" class="btn btn-block btn-primary" />
        </div>
    </fieldset>
</form>