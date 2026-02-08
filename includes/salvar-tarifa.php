<?php
switch ($_REQUEST['acao']) {
    case 'cadastrar':
        $consumo = $_POST['tipo_consumo'];
        $unitario = $_POST['valor_unitario'];
        $vigencia = $_POST['data_vigencia'];


        $sql = "INSERT INTO tarifa (tipo_consumo, valor_unitario, data_vigencia)
            VALUES('{$consumo}','{$unitario}','{$vigencia}')";

        $res = $conn->query($sql);
        if ($res == true) {
            print "<script>alert('Cadastrou com sucesso!');</script>";
            print "<script>location.href='?page=listar-tarifa';</script>";
        } else {
            print "<script>alert('Não cadastrou');</script>";
            print "<script>location.href='?page=listar-tarifa';</script>";
        }
        break;

    case 'editar':
        $consumo = $_POST['tipo_consumo'];
        $unitario = $_POST['valor_unitario'];
        $vigencia = $_POST['data_vigencia'];

        $sql = "UPDATE tarifa SET tipo_consumo ='{$consumo}', 
        valor_unitario = '{$unitario}', data_vigencia = '{$vigencia}'
        WHERE id_tarifa = " . $_REQUEST['id_tarifa'];

        $res = $conn->query($sql);

        if ($res == true) {
            print "<script>alert('Editado com sucesso!'); </script>";
            print "<script>
            location.href= '?page=listar-tarifa'; </script>";
        } else {
            print "<script>alert('Não foi Editado'); </script>";
            print "<script>
            location.href= '?page=listar-tarifa'; </script>";
        }
        break;

    case 'excluir':

        $sql = "DELETE FROM tarifa WHERE id_tarifa=" . $_REQUEST['id_tarifa'];

        $res = $conn->query($sql);

        if ($res == true) {
            print "<script>alert('Excluido com sucesso!'); </script>";
            print "<script>
            location.href= '?page=listar-tarifa'; </script>";
        } else {
            print "<script>alert('Não foi Excluido'); </script>";
            print "<script>
            location.href= '?page=listar-tarifa'; </script>";
        }
        break;
}
