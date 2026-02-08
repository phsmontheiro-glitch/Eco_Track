<link rel="stylesheet" href="css/tarifaEco.css?v=999">

<h1>Editar Tarifa</h1>
<?php

$sql = "SELECT * FROM tarifa WHERE id_tarifa=" . $_REQUEST['id_tarifa'];

$res = $conn->query($sql);

$row = $res->fetch_object();
?>
<form action="?page=salvar-tarifa" method="POST">
    <input type="hidden" name="acao" value="editar">
    <input type="hidden" name="id_tarifa" value="<?php print $row->id_tarifa ?>">
    <div class="mb-3">

        <label>Tipo de Consumo
            <input type="text" name="tipo_consumo" class="form-control"
                placeholder="Água, Luz, Água e Luz" value="<?php print $row->tipo_consumo; ?>">
        </label>
    </div>

    <div class="mb-3">
        <label>Valor Unitario
            <input type="number" name="valor_unitario" class="form-control"
                placeholder="11" value="<?php print $row->valor_unitario; ?>">
        </label>
    </div>

    <div class="mb-3">
        <label>Data Vigencia
            <input type="date" name="data_vigencia" class="form-control"
                value="<?php print $row->data_vigencia; ?>">
        </label>
    </div>

    <div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </div>
</form>