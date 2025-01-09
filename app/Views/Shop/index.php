<section class='shop'>
	<h1>Loja</h1>
	<div class='all-products'>
		<?php $polo_regata = [] ?>
		<?php $moletom_colete_bolsa = [] ?>
		<?php foreach ($randomProducts as $categoryName => $products): ?>
			<?php $category = $getCategoryByName($categoryName) ?>
			<?php
				if ($category->addr === 'camisa-polo') {
					$polo_regata = array_merge($polo_regata, $products);
					continue;
				} else if ($category->addr === 'bolsa' || $category->addr === 'colete') {
					$moletom_colete_bolsa = array_merge($moletom_colete_bolsa, $products);
					continue;
				}
			?>
			<?php
				if ($category->addr === 'camiseta-regata') {
					$polo_regata = array_merge($polo_regata, $products);

					$category->name = 'Camisa Polo e Regata';
					$category->addr = null;

					$products = $polo_regata;
				} else if ($category->addr === 'moletom') {
					$moletom_colete_bolsa = array_merge($moletom_colete_bolsa, $products);
					
					$category->name = 'Necessaire, Colete e Moletom';
					$category->addr = null;

					$products = $moletom_colete_bolsa;
				}
			?>
			<div class='products-group'>
				<div class='show-category'>
					<h2><?= ucfirst($category->name) ?></h2>
					<?php if ($category->addr): ?>
						<a href='/categoria/<?= $category->addr ?>' class='go-to-category'>Ver mais produtos</a>
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
					<a href='/categoria/<?= $category->addr ?>' class='go-to-category-mobile'>Ver mais produtos</a>
				<?php endif ?>
			</div>
		<?php endforeach ?>
	</div>
</section>
