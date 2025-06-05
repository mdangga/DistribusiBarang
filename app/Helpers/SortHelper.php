<?php

namespace App\Helpers;

class SortHelper
{
    public static function sortUrl($column)
    {
        $sort_by = request('sort_by');
        $sort_order = request('sort_order');

        $order = ($sort_by === $column && $sort_order === 'asc') ? 'desc' : 'asc';
        return request()->fullUrlWithQuery(['sort_by' => $column, 'sort_order' => $order]);
    }

    public static function sortArrow($column)
    {
        $sort_by = request('sort_by');
        $sort_order = request('sort_order');

        if ($sort_by === $column) {
            return $sort_order === 'asc' ? '↑' : '↓';
        }

        return '';
    }
}