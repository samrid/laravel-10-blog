<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class AppLayout extends Component
{
    public function __construct(public ?string $metaTitle = null, public ?string $metaDescription = null)
    {

    }

    public function render(): View|Closure|string
    {
        $categories = Category::query()
            ->join('category_post', 'categories.id', '=', 'category_post.category_id')
            ->select('categories.title', 'categories.slug', DB::raw('count(*) as total'))
            ->groupBy(['categories.title', 'categories.slug'])
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('layouts.app', compact('categories'));
    }
}
