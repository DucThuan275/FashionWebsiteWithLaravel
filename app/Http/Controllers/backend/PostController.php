<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'DESC')
            ->select('id', 'topic_id', 'title', 'slug', 'content', 'description', 'thumbnail', 'type')
            ->with('topic')
            ->paginate(10);

        return view('backend.post.index', compact('posts'));
    }
    public function create()
    {
        $topics = Topic::orderBy('name', 'ASC')->get(); // Lấy danh sách chủ đề nếu có
        return view('backend.post.create', compact('topics'));
    }

    public function store(StorePostRequest $request)
    {
        try {
            $post = new Post();

            // Xử lý upload thumbnail (hình ảnh thu nhỏ)
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $extension = $file->getClientOriginalExtension();
                $filename = now()->format('YmdHis') . '.' . $extension;

                // Lưu ảnh vào thư mục public/images/posts
                $file->move(public_path('images/posts'), $filename);
                $post->thumbnail = $filename;
            } else {
                return back()->with('error', 'Chưa chọn hình thu nhỏ!');
            }

            // Lưu thông tin bài viết
            $post->topic_id = $request->topic_id;
            $post->title = $request->title;
            $post->slug = Str::slug($request->title);
            $post->content = $request->content;
            $post->description = $request->description;
            $post->type = $request->type;
            $post->created_by = 1;  // Sử dụng Auth::id() để lấy user id thực tế
            $post->created_at = now();
            $post->status = $request->status;

            $post->save();

            return redirect()->route('post.index')->with('success', 'Thêm bài viết thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $post = Post::findOrFail($id);  // Lấy bài viết theo ID
        $topics = Topic::orderBy('name', 'ASC')->get(); // Lấy danh sách chủ đề
        return view('backend.post.edit', compact('post', 'topics'));
    }

    public function update(UpdatePostRequest $request, string $id)
    {
        try {
            $post = Post::findOrFail($id);  // Lấy bài viết cần cập nhật

            // Cập nhật thông tin bài viết
            $post->topic_id = $request->topic_id;
            $post->title = $request->title;
            $post->slug = Str::slug($request->title);
            $post->content = $request->content;
            $post->description = $request->description;
            $post->type = $request->type;

            // Upload lại hình ảnh thumbnail nếu có
            if ($request->hasFile('thumbnail')) {
                // Xóa ảnh cũ nếu có
                if ($post->thumbnail && File::exists(public_path("images/posts/" . $post->thumbnail))) {
                    File::delete(public_path("images/posts/" . $post->thumbnail));
                }

                $file = $request->file('thumbnail');
                $extension = $file->extension();
                $filename = now()->format('YmdHis') . '.' . $extension;
                $file->move(public_path('images/posts'), $filename);
                $post->thumbnail = $filename;
            }

            // Cập nhật trạng thái và các thông tin khác
            $post->status = $request->status;
            $post->updated_by = 1;  // Thay thế bằng Auth::id() nếu dùng auth
            $post->updated_at = now();

            $post->save();

            return redirect()->route('post.index')->with('success', 'Cập nhật bài viết thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }

    public function delete(string $id)
    {
        $post = Post::find($id);
        if ($post != null) {
            $post->delete();
            return redirect()->route('post.index')->with('success', 'Xóa vào thùng rác thành công!');
        }
        return redirect()->route("post.index")->with('error', 'Failed to delete');
    }
    public function restore(string $id)
    {
        $post = Post::withTrashed()->where('id', $id)->first();
        if ($post != null) {
            $post->restore();
            return redirect()->route('admin.post.trash')->with('success', 'Khôi phục thành công!');
        }
        return redirect()->route("post.trash")->with('error', 'Failed to restore');
    }
    public function destroy(string $id)
    {
        $post = Post::withTrashed()->where('id', $id)->first();
        if ($post != null) {
            if ($post->image && File::exists(public_path("images/post/" . $post->image))) {
                File::delete(public_path("images/post/" . $post->image));
            }
            $post->forceDelete();
            return redirect()->route('admin.post.trash')->with('success', 'Xóa  thành công!');
        }
        return redirect()->route("admin.post.trash")->with('error', 'Failed to delete');
    }

    public function trash()
    {
        // Thay vì get(), sử dụng paginate() để phân trang kết quả
        $posts = Post::onlyTrashed()
            ->orderBy('deleted_at', 'DESC')->select('id', 'fullname', 'postname', 'status', 'deleted_at')
            ->paginate(10);  // Phân trang, ví dụ 10 bản ghi mỗi trang

        // Trả về view với dữ liệu phân trang
        return view('backend.post.trash', compact('posts'));
    }

    public function status(string $id)
    {
        $post = Post::find($id);

        if ($post) {
            $post->status = $post->status ? 0 : 1;
            $post->updated_by = 1;
            $post->updated_at = now();

            if ($post->save()) {
                return redirect()->route('post.index')->with('success', 'Trạng thái đã được cập nhật thành công!');
            }
        }

        return redirect()->route('post.index')->with('error', 'Không tìm thấy post để cập nhật trạng thái.');
    }
    public function show($id)
    {
        $post = Post::select("id", "topic_id", "title", "slug", "content", "description", "thumbnail", "type", "status")
            ->with('topic')
            ->findOrFail($id);

        return view('backend.post.show', compact('post'));
    }
}
