<?php

require_once 'AdminController.php';

require_once __DIR__.'/../models/ProductModel.php';
require_once __DIR__.'/../models/ImageModel.php';
require_once  __DIR__.'/../models/CategoryModel.php';

class ProductController {
	private string $viewPath;
	private ProductModel $Product;
	private ImageModel $Image;
	private CategoryModel $Category;

	public function __construct() {
		$this->viewPath = __DIR__.'/../views';
		$this->Product = new ProductModel;
		$this->Image = new ImageModel;
		$this->Category = new CategoryModel;
	}
	
	public function index($id) {
		$product = $this->Product->findByField('id', $id)->fetchObject();
		
		if (!$product) {
			AdminController::error();
			return;
		}
				
		$images = $this->Image->findByField('product_id', $id)->fetchAll();

		if (!$images) {
			AdminController::error();
			return;
		}

		require_once "{$this->viewPath}/product.php";
	}

	public function create() {
		$categories = $this->Category->findAll();

		if (!$categories) {
			AdminController::error('Adicione alguma categoria antes de adicionar um produto');
			return;
		}
		
		require_once "{$this->viewPath}/product_create.php";
	}

	public function store() {
		$log = fopen('logs/product_store.txt', 'w');
	
		if (!$_POST['title'] || !$_POST['sku'] || !$_POST['category'] || !$_POST['description'] || !$_FILES['images']) {
			fwrite($log, "Falta informações\n");
			AdminController::error();
			return;
		}
		
		$title = $_POST['title'];
		$sku = strtoupper($_POST['sku']);
		$category = $_POST['category'];
		$description = $_POST['description'];

		$images = $_FILES['images'];
		$numberOfImages = count($images['name']);

		
		fwrite($log, "title: $title | sku: $sku | category: $category | description: $description\n");
		
		for ($i = 0; $i < $numberOfImages ; $i++) {
			fwrite($log, "image $i: {$images['size'][$i]}\n");
		}
		
		

		if (!$this->Category->findByField('addr', $category)) {
			fwrite($log, "Categoria $category não encontrada\n");
			return;
		}

		if ($this->Product->findByField('sku', $sku)->fetchObject()) {
			fwrite($log, "Produto já existe (sku $sku inválido)\n");
			return;
		}
		

		// if (!$this->Category->findByField('addr', $category) || $this->Product->findByField('sku', $sku)->fetchObject()) {
			// fwrite($log, "Dados inválidos\n");
			// AdminController::error('Dados inválidos. Tente novamente.');
			// return;
		// }

		

		/*
		$images = [
			'name' => [
				0 => 'imagem1.png',
				1 => 'imagem2.jpeg'
			],
			'full_path' => [
				0 => 'imagem1.png',
				1 => 'imagem2.jpeg'
			],
			'type' => [
				0 => 'image/png',
				1 => 'image/jpeg'
			],
			'tmp_name' => [
				0 => '/opt/lampp/temp/phpim1Th8',
				1 => '/opt/lampp/temp/phpLc1Ncv'
			],
			'error' => [
				0 => 0,
				1 => 0
			],
			'size' => [
				0 => 79190,
				1 => 26080
			]
		]
		*/

		// Store images in the public folder

		$target_dir = __DIR__.'/../../public/images/products/';

		fwrite($log, "Target dir: $target_dir\n");

		for ($i = 0; $i < $numberOfImages; $i++) {
			$target_file = $target_dir.basename($images['name'][$i]);

			// Verify if the file is a image
			$check = getimagesize($images['tmp_name'][$i]);
			if (!$check) {
				echo "File is not an image";
				fwrite($log, "Arquivo não é uma imagem\n");
				return;
			}

			// Verify if the image file alredy exists
			if (file_exists($target_file)) {
				echo "Sorry, file alredy exists.";
				fwrite($log, "Arquivo já existe\n");
				return;
			}

			// Verify image size
			// if ($images['size'][$i] > 500000) {
				// echo "Sorry, your file is too large.";
				// fwrite($log, "Arquivo muito grande\n");
				// return;
			// }

			// Verify image file type
			$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
			if ($imageFileType !== "jpg" && $imageFileType !== "png" && $imageFileType !== "jpeg" && $imageFileType !== "gif") {
				echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				fwrite($log, "Extensão da imagem inválida ($imageFileType)\n");
				return;
			}

			fwrite($log, "Validações de imagem: OK\n");

			// try to upload the file
			try {
				if (move_uploaded_file($images['tmp_name'][$i], $target_file)) {
					echo "The file ". htmlspecialchars( basename( $images["name"][$i] ) ). " has been uploaded.";
					fwrite($log, "Imagem criada!\n");
				} else {
					echo "Sorry, there was an error uploading your file.";
					fwrite($log, "Imagem NÃO foi criada!\n");
					return;
				}
			} catch (\Throwable $e) {
				echo $e;
				fwrite($log, "Deu um erro maluco!\n");
			}
		}

		fclose($log);

		// Store product
		try {
			$categoryName = $this->Category->findByField('addr', $category)->name;
			$this->Product->store($title, $sku, $categoryName, $description);
		} catch (\Throwable $e) {
			echo "Store product action failed!";
			echo $e;
		}
		
		// Store images in the database
		try {
			$product = $this->Product->findByField('sku', $sku)->fetchObject();
			$product_id = $product->id;

			for ($i = 0; $i < $numberOfImages; $i++) {
				$this->Image->store($images['name'][$i], $product_id);
			}
			
			header('Location: /');
		} catch (\Throwable $e) {
			echo "Store product action failed!";
			echo $e;
		}
	}

	public function edit($id) {
		$product = $this->Product->findByField('id', $id)->fetchObject();
		$categories = $this->Category->findAll();
		
		if (!$product || !$categories) {
			AdminController::error();
			return;
		}
	
		require_once "{$this->viewPath}/product_edit.php";
	}

	public function update($id) {
		echo "product update";
	}

	public function destroy($id) {
		$productImages = $this->Image->findByField('product_id', $id)->fetchAll();
	
		# Destroy the product images in the database
		if (!$productImages) {
			AdminController::error();
			return;
		}

		$this->Image->destroy('product_id', $id);

		# Destroy the product images in the public folder
		foreach ($productImages as $image) {
			try {
				unlink(__DIR__."/../../public/images/products/{$image->addr}");
			} catch (\Throwable $e) {
				echo $e;
			}	
		}

		# Destroy the product
		if (!$this->Product->findByField('id', $id)->fetchObject()) {
			AdminController::error();
			return;
		}
	
		$this->Product->destroy('id', $id);
		
		header('Location: /');
	}
}
