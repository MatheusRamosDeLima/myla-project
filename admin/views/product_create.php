<!DOCTYPE html>
<html lang='pt-br'>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel='stylesheet' href='/css/_template.css'>
	<title>Adicionar produto</title>
</head>
<body>
	<header>
		<h1>Admin</h1>
	</header>
	<main>
		<div class='content'>
			<h1>Adicionar produto</h1>
			<form action='/product_store' method='post' enctype="multipart/form-data">
				<div>
					<div>
						<label for='input-title'>Título</label>
						<input type='text' name='title' id='input-title'>
					</div>
					<div>
						<label for='input-sku'>SKU</label>
						<input type='text' name='sku' id='input-sku'>
					</div>
					<div>
						<label for='select-category'>Categoria</label>
						<?php if (!$categories): ?>
							<p>Adicione alguma categoria antes de adicionar um produto.</p>
						<?php endif ?>
						<?php if ($categories): ?>
							<select name='category' id='select-category'>
								<option disabled selected>Selecione</option>
								<?php foreach($categories as $category): ?>
									<option value='<?= $category->addr ?>'><?= ucfirst($category->name) ?></option>
								<?php endforeach ?>
							</select>
						<?php endif ?>
					</div>
					<div>
						<label for='textarea-description'>Descrição</label>
						<textarea name='description' id='textarea-description'></textarea>
					</div>
					<div>
						<label for='input-image'>Imagem</label>
						<input type='file' name='images[]' multiple accept='image/*' id='input-image'>
					</div>
				</div>
				<button>Criar</button>
			</form>
		</div>
	</main>
</body>
</html>
