<?php

namespace Framework\Mvc;

use Framework\Http\Response;
use Framework\Mvc\View;

use App\Models\CategoryModel;

class Controller {
    protected array $modelData;
    protected View $view;

    protected function view(string $viewPath, array $modelData = []): void {
        $this->modelData = $modelData;
        extract($modelData);
        require_once __DIR__."/../../app/Views/$viewPath.php";
    }
    protected function viewWithTemplate(View $view, array $modelData = []): void {
		$categories = (new CategoryModel)->selectAll();
    
        extract($modelData);

		$this->view = $view;
        require_once __DIR__."/../../app/Views/_template.php";
    }

    protected function error400(?string $msg = null): void {
        Response::json([], 400);
        $this->view('Error/error400', ['msg' => $msg]);
    }
    public function error404(): void {
        Response::json([], 404);
        $this->viewWithTemplate('Error/error404');
    }
    public function error405(): void {
        Response::json([], 405);
        $this->view('Error/error405');
    }
}
