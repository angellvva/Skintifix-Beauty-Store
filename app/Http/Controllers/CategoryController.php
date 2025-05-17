<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $categories = ProductCategory::withCount('products')->get();
        return view('admin.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
        ]);

        ProductCategory::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        $category = ProductCategory::findOrFail($id);
        return view('admin.categories-edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
        ]);

        $category = ProductCategory::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories')->with('success', 'Category updated successfully.');
    }

    public function removeCategory(Request $request)
    {
        $categoryId = $request->input('category_id');

        if ($categoryId) {
            ProductCategory::destroy($categoryId);
            return redirect()->back()->with('success', 'Category deleted successfully.');
        }

        return redirect()->back()->with('error', 'Category not found.');
    }
}
