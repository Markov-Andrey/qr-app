<?php

// app/Http/Controllers/MenuController.php

namespace App\Http\Controllers;

use App\Services\MenuService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected MenuService $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    /**
     * Возвращает элементы меню.
     *
     * @return JsonResponse
     */
    public function getMenuItems(): JsonResponse
    {
        $menuItems = $this->menuService->getMenuItems();
        return response()->json($menuItems);
    }
}

