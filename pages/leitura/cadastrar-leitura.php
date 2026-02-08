<link rel="stylesheet" href="css/leituraEco.css">

<?php
// CÓDIGO FORNECIDO (Busca de dados)
$sql_clientes = "SELECT id_cliente, nome_cliente FROM cliente ORDER BY nome_cliente";
$res_clientes = $conn->query($sql_clientes);

$sql_tarifas = "SELECT id_tarifa, tipo_consumo FROM tarifa ORDER BY tipo_consumo";
$res_tarifas = $conn->query($sql_tarifas);
?>
<h1>Cadastrar leitura</h1>

<form action="?page=salvar-leitura" method="POST">
    <input type="hidden" name="acao" value="cadastrar">
    
    <div class="mb-3">
        <label>Valor do Medidor
            <input type="number" name="valor_medidor" class="form-control" step="any"
            placeholder="Ex:003520,14">
        </label>
    </div>

    <div class="mb-3">
        <label>Data de Registro
            <input type="date" name="dt_registro" class="form-control">
        </label>
    </div>

    <div class="mb-3">
        <label for="id_cliente">Cliente</label>
        <select name="id_cliente" id="id_cliente" class="form-control" class="form-select" style="width: 200px" required>
            <option value="" disabled selected>Selecione o Cliente</option>
            <?php 
                if ($res_clientes && $res_clientes->num_rows > 0) {
                    // Itera sobre a lista de clientes
                    while ($row_c = $res_clientes->fetch_object()) {
                        print "<option value='{$row_c->id_cliente}'>{$row_c->nome_cliente} (ID: {$row_c->id_cliente})</option>";
                    }
                } else {
                     print "<option disabled>Nenhum cliente cadastrado</option>";
                }
            ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="id_tarifa">Tarifa</label>
        <select name="id_tarifa" id="id_tarifa" class="form-control" class="form-select" style="width: 200px" required>
            <option value="" disabled selected>Selecione a Tarifa</option>
            <?php 
                if ($res_tarifas && $res_tarifas->num_rows > 0) {
                    // Itera sobre a lista de tarifas
                    while ($row_t = $res_tarifas->fetch_object()) {
                        print "<option value='{$row_t->id_tarifa}'>{$row_t->tipo_consumo} (Valor: {$row_t->valor_unitario})</option>";
                    }
                } else {
                    print "<option disabled>Nenhuma tarifa cadastrada</option>";
                }
            ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Enviar</button>
</form>
