<link rel="stylesheet" href="css/tarifaEco.css?v=999">

<h1>Listar Tarifa</h1>
<?php
$sql = "SELECT * FROM tarifa";

$res = $conn->query($sql);

$qtd = $res->num_rows;

if ($qtd > 0) {

  print "<p>Encontrou <b>$qtd</b> resultado(s)</p>";
  print "<table class='table table-bordered table-striped table-hover'>";
  print "<tr>";
  print "<th>#</th>";
  print "<th>Tipo de Consumo</th>";
  print "<th>Valor Unitario</th>";
  print "<th>Data Vigencia</th>";
  print "<th>Ações</th>";
  print "</tr>";

  while ($row =  $res->fetch_object()) {
    print "<tr>";
    print "<td>" . $row->id_tarifa . "</td>";
    print "<td>" . $row->tipo_consumo . "</td>";
    print "<td>" . $row->valor_unitario . "</td>";
    print "<td>" . $row->data_vigencia . "</td>";
    print "<td>

              <button class='btn btn-success' onclick=\"location.href= 
            '?page=editar-tarifa&id_tarifa={$row->id_tarifa}'; \">Editar</button>

             <button class='btn btn-danger' onclick=\"if(confirm('Tem certeza que deseja excluir?')) { location.href=
                 '?page=salvar-tarifa&acao=excluir&id_tarifa={$row->id_tarifa}'; }\">
                             Excluir</button>
               </td>";
    print "</tr>";
  }
  print "</table>";
} else {
  print "<p>Não encotrou resultado</p>";
}
?>