<?php
switch ($_REQUEST['acao']) {
    case 'cadastrar':
        $medidor = $_POST['valor_medidor'];
        $registro = $_POST['dt_registro'];
        $cliente = $_POST['id_cliente'];
        $tarifa = $_POST['id_tarifa'];


        $sql = "INSERT INTO leitura (valor_medidor, dt_registro, id_cliente, id_tarifa)
            VALUES('{$medidor}','{$registro}','{$cliente}',
            '{$tarifa}')";

        $res = $conn->query($sql);
        if ($res == true) {
            print "<script>alert('Cadastrou com sucesso!');</script>";
            print "<script>location.href='?page=listar-leitura';</script>";
        } else {
            print "<script>alert('Não cadastrou');</script>";
            print "<script>location.href='?page=listar-leitura';</script>";
        }
        break;

    case 'editar':
        $medidor = $_POST['valor_medidor'];
        $registro = $_POST['dt_registro'];
        $cliente = $_POST['id_cliente'];
        $tarifa = $_POST['id_tarifa'];

        $sql = "UPDATE leitura SET valor_medidor ='{$medidor}', 
        dt_registro = '{$registro}', id_cliente = '{$cliente}',
        id_tarifa = '{$tarifa}'
        WHERE id_leitura = " . $_REQUEST['id_leitura'];

        $res = $conn->query($sql);

        if ($res == true) {
            print "<script>alert('Editado com sucesso!'); </script>";
            print "<script>
            location.href= '?page=listar-leitura'; </script>";
        } else {
            print "<script>alert('Não foi Editado'); </script>";
            print "<script>
            location.href= '?page=listar-leitura'; </script>";
        }
        break;

    case 'excluir':

        $sql = "DELETE FROM leitura WHERE id_leitura=" . $_REQUEST['id_leitura'];

        $res = $conn->query($sql);

        if ($res == true) {
            print "<script>alert('Excluido com sucesso!'); </script>";
            print "<script>
            location.href= '?page=listar-leitura'; </script>";
        } else {
            print "<script>alert('Não foi Excluido'); </script>";
            print "<script>
            location.href= '?page=listar-leitura'; </script>";
        }
        break;
}
