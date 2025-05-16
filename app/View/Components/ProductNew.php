<?php

namespace App\View\Components;

use App\Models\Product;
use Illuminate\View\Component;

class ProductNew extends Component
{
    public $latestProducts;

    public function __construct()
    {
        $this->latestProducts = Product::where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->take(4)
            ->get();
    }

    public function render()
    {
        return view('components.product-new', ['products' => $this->latestProducts]);
    }
}
