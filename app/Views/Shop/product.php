<h1><?= $product->title ?></h1>
<section class='main-product'>
	<div class='images'>
		<div class='main-image'>
			<img src='/images/products/<?= $images[0]->addr ?>' alt='Imagem principal de <?= $product->title ?>'>
		</div>
		<div class='switch-image'>
			<?php $i = 0 ?>
			<?php foreach ($images as $image): ?>
				<div class='image-div' >
					<?php if ($i === 0): ?>
						<img src='/images/products/<?= $image->addr ?>' alt='Imagem de <?= $product->title ?>' onclick='switchImage("<?= $image->addr ?>")' class='selected'>						
					<?php endif ?>
					<?php if ($i !== 0): ?>
						<img src='/images/products/<?= $image->addr ?>' alt='Imagem de <?= $product->title ?>' onclick='switchImage("<?= $image->addr ?>")'>
					<?php endif ?>
					<?php $i++ ?>
				</div>
			<?php endforeach ?>
		</div>
	</div>
	<div class='product-info'>
		<div class='details'>
			<h1><?= $product->title ?></h1>
			<p><span class='field'>SKU:</span> <?= $product->sku ?></p>
			<p><span class='field'>Categoria:</span> <a href='/categoria/<?= $category->addr ?>'><?= ucfirst($category->name) ?></a></p>
			<div class='desc'>
				<p><?= $product->description ?></p>
			</div>
		</div>
		<div class='request-quote'>
			<button onclick='openAdvice()'>Solicitar orçamento</button>
			<div id='advice' class='advice'>
				<div class='close-advice' onclick='closeAdvice()'>X</div>
				<div class='info'>
					<h2>Selecione uma forma de <span>contato</span></h2>
					<div class='contact-options'>
						<a href='https://wa.me/5541999087542'>
							<img src='/images/icons/whatsapp-blue-outlined.png' width='75px'>
						</a>
						<a href='mailto:ronaldoramosim@gmail.com'>
							<img src='/images/icons/mail-blue.png' width='75px'>
						</a>
					</div>
				</div>
			</div>
			<div id='blur-background' class='blur-background' onclick='closeAdvice()'></div>
		</div>
	</div>
</section>
<?php if ($randomProducts): ?>
	<div class='separator'></div>
	<section class='relationed-products'>
		<h2>Produtos relacionados</h2>
		<div style='overflow-x: scroll; padding: 30px;'>
			<div class='products'>
				<?php foreach ($randomProducts as $randomProduct): ?>
					<?php $randomImages = $getImagesByProduct($randomProduct) ?>
					<a href='/produto/<?= $randomProduct->id ?>' class='product'>
						<div class='div-product-image'>
							<?php $randomImage = $randomImages[0] ?>
							<img src='/images/products/<?= $randomImage->addr ?>' width='150px'>
						</div>
						<div class='div-product-title'>
							<h3><?= $randomProduct->title ?></h3>
						</div>
					</a>
				<?php endforeach ?>
			</div>
		</div>
	</section>
<?php endif ?>
