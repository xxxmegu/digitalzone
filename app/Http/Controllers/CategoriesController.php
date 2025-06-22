<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function getCategories()
    {
        $categories = DB::table('categories')
            ->leftJoin('subcategories', 'categories.id', '=', 'subcategories.category_id')
            // ->select('categories.*', DB::raw('COUNT(subcategories.id) as subcategories_count'))
            // ->groupBy('categories.id')
            ->select('categories.id', 'categories.product_type', DB::raw('COUNT(subcategories.id) as subcategories_count'))
            ->groupBy('categories.id', 'categories.product_type')
            ->get();

        $subcategories = DB::table('subcategories')
            ->join('categories', 'categories.id', '=', 'subcategories.category_id')
            ->select('subcategories.*', 'categories.product_type as parent_name')
            ->get();
            
        return view('admin.categories', [
            'categories' => $categories,
            'subcategories' => $subcategories
        ]);
    }

    public function createCategoryView()
    {
        $categories = DB::table('categories')->get();
        return view('admin.category-create', ['categories' => $categories]);
    }

    public function createCategory(Request $request)
    {
        DB::table('categories')->insert([
            'product_type' => $request->input('title')
        ]);
        return redirect()->route('admin.categories')->with('success', 'Категория успешно создана');
    }

    public function editCategoryView($id)
    {
        $category = DB::table('categories')->where('id', $id)->first();

        if (!is_null($category)) {
            return view('admin.category-edit', [
                'category' => $category
            ]);
        } else {
            return abort(404);
        }
    }

    public function updateCategory(Request $request, $id)
    {
        DB::table('categories')
            ->where('id', $id)
            ->update([
                'product_type' => $request->input('title')
            ]);
        return redirect()->route('admin.categories')->with('success', 'Категория успешно обновлена');
    }

    public function deleteCategory(Request $request)
    {
        $category = DB::table('categories')->where('id', $request->id);
        
        DB::table('subcategories')->where('category_id', $request->id)->delete();
        
        $productsForDelete = DB::table('products')->where('product_type', $request->id);
        foreach ($productsForDelete->select('id')->get() as $value) {
            DB::table('cart')->where('pid', $value->id)->delete();
            DB::table('orders')->where('pid', $value->id)->delete();
        }
        $productsForDelete->delete();
        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'Категория успешно удалена');
    }

    public function createSubcategory(Request $request)
    {
        DB::table('subcategories')->insert([
            'name' => $request->input('title'),
            'category_id' => $request->input('category_id')
        ]);
        return redirect()->route('admin.categories')->with('success', 'Подкатегория успешно создана');
    }

    public function deleteSubcategory(Request $request)
    {
        DB::table('subcategories')->where('id', $request->id)->delete();
        return redirect()->route('admin.categories')->with('success', 'Подкатегория успешно удалена');
    }

    public function editSubcategoryView($id)
    {
        $subcategory = DB::table('subcategories')
            ->where('id', $id)
            ->first();
            
        $categories = DB::table('categories')->get();

        return view('admin.subcategory-edit', [
            'subcategory' => $subcategory,
            'categories' => $categories
        ]);
    }

    public function updateSubcategory(Request $request, $id)
    {
        DB::table('subcategories')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'category_id' => $request->category_id
            ]);

        return redirect('/categories')->with('success', 'Подкатегория успешно обновлена');
    }
}
