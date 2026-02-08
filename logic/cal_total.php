<style>
    nav, .navbar { display: none !important; }
    .item-box { background: #f8f9fa; border-radius: 8px; padding: 15px; margin-bottom: 10px; border-left: 5px solid #007bff; }
    .resultado-card { border: 2px solid #ddd; border-radius: 15px; background: #fff; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
</style>

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/aguaLuzEco.css">

<div class="container p-4">
    <a href="index.php" class="btn btn-secondary mb-3">Voltar ao Menu</a>

    <form action="index.php" method="GET">
        <input type="hidden" name="page" value="cal-total">
        <h1 class="text-primary">EcoTrak — Consumo Global</h1>

        <div class="row mt-4">
            <div class="col-md-4">
                <label class="form-label"><b>Itens por categoria:</b></label>
                <select name="item" class="form-select">
                    <?php 
                    for ($i = 1; $i <= 15; $i++) {
                        $sel = (isset($_GET['item']) && $_GET['item'] == $i) ? 'selected' : '';
                        echo "<option value='$i' $sel>$i</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label"><b>Pessoas na casa:</b></label>
                <select name="pessoas" class="form-select">
                    <?php 
                    for ($i = 1; $i <= 15; $i++) {
                        $sel = (isset($_GET['pessoas']) && $_GET['pessoas'] == $i) ? 'selected' : '';
                        echo "<option value='$i' $sel>$i</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label"><b>Seu Salário (R$):</b></label>
                <input type="number" step="0.01" name="salario" class="form-control" value="<?php echo $_GET['salario'] ?? ''; ?>" required>
            </div>
        </div>
        <button type="submit" name="gerar" class="btn btn-primary w-100 mt-3">Gerar Campos de Preenchimento</button>
    </form>

    <?php
    // SÓ MOSTRA OS CAMPOS SE O USUÁRIO CLICAR EM "GERAR" OU JÁ TIVER CLICADO
    if (isset($_GET['gerar']) || isset($_GET['calcular_total'])) {
        $item = $_GET['item'] ?? 1;
        $pessoas = $_GET['pessoas'] ?? 1;
        $salario = $_GET['salario'] ?? 0;

        print "<hr><form action='index.php' method='GET'>";
        print "<input type='hidden' name='page' value='cal-total'>";
        print "<input type='hidden' name='pessoas' value='$pessoas'>";
        print "<input type='hidden' name='salario' value='$salario'>";
        print "<input type='hidden' name='item' value='$item'>";

        echo "<div class='row'>";
        
        // COLUNA ÁGUA (15 ITENS)
        echo "<div class='col-md-6'><h3 class='text-info'>Itens de Água</h3>";
        for ($i = 0; $i < $item; $i++) {
            echo "<div class='item-box'>
                <label>Item ".($i+1).":</label>
                <select name='agua[]' class='form-select mb-2'>
                    <option value='1'>Chuveiro</option><option value='2'>Descarga</option>
                    <option value='3'>Torneira Cozinha</option><option value='4'>Brincadeiras</option>
                    <option value='5'>Máquina Roupa</option><option value='6'>Máquina Louça</option>
                    <option value='7'>Mangueira</option><option value='8'>Escovar dentes</option>
                    <option value='9'>Vazamento</option><option value='10'>Banho demorado</option>
                    <option value='11'>Limpeza</option><option value='12'>Cozinhar</option>
                    <option value='13'>Lavar Carro</option><option value='14'>Tanque</option>
                    <option value='15'>Plantas</option>
                </select>
                <div class='row g-2'>
                    <div class='col'><input type='number' name='h_agua[]' placeholder='H' class='form-control' value='0' min='0'></div>
                    <div class='col'><input type='number' name='m_agua[]' placeholder='Min' class='form-control' value='0' min='0'></div>
                </div>
            </div>";
        }
        echo "</div>";

        // COLUNA LUZ (15 ITENS)
        echo "<div class='col-md-6'><h3 class='text-warning'>Itens de Luz</h3>";
        for ($i = 0; $i < $item; $i++) {
            echo "<div class='item-box' style='border-left-color: #ffc107;'>
                <label>Aparelho ".($i+1).":</label>
                <select name='luz[]' class='form-select mb-2'>
                    <option value='1'>Ventilador</option><option value='2'>Geladeira</option>
                    <option value='3'>Chuveiro Elétrico</option><option value='4'>TV</option>
                    <option value='5'>Freezer</option><option value='6'>Computador</option>
                    <option value='7'>Micro-ondas</option><option value='8'>Ferro</option>
                    <option value='9'>Máquina Lavar</option><option value='10'>Lâmpada LED</option>
                    <option value='11'>Ar-condicionado</option><option value='12'>Carregador</option>
                    <option value='13'>Wi-Fi</option><option value='14'>Videogame</option>
                    <option value='15'>Forno Elétrico</option>
                </select>
                <div class='row g-2'>
                    <div class='col'><input type='number' name='h_luz[]' placeholder='H' class='form-control' value='0' min='0'></div>
                    <div class='col'><input type='number' name='m_luz[]' placeholder='Min' class='form-control' value='0' min='0'></div>
                </div>
            </div>";
        }
        echo "</div></div>";

        print "<button type='submit' name='calcular_total' class='btn btn-success btn-lg w-100 mt-4 shadow-sm'>CALCULAR IMPACTO NO SALÁRIO</button>";
        print "</form>";
    }

    if (isset($_GET['calcular_total']) && isset($_GET['agua']) && isset($_GET['luz'])) {
        $salario = (float)$_GET['salario'];
        $pessoas = (int)$_GET['pessoas'];
        
        //* Cálculos Água
        $total_litros_dia = 0;
        $taxas_agua = [1=>15, 2=>12, 3=>10, 4=>12, 5=>2.5, 6=>0.6, 7=>18, 8=>10, 9=>16, 10=>18, 11=>20, 12=>8, 13=>16, 14=>12, 15=>12];
        
        foreach($_GET['agua'] as $index => $tipo) {
            $h = (int)($_GET['h_agua'][$index] ?? 0);
            $m = (int)($_GET['m_agua'][$index] ?? 0);
            $total_litros_dia += ($taxas_agua[$tipo] ?? 0) * (($h * 60) + $m);
        }
        $custo_agua_mes = (($total_litros_dia / 1000) * 30 * 4.13) * 2; // Dobro por conta do esgoto

        //* Cálculos Luz
        $total_luz_mes = 0;
        $potencias = [1=>120, 2=>350, 3=>4500, 4=>110, 5=>350, 6=>150, 7=>1200, 8=>1000, 9=>500, 10=>15, 11=>2000, 12=>10, 13=>10, 14=>200, 15=>1800];
        
        foreach($_GET['luz'] as $index => $tipo) {
            $h = (int)($_GET['h_luz'][$index] ?? 0);
            $m = (int)($_GET['m_luz'][$index] ?? 0);
            $horas_decimais = $h + ($m / 60);
            
            $p = $potencias[$tipo] ?? 0;
            if($tipo == 2 || $tipo == 5) $horas_decimais /= 2; // Ciclo de refrigeração
            
            $total_luz_mes += ($p * $horas_decimais / 1000) * 0.90 * 30;
        }
        $custo_luz_mes_total = $total_luz_mes * $pessoas;

        $total_geral = $custo_agua_mes + $custo_luz_mes_total;
        $percentual = ($salario > 0) ? ($total_geral / $salario) * 100 : 0;

        //* Definindo Julius
        if($percentual > 15) {
            $cor = "red"; $nivel = "ALTA — Você está gastando demais!"; $img = "imgs/JuliusBravo.jpeg";
        } elseif($percentual > 10) {
            $cor = "orange"; $nivel = "MÉDIA — Cuidado com o desperdício."; $img = "imgs/JiuliusNeutro.jpg";
        } else {
            $cor = "green"; $nivel = "BOA — Economia aprovada pelo Julius!"; $img = "imgs/JuliusFeliz.jpeg";
        }

        echo "<div class='resultado-card mt-5 text-center'>
                <h2 class='mb-4'>Resultado do EcoTrak</h2>
                <div class='row'>
                    <div class='col-md-6 border-end'>
                        <h5>Custo Mensal Água/Esgoto</h5>
                        <h4 class='text-info'>R$ ".number_format($custo_agua_mes, 2, ',', '.')."</h4>
                    </div>
                    <div class='col-md-6'>
                        <h5>Custo Mensal Energia</h5>
                        <h4 class='text-warning'>R$ ".number_format($custo_luz_mes_total, 2, ',', '.')."</h4>
                    </div>
                </div>
                <hr>
                <h1 style='color:$cor'>TOTAL: R$ ".number_format($total_geral, 2, ',', '.')."</h1>
                <p class='lead'>Isso representa <b>".number_format($percentual, 2, ',', '.')."%</b> do seu salário.</p>
                <h3 style='color:$cor' class='mt-3'>$nivel</h3>
                <img src='$img' width='230' height='200' class='mt-3 rounded shadow'>
                <br><br>
                <a href='index.php?page=cal-total' class='btn btn-outline-secondary'>Novo Cálculo</a>
              </div>";
    }
    ?>
</div>
