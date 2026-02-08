<link rel="stylesheet" href="css/tarifaEco.css?v=999">

<h1>Cadastrar Tarifa</h1>

<form action="?page=salvar-tarifa" method="POST">
    <input type="hidden" name="acao" value="cadastrar">

    <div class="mb-3">
        <label>Tipo de Consumo
            <input type="text" name="tipo_consumo" class="form-control"
                placeholder="Água, Luz, Água e Luz">
        </label>
    </div>

    <div class="mb-3">
        <label>Valor Unitario
            <input type="number" name="valor_unitario" class="form-control"
                placeholder="11">
        </label>
    </div>

    <div class="mb-3">
        <label>Data Vigencia
            <input type="date" name="data_vigencia" class="form-control">
        </label>
    </div>

    <button type="submit" class="btn btn-primary">Enviar</button>

</form>