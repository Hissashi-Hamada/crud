<?php
include __DIR__ . '/../backend/config.php';
include __DIR__ . '/../backend/verificacao.php';
include __DIR__ . '/../layout/cabecalho.php';
?>
    <section aria-label="Painel de opções principais" class="py-4">
        <div class="" id="centro-menu">
            <div class="card p-3 h-100 botao text-center" onclick="produtos()">
                <div class="caixa_de_sites">
                    <h3>Produtos</h3>
                </div>
            </div>

            <div class="card p-3 h-100 botao text-center" onclick="clientes()">
                <div class="caixa_de_sites">
                    <h3>Clientes</h3>
                </div>
            </div>
        </div>
    </section>
<?php
include __DIR__ . '/../layout/rodape.php';
?>
