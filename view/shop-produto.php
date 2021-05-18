<?php include_once("header.php");?>

<section>
 	<div class="container" id="destaque-produtos-container">

 		<div id="destaque-produtos">

 			 <div class="col-sm-6 col-imagem">	
 				<img src="img/produtos/<?=$produto['foto_principal']?>" class="imagemproduto" alt="<?=$produto['nome_prod_longo']?>">
 			</div>
 			<div class="col-sm-6 col-descricao">
 				<h2><?=$produto['nome_prod_longo']?></h2>
 				<div class="box-valor">
	 				<div class="text-noboleto text-arial-cinza">no boleto</div>
	 				<div class="text-por text-arial-cinza">por</div>
	 				<div class="text-reais text-roxo">R$</div>
	 				<div class="text-valor text-roxo"><?=$produto['preco']?></div>
	 				<div class="text-valor-centavos text-roxo">,<?=$produto['centavos']?></div>
	 				<div class="text-parcelas text-arial-cinza">ou até em <?=$produto['parcelas']?>x de R$ <?=$produto['parcela']?></div>
	 				<div class="text-total text-arial-cinza">total a prazo R$ <?=$produto['total']?></div>
				</div>
 				<a href="carrinhoAdd-<?=$produto['id_prod']?>" class="btn btn-comprar text-roxo"><i class="fa fa-shopping-cart text-roxo"></i> compre agora</a>
 			</div>

 		</div>

 	</div>
		
</section>

<?php include_once("footer2.php");?>
