<?php

if (!function_exists('sortUrl')) {
    function sortUrl($column)
    {
        $sort_by = request('sort_by');
        $sort_order = request('sort_order');

        $order = ($sort_by === $column && $sort_order === 'asc') ? 'desc' : 'asc';
        return request()->fullUrlWithQuery(['sort_by' => $column, 'sort_order' => $order]);
    }
}

if (!function_exists('sortArrow')) {
    function sortArrow($column)
    {
        $sort_by = request('sort_by');
        $sort_order = request('sort_order');

        if ($sort_by === $column) {
            return $sort_order === 'asc' ? '↑' : '↓';
        }

        return '';
    }
}