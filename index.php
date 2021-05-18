<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;


require './vendor/autoload.php';
require './inc/configuration.php';

$app = AppFactory::create();
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->get('/', function (Request $request, Response $response, $args) {
	
	require_once("view/_index.php");
	return $response;
});

$app->get('/videos', function (Request $request, Response $response, $args) {
	
	require_once("view/_videos.php");
	return $response;
});

$app->get('/shop', function (Request $request, Response $response, $args) {
	
	require_once("view/shop.php");
	return $response;
});


$app->get('/produtos', function (Request $request, Response $response, $args) {

	$sql = new Sql();

	$data = $sql->select("SELECT * FROM tb_produtos WHERE preco_promorcional > 0 ORDER BY preco_promorcional DESC limit 3") ;

	foreach ($data as &$produto) {
		$preco = $produto['preco'];
		$centavos = explode(".", $preco);
		$produto['preco'] = number_format($preco, 0, ",", ".");
		$produto['centavos'] = end($centavos);
		$produto['parcelas'] = 10;
		$produto['parcela'] = number_format($preco/$produto['parcelas'], 2, ",", ".");
		$produto['total'] = number_format($preco, 2, ",", ".");
	}

	echo json_encode($data);

	return $response;

});

$app->get('/produtos-mais-buscados', function(Request $request, Response $response, $args){

	
	$sql = new Sql();

	$data = $sql->select("
	SELECT 
	tb_produtos.id_prod,
	tb_produtos.nome_prod_curto,
	tb_produtos.nome_prod_longo,
	tb_produtos.codigo_interno,
	tb_produtos.id_cat,
	tb_produtos.preco,
	tb_produtos.peso,
	tb_produtos.largura_centimetro,
	tb_produtos.altura_centimetro,
	tb_produtos.quantidade_estoque,
	tb_produtos.preco_promorcional,
	tb_produtos.foto_principal,
	tb_produtos.visivel,
	cast(avg(review) as dec(10,2)) as media, 
	count(id_prod) as total_reviews
	FROM tb_produtos 
	INNER JOIN tb_reviews USING(id_prod) 
	GROUP BY 
	tb_produtos.id_prod,
	tb_produtos.nome_prod_curto,
	tb_produtos.nome_prod_longo,
	tb_produtos.codigo_interno,
	tb_produtos.id_cat,
	tb_produtos.preco,
	tb_produtos.peso,
	tb_produtos.largura_centimetro,
	tb_produtos.altura_centimetro,
	tb_produtos.quantidade_estoque,
	tb_produtos.preco_promorcional,
	tb_produtos.foto_principal,
	tb_produtos.visivel
	LIMIT 4");

	foreach ($data as &$produto) {
		$preco = $produto['preco'];
		$centavos = explode(".", $preco);
		$produto['preco'] = number_format($preco, 0, ",", ".");
		$produto['centavos'] = end($centavos);
		$produto['parcelas'] = 10;
		$produto['parcela'] = number_format($preco/$produto['parcelas'], 2, ",", ".");
		$produto['total'] = number_format($preco, 2, ",", ".");
	}

	echo json_encode($data);

	return $response;

});

$app->get('/produto-{id_prod}', function($request, $response, array $args){

$sql = new Sql();
$id = $args['id_prod'];

$produtos = $sql->select("SELECT * FROM tb_produtos WHERE id_prod = $id");

$produto = $produtos[0];

$preco = $produto['preco'];
$centavos = explode(".", $preco);
$produto['preco'] = number_format($preco, 0, ",", ".");
$produto['centavos'] = end($centavos);
$produto['parcelas'] = 10;
$produto['parcela'] = number_format($preco/$produto['parcelas'], 2, ",", ".");
$produto['total'] = number_format($preco, 2, ",", ".");

require_once("view/shop-produto.php");

return $response;

});

$app->get('/cart', function($request, $response, array $args){
	require_once("view/cart.php");

	return $response;

});

$app->get('/carrinho-dados', function ($request, $response, array $args) {
	$sql = new Sql();

	$result = $sql->select("CALL sp_carrinhos_get('".session_id()."')");

	$carrinho = $result[0];

	$sql = new Sql();

	$carrinho['produtos'] = $sql->select("CALL sp_carrinhosprodutos_list(".$carrinho['id_car'].")");

	$carrinho['total_car'] = number_format((float)$carrinho['total_car'], 2, ',', '.');
	$carrinho['subtotal_car'] = number_format((float)$carrinho['subtotal_car'], 2, ',', '.');
	$carrinho['frete_car'] = number_format((float)$carrinho['frete_car'], 2, ',', '.');



	echo json_encode($carrinho);

	return $response;
});

$app->get('/carrinhoAdd-{id_prod}', function($request, $response, array $args){
	$id = $args['id_prod'];

	$sql = new Sql();

	$result = $sql->select("CALL sp_carrinhos_get('".session_id()."')");

	$carrinho = $result[0];

	$sql= new Sql();

	$sql->query("CALL sp_carrinhosprodutos_add(".$carrinho['id_car'].",".$id.")");

	header("Location: cart");
	exit;

	return $response;

});

$app->delete("/carrinhoRemoveAll-{id_prod}", function($request, $response, array $args){

	$id = $args['id_prod'];

	$sql = new Sql();

	$result = $sql->select("CALL sp_carrinhos_get('".session_id()."')");

	$carrinho = $result[0];

	$sql = new Sql();

	$sql->query("CALL sp_carrinhosprodutostodos_rem(".$carrinho['id_car'].",".$id.")");

	echo json_encode(array(
		"success"=>true
	));
	return $response;
});

$app->post("/carrinho-produto",function($request, $response, array $args){

	$data = json_decode(file_get_contents("php://input"), true);

	$sql = new Sql();

	$result = $sql->select("CALL sp_carrinhos_get('".session_id()."')");

	$carrinho = $result[0];

	$sql = new Sql();

	$sql->query("CALL sp_carrinhosprodutos_add(".$carrinho['id_car'].",".$data['id_prod'].")");

	echo json_encode(array(
		"success"=>true
	));

	return $response;

});

$app->delete("/carrinho-produto",function($request, $response, array $args){

	$data = json_decode(file_get_contents("php://input"), true);

	$sql = new Sql();

	$result = $sql->select("CALL sp_carrinhos_get('".session_id()."')");

	$carrinho = $result[0];

	$sql = new Sql();

	$sql->query("CALL sp_carrinhosprodutos_rem(".$carrinho['id_car'].",".$data['id_prod'].")");

	echo json_encode(array(
		"success"=>true
	));

	return $response;

});

$app->get("/calcular-frete-{cep}", function($request, $response, array $args){

	$cepid = $args['cep'];

	require_once("inc/php-calcular-frete-correios-master/Frete.php");

	$sql = new Sql();

    $result = $sql->select("CALL sp_carrinhos_get('".session_id()."')");

    $carrinho = $result[0];

    $sql = new Sql();

    $produtos = $sql->select("CALL sp_carrinhosprodutosfrete_list(".$carrinho['id_car'].")");

    $peso = 0; 
    $comprimento = 0;
    $altura = 0;
    $largura = 0;
    $valor = 0;

    foreach ($produtos as $produto) {
        $peso =+ $produto['peso'];
        $comprimento =+ $produto['comprimento'];
        $altura =+ $produto['altura'];
        $largura =+ $produto['largura'];
        $valor =+ $produto['preco'];
    }

    $cep = trim(str_replace('-', '', $cepid));

	if ($altura < 2) $altura = 2;
	if ($comprimento < 16) $comprimento = 16;
	if ($largura < 11) $largura = 11;

	$frete = new Frete(
        $cepDeOrigem = '01418100', 
        $cepDeDestino = $cep, 
        $peso, 
        $comprimento, 
        $altura, 
        $largura, 
        $valor
    );

    $sql = new Sql();

    $sql->query("
        UPDATE tb_carrinhos 
        SET 
            cep_car = '".$cep."', 
            frete_car = ".$frete->getValor().",
            prazo_car = ".$frete->getPrazoEntrega()."
        WHERE id_car = ".$carrinho['id_car']
    );

    echo json_encode(array(
        'success'=>true
    ));
    
	return $response;

});

$app->run();