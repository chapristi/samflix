<?php

namespace App\Services\Basket;

interface BasketInterface
{
    public function add($id);

    public function get();

    public function remove();

    public function delete($id);

    public function decrease($id);

}