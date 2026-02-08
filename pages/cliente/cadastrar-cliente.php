<link rel="stylesheet" href="css/clientesEco.css?v=999">
<h1>Cadastrar Cliente</h1>

<form action="?page=salvar-cliente" method="POST">
    <input type="hidden" name="acao" value="cadastrar">

    <div class="mb-3">
        <label>Nome
            <input type="text" name="nome_cliente" class="form-control"
                placeholder="Seu Nome">
        </label>
    </div>

    <div class="mb-3">
        <label>E-mail
            <input type="email" name="email_cliente" class="form-control"
                placeholder="cliente@gmail.com">
        </label>
    </div>

    <div class="mb-3">
        <label>CPF
            <input type="text" name="cpf_cliente" class="form-control"
                placeholder="Não use (. ou -)">
        </label>
    </div>

    <div class="mb-3">
        <label>Endereço
            <input type="text" name="endereco_cliente" class="form-control"
                placeholder="Rua Amaral, 30, Edifício...">
        </label>
    </div>

    <div class="mb-3">
        <label>Data de Nascimento
            <input type="date" name="dt_nasc_cliente" class="form-control">
        </label>
    </div>

    <div class="mb-3">
        <label>Telefone
            <input type="tel" name="telefone_cliente" class="form-control"
                pattern="\d{10,11}" placeholder="(xx) xxxxx-xxxx">
        </label>
    </div>

    <button type="submit" class="btn btn-primary">Enviar</button>
<br>
<br>
<br>
</form>
