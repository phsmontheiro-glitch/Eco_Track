<?php
include('config.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<style>
    nav,
    .navbar {
        display: none !important;
    }
</style>

<head>
    <meta charset="utf-8">
    <title>EcoTrak — Cálculo de Água</title>

    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/aguaEco.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

</head>

<body class="p-4">

    <a href="index.php" class="btn btn-secondary mb-3"> Voltar ao Menu</a>


    <form action="cal_agua.php" method="GET">
        <h1>Quanto Você Gasta de Água</h1><br>

        <label for="quantidade">Quantidade de Itens de Uso:</label><br>
        <select name="quantidade" id="quantidade" class="form-select" style="width: 100px;">
            <?php
            for ($i = 1; $i <= 15; $i++) {
                print "<option value='$i'>$i</option>";
            }
            ?>
        </select><br><br>

        <label for="pessoas">Quantas pessoas moram na residência:</label><br>
        <select name="pessoas" id="pessoas" class="form-select" style="width: 100px;">
            <?php
            for ($i = 1; $i <= 15; $i++) {
                print "<option value='$i'>$i</option>";
            }
            ?>
        </select><br><br>

        <label for="salario">Informe seu salário (R$):</label><br>
        <input type="number" step="0.01" name="salario" id="salario" required><br><br>

        <button type="submit" name="gerar">Gerar Campos</button>
    </form>

    <?php
    print "<br>";
    print "<br>";
    print "<br>";
    print "<br>";
    print "<br>";
    $quantidade = @$_GET['quantidade'];
    $salario = $_GET['salario'] ?? 0;
    $pessoas = @$_GET['pessoas'];

    if ($quantidade != "" && $quantidade != null) {
        print "<hr><form action='cal_agua.php' method='GET'>";
        print "<input type='hidden' name='quantidade' value='$quantidade'>";
        print "<input type='hidden' name='salario' value='$salario'>";
        print "<input type='hidden' name='pessoas' value='$pessoas'>";
        print "<h2>Selecione os itens e o tempo de uso diário:</h2>";

        for ($i = 1; $i <= $quantidade; $i++) {
            print "<div style='margin-bottom: 10px;'>";
            print "<label>Item $i:</label><br>";
            print "<select name='agua[]'>
                <option value='1'>Chuveiro</option>
                <option value='2'>Descarga</option>
                <option value='3'>Torneira</option>
                <option value='4'>Brincadeiras com água (crianças, pets)</option>
                <option value='5'>Máquina de Lavar Roupa</option>
                <option value='6'>Máquina de Lavar Louça</option>
                <option value='7'>Mangueira</option>
                <option value='8'>Torneira aberta</option>
                <option value='9'>Caixa d'água vazando</option>
                <option value='10'>Banho </option>
                <option value='11'>Limpeza de casa</option>
                <option value='12'>Cozinhar alimentos</option>
                <option value='13'>Lavagem de carro</option>
                <option value='14'>Tanque (manual)</option>
                <option value='15'>Regar plantas</option>
              </select>";

            print " <label>Horas:</label> 
               <input type='number' name='horas[]' min='0' max='24' value='0' style='width:60px;'>";

            print " <label>Minutos:</label> 
               <input type='number' name='tempo[]' min='0' max='300' value='0' style='width:70px;'>";
            print "</div>";
        }
        print "<button type='submit'>Calcular</button>";
        print "</form>";
    }

    //*CÁLCULOS
    if (isset($_GET['agua']) && isset($_GET['tempo']) && isset($_GET['horas'])) {

        $itens  = $_GET['agua'];
        $tempos = $_GET['tempo'];
        $horas  = $_GET['horas'];

        $total_m3_dia   = 0;
        $total_minutos  = 0;

        for ($i = 0; $i < count($itens); $i++) {

            $item    = $itens[$i];
            $minutos = ($tempos[$i]) + ($horas[$i] * 60);
            $total_minutos += $minutos;

            switch ($item) {

                //*Chuveiro 15L
                case 1:
                    $litros_por_minuto = 15;
                    break;

                //*Descarga 12L
                case 2:
                    $litros_por_minuto = 12;
                    break;

                //*Torneira cozinha 10L
                case 3:
                    $litros_por_minuto = 10;
                    break;

                //*Brincadeiras com água 12L
                case 4:
                    $litros_por_minuto = 12;
                    break;

                //*Máquina roupa 2.5L
                case 5:
                    $litros_por_minuto = 2.5;
                    break;

                //*Máquina louça  
                case 6:
                    $litros_por_minuto = 0.6;
                    break;

                //*Mangueira 18L
                case 7:
                    $litros_por_minuto = 18;
                    break;

                //*Escovar dentes 10L
                case 8:
                    $litros_por_minuto = 10;
                    break;

                //*Caixa d’água vazando 16L
                case 9:
                    $litros_por_minuto = 16;
                    break;

                //*Banho demorado 18L
                case 10:
                    $litros_por_minuto = 18;
                    break;

                //*Limpeza 20L
                case 11:
                    $litros_por_minuto = 20;
                    break;

                //*Cozinhar 8L
                case 12:
                    $litros_por_minuto = 8;
                    break;

                //*Lavagem de carro 16L
                case 13:
                    $litros_por_minuto = 16;
                    break;

                //*Tanque (manual) 12L
                case 14:
                    $litros_por_minuto = 12;
                    break;

                //*Regar plantas 12L
                case 15:
                    $litros_por_minuto = 12;
                    break;

                default:
                    $litros_por_minuto = 0;
            }

            $litros_dia = $litros_por_minuto * $minutos;

            $m3_dia = $litros_dia / 1000;
            $total_m3_dia += $m3_dia;
        }

        //*Consumo diário e mensal 
        $consumo_dia = $total_m3_dia;
        $consumo_mes = $consumo_dia * 30;

        //*Tarifas CAESB (Brasília)
        $valor_total = 0;
        $restante = $consumo_mes;

        if ($restante > 10) {
            $valor_total += 10 * 4.13;
            $restante = 10;

            if ($restante > 5) {
                $valor_total += 5 * 4.96;
                $restante -= 5;
                $valor_total += $restante * 11.18;
            } else {
                $valor_total += $restante * 4.96;
            }
        } else {
            $valor_total = $restante * 4.13;
        }

        //*Converter tempo total para horas:minutos
        $horas_convertidas   = floor($total_minutos / 60);
        $minutos_restantes   = $total_minutos % 60;

        //*Taxa esgoto
        $valor_agua = $valor_total;
        $valor_esgoto = $valor_agua;
        $valor_total += $valor_esgoto;

        //*Percentual do salário
        $percentual    = ($salario > 0) ? ($valor_total / $salario) * 100 : 0;
        $resto_salario = $salario - $valor_total;

        //*Classificação do consumo
        if ($percentual > 15) {
            $nivel  = "Alta — Consome mais de 15% do salário!";
            $cor    = "red";
            $imagem = "JuliusBravo.jpeg";
        } elseif ($percentual > 10) {
            $nivel  = "Média — Fique atento, consome cerca de 10% do seu salário.";
            $cor    = "orange";
            $imagem = "JiuliusNeutro.jpg";
        } else {
            $nivel  = "Boa — Seu consumo está controlado! Consome menos de 10% do seu salário.";
            $cor    = "green";
            $imagem = "JuliusFeliz.jpeg";
        }

        print "<hr>";
        print "<h3>Numero de pessoas: $pessoas </h3>";
        print "<h3> Seu salário informado foi de <b>R$" . number_format($salario, 2, ',', '.') . "</b></h3>";
        print "<h3>Percentual do Salário na conta de Água: <b>" . number_format($percentual, 2, ',', '.') . "%</b></h3>";
        print "<h3> Tempo total de uso diário: <b>{$horas_convertidas}h {$minutos_restantes}min</b></h3>";
        print "<h3> Consumo diário: <b>" . number_format($consumo_dia, 2, ',', '.') . " m³</b></h3>";
        print "<h3> Consumo mensal: <b>" . number_format($consumo_mes, 2, ',', '.') . " m³</b></h3>";
        print "<h3>Valor total da conta de Água (com esgoto): <b>R$ " . number_format($valor_total, 2, ',', '.') . "</b></h3>";
        print "<h3>Salario restante após o gasto: <b>R$ " . number_format($resto_salario, 2, ',', '.') . "</b></h3>";
        print "<h3 style='color:$cor;'>$nivel</h3>";

        //*imagem
        print "<img src='$imagem' width='230' height='200' alt='Julius'>";

        //* Site vai reiniciar
        print "<br><form action='cal_agua.php' method='GET'>";
        print "<button type='submit'>Calcular Novamente</button>";
        print "</form>";
    }
    ?>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html