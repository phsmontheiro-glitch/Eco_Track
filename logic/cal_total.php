<?php
include('../includes/config.php')
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
    <title>Quanto Você Gasta de Água + Luz</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/aguaLuzEco.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>

<body class="p-4">

    <a href="index.php" class="btn btn-secondary mb-3">Voltar ao Menu</a>


    <form action="cal_total.php" method="GET">
        <h1>EcoTrak — Consumo de Água + Luz</h1><br>

        <div class="mb-3">
            <label for="item" class="form-label">Quantidade de Aparelhos (Água e Luz):</label>
            <select name="item" id="item" class="form-select" style="width: 100px;">
                <?php
                for ($i = 1; $i <= 15; $i++) {
                    print "<option value='$i'>$i</option>";
                }
                ?>
            </select>
        </div>

        <label for="pessoas">Quantas pessoas moram na residência:</label><br>
        <select name="pessoas" id="pessoas" class="form-select" style="width: 100px;">
            <?php
            for ($i = 1; $i <= 15; $i++)
                print "<option value='$i'>$i</option>"; ?>
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
    $pessoas = @$_GET['pessoas'];
    $salario = $_GET['salario'] ?? null;
    $item    = @$_GET['item'];
    if ($pessoas && $salario) {
        print "<hr><h2>Selecione os Itens de Água</h2>";
        print "<form action='cal_total.php' method='GET'>";
        print "<input type='hidden' name='pessoas' value='$pessoas'>";
        print "<input type='hidden' name='salario' value='$salario'>";

        //*Itens de Água
        for ($i = 1; $i <= $item; $i++) {
            print "<label>Item $i:</label> 
               <select name='agua[]'>
                    <option value='1'>Chuveiro</option>
                    <option value='2'>Descarga</option>
                    <option value='3'>Torneira</option>
                    <option value='4'>Brincadeiras com água</option>
                    <option value='5'>Máquina de Lavar Roupa</option>
                    <option value='6'>Máquina de Lavar Louça</option>
                    <option value='7'>Mangueira</option>
                    <option value='8'>Torneira aberta</option>
                    <option value='9'>Caixa d'água vazando</option>
                    <option value='10'>Banho demorado</option>
                    <option value='11'>Limpeza de casa</option>
                    <option value='12'>Cozinhar alimentos</option>
                    <option value='13'>Lavagem de carro</option>
                    <option value='14'>Tanque (manual)</option>
                    <option value='15'>Regar plantas</option>
               </select>
               <label>Horas:</label>
               <input type='number' name='horas_agua[]' step='0.01' min='0' max='24' value='0' style='width:60px;'>
               <label>Minutos:</label>
               <input type='number' name='minutos_agua[]' min='0' max='59' value='0' style='width:70px;'><br><br>";
        }

        //*Itens de Luz
        print "<hr><h2>Selecione os Aparelhos de Luz</h2>";
        for ($i = 1; $i <= $item; $i++) {
            print "<label>Aparelho $i:</label> 
               <select name='luz[]'>
                    <option value='1'>Ventilador</option>
                    <option value='2'>Geladeira</option>
                    <option value='3'>Chuveiro elétrico</option>
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
                    <option value='15'>Forno elétrico</option>
               </select>
               <label>Horas:</label>
               <input type='number' name='horas_luz[]' min='0' max='24' value='0' style='width:60px;'>
               <label>Minutos:</label>
               <input type='number' name='minutos_luz[]' min='0' max='59' value='0' style='width:70px;'><br><br>";
        }

        print "<button type='submit'>Calcular Total</button>";
        print "</form>";
    }

    //*CÁLCULO FINAL 
    if (
        isset($_GET['agua']) && isset($_GET['luz']) &&
        isset($_GET['horas_agua']) && isset($_GET['minutos_agua']) &&
        isset($_GET['horas_luz']) && isset($_GET['minutos_luz'])
    ) {
        $pessoas = $_GET['pessoas'] ?? 1;
        $salario = $_GET['salario'] ?? 0;

        $itensAgua = $_GET['agua'] ?? [];
        $horasAgua = $_GET['horas_agua'] ?? [];
        $minutosAgua = $_GET['minutos_agua'] ?? [];

        $itensLuz = $_GET['luz'] ?? [];
        $horasLuz = $_GET['horas_luz'] ?? [];
        $minutosLuz = $_GET['minutos_luz'] ?? [];

        //*CÁLCULO ÁGUA
        $totalLitrosDia = 0;
        foreach ($itensAgua as $i => $item_agua) {
            $horas = isset($horasAgua[$i]) ? (float)$horasAgua[$i] : 0;
            $minutos = isset($minutosAgua[$i]) ? (float)$minutosAgua[$i] : 0;

            switch ($item_agua) {
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

            $minutosTotais = ($horas * 60) + $minutos;
            $totalLitrosDia += $litros_por_minuto * $minutosTotais;
        }

        $m3Dia = $totalLitrosDia / 1000;
        $m3Mes = $m3Dia * 30;

        $valorAgua = $m3Mes * 4.13;
        $valorEsgoto = $valorAgua;
        $totalAgua = $valorAgua + $valorEsgoto;

        //*CÁLCULO LUZ
        $valor_kwh = 0.90;
        $totalLuz = 0;

        foreach ($itensLuz as $i => $item_luz) {
            $horas = isset($horasLuz[$i]) ? (float)$horasLuz[$i] : 0;
            $minutos = isset($minutosLuz[$i]) ? (float)$minutosLuz[$i] : 0;

            switch ($item_luz) {
                case 1:
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

            $horasTotais = $horas + ($minutos / 60);
            $gasto = ($potencia * $horasTotais / 1000) * $valor_kwh;
            $totalLuz += $gasto * 30;
        }

        //*RESULTADO FINAL
        $totalGeral = $totalAgua + $totalLuz;
        $percentual = ($salario > 0) ? ($totalGeral / $salario) * 100 : 0;
        $resto = $salario - $totalGeral;

        if ($percentual > 15) {
            $nivel = "Alta — Consome mais de 15% do salário!";
            $cor = "red";
            $imagem = "JuliusBravo.jpeg";
        } elseif ($percentual > 10) {
            $nivel = "Média — Consome cerca de 10% do salário.";
            $cor = "orange";
            $imagem = "JiuliusNeutro.jpg";
        } else {
            $nivel = "Boa — Consome menos de 10% do salário.";
            $cor = "green";
            $imagem = "JuliusFeliz.jpeg";
        }

        print "<hr>";
        print "<h2>Resultado Final</h2>";
        print "<h3>Água: R$ " . number_format($totalAgua, 2, ',', '.') . "</h3>";
        print "<h3>Luz: R$ " . number_format($totalLuz, 2, ',', '.') . "</h3>";
        print "<h3><b>Total: R$ " . number_format($totalGeral, 2, ',', '.') . "</b></h3>";
        print "<h3>Percentual do Salário: <b>" . number_format($percentual, 2, ',', '.') . "%</b></h3>";
        print "<h3>Salário restante: <b>R$ " . number_format($resto, 2, ',', '.') . "</b></h3>";
        print "<h3 style='color:$cor;'>$nivel</h3>";

        //*imagem
        if (isset($imagem)) {
            print "<img src='$imagem' width='230' height='200'>";
        }

        print "<br><form action='cal_total.php' method='GET'>
           <button type='submit'>Novo Cálculo</button></form>";
    }
    ?>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>