<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('site.login')->with('warning', 'Bạn cần đăng nhập để truy cập giỏ hàng.');
        }
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return view('frontend.cart', compact('cart'))->with('warning', 'Giỏ hàng của bạn hiện tại đang rỗng.');
        }
        return view('frontend.cart', compact('cart'));
    }

    // Chức năng thêm sản phẩm vào giỏ hàng
    public function addcart($id)
    {
        if (!Auth::check()) {
            return redirect()->route('site.login')->with('warning', 'Bạn cần đăng nhập để thêm vào giỏ hàng');
        }
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['qty']++;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'qty' => 1,
                'price' => $product->price_buy,
                'thumbnail' => $product->thumbnail
            ];
        }
        session()->put('cart', $cart);

        return redirect()->route('site.cart')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng');
    }
    // Chức năng cập nhật giỏ hàng
    public function updatecart(Request $request)
    {
        $cart = session()->get('cart', []);
        $qty = $request->qty;
        foreach ($qty as $id => $n) {
            if ($n <= 0) {
                unset($cart[$id]);
            } else {
                $cart[$id]['qty'] = $n;
            }
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Cập nhật giỏ hàng thành công');
    }
    // Chức năng xóa sản phẩm khỏi giỏ hàng
    function delcart($id = null)
    {
        if ($id == null) {
            session()->forget('cart');
        } else {
            $cart = session()->get('cart', []);
            if (array_key_exists($id, $cart)) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
        }
        return redirect()->back()->with('success', 'Xóa thành công');
    }
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('site.cart')->with('warning', 'Giỏ hàng của bạn hiện tại đang rỗng.');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $userId = $user->id;
        DB::beginTransaction();

        try {
            $order = new Order();
            $order->user_id = $userId;
            $order->name = $validated['name'];
            $order->email = $validated['email'];
            $order->phone = $validated['phone'];
            $order->address = $validated['address'];
            $order->created_by = $userId;
            $order->status = 1;
            $order->created_at = now();

            if ($order->save()) {
                foreach ($cart as $id => $item) {
                    $orderdetail = new Orderdetail();
                    $orderdetail->order_id = $order->id;
                    $orderdetail->product_id = $id;
                    $orderdetail->qty = $item['qty'];
                    $orderdetail->price = $item['price'];
                    $orderdetail->discount = 0;
                    $orderdetail->amount = $item['qty'] * $item['price'];
                    $orderdetail->save();
                }
                session()->forget('cart');
                DB::commit();
                return redirect()->route('site.thanks')->with('success', 'Đã đặt hàng thành công');
            }
            DB::rollBack();
            return redirect()->route('site.cart')->with('error', 'Có lỗi xảy ra, vui lòng thử lại.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout failed: ' . $e->getMessage());
            return redirect()->route('site.cart')->with('error', 'Có lỗi xảy ra, vui lòng thử lại.');
        }
    }
    function thanks()
    {
        return view('frontend.thanks');
    }
}
