<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Models\Menu;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index()
    {
        // Lấy danh sách các mục từ bảng menus
        $menus = Menu::orderBy('created_at', 'DESC')
            ->select(
                'id',
                'name',
                'link',
                'type',
                'position',
                'table_id',
                'sort_order',
                'parent_id',
                'created_by',
                'updated_by',
                'created_at',
                'status'
            )
            ->paginate(10); // Phân trang 10 mục mỗi lần

        return view('backend.menu.index', compact('menus'));
    }
    public function create()
    {
        // Lấy các menu cha (không có parent_id)
        $parentMenus = Menu::whereNull('parent_id')->get();

        if ($parentMenus->isEmpty()) {
            $parentMenus = collect([(object) ['id' => 0, 'name' => 'Không có menu cha']]);
        }

        $positions = ['mainmenu' => 'Main Menu', 'footermenu' => 'Footer Menu'];

        $products = DB::table('product')->select('id', DB::raw("'Product' as name"));
        $brands = DB::table('brand')->select('id', DB::raw("'Brand' as name"));
        $banners = DB::table('banner')->select('id', DB::raw("'Banner' as name"));
        $topics = DB::table('topic')->select('id', DB::raw("'Topic' as name"));
        $posts = DB::table('post')->select('id', DB::raw("'Post' as name"));

        // Kết hợp tất cả vào một mảng
        $tables = $products->union($brands)->union($banners)->union($topics)->union($posts)->get();

        // Trả về view với các menu cha, các vị trí và các bảng
        return view('backend.menu.create', compact('parentMenus', 'positions', 'tables'));
    }

    public function store(StoreMenuRequest $request)
    {
        try {
            // Lấy dữ liệu đã được xác thực từ request
            $validatedData = $request->validated();

            // Tạo mới menu
            $menu = new Menu();
            $menu->name = $validatedData['name'];
            $menu->link = $validatedData['link'];
            $menu->sort_order = $validatedData['sort_order'];
            $menu->parent_id = $validatedData['parent_id'] ?? 0; // Nếu không chọn menu cha, mặc định là 0
            $menu->type = $validatedData['type'];
            $menu->position = $validatedData['position']; // Lưu vị trí menu
            $menu->table_id = $validatedData['table_id']; // Lưu table_id
            $menu->status = $validatedData['status'];
            $menu->created_by = 1; // Hoặc lấy từ Auth::id() nếu có
            $menu->created_at = now();

            // Lưu menu vào cơ sở dữ liệu
            $menu->save();

            // Điều hướng về danh sách menu với thông báo thành công
            return redirect()->route('menu.index')->with('success', 'Menu đã được tạo thành công!');
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            return back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }

    // Phương thức edit
    public function edit(Menu $menu)
    {
        $parentMenus = Menu::whereNull('parent_id')->get(); // Lấy các menu cha (nếu có)
        $positions = ['mainmenu' => 'Main Menu', 'footermenu' => 'Footer Menu'];

        $products = DB::table('product')->select('id', DB::raw("'Product' as name"));
        $brands = DB::table('brand')->select('id', DB::raw("'Brand' as name"));
        $banners = DB::table('banner')->select('id', DB::raw("'Banner' as name"));
        $topics = DB::table('topic')->select('id', DB::raw("'Topic' as name"));
        $posts = DB::table('post')->select('id', DB::raw("'Post' as name"));

        // Kết hợp tất cả vào một mảng
        $tables = $products->union($brands)->union($banners)->union($topics)->union($posts)->get();

        return view('backend.menu.edit', compact('menu', 'parentMenus', 'positions', 'tables'));
    }

    // Phương thức update
    public function update(StoreMenuRequest $request, Menu $menu)
    {
        try {
            // Lấy dữ liệu đã được xác thực từ request
            $validatedData = $request->validated();

            // Cập nhật menu
            $menu->name = $validatedData['name'];
            $menu->link = $validatedData['link'];
            $menu->sort_order = $validatedData['sort_order'];
            $menu->parent_id = $validatedData['parent_id'] ?? 0; // Nếu không chọn menu cha, mặc định là 0
            $menu->type = $validatedData['type'];
            $menu->position = $validatedData['position'];
            $menu->table_id = $validatedData['table_id'];
            $menu->status = $validatedData['status'];
            $menu->updated_at = now();

            // Lưu thông tin menu đã cập nhật
            $menu->save();

            return redirect()->route('menu.index')->with('success', 'Menu đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }

    public function delete(string $id)
    {
        $menu = Menu::find($id);
        if ($menu != null) {
            $menu->delete();
            return redirect()->route('menu.index')->with('success', 'Xóa vào thùng rác thành công!');
        }
        return redirect()->route("menu.index")->with('error', 'Failed to delete');
    }
    public function restore(string $id)
    {
        $menu = Menu::withTrashed()->where('id', $id)->first();
        if ($menu != null) {
            $menu->restore();
            return redirect()->route('admin.menu.trash')->with('success', 'Khôi phục thành công!');
        }
        return redirect()->route("menu.trash")->with('error', 'Failed to restore');
    }
    public function destroy(string $id)
    {
        $menu = Menu::withTrashed()->where('id', $id)->first();
        if ($menu != null) {
            if ($menu->image && File::exists(public_path("images/menu/" . $menu->image))) {
                File::delete(public_path("images/menu/" . $menu->image));
            }
            $menu->forceDelete();
            return redirect()->route('admin.menu.trash')->with('success', 'Xóa  thành công!');
        }
        return redirect()->route("admin.menu.trash")->with('error', 'Failed to delete');
    }

    public function trash()
    {
        // Thay vì get(), sử dụng paginate() để phân trang kết quả
        $menus = Menu::onlyTrashed()
            ->orderBy('deleted_at', 'DESC')->select('id', 'name', 'position', 'status', 'deleted_at')
            ->paginate(10);  // Phân trang, ví dụ 10 bản ghi mỗi trang

        // Trả về view với dữ liệu phân trang
        return view('backend.menu.trash', compact('menus'));
    }

    public function status(string $id)
    {
        $menu = Menu::find($id);

        if ($menu) {
            $menu->status = $menu->status ? 0 : 1;
            $menu->updated_by = 1;
            $menu->updated_at = now();

            if ($menu->save()) {
                return redirect()->route('menu.index')->with('success', 'Trạng thái đã được cập nhật thành công!');
            }
        }

        return redirect()->route('menu.index')->with('error', 'Không tìm thấy menu để cập nhật trạng thái.');
    }
    public function show($id)
    {
        $menu = Menu::select("id", "name", "link", "type", "position", "table_id", "parent_id", "sort_order", "status")
            ->findOrFail($id);

        return view('backend.menu.show', compact('menu'));
    }
}
