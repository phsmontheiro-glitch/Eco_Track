<link rel="stylesheet" href="css/leituraEco.css">

<h1>Listar-Leitura</h1>

<?php
$sql = "
    SELECT 
        l.id_leitura, 
        l.valor_medidor, 
        l.dt_registro, 
        l.id_cliente, 
        l.id_tarifa,
        c.nome_cliente,   /* Coluna 'nome_cliente' da tabela 'cliente' */
        t.tipo_consumo    /* Coluna 'tipo_consumo' da tabela 'tarifa' */
    FROM 
        leitura l
    JOIN 
        cliente c ON l.id_cliente = c.id_cliente
    JOIN 
        tarifa t ON l.id_tarifa = t.id_tarifa
    ORDER BY l.id_leitura DESC
";

$res = $conn->query($sql);

if ($res === false) {

  print "<p class='alert alert-danger'>Erro ao executar a consulta: </p>";
    exit();
}

$qtd = $res->num_rows;

if ($qtd > 0) {

    print "<p>Encontrou <b>$qtd</b> resultado(s)</p>";
    print "<table class='table table-bordered table-striped table-hover'>";
    print "<tr>";
    print "<th>#</th>";
    print "<th>Valor Medidor</th>";
    print "<th>Data de Registro</th>";
    print "<th>Cliente</th>"; 
    print "<th>Tarifa</th>"; 
    print "<th>Ações</th>";
    print "</tr>";

    while ($row = $res->fetch_object()) {
        print "<tr>";
        print "<td>" . $row->id_leitura . "</td>";
        print "<td>" . $row->valor_medidor . "</td>";
        print "<td>" . date('d/m/Y', strtotime($row->dt_registro)) . "</td>"; // Formato brasileiro
        print "<td>" . $row->nome_cliente . "</td>";
        print "<td>" . $row->tipo_consumo . "</td>";
        print "<td>

              <button class='btn btn-success' onclick=\"location.href= 
                '?page=editar-leitura&id_leitura={$row->id_leitura}'; \">Editar</button>

              <button class='btn btn-danger' onclick=\"if(confirm('Tem certeza que deseja excluir?')) { location.href=
                '?page=salvar-leitura&acao=excluir&id_leitura={$row->id_leitura}'; }\">
                Excluir</button>
            </td>";
        print "</tr>";
    }
    print "</table>";
} else {
    print "Não encontrou resultado";
}
?>
