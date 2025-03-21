<!DOCTYPE html>
<html lang='pt-br'>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel='stylesheet' href='/css/_template.css'>
	<link rel='stylesheet' href='/css/product.css'>
</head>
<body>
	<header>
		<h1>Admin</h1>
	</header>
	<main>
		<div class='content'>
			<div class='images'>
				<!-- <div class='current-image'>
					<img src='' alt='Imagem atual'>
				</div>
				<div class='other-images'>
					<img src='' alt='img1'>
					<img src='' alt='img2'>
				</div> -->

				<?php foreach ($images as $image): ?>
					<img src='http://localhost:8080/images/products/<?= $image->addr ?>' alt='Imagem' width='300px'>
				<?php endforeach ?>
			</div>
			<div class='info'>
				<h1><?= $product->title ?></h1>
				<p><span>SKU:</span><?= $product->sku ?></p>
				<p><span>Categoria:</span><?= $product->category ?></p>
				<p><?= $product->description ?></p>
			</div>
		</div>
	</main>
</body>
</html>
