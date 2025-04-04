<?php

namespace App\Services;

use App\Models\Page;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class PageService
{

    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['p_menu']) && is_array($data['p_menu'])) {
                $menu = Menu::create($data['p_menu']);
                $data['p_menu'] = $menu->menu_id;
            }

            return Page::create($data);
        });
    }

    public function update(Page $page, array $data)
    {
        return DB::transaction(function () use ($page, &$data) {
            if (!empty($data['p_menu']) && is_array($data['p_menu'])) {
                $menu = Menu::create($data['p_menu']);
                $data['p_menu'] = $menu->menu_id;
            }

            $page->update($data);
            return $page;
        });
    }
}
