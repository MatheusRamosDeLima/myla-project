<section class='shop'>
	<h1><?= ucfirst($category->name) ?></h1>
	<div class='products'>
		<?php if (!$products): ?>
			<p>Nenhum produto disponível</p>
		<?php endif ?>
		<?php if ($products): ?>	
			<?php foreach ($products as $product): ?>
				<a href='/produto/<?= $product->id ?>' class='product'>
				
					<div class='div-product-image'>
						<?php
						$images = $getImagesByProduct($product);
						$image = $images[0];
						?>
						<img src='/images/products/<?= $image->addr ?>'>
					</div>
					<div class='div-product-title'>
						<h2><?= $product->title ?></h2>
					</div>
				</a>
			<?php endforeach ?>
		<?php endif ?>
	</div>
</section>
