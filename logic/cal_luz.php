<style>
    nav, .navbar { display: none !important; }
</style>

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/luzEco.css">

<div class="container p-4">
    <a href="index.php" class="btn btn-secondary mb-3">Voltar ao Menu</a>

    <form action="index.php" method="GET">
        <input type="hidden" name="page" value="cal-luz">
        <h1>Quanto Você Gasta de Luz</h1> <br>

        <label for="quantidade">Quantidade de Aparelhos:</label><br>
        <select name="quantidade" id="quantidade" class="form-select" style="width: 100px;">
            <?php
            for ($i = 1; $i <= 15; $i++) {
                $sel = (isset($_GET['quantidade']) && $_GET['quantidade'] == $i) ? 'selected' : '';
                print "<option value='$i' $sel>$i</option>";
            }
            ?>
        </select><br><br>

        <label for="pessoas">Informe quantas pessoas residem em sua residência:</label><br>
        <select name="pessoas" id="pessoas" class="form-select" style="width: 100px;">
            <?php
            for ($i = 1; $i <= 15; $i++) {
                $sel = (isset($_GET['pessoas']) && $_GET['pessoas'] == $i) ? 'selected' : '';
                print "<option value='$i' $sel>$i</option>";
            }
            ?>
        </select><br><br>

        <label for="salario">Informe seu salário (R$):</label><br>
        <input type="number" step="0.01" name="salario" id="salario" class="form-control" style="width:200px;" value="<?php echo $_GET['salario'] ?? ''; ?>" required>
        <br><br>

        <button type="submit" name="gerar" class="btn btn-primary">Gerar campos</button>
    </form>

    <?php
    $quantidade = $_GET['quantidade'] ?? null;
    $salario = $_GET['salario'] ?? 0;
    $pessoas = $_GET['pessoas'] ?? 1;

    if ($quantidade != "" && $quantidade != null) {
        print "<hr><form action='index.php' method='GET'>";
        print "<input type='hidden' name='page' value='cal-luz'>";
        print "<input type='hidden' name='quantidade' value='$quantidade'>";
        print "<input type='hidden' name='salario' value='$salario'>";
        print "<input type='hidden' name='pessoas' value='$pessoas'>";
        print "<h2>Selecione os aparelhos e o tempo de uso diário:</h2>";

        for ($i = 1; $i <= $quantidade; $i++) {
            print "<div class='mb-3 p-2 border rounded'>";
            print "<label>Aparelho $i:</label><br>";
            print "<select name='luz[]' class='form-select d-inline-block' style='width:auto;'>
                      <option value='1'>Ventilador</option>
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
                      <option value='15'>Forno elétrico</option>
                  </select>";

            print " <label>Horas:</label> 
                    <input type='number' name='horas[]' min='0' max='24' value='0' class='form-control d-inline-block' style='width: 70px;'>";

            print " <label>Minutos:</label> 
                    <input type='number' name='minutos[]' min='0' max='59' value='0' class='form-control d-inline-block' style='width: 70px;'>";
            print "</div>";
        }

        print "<button type='submit' name='calcular' class='btn btn-success'>Calcular</button>";
        print "</form>";
    }

    if (isset($_GET['calcular']) && isset($_GET['luz'])) {
        $aparelhos = $_GET['luz'];
        $horas = $_GET['horas'];
        $minutos = $_GET['minutos'];
        $valor_kwh = 0.90;
        $total_diario = 0;
        $total_horas_consumo = 0;

        for ($i = 0; $i < count($aparelhos); $i++) {
            $luz = $aparelhos[$i];
            $h = (float)$horas[$i];
            $m = (float)$minutos[$i];
            $horas_de_consumo = $h + ($m / 60);
            $total_horas_consumo += $horas_de_consumo;

            switch ($luz) {
                case 1: $potencia = 120; break;
                case 2: $potencia = 350; $horas_de_consumo /= 2; break; // Geladeira cicla
                case 3: $potencia = 4500; break;
                case 4: $potencia = 110; break;
                case 5: $potencia = 350; $horas_de_consumo *= 0.25; break;
                case 6: $potencia = 150; break;
                case 7: $potencia = 1200; break;
                case 8: $potencia = 1000; break;
                case 9: $potencia = 500; break;
                case 10: $potencia = 15; break;
                case 11: $potencia = 2000; break;
                case 12: $potencia = 10; break;
                case 13: $potencia = 10; break;
                case 14: $potencia = 200; break;
                case 15: $potencia = 1800; break;
                default: $potencia = 0;
            }
            $total_diario += ($potencia * $horas_de_consumo / 1000) * $valor_kwh;
        }

        $gasto_mensal = ($total_diario * 30) * $pessoas;
        $percentual = ($salario > 0) ? ($gasto_mensal / $salario) * 100 : 0;
        $resto_salario = $salario - $gasto_mensal;

        if ($percentual > 15) {
            $nivel = "Alta — Cuidado!"; $cor = "red"; $img = "imgs/JuliusBravo.jpeg";
        } elseif ($percentual > 10) {
            $nivel = "Média — Atente-se."; $cor = "orange"; $img = "imgs/JiuliusNeutro.jpg";
        } else {
            $nivel = "Boa — Controlado!"; $cor = "green"; $img = "imgs/JuliusFeliz.jpeg";
        }

        print "<div class='alert alert-secondary mt-4'>";
        print "<h3>Gasto mensal aproximado: <b>R$ " . number_format($gasto_mensal, 2, ',', '.') . "</b></h3>";
        print "<h3>Percentual do Salário: <b>" . number_format($percentual, 2, ',', '.') . "%</b></h3>";
        print "<h3 style='color:$cor;'>$nivel</h3>";
        print "</div>";
        print "<img src='$img' width='230' height='200' class='rounded shadow'>";
        print "<br><br><a href='?page=cal-luz' class='btn btn-warning'>Novo Cálculo</a>";
    }
    ?>
</div>
