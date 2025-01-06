<?php

namespace Framework\Mvc;

class View {
    private string $path, $title;
    private string|array|null $css, $js;

    public function __construct(string $path, string $title, string|array|null $css = null, string|array|null $js = null) {
        $this->path = $path;
        $this->title = $title;
        $this->css = $css;
        $this->js = $js;
    }

    public function getPath():string {
        return $this->path;
    }
    public function getTitle():string {
        return $this->title;
    }
    public function getCss():string|array|null {
        return $this->css;
    }
    public function getJs():string|array|null {
        return $this->js;
    }
}