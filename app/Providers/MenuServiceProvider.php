<?php

// app/Providers/MenuServiceProvider.php
namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\MenuItem; // Make sure to import your model

class MenuServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) { // Use '*' to share with all views
            $menuItems = MenuItem::where('parent_id', null)
                                 ->orderBy('order')
                                 ->get();
            $view->with('menuItems', $menuItems);
        });
    }
}

