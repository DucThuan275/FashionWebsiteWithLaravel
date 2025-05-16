<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categorys = Category::orderBy('created_at', 'DESC')
            ->select("id", "name", "slug", "image", "status")
            ->paginate(8);
        return view('backend.category.index', compact('categorys'));
    }
    public function create()
    {
        $categorys = Category::orderBy('created_at', 'ASC')
            ->select("id", "name", "sort_order")
            ->get();
        return view('backend.category.create', compact('categorys'));
    }
    public function store(StoreCategoryRequest $request)
    {
        try {
            $category = new Category();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = now()->format('YmdHis') . '.' . $extension;

                // Lưu ảnh vào thư mục công khai
                $file->move(public_path('images/category'), $filename);
                $category->image = $filename;
            } else {
                return back()->with('error', 'Chưa chọn hình ảnh!');
            }

            $category->name = $request->name;
            $category->slug = Str::slug($request->name);
            $category->parent_id = $request->parent_id;
            $category->description = $request->description;
            $category->sort_order = $request->sort_order;
            $category->created_by = 1; // Có thể thay đổi cho phù hợp
            $category->status = $request->status;
            $category->created_at = now();

            $category->save();

            return redirect()->route('category.index')->with('success', 'Danh mục được tạo thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }
    public function edit(string $id)
    {
        $category = Category::where('id', $id)->first();
        $categorys = Category::orderBy('sort_order', 'asc')
            ->select("id", "name", "sort_order", "status")
            ->get();
        return view('backend.category.edit', compact('category', 'categorys'));
    }
    public function update(UpdateCategoryRequest $request, string $id)
    {
        try {
            // Lấy danh mục cần cập nhật
            $category = Category::where('id', $id)->first();

            // Cập nhật thông tin cơ bản của danh mục
            $category->name = $request->name;
            $category->slug = Str::slug($request->name);
            $category->parent_id = $request->parent_id;
            $category->description = $request->description;
            $category->sort_order = $request->sort_order;
            $category->status = $request->status;
            $category->updated_by = 1; // Bạn có thể thay đổi theo người dùng đăng nhập
            $category->updated_at = now(); // Cập nhật thời gian

            // Xử lý upload ảnh mới nếu có
            if ($request->hasFile('image')) {
                // Xóa ảnh cũ nếu có
                if ($category->image && File::exists(public_path('images/category/' . $category->image))) {
                    File::delete(public_path('images/category/' . $category->image));
                }

                // Lưu ảnh mới
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = now()->format('YmdHis') . '.' . $extension;
                $file->move(public_path('images/category'), $filename);
                $category->image = $filename;
            }

            // Lưu lại danh mục đã được cập nhật
            $category->save();

            return redirect()->route('category.index')->with('success', 'Danh mục cập nhật thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }

    public function delete(string $id)
    {
        $category = Category::find($id);
        if ($category != null) {
            $category->delete();
            return redirect()->route('category.index')->with('success', 'Xóa vào thùng rác thành công!');
        }
        return redirect()->route("category.index")->with('error', 'Failed to delete');
    }
    public function restore(string $id)
    {
        $category = Category::withTrashed()->where('id', $id)->first();
        if ($category != null) {
            $category->restore();
            return redirect()->route('admin.category.trash')->with('success', 'Khôi phục thành công!');
        }
        return redirect()->route("category.trash")->with('error', 'Failed to restore');
    }
    public function destroy(string $id)
    {
        $category = Category::withTrashed()->where('id', $id)->first();
        if ($category != null) {
            if ($category->image && File::exists(public_path("images/category/" . $category->image))) {
                File::delete(public_path("images/category/" . $category->image));
            }
            $category->forceDelete();
            return redirect()->route('admin.category.trash')->with('success', 'Xóa  thành công!');
        }
        return redirect()->route("admin.category.trash")->with('error', 'Failed to delete');
    }
    public function trash()
    {
        $categorys = Category::onlyTrashed()
            ->orderBy('deleted_at', 'DESC')
            ->select('id', 'name', 'status', 'deleted_at')
            ->paginate(8);

        return view('backend.category.trash', compact('categorys'));
    }
    public function status(string $id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->status = $category->status ? 0 : 1;
            $category->updated_by = 1;
            $category->updated_at = now();

            if ($category->save()) {
                return redirect()->route('category.index')->with('success', 'Trạng thái đã được cập nhật thành công!');
            }
        }

        return redirect()->route('category.index')->with('error', 'Không tìm thấy category để cập nhật trạng thái.');
    }
    public function show($id)
    {
        $category = Category::select('category.id', 'category.name', 'category.slug', 'category.sort_order', 'category.image', 'category.parent_id', 'category.status', 'category.description', 'category.created_at', 'parent.name as parent_name')
            ->leftJoin('category as parent', 'category.parent_id', '=', 'parent.id')
            ->findOrFail($id);
        return view('backend.category.show', compact('category'));
    }
}
