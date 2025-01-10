<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://mylabones.com.br/wp-content/uploads/2024/04/cropped-favicon-32x32.png" sizes='32x32'>
    <link rel="stylesheet" href="/css/_template.css">
    <?php if ($view->getCss() !== null): ?>
        <?php if (gettype($view->getCss()) === 'string'): ?>
            <link rel="stylesheet" href="/css/<?= $view->getCss() ?>.css">
        <?php endif ?>
        <?php if (gettype($view->getCss()) === 'array'): ?>
            <?php foreach ($view->getCss() as $css): ?>
                <link rel="stylesheet" href="/css/<?= $css ?>.css">
            <?php endforeach ?>
        <?php endif ?>
    <?php endif ?>
    <?php if ($view->getJs() !== null): ?>
        <?php if (gettype($view->getJs()) === 'string'): ?>
            <script src="/js/<?= $view->getJs() ?>.js" defer></script>
        <?php endif ?>
        <?php if (gettype($view->getJs()) === 'array'): ?>
            <?php foreach ($view->getJs() as $js): ?>
                <script src="/js/<?= $js ?>.js" defer></script>
            <?php endforeach ?>
        <?php endif ?>
    <?php endif ?>
    <title><?= $view->getTitle() ?></title>
</head>
<body>
    <header>
        <a href='/' class='title'>
        	<h1>Ronaldo Ramos</h1>
        	<span>Representante Comercial / Curitiba</span>
        </a>
        <div class='info'>
			<a href='https://wa.me/5541999087542'>
				<span><img src='/images/icons/whatsapp-green.png' alt='Telefone'></span>
				<span>(41) 99908-7542</span>
			</a>
			<a href='mailto:ronaldoramosim@gmail.com'>
				<span><img src='/images/icons/mail-red.png' alt='Email'></span>
				<span>ronaldoramosim@gmail.com</span>
			</a>
        </div>
    </header>
    <main>
    	<div class='main-content'>
        	<?php $this->view($view->getPath(), $modelData) ?>
        </div>
    </main>
    <footer>
    	<div class='owner-info'>
	    	<span class='title'>
		    	<h1 style='color: #04abeb;'>Ronaldo Ramos</h1>
		    	<span>Representante Comercial / Curitiba</span>
	    	</span>
	    	<div class='contact'>
				<a href='https://wa.me/5541999087542'><img src='/images/icons/chat_on_whatsapp.png' alt='WhatsApp' class='whatsapp-icon'></a>
				<a href='mailto:ronaldoramosim@gmail.com' class='send-email'>
					<img src='/images/icons/mail-white.png' alt='E-mail'>
					<span>Enviar E-mail</span>
				</a>
	    	</div>
    	</div>
    	<div class='guide'>
    		<div>
    			<h2>Menu</h2>
    			<ul>
    				<li><a href='/'>Home</a></li>
    				<li><a href='/loja'>Loja</a></li>
    			</ul>
    		</div>
    		<div>
    			<h2>Categorias</h2>
    			<ul>
    				<?php foreach ($categories as $category): ?>
    					<li><a href='/categoria/<?= $category->addr ?>'><?= $category->name ?></a></li>
    				<?php endforeach ?>
    			</ul>
    		</div>    		
    	</div>
    	<div class='myla-info'>
			<img src='/images/myla/logo-myla.png' alt='Myla'>
			<div style='display: flex; flex-direction: column; gap: 10px;'>
				<div>
					<span>CNPJ:</span>
					<span>05.866.853/0001-24</span>
				</div>
				<div style='display: flex; flex-direction: column; gap: 5px;'>
					<span>Rua Jaroslau Maistrovicz, 24</span>
					<span>Apucarana - PR, 86801-600</span>
				</div>
			</div>
    	</div>
    </footer>
</body>
</html>
