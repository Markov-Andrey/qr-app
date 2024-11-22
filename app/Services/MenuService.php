<?php

namespace App\Services;

class MenuService
{
    /**
     * Возвращает список элементов меню.
     *
     * @return array
     */
    public function getMenuItems(): array
    {
        return [
            ['label' => 'Шаблон 1', 'to' => '/'],
            ['label' => 'Шаблон 2', 'to' => '/about'],
            ['label' => 'Шаблон 3', 'to' => '/contact'],
        ];
    }
}
