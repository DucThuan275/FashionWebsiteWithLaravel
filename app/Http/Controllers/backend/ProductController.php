<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()
            ->select('id', 'name', 'category_id', 'brand_id', 'price_buy', 'slug', 'thumbnail', 'status', 'created_at')
            ->with('category', 'brand');

        // Apply search filter
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('brand', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Apply status filter
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Apply sorting
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price_buy', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price_buy', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc'); // Default sorting
        }

        // Paginate results
        $products = $query->paginate(5)->withQueryString();

        // Get categories and brands for filter dropdowns if needed
        $categories = Category::select('id', 'name')->get();
        $brands = Brand::select('id', 'name')->get();

        return view('backend.product.index', compact('products', 'categories', 'brands'));
    }
    public function create()
    {
        // Lấy tất cả các danh mục và thương hiệu để hiển thị trong form
        $categories = Category::all();
        $brands = Brand::all();

        return view('backend.product.create', compact('categories', 'brands'));
    }
    public function store(StoreProductRequest $request)
    {
        try {
            // Lưu sản phẩm vào cơ sở dữ liệu
            $product = new Product();
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            $product->name = $request->name;
            // Tạo slug từ tên sản phẩm
            $slug = Str::slug($request->name);

            // Kiểm tra nếu slug đã tồn tại
            if (Product::where('slug', $slug)->exists()) {
                $slug = $slug . '-' . uniqid(); // Thêm một đoạn duy nhất vào slug
            }

            $product->slug = $slug;

            $product->content = $request->content;
            $product->description = $request->description;
            $product->price_buy = $request->price_buy;
            $product->price_sale = $request->price_sale;
            $product->qty = $request->qty;

            // Xử lý upload thumbnail (hình ảnh thu nhỏ)
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $extension = $file->getClientOriginalExtension();
                $filename = now()->format('YmdHis') . '.' . $extension;

                // Lưu ảnh vào thư mục public/images/products
                $file->move(public_path('images/products'), $filename);
                $product->thumbnail = $filename;
            } else {
                return back()->with('error', 'Chưa chọn hình thu nhỏ!');
            }

            $product->created_by = 1; // Hoặc lấy ID người dùng hiện tại
            $product->created_at = now();
            $product->status = $request->status;

            $product->save();

            return redirect()->route('product.index')->with('success', 'Sản phẩm đã được tạo thành công!');
        } catch (\Exception $e) {
            // Log the error to debug and show specific error message
            Log::error('Error storing product: ' . $e->getMessage());

            // Hiển thị lỗi chi tiết cho người dùng (có thể là lỗi của server hoặc database)
            return back()->with('error', 'Có lỗi xảy ra trong quá trình tạo sản phẩm: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        // Lấy sản phẩm cần chỉnh sửa và các danh mục, thương hiệu
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();

        return view('backend.product.edit', compact('product', 'categories', 'brands'));
    }
    public function update(UpdateProductRequest $request, $id)
    {
        // Lấy sản phẩm cần cập nhật
        $product = Product::findOrFail($id);

        // Cập nhật các thông tin khác
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->content = $request->content;
        $product->description = $request->description;
        $product->price_buy = $request->price_buy;
        $product->price_sale = $request->price_sale;
        $product->qty = $request->qty;

        // Kiểm tra và xử lý ảnh thumbnail
        if ($request->hasFile('thumbnail')) {
            // Xóa ảnh cũ nếu có
            if ($product->thumbnail && File::exists(public_path("images/products/" . $product->thumbnail))) {
                File::delete(public_path("images/products/" . $product->thumbnail));
            }

            $file = $request->file('thumbnail');
            $extension = $file->extension();
            $filename = now()->format('YmdHis') . '.' . $extension;
            $file->move(public_path('images/products'), $filename);
            $product->thumbnail = $filename;
        } else {
            $validatedData['thumbnail'] = $product->thumbnail;
        }

        // Cập nhật trạng thái
        $product->status = $request->status;
        $product->updated_by = 1; // Hoặc lấy ID người dùng hiện tại
        $product->save();

        return redirect()->route('product.index')->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }


    public function delete(string $id)
    {
        $product = Product::find($id);
        if ($product != null) {
            $product->delete();
            return redirect()->route('product.index')->with('success', 'Xóa vào thùng rác thành công!');
        }
        return redirect()->route("product.index")->with('error', 'Failed to delete');
    }
    public function restore(string $id)
    {
        $product = Product::withTrashed()->where('id', $id)->first();
        if ($product != null) {
            $product->restore();
            return redirect()->route('admin.product.trash')->with('success', 'Khôi phục thành công!');
        }
        return redirect()->route("product.trash")->with('error', 'Failed to restore');
    }
    public function destroy(string $id)
    {
        $product = Product::withTrashed()->where('id', $id)->first();
        if ($product != null) {
            if ($product->image && File::exists(public_path("images/product/" . $product->image))) {
                File::delete(public_path("images/product/" . $product->image));
            }
            $product->forceDelete();
            return redirect()->route('admin.product.trash')->with('success', 'Xóa  thành công!');
        }
        return redirect()->route("admin.product.trash")->with('error', 'Failed to delete');
    }

    public function trash()
    {
        // Thay vì get(), sử dụng paginate() để phân trang kết quả
        $products = Product::onlyTrashed()
            ->orderBy('deleted_at', 'DESC')->select('id', 'name', 'price_buy', 'thumbnail', 'status', 'deleted_at')
            ->paginate(10);  // Phân trang, ví dụ 10 bản ghi mỗi trang

        // Trả về view với dữ liệu phân trang
        return view('backend.product.trash', compact('products'));
    }

    public function status(string $id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->status = $product->status ? 0 : 1;
            $product->updated_by = 1;
            $product->updated_at = now();

            if ($product->save()) {
                return redirect()->route('product.index')->with('success', 'Trạng thái đã được cập nhật thành công!');
            }
        }

        return redirect()->route('product.index')->with('error', 'Không tìm thấy product để cập nhật trạng thái.');
    }
    public function show($id)
    {
        $product = Product::select('id', 'name', 'category_id', 'brand_id', 'slug', 'thumbnail', 'status', 'description', 'price_buy', 'created_at', "updated_at")
            ->with('category', 'brand')
            ->findOrFail($id);

        return view('backend.product.show', compact('product'));
    }
}
