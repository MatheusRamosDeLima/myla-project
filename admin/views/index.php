<!DOCTYPE html>
<html lang='pt-br'>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel='stylesheet' href='/css/_template.css'>
	<link rel='stylesheet' href='/css/index.css'>
	<script src='/js/index.js' defer></script>
	<title>Admin</title>
</head>
<body>
	<header>
		<h1>Admin</h1>
	</header>
	<main>
		<div class='content'>
			<div class='actions'>
				<a href='/product_create' class='create-product'>Adicionar produto</a>
			</div>
			<div class='categories'>
				<h2>Categorias</h2>
				<form action='/category_store' method='post'>
					<input type='text' name='category_name' placeholder='Nome da categoria'>
					<button>Adicionar categoria</button>
				</form>
				<?php if (!$categories): ?>
					<p>Nenhuma categoria ainda</p>
				<?php endif ?>
				<?php if ($categories): ?>
					<input type='button' value='Mostrar categorias' id='btn-show-categories'>
					<ul class='categories-list' id='categories-list'>
						<?php foreach ($categories as $category): ?>
							<li>
								<span><?= ucfirst($category->name) ?></span>
								<?php if ($numberOfProductsByCategory["{$category->name}"] === 0): ?>
									<form action='/category_destroy/<?= $category->id ?>' method='post' onsubmit='return confirmDeleteCategoryAction()'>
										<button>Excluir</button>
									</form>
								<?php endif ?>
							</li>
						<?php endforeach ?>
					</ul>
				<?php endif ?>
			</div>
			<div class='products'>
				<h1>Produtos</h1>
				<?php if (!$products): ?>
					<p>Nenhum produto ainda</p>
				<?php endif ?>
				<?php if ($products): ?>
					<div class='div-table'>
						<table>
							<thead>
								<tr>
									<th>ID</th>
									<th>Título</th>
									<th>SKU</th>
									<th>Categoria</th>
									<th>Descrição</th>
									<!-- <th>Imagem</th> -->
									<th>Ações</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($products as $product): ?>
									<tr>
										<td><?= $product->id ?></td>
										<td><?= $product->title ?></td>
										<td><?= $product->sku ?></td>
										<td><?= $product->category ?></td>
										<td><?= $product->description ?></td>
										<td>
											<a href='/product/<?= $product->id ?>'>Link</a>
											<a href='/product_edit/<?= $product->id ?>'>Editar</a>
											<form action='/product_destroy/<?= $product->id ?>' method='post'>
												<button>Excluir</button>
											</form>
										</td>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
				<?php endif ?>
			</div>
		</div>
	</main>
</body>
</html>
