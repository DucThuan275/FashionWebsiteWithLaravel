<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'DESC')
            ->select('id', 'name', 'email', 'phone', 'title', 'content', 'reply_id', 'user_id', 'created_by', 'updated_by', 'created_at', 'status')
            ->paginate(10);
        return view('backend.contact.index', compact('contacts'));
    }

    public function reply($contact_id)
    {
        // Lấy contact cần trả lời
        $contact = Contact::findOrFail($contact_id);

        return view('backend.contact.reply', compact('contact'));
    }

    // Phương thức để lưu phản hồi
    public function storeReply(Request $request, $contact_id)
    {
        $request->validate([
            'reply_content' => 'required|string',
        ]);
        $contact = Contact::findOrFail($contact_id);
        $reply_id = $this->generateUniqueReplyId();
        $contact->reply_id = $reply_id;
        $contact->reply_content = $request->input('reply_content');
        $contact->status = 2;
        $contact->updated_by = 1;
        $contact->save();
        return redirect()->route('contact.index')->with('success', 'Phản hồi đã được gửi thành công!');
    }

    /**
     * Hàm để tạo mã reply_id ngẫu nhiên duy nhất
     */
    private function generateUniqueReplyId()
    {
        do {
            // Tạo mã số ngẫu nhiên, bạn có thể thay đổi phạm vi nếu muốn
            $reply_id = mt_rand(100000, 999999); // Mã số ngẫu nhiên 6 chữ số
        } while (Contact::where('reply_id', $reply_id)->exists());  // Kiểm tra xem mã này đã tồn tại chưa

        return $reply_id;
    }

    public function show($id)
    {
        $contact = Contact::select("id", "name", "phone", "title", "content", "user_id", "status")
            ->findOrFail($id);

        return view('backend.contact.show', compact('contact'));
    }
    public function delete(string $id)
    {
        $contact = contact::find($id);
        if ($contact != null) {
            $contact->delete();
            return redirect()->route('contact.index')->with('success', 'Xóa vào thùng rác thành công!');
        }
        return redirect()->route("contact.index")->with('error', 'Failed to delete');
    }
    public function restore(string $id)
    {
        $contact = Contact::withTrashed()->where('id', $id)->first();
        if ($contact != null) {
            $contact->restore();
            return redirect()->route('admin.contact.trash')->with('success', 'Khôi phục thành công!');
        }
        return redirect()->route("contact.trash")->with('error', 'Failed to restore');
    }
    public function destroy(string $id)
    {
        $contact = Contact::withTrashed()->where('id', $id)->first();
        if ($contact != null) {
            if ($contact->image && File::exists(public_path("images/contact/" . $contact->image))) {
                File::delete(public_path("images/contact/" . $contact->image));
            }
            $contact->forceDelete();
            return redirect()->route('admin.contact.trash')->with('success', 'Xóa  thành công!');
        }
        return redirect()->route("admin.contact.trash")->with('error', 'Failed to delete');
    }

    public function trash()
    {
        $contacts = Contact::onlyTrashed()
            ->orderBy('deleted_at', 'DESC')
            ->select("id", "name", "phone", "title", "status", "deleted_at")
            ->paginate(8);

        return view('backend.contact.trash', compact('contacts'));
    }
    public function status(string $id)
    {
        $contact = Contact::find($id);

        if ($contact) {
            $contact->status = $contact->status ? 0 : 1;
            $contact->updated_by = 1;
            $contact->updated_at = now();

            if ($contact->save()) {
                return redirect()->route('contact.index')->with('success', 'Trạng thái đã được cập nhật thành công!');
            }
        }

        return redirect()->route('contact.index')->with('error', 'Không tìm thấy contact để cập nhật trạng thái.');
    }
}
