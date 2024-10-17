<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Alert;
use App\Helper\Toastr;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductSizeRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductSizeController extends Controller
{
    private const VIEW_PATH = "admin.product_size.";
    public function index()
    {
        $productSizes = ProductSize::query()->latest('id')->paginate(10);
        return view(self::VIEW_PATH . __FUNCTION__, compact('productSizes'));
    }

    public function create()
    {
        return view(self::VIEW_PATH . __FUNCTION__);
    }
    public function store(StoreProductSizeRequest $request)
    {
        try {
            ProductSize::create($request->validated());
            Toastr::success(null, 'Thêm size thành công');
            return redirect()->route('admin.product-sizes.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Toastr::error(null, 'Thêm size không thành công');
            return back();
        }
    }
    public function show() {}
    public function edit(ProductSize $productSize) {
        return view(self::VIEW_PATH . __FUNCTION__, compact('productSize'));
    }
    public function update(UpdateProductRequest $request, ProductSize $productSize) {
        try {
            $productSize->update($request->validated());
            Toastr::success(null, 'Sửa size thành công');
            return back();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Toastr::error(null, 'Sửa size không thành công');
            return back();
        }
    }
    public function destroy(ProductSize $productSize) {
        try {
            $productSize->delete();
            Alert::success('Xóa size thành công, chuyển vào thùng rác 30d', 'LuxChill Thông Báo');
            return back();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Toastr::error(null, 'Xóa size không thành công');
            return back();
        }
    }
}
