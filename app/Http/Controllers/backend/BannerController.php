<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Models\Banner;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('created_at', 'DESC')
            ->select("id", "name", "link", "image", "position", "status")
            ->paginate(8);
        return view('backend.banner.index', compact('banners'));
    }
    public function create()
    {
        $banners = Banner::orderBy('created_at', 'ASC')
            ->select("id", "name", "sort_order")
            ->get();
        return view('backend.banner.create', compact('banners'));
    }
    public function store(StoreBannerRequest $request)
    {
        try {
            $banner = new Banner();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = now()->format('YmdHis') . '.' . $extension;

                // Lưu ảnh vào thư mục công khai (public/images/banner)
                $file->move(public_path('images/banner'), $filename);
                $banner->image = $filename;
            } else {
                return back()->with('error', 'Chưa chọn hình!');
            }

            // Lưu thông tin banner
            $banner->name = $request->name;
            $banner->link = $request->link;
            $banner->position = $request->position;
            $banner->description = $request->description;
            $banner->sort_order = $request->sort_order;
            $banner->created_by = 1;
            // $banner->created_by = Auth::id() ?? 1;
            $banner->created_at = now(); // Sử dụng Carbon để lấy thời gian hiện tại
            $banner->status = $request->status;

            $banner->save();

            return redirect()->route('banner.index')->with('success', 'Thêm thành công!');
        } catch (\Exception $e) {
            // Xử lý lỗi trong quá trình lưu banner
            return back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }
    public function edit(string $id)
    {
        $banner = Banner::where('id', $id)->first();
        $banners = Banner::orderBy('sort_order', 'asc')
            ->select("id", "name", "sort_order", "status")
            ->get();
        return view('backend.banner.edit', compact('banner', 'banners'));
    }
    public function update(UpdateBannerRequest $request, string $id)
    {
        $banner = Banner::where('id', $id)->first();
        $banner->name = $request->name;
        $banner->link = $request->link;

        // upload file
        if ($request->hasFile('image')) {
            // Xóa hình
            if ($banner->image && File::exists(public_path("images/banner/" . $banner->image))) {
                File::delete(public_path("images/banner/" . $banner->image));
            }

            $file = $request->file('image');
            $extension = $file->extension();
            $filename = date('YmdHis') . "." . $extension;
            $file->move(public_path('images/banner'), $filename);
            $banner->image = $filename;
        } else {
            // Retain the old image
            $validatedData['image'] = $banner->image;
        }
        // end upload file

        $banner->position = $request->position;
        $banner->description = $request->description;
        $banner->sort_order = $request->sort_order;
        $banner->updated_by = 1;
        // $banner->updated_by = Auth::id() ?? 1;
        $banner->updated_at = date('Y-m-d H:i:s');
        $banner->status = $request->status;

        if ($banner->save()) {
            return redirect()->route('banner.index')->with('success', 'Banner update successfully');
        }
        return redirect()->back()->with('error', 'Failed to create banner');
    }
    public function delete(string $id)
    {
        $banner = Banner::find($id);
        if ($banner != null) {
            $banner->delete();
            return redirect()->route('banner.index')->with('success', 'Xóa vào thùng rác thành công!');
        }
        return redirect()->route("banner.index")->with('error', 'Failed to delete');
    }
    public function restore(string $id)
    {
        $banner = Banner::withTrashed()->where('id', $id)->first();
        if ($banner != null) {
            $banner->restore();
            return redirect()->route('admin.banner.trash')->with('success', 'Khôi phục thành công!');
        }
        return redirect()->route("banner.trash")->with('error', 'Failed to restore');
    }
    public function destroy(string $id)
    {
        $banner = Banner::withTrashed()->where('id', $id)->first();
        if ($banner != null) {
            if ($banner->image && File::exists(public_path("images/banner/" . $banner->image))) {
                File::delete(public_path("images/banner/" . $banner->image));
            }
            $banner->forceDelete();
            return redirect()->route('admin.banner.trash')->with('success', 'Xóa  thành công!');
        }
        return redirect()->route("admin.banner.trash")->with('error', 'Failed to delete');
    }
    public function trash()
    {
        $banners = Banner::onlyTrashed()
            ->orderBy('deleted_at', 'DESC')
            ->select('id', 'name', 'link', 'image', 'position', 'status', 'deleted_at')
            ->paginate(8);

        return view('backend.banner.trash', compact('banners'));
    }
    public function status(string $id)
    {
        $banner = Banner::find($id);

        if ($banner) {
            $banner->status = $banner->status ? 0 : 1;
            $banner->updated_by = 1;
            $banner->updated_at = now();

            if ($banner->save()) {
                return redirect()->route('banner.index')->with('success', 'Trạng thái đã được cập nhật thành công!');
            }
        }

        return redirect()->route('banner.index')->with('error', 'Không tìm thấy banner để cập nhật trạng thái.');
    }
    public function show($id)
    {
        $banner = Banner::select("id", "name", "link", "image", "position", "status")
            ->findOrFail($id);
        if ($banner == null) {
            return redirect()->back()->with('error', 'Không tồn tại mẫu tin');
        }

        return view('backend.banner.show', compact('banner'));
    }
}
