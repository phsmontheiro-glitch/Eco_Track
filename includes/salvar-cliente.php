
<?php
switch ($_REQUEST['acao']) {
    case 'cadastrar':
        $nome = $_POST['nome_cliente'];
        $email = $_POST['email_cliente'];
        $cpf = $_POST['cpf_cliente'];
        $endereco = $_POST['endereco_cliente'];
        $dt_nasce = $_POST['dt_nasc_cliente'];
        $telefone = $_POST['telefone_cliente'];

        $sql = "INSERT INTO cliente (nome_cliente, email_cliente, cpf_cliente, endereco_cliente,
        dt_nasc_cliente, telefone_cliente)
            VALUES('{$nome}','{$email}','{$cpf}',
            '{$endereco}','{$dt_nasce}','{$telefone}')";

        $res = $conn->query($sql);
        if ($res == true) {
            print "<script>alert('Cadastrou com sucesso!');</script>";
            print "<script>location.href='?page=listar-cliente';</script>";
        } else {
            print "<script>alert('Não cadastrou');</script>";
            print "<script>location.href='?page=listar-cliente';</script>";
        }
        break;

    case 'editar':
        $nome = $_POST['nome_cliente'];
        $email = $_POST['email_cliente'];
        $cpf = $_POST['cpf_cliente'];
        $endereco = $_POST['endereco_cliente'];
        $dt_nasce = $_POST['dt_nasc_cliente'];
        $telefone = $_POST['telefone_cliente'];

        $sql = "UPDATE cliente SET nome_cliente ='{$nome}', 
        email_cliente = '{$email}', cpf_cliente = '{$cpf}',
        endereco_cliente = '{$endereco}', dt_nasc_cliente = '{$dt_nasce}',
        telefone_cliente = '{$telefone}'
        WHERE id_cliente = " . $_REQUEST['id_cliente'];

        $res = $conn->query($sql);

        if ($res == true) {
            print "<script>alert('Editado com sucesso!'); </script>";
            print "<script>
            location.href= '?page=listar-cliente'; </script>";
        } else {
            print "<script>alert('Não foi Editado'); </script>";
            print "<script>
            location.href= '?page=listar-cliente'; </script>";
        }
        break;

    case 'excluir':

        $sql = "DELETE FROM cliente WHERE id_cliente=" . $_REQUEST['id_cliente'];

        $res = $conn->query($sql);

        if ($res == true) {
            print "<script>alert('Excluido com sucesso!'); </script>";
            print "<script>
            location.href= '?page=listar-cliente'; </script>";
        } else {
            print "<script>alert('Não foi Excluido'); </script>";
            print "<script>
            location.href= '?page=listar-cliente'; </script>";
        }
        break;
}
