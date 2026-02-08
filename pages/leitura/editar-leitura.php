<link rel="stylesheet" href="css/leituraEco.css">

<h1>Editar-Leitura</h1>
<?php
// CÓDIGO FORNECIDO (Busca de dados)
$sql_clientes = "SELECT id_cliente, nome_cliente FROM cliente ORDER BY nome_cliente";
$res_clientes = $conn->query($sql_clientes);

$sql_tarifas = "SELECT id_tarifa, tipo_consumo FROM tarifa ORDER BY tipo_consumo";
$res_tarifas = $conn->query($sql_tarifas);
?>
<?php

$sql = "SELECT * FROM leitura WHERE id_leitura=" . $_REQUEST['id_leitura'];

$res = $conn->query($sql);

$row = $res->fetch_object();
?>
<form action="?page=salvar-leitura" method="POST">
    <input type="hidden" name="acao" value="editar">
    <input type="hidden" name="id_leitura" value="<?php print $row->id_leitura ?>">
    <div class="mb-3">

        <label>Valor Medidor
            <input type="number" name="valor_medidor" class="form-control"
                value="<?php print $row->valor_medidor; ?>">
        </label>
    </div>

    <div class="mb-3">
        <label>Data de Registro
            <input type="date" name="dt_registro" class="form-control"
                value="<?php print $row->dt_registro; ?>">
        </label>
    </div>

    <div class="mb-3">
        <label for="id_cliente">Cliente</label>
        <select name="id_cliente" id="id_cliente" class="form-select" style="width: 500px" required>>
            <option value="">Selecione um Cliente</option>
            <?php
            $res_clientes->data_seek(0);
            while ($cliente = $res_clientes->fetch_object()) {
                $selected = ($cliente->id_cliente == $row->id_cliente) ? 'selected' : '';
                print "<option value='{$cliente->id_cliente}' {$selected}>{$cliente->nome_cliente}</option>";
            }
            ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="id_tarifa">Tarifa</label>
        <select name="id_tarifa" id="id_tarifa" class="form-select" style="width: 500px" required>>
            <option value="">Selecione uma Tarifa</option>
            <?php
            //* Garantindo que a busca de tarifas volte ao início para o loop
            $res_tarifas->data_seek(0);
            while ($tarifa = $res_tarifas->fetch_object()) {
                //* Verifica se o ID da tarifa atual é o mesmo da leitura ($row->id_tarifa)
                $selected = ($tarifa->id_tarifa == $row->id_tarifa) ? 'selected' : '';
                print "<option value='{$tarifa->id_tarifa}' {$selected}>{$tarifa->tipo_consumo}</option>";
            }
            ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
    </div>
</form>
