<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Aside extends Component
{
    /**
     * Create a new component instance.
     */

    public $routes;
    public function __construct()
    {
        $this->routes =[[
            'label' => 'Dashboard',
            'icon' => 'fas fa-tv',
            'route_name' =>'dashboard',
            'route_active' => 'dashboard',
            'is_dropdown' => false,
        ],[
            'label' => 'Data User',
            'icon' => 'fas fa-users',
            'route_name' =>'users.index',
            'route_active' => 'users.*',
            'is_dropdown' => false,
        ],[
            'label' => 'Master Data',
            'icon' => 'fas fa-database',
            'route_active' => 'master-data.*',
            'is_dropdown' => true,
            'dropdown' => [
                [
                    'label' => 'kategori',
                    'route_active' => 'master-data.kategori.*',
                    'route_name' => 'master-data.kategori.index',
                ],
                [
                    'label' => 'product',
                    'route_active' => 'master-data.product.*',
                    'route_name' => 'master-data.product.index',
                ],
            ],

        ]
    ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.aside');
    }
};
