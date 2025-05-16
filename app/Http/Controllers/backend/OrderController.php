<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query()
            ->select('id', 'name', 'email', 'phone', 'address', 'status', 'created_at');

        // Handle search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // Handle status filter
        if ($request->has('status') && in_array($request->status, ['1', '2'])) {
            $query->where('status', $request->status);
        }

        // Handle sorting
        $sortColumn = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'DESC');

        if (in_array($sortColumn, ['created_at', 'id', 'status'])) {
            $query->orderBy($sortColumn, $sortDirection);
        }

        $orders = $query->with('orderdetails')->paginate(5);

        return view('backend.order.index', compact('orders'));
    }
    public function delete(string $id)
    {
        $order = Order::find($id);
        if ($order != null) {
            $order->delete();
            return redirect()->route('order.index')->with('success', 'Xóa vào thùng rác thành công!');
        }
        return redirect()->route("order.index")->with('error', 'Failed to delete');
    }
    public function restore(string $id)
    {
        $order = Order::withTrashed()->where('id', $id)->first();
        if ($order != null) {
            $order->restore();
            return redirect()->route('admin.order.trash')->with('success', 'Khôi phục thành công!');
        }
        return redirect()->route("order.trash")->with('error', 'Failed to restore');
    }
    public function destroy(string $id)
    {
        $order = Order::withTrashed()->where('id', $id)->first();
        if ($order != null) {
            if ($order->image && File::exists(public_path("images/order/" . $order->image))) {
                File::delete(public_path("images/order/" . $order->image));
            }
            $order->forceDelete();
            return redirect()->route('admin.order.trash')->with('success', 'Xóa  thành công!');
        }
        return redirect()->route("admin.order.trash")->with('error', 'Failed to delete');
    }

    public function trash()
    {
        // Thay vì get(), sử dụng paginate() để phân trang kết quả
        $orders = Order::onlyTrashed()
            ->orderBy('deleted_at', 'DESC')->select('id', 'fullname', 'ordername', 'status', 'deleted_at')
            ->paginate(10);  // Phân trang, ví dụ 10 bản ghi mỗi trang

        // Trả về view với dữ liệu phân trang
        return view('backend.order.trash', compact('orders'));
    }

    public function status(string $id)
    {
        $order = Order::find($id);

        if ($order) {
            $order->status = $order->status ? 0 : 1;
            $order->updated_by = 1;
            $order->updated_at = now();

            if ($order->save()) {
                return redirect()->route('order.index')->with('success', 'Trạng thái đã được cập nhật thành công!');
            }
        }

        return redirect()->route('order.index')->with('error', 'Không tìm thấy order để cập nhật trạng thái.');
    }
    public function show($id)
    {
        $order = Order::select("id", "name", "email", "phone", "address", "status")
            ->with('orderdetails.product')
            ->findOrFail($id);

        return view('backend.order.show', compact('order'));
    }
}
