<style>
    nav, .navbar {
        display: none !important;
    }
    .img-julius {
        margin-top: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
</style>

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/aguaEco.css">

<div class="container p-4">

    <a href="index.php" class="btn btn-secondary mb-3"> Voltar ao Menu</a>

    <form action="index.php" method="GET">
        <input type="hidden" name="page" value="cal-agua">
        
        <h1>Quanto Você Gasta de Água</h1><br>

        <label for="quantidade">Quantidade de Itens de Uso:</label><br>
        <select name="quantidade" id="quantidade" class="form-select" style="width: 100px;">
            <?php
            for ($i = 1; $i <= 15; $i++) {
                $sel = (isset($_GET['quantidade']) && $_GET['quantidade'] == $i) ? 'selected' : '';
                print "<option value='$i' $sel>$i</option>";
            }
            ?>
        </select><br><br>

        <label for="pessoas">Quantas pessoas moram na residência:</label><br>
        <select name="pessoas" id="pessoas" class="form-select" style="width: 100px;">
            <?php
            for ($i = 1; $i <= 15; $i++) {
                $sel = (isset($_GET['pessoas']) && $_GET['pessoas'] == $i) ? 'selected' : '';
                print "<option value='$i' $sel>$i</option>";
            }
            ?>
        </select><br><br>

        <label for="salario">Informe seu salário (R$):</label><br>
        <input type="number" step="0.01" name="salario" id="salario" class="form-control" style="width: 200px;" value="<?php echo $_GET['salario'] ?? ''; ?>" required><br><br>

        <button type="submit" class="btn btn-primary" name="gerar">Gerar Campos</button>
    </form>

    <?php
    $quantidade = $_GET['quantidade'] ?? null;
    $salario = $_GET['salario'] ?? 0;
    $pessoas = $_GET['pessoas'] ?? 1;

    if ($quantidade != "" && $quantidade != null) {
        print "<hr><form action='index.php' method='GET'>";
        print "<input type='hidden' name='page' value='cal-agua'>"; // Garante permanência na página
        print "<input type='hidden' name='quantidade' value='$quantidade'>";
        print "<input type='hidden' name='salario' value='$salario'>";
        print "<input type='hidden' name='pessoas' value='$pessoas'>";
        print "<h2>Selecione os itens e o tempo de uso diário:</h2>";

        for ($i = 1; $i <= $quantidade; $i++) {
            print "<div style='margin-bottom: 10px;' class='border p-2'>";
            print "<label>Item $i:</label><br>";
            print "<select name='agua[]' class='form-select d-inline-block' style='width:auto;'>
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
                <input type='number' name='horas[]' min='0' max='24' value='0' class='form-control d-inline-block' style='width:70px;'>";

            print " <label>Minutos:</label> 
                <input type='number' name='tempo[]' min='0' max='300' value='0' class='form-control d-inline-block' style='width:80px;'>";
            print "</div>";
        }
        print "<button type='submit' name='calcular' class='btn btn-success'>Calcular Agora</button>";
        print "</form>";
    }

    //* CÁLCULOS (Aparece após o Calcular)
    if (isset($_GET['calcular']) && isset($_GET['agua'])) {

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
                case 1: $litros_por_minuto = 15; break;
                case 2: $litros_por_minuto = 12; break;
                case 3: $litros_por_minuto = 10; break;
                case 4: $litros_por_minuto = 12; break;
                case 5: $litros_por_minuto = 2.5; break;
                case 6: $litros_por_minuto = 0.6; break;
                case 7: $litros_por_minuto = 18; break;
                case 8: $litros_por_minuto = 10; break;
                case 9: $litros_por_minuto = 16; break;
                case 10: $litros_por_minuto = 18; break;
                case 11: $litros_por_minuto = 20; break;
                case 12: $litros_por_minuto = 8; break;
                case 13: $litros_por_minuto = 16; break;
                case 14: $litros_por_minuto = 12; break;
                case 15: $litros_por_minuto = 12; break;
                default: $litros_por_minuto = 0;
            }

            $litros_dia = $litros_por_minuto * $minutos;
            $total_m3_dia += ($litros_dia / 1000);
        }

        $consumo_dia = $total_m3_dia;
        $consumo_mes = $consumo_dia * 30;

        //* Tarifas CAESB Simplificadas
        $valor_total = 0;
        if ($consumo_mes <= 10) {
            $valor_total = $consumo_mes * 4.13;
        } else {
            $valor_total = (10 * 4.13) + (($consumo_mes - 10) * 4.96);
        }

        $valor_agua = $valor_total;
        $valor_total = $valor_agua * 2;
        $horas_convertidas = floor($total_minutos / 60);
        $minutos_restantes = $total_minutos % 60;
        $percentual = ($salario > 0) ? ($valor_total / $salario) * 100 : 0;
        $resto_salario = $salario - $valor_total;

        if ($percentual > 15) {
            $nivel = "Alta — Consome mais de 15% do salário!";
            $cor = "red";
            $imagem = "imgs/JuliusBravo.jpeg"; 
        } elseif ($percentual > 10) {
            $nivel = "Média — Fique atento!";
            $cor = "orange";
            $imagem = "imgs/JiuliusNeutro.jpg";
        } else {
            $nivel = "Boa — Consumo controlado!";
            $cor = "green";
            $imagem = "imgs/JuliusFeliz.jpeg";
        }

        print "<div class='alert alert-info mt-4'>";
        print "<h3>Número de pessoas: $pessoas </h3>";
        print "<h3> Salário: <b>R$" . number_format($salario, 2, ',', '.') . "</b></h3>";
        print "<h3> Percentual na conta: <b>" . number_format($percentual, 2, ',', '.') . "%</b></h3>";
        print "<h3> Consumo mensal: <b>" . number_format($consumo_mes, 2, ',', '.') . " m³</b></h3>";
        print "<h3> Valor Total (Água + Esgoto): <b>R$ " . number_format($valor_total, 2, ',', '.') . "</b></h3>";
        print "<h3 style='color:$cor;'>$nivel</h3>";
        print "</div>";

        print "<img src='$imagem' width='230' class='img-julius' alt='Julius'>";
        
        print "<br><br><a href='?page=cal-agua' class='btn btn-warning'>Calcular Novamente</a>";
    }
    ?>
</div>

<script src="js/bootstrap.bundle.js"></script>
