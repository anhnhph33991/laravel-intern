<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Alert;
use App\Helper\Toastr;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    private const PATH_VIEW = 'admin.categories.';
    public function index()
    {

        $categories = Category::query()
            ->latest()->paginate(10);

        if ($categories->currentPage() > $categories->lastPage()) {
            return redirect()->route('admin.categories.index', parameters: ['page' => $categories->lastPage()]);
        }

        return view(self::PATH_VIEW . __FUNCTION__, compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {

        $data = $request->except(['status', 'is_active']);
        $data['status'] = $request->boolean('status', false);
        $data['is_active'] = $request->boolean('is_active', false);
        $data['slug'] = Str::slug($request->name, '-') . '-' .  time();

        Category::create($data);

        Toastr::success(null, 'Thao tác thành công');
        return redirect()->route('admin.categories.index');

        // dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->except(['status', 'is_active']);
        $data['status'] = $request->boolean('status', false);
        $data['is_active'] = $request->boolean('is_active', false);
        $data['slug'] = Str::slug($request->name, '-') . '-' .  time();

        $category->update($data);

        Toastr::success(null, 'Thao tác thành công');
        return redirect()->back();

        // dd($request->all());

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {

        try {

            if ($category) {
                $category->delete();
            }

            Alert::success("Bạn đã xóa thành công category:  {$category->name}", 'Thông Báo');
            return redirect()->route('admin.categories.index');
        } catch (\Throwable $th) {
            //throw $th;
            Alert::success("Có lỗi xảy ra. Check log", 'Thông Báo');
            Log::error("message" . $th->getMessage());
            return redirect()->back();
        }
    }
}
