<?php

namespace App\controllers;

class HomeController extends AbstractController
{
    public function index(): void
    {
        $this->view();
    }
}
