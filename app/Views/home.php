<section class='myla'>
	<div class='main'>
		<div class='logo'>
			<img src='/images/myla/logo-myla.png' alt='Myla logo'>
		</div>
		<button class='btn-toggle-info' id='btn-toggle-info'>
			<img src='/images/icons/arrow_down-lightgray.png' alt='Mostrar informações'>
		</button>
	</div>
	<div class='info' id='info'>
		<div>
			<span>CNPJ:</span>
			<span>05.866.853/0001-24</span>
		</div>
		<div>
			<span>Endereço:</span>
			<span>Rua Jaroslau Maistrovicz, 24</span>
		</div>
	</div>
</section>
<section class='shop'>
	<div class='all-products'>
		<?php $polo_regata = [] ?>
		<?php foreach ($randomProducts as $categoryName => $products): ?>
			<?php $category = $getCategoryByName($categoryName) ?>
			<?php
				if ($category->addr === 'camisa-polo') {
					$polo_regata = array_merge($polo_regata, $products);
					continue;
				}
			?>
			<?php
				if ($category->addr === 'camiseta-regata') {
					$polo_regata = array_merge($polo_regata, $products);

					$category->name = 'Camisa Polo e Regata';
					$category->addr = null;

					$products = $polo_regata;
				}
			?>
			<div class='products-group'>
				<div class='show-category'>
					<h2><?= ucfirst($category->name) ?></h2>
					<?php if ($category->addr): ?>
						<a href='/categoria/<?= $category->addr ?>' class='go-to-category'>Mais de <?= ucfirst($category->name) ?></a>
					<?php endif ?>
				</div>
				<div style='overflow-x: scroll'>
					<div class='products'>
						<?php foreach ($products as $product): ?>
							<?php $image = $getImageByProduct($product) ?>
							<a href='/produto/<?= $product->id ?>' class='product'>
								<div class='div-product-image'>
									<img src='/images/products/<?= $image->addr ?>'>
								</div>
								<div class='div-product-title'>
									<h3><?= $product->title ?></h3>
								</div>
							</a>
						<?php endforeach ?>
					</div>
				</div>
				<?php if ($category->addr): ?>
					<a href='/categoria/<?= $category->addr ?>' class='go-to-category-mobile'>Mais de <?= ucfirst($category->name) ?></a>
				<?php endif ?>
			</div>
		<?php endforeach ?>
	</div>
	<a href='/loja' class='go-to-shop'>Ver mais produtos</a>
</section>
