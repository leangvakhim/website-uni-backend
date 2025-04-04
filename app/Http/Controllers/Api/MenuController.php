<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Menu;
use App\Http\Requests\MenuRequest;
use Exception;

class MenuController extends Controller
{
    public function index()
    {
        try {
            $menus = Menu::with('children')->where('active', 1)->get();
            return $this->sendResponse($menus->count() === 1 ? $menus->first() : $menus);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch menus', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $menu = Menu::with('children')->find($id);
            if (!$menu) return $this->sendError('Menu not found', 404);
            return $this->sendResponse($menu);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch menu', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(MenuRequest $request)
    {
        try {
            $data = $request->validated();

            if (!isset($data['menu_order'])) {
                $data['menu_order'] = Menu::max('menu_order') + 1;
            }

            $menu = Menu::create($data);
            return $this->sendResponse($menu, 201, 'Menu created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create menu', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(MenuRequest $request, $id)
    {
        try {
            $menu = Menu::find($id);
            if (!$menu) return $this->sendError('Menu not found', 404);

            $menu->update($request->validated());
            return $this->sendResponse($menu, 200, 'Menu updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update menu', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $menu = Menu::find($id);
            if (!$menu) return $this->sendError('Menu not found', 404);

            $menu->active = !$menu->active;
            $menu->save();

            return $this->sendResponse([], 200, 'Menu visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to update visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
