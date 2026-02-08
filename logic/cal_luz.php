<?php
include('../includes/config.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<html lang="pt-br">
<style>
    nav,
    .navbar {
        display: none !important;
    }
</style>

<head>
    <meta charset="utf-8">
    <title>EcoTrak — Cálculo de Luz</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/luzEco.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>

<body class="p-4">

    <a href="index.php" class="btn btn-secondary mb-3">Voltar ao Menu</a>



    <form action="cal_luz.php" method="GET">
        <h1>Quanto Você Gasta de Luz</h1> <br>

        <label for="quantidade">Quantidade de Aparelhos:</label><br>
        <select name="quantidade" id="quantidade" class="form-select" style="width: 100px;">
            <?php
            for ($i = 1; $i <= 15; $i++) {
                print "<option value='$i'>$i</option>";
            }
            ?>
        </select><br><br>

        <label for="pessoas">Informe quantas pessoas residem em sua residência:</label><br>
        <select name="pessoas" id="pessoas" class="form-select" style="width: 100px;">
            <?php
            for ($i = 1; $i <= 15; $i++) {
                print "<option value='$i'>$i</option>";
            }
            ?>
        </select><br><br>

        <label for="salario">Informe seu salário (R$):</label><br>
        <input type="number" step="0.01" name="salario" id="salario" required>
        <br><br>

        <button type="submit" name="gerar">Gerar campos</button>
    </form>

    <?php
    print "<br>";
    print "<br>";
    print "<br>";
    print "<br>";
    print "<hr>";
    print "<br>";

    $quantidade = @$_GET['quantidade'];
    $salario = $_GET['salario'] ?? 0;
    $pessoas = @$_GET['pessoas'];

    if ($quantidade != "" && $quantidade != null) {
        print "<form action='cal_luz.php' method='GET'>";
        print "<input type='hidden' name='quantidade' value='$quantidade'>";
        print "<input type='hidden' name='salario' value='$salario'>";
        print "<input type='hidden' name='pessoas' value='$pessoas'>";
        print "<h2>Selecione os aparelhos e as horas de uso no diario:</h2>";

        for ($i = 1; $i <= $quantidade; $i++) {
            print "<label>Aparelho $i:</label><br>";
            print "<select name='luz[]'>";
            print    "<option value='1'>Ventilador</option>
                  <option value='2'>Geladeira</option>
                  <option value='3'>Chuveiro</option>
                  <option value='4'>TV</option>
                  <option value='5'>Freezer</option>
                  <option value='6'>Computador/Notebook</option>
                  <option value='7'>Micro-ondas</option>
                  <option value='8'>Ferro de passar</option>
                  <option value='9'>Máquina de lavar</option>
                  <option value='10'>Lâmpada LED</option>
                  <option value='11'>Ar-condicionado</option>
                  <option value='12'>Carregador celular</option>
                  <option value='13'>Roteador Wi-Fi</option>
                  <option value='14'>Videogame / console</option>
                  <option value='15'>Forno elétrico</option>";
            print "</select>";


            print " <label>Horas:</label> 
                <input type='number' name='horas[]' min='0' max='24' value='0' style='width: 60px;'>";

            print " <label>Minutos:</label> 
                <input type='number' name='minutos[]' min='0' max='59' value='0' style='width: 60px;'><br><br>";
        }

        print "<button type='submit'>Calcular</button>";
        print "</form>";
    }


    //* Cálculo 

    if (isset($_GET['luz']) && isset($_GET['horas']) && isset($_GET['minutos'])) {

        $aparelhos = $_GET['luz'];
        $horas = $_GET['horas'];
        $minutos = $_GET['minutos'];
        $valor_kwh = 0.90;
        $total = 0;
        $resto_salario = 0;
        $total_horas_consumo = 0;


        for ($i = 0; $i < count($aparelhos); $i++) {
            $luz = $aparelhos[$i];
            $horas_diarias_base = (float)($horas[$i] ?? 0);
            $minutos_diarios = (float)($minutos[$i] ?? 0);

            //* Convertendo tudo para horas
            $horas_de_consumo = $horas_diarias_base + ($minutos_diarios / 60);
            $total_horas_consumo += $horas_de_consumo;

            switch ($luz) {

                //*  Ventilador 120 W 
                case 1:
                    $potencia = 120;
                    break;

                //* Geladeira 350 W 
                case 2:
                    $potencia = 350;
                    $horas_de_consumo = $horas_de_consumo / 2;
                    break;

                //*Chuveiro elétrico 4500 W
                case 3:
                    $potencia = 4500;
                    break;

                //*TV LED 110 W
                case 4:
                    $potencia = 110;
                    break;

                //*Freezer 200 W
                case 5:
                    $potencia = 350;
                    $horas_de_consumo = $horas_de_consumo * 0.25;
                    break;
                //*Computador/Notebook 150 W
                case 6:
                    $potencia = 150;
                    break;

                //*Micro-ondas 1200 W 
                case 7:
                    $potencia = 1200;
                    break;

                //*Ferro de passar 1000 W
                case 8:
                    $potencia = 1000;
                    break;

                //*Máquina de lavar 500 W
                case 9:
                    $potencia = 500;
                    break;

                //*Lâmpada LED 15 W
                case 10:
                    $potencia = 15;
                    break;

                //*Ar-condicionado 1500 W
                case 11:
                    $potencia = 2000;
                    break;

                //*Carregador celular 10 W
                case 12:
                    $potencia = 10;
                    break;

                //*Roteador Wi-Fi 10W
                case 13:
                    $potencia = 10;
                    break;

                //*Videogame / console 200 W
                case 14:
                    $potencia = 200;
                    break;

                //*Forno elétrico 1800 W 
                case 15:
                    $potencia = 1800;
                    break;
                default:
                    $potencia = 0;
            }
            //*Calculo Mensal
            $gasto = ($potencia * $horas_de_consumo / 1000) * $valor_kwh;
            $total += $gasto;
        }

        $total_minutos_consumo = $total_horas_consumo * 60;
        $horas_convertidas = floor($total_minutos_consumo / 60);
        $minutos_restantes = $total_minutos_consumo % 60;

        //* Se quiser multiplicar o consumo por pessoa, ative:
        $modo_por_pessoa = true;

        if ($modo_por_pessoa) {
            $gasto_mensal = ($total * 30) * $pessoas;
        } else {
            $gasto_mensal = ($total * 30);
        }


        //* Calcula a porcentagem
        $percentual = ($salario > 0) ? ($gasto_mensal / $salario) * 100 : 0;
        $resto_salario = $salario - $gasto_mensal;

        //* Define o nível de consumo
        if ($percentual > 15) {
            $nivel = "Alta — Consome mais de 15% do seu salário!<br>";
            $cor = "red";
            $caminho_imagem_original = 'JuliusBravo.jpeg';
            $nova_largura = 230;
            $nova_altura = 200;
        } elseif ($percentual > 10) {
            $nivel = "Média — Fique atento ao uso dos aparelhos consome 10% do seu salário.";
            $cor = "orange";
            $caminho_imagem_original = 'JiuliusNeutro.jpg';
            $nova_largura = 230;
            $nova_altura = 200;
        } else {
            $nivel = "Boa — Seu consumo está controlado! Consome menos de 10% do seu salário.";
            $cor = "green";
            $caminho_imagem_original = 'JuliusFeliz.jpeg';
            $nova_largura = 230;
            $nova_altura = 200;
        }

        print "<hr>";
        print "<h3>Numero de pessoas: $pessoas </h3>";
        print "<h3>Seu salário informado foi de <b>R$ " . number_format($salario, 2, ',', '.') . "</b></h3>";
        print "<h3>Tempo total de uso diário (média): <b>{$horas_convertidas}h {$minutos_restantes}min</b></h3>";
        print "<h3>Gasto diário: <b>R$ " . number_format($total, 2, ',', '.') . "</b></h3>";
        print "<h3>Gasto mensal aproximado: <b>R$ " . number_format($gasto_mensal, 2, ',', '.') . "</b></h3>";
        print "<h3>Percentual do Salário na conta de Luz: <b>" . number_format($percentual, 2, ',', '.') . "%</b></h3>";
        print "<h3>Salario restante após o gasto: <b>R$ " . number_format($resto_salario, 2, ',', '.') . "</b></h3>";
        print "<h3 style='color:$cor;'>$nivel</h3>";

        //*imagem
        print "<img src='$caminho_imagem_original' width='$nova_largura' height='$nova_altura'>";

        //* Site vai reiniciar
        print "<br><form action='cal_luz.php' method='GET'>";
        print "<button type='submit'>Calcular Novamente</button>";
        print "</form>";
    }
    ?>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>