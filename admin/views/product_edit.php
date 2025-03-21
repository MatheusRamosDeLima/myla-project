<!DOCTYPE html>
<html lang='pt-br'>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel='stylesheet' href='/css/_template.css'>
	<title>Editando <?= $product->title ?></title>
</head>
<body>
	<header>
		<h1>Admin</h1>
	</header>
	<main>
		<div class='content'>
			<h1>Editar produto</h1>
			<form action='/product_update/<?= $product->id ?>' method='post'>
				<div>
					<div>
						<label for='input-title'>Título</label>
						<input type='text' name='title' id='input-title' value='<?= $product->title ?>'>
					</div>
					<div>
						<label for='input-sku'>SKU</label>
						<input type='text' name='sku' id='input-sku' value='<?= $product->sku ?>'>
					</div>
					<div>
						<label for='select-category'>Categoria</label>
						<select name='category' id='select-category'>
							<option disabled selected>Selecione</option>
							<?php foreach($categories as $category): ?>
								<option value='<?= $category->name ?>'><?= ucfirst($category->name) ?></option>
							<?php endforeach ?>
							<script>
								 const allOptions = document.querySelectorAll('option');
								 
								 let optionPreSelected;
								 
								 allOptions.forEach((option) => {
								 	if (option.value === '<?= $product->category ?>') optionPreSelected = option;
								 });

								 if (optionPreSelected.length !== 0) {
								 	optionPreSelected.selected = true;
								 }
							</script>
						</select>
					</div>
					<div>
						<label for='textarea-description'>Descrição</label>
						<textarea name='description' id='textarea-description'><?= $product->description ?></textarea>
					</div>
					<div>
						<label for='input-image'>Imagem</label>
						<input type='file' name='images[]' multiple accept='image/*' id='input-image'>
					</div>
				</div>
				<button>Editar</button>
			</form>
		</div>
	</main>
</body>
</html>
