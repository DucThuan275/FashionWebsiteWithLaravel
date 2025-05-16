<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('created_at', 'DESC')
            ->select("id", "name", "image", "slug", "status")
            ->paginate(8);
        return view('backend.brand.index', compact('brands'));
    }
    public function create()
    {
        $brands = Brand::orderBy('created_at', 'ASC')
            ->select("id", "name", "sort_order")
            ->get();
        return view('backend.brand.create', compact('brands'));
    }
    public function store(StoreBrandRequest $request)
    {
        try {
            // Kiểm tra đầu vào
            $data = $request->only(['name', 'slug', 'description', 'sort_order', 'status']);

            // Tạo mới Brand
            $brand = new Brand();
            $brand->name = $data['name'];
            $brand->slug = Str::slug($data['name']);
            $brand->description = $data['description'];
            $brand->sort_order = $data['sort_order'];
            $brand->status = $data['status'];
            $brand->created_by = 1;  // Hoặc Auth::id() nếu sử dụng tính năng xác thực
            $brand->created_at = now();  // Tự động lưu thời gian

            // Kiểm tra và lưu ảnh
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = now()->format('YmdHis') . '.' . $extension;
                $file->move(public_path('images/brand'), $filename);
                $brand->image = $filename;
            } else {
                return back()->with('error', 'Chưa chọn hình!');
            }

            // Lưu vào cơ sở dữ liệu
            if ($brand->save()) {
                return redirect()->route('brand.index')->with('success', 'Thêm thành công!');
            } else {
                return back()->with('error', 'Đã xảy ra lỗi khi lưu!');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $brand = Brand::where('id', $id)->first();
        $brands = Brand::orderBy('sort_order', 'asc')
            ->select("id", "name", "sort_order", "status")
            ->get();
        return view('backend.brand.edit', compact('brand', 'brands'));
    }
    public function update(UpdateBrandRequest $request, $id)
    {
        try {
            // Lấy thông tin thương hiệu cần cập nhật
            $brand = Brand::where('id', $id)->first();

            // Cập nhật thông tin không liên quan đến ảnh
            $brand->name = $request->name;
            $brand->slug = Str::slug($request->name);
            $brand->description = $request->description;
            $brand->sort_order = $request->sort_order;
            $brand->status = $request->status;
            $brand->updated_by = 1;  // Hoặc Auth::id() nếu bạn muốn lấy id người dùng hiện tại

            // Xử lý ảnh (nếu có ảnh mới được upload)
            if ($request->hasFile('image')) {
                // Nếu có ảnh cũ, xóa nó
                if ($brand->image && File::exists(public_path("images/brand/" . $brand->image))) {
                    File::delete(public_path("images/brand/" . $brand->image));
                }

                // Lưu ảnh mới
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = now()->format('YmdHis') . '.' . $extension;
                $file->move(public_path('images/brand'), $filename);

                // Cập nhật tên ảnh mới
                $brand->image = $filename;
            }
            $brand->updated_at = now();
            if ($brand->save()) {
                return redirect()->route('brand.index')->with('success', 'Thêm thành công!');
            } else {
                return back()->with('error', 'Đã xảy ra lỗi khi lưu!');
            }
        } catch (\Exception $e) {
            // Xử lý lỗi trong quá trình lưu
            return back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }
    public function delete(string $id)
    {
        $brand = brand::find($id);
        if ($brand != null) {
            $brand->delete();
            return redirect()->route('brand.index')->with('success', 'Xóa vào thùng rác thành công!');
        }
        return redirect()->route("brand.index")->with('error', 'Failed to delete');
    }
    public function restore(string $id)
    {
        $brand = Brand::withTrashed()->where('id', $id)->first();
        if ($brand != null) {
            $brand->restore();
            return redirect()->route('admin.brand.trash')->with('success', 'Khôi phục thành công!');
        }
        return redirect()->route("brand.trash")->with('error', 'Failed to restore');
    }
    public function destroy(string $id)
    {
        $brand = Brand::withTrashed()->where('id', $id)->first();
        if ($brand != null) {
            if ($brand->image && File::exists(public_path("images/brand/" . $brand->image))) {
                File::delete(public_path("images/brand/" . $brand->image));
            }
            $brand->forceDelete();
            return redirect()->route('admin.brand.trash')->with('success', 'Xóa  thành công!');
        }
        return redirect()->route("admin.brand.trash")->with('error', 'Failed to delete');
    }


    public function trash()
    {
        $brands = Brand::onlyTrashed()
            ->orderBy('deleted_at', 'DESC')
            ->select('id', 'name', 'image', 'status', 'deleted_at')
            ->paginate(8);

        return view('backend.brand.trash', compact('brands'));
    }
    public function status(string $id)
    {
        $brand = Brand::find($id);

        if ($brand) {
            $brand->status = $brand->status ? 0 : 1;
            $brand->updated_by = 1;
            $brand->updated_at = now();

            if ($brand->save()) {
                return redirect()->route('brand.index')->with('success', 'Trạng thái đã được cập nhật thành công!');
            }
        }

        return redirect()->route('brand.index')->with('error', 'Không tìm thấy brand để cập nhật trạng thái.');
    }
    public function show($id)
    {
        $brand = Brand::select(
            'id',
            'name',
            'slug',
            'image',
            'description',
            'sort_order',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
            'deleted_at',
            'status'
        )
            ->findOrFail($id); // Nếu không tìm thấy, sẽ tự động ném lỗi 404

        // Kiểm tra xem thương hiệu có tồn tại không (mặc dù `findOrFail` sẽ ném lỗi nếu không có)
        if (!$brand) {
            return redirect()->back()->with('error', 'Không tồn tại mẫu tin');
        }

        // Trả về view kèm theo dữ liệu
        return view('backend.brand.show', compact('brand'));
    }
}
