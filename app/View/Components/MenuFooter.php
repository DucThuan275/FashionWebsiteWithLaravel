<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Menu;

class MenuFooter extends Component
{
    public $menus;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        // Retrieve only parent menus with parent_id = 0
        $this->menus = Menu::where([
            ['status', '=', 1],
            ['position', '=', 'footermenu'],
            ['parent_id', '=', 0],
        ])
            ->orderBy('sort_order', 'DESC')
            // Optional: eager load relationships, for example if menus have submenus
            // ->with('submenus')
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.menu-footer', ['menus' => $this->menus]);
    }
}
