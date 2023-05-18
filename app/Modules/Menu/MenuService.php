<?php
/**
 * Created by PhpStorm
 * User: Cap
 * Date: 2023/05/18 14:19
 */

namespace App\Modules\Menu;


use App\Models\Menu;
use function PHPUnit\Framework\arrayHasKey;
use function PHPUnit\Framework\isEmpty;

class MenuService
{
    public function menuGroup()
    {
        $menus = Menu::all()->toArray();

        $menuArray = $this->makeMenu($menus, 0);
        return  $this->renderMenu($menuArray);
    }

    private function makeMenu($menus, $pid = 0)
    {
        $myMenus = [];
        foreach ($menus as $menu) {
            if ($menu['pid'] == $pid) {
                $childMenu = $this->makeMenu($menus, $menu['id']);
                if (!empty($childMenu)) {
                    $menu['children'] = $childMenu;
                }
                $myMenus[] = $menu;
            }
        }
        return $myMenus;
    }

    public function renderMenu($menuArray)
    {
        $html = '';
        foreach ($menuArray as $menu) {
            $randomId = rand(0, 10000);
            if (array_key_exists('children', $menu)) {
                $tag = '<li>' . '<a data-bs-toggle="collapse" aria-expanded="false" aria-controls="dropdown-menu" href="#dropdown-menu' . $randomId. '">' . $menu['name'] .'</a>';
                $tag .= ('<ul ' . 'id="dropdown-menu' . $randomId .  '" class="collapse"' . '>' . $this->renderMenu($menu['children']) . '</ul>');
            }
            else {
                $tag = '<li>' . '<a href="' . $menu['path'] . '"' .'">' . $menu['name'] .'</a>';
            }

            $tag.='</li>';
            $html .= $tag;
        }
        return $html;
    }
}
