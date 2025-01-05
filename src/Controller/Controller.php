<?php

namespace App\Controller;

class Controller
{
    public function render(string $view, array $data = []): void
    {
        extract($data);
        include dirname(__DIR__) . "/Views/$view.php";
    }
}
