<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Models\Topic;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::orderBy('created_at', 'DESC')
            ->select('id', 'name', 'slug', 'sort_order', 'description', 'created_by', 'updated_by', 'status')
            ->paginate(10);
        return view('backend.topic.index', compact('topics'));
    }
    public function create()
    {
        $topics = Topic::orderBy('created_at', 'ASC')
            ->select("id", "name", "sort_order")
            ->get();
        return view('backend.topic.create', compact('topics'));
    }
    public function store(StoreTopicRequest $request)
    {
        try {
            $topic = new Topic();
            // Lưu thông tin topic
            $topic->name = $request->name;
            $topic->slug = Str::slug($request->name);
            $topic->description = $request->description;
            $topic->sort_order = $request->sort_order;
            $topic->status = $request->status;
            $topic->created_by = 1;
            $topic->created_at = now(); // Lấy thời gian hiện tại
            $topic->updated_at = now();
            $topic->save();

            return redirect()->route('topic.index')->with('success', 'Topic created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
    public function edit(string $id)
    {
        $topic = Topic::where('id', $id)->first();
        $topics = Topic::orderBy('sort_order', 'asc')
            ->select("id", "name", "sort_order", "status")
            ->get();
        return view('backend.topic.edit', compact('topic', 'topics'));
    }

    public function update(UpdateTopicRequest $request, string $id)
    {
        try {
            $topic = Topic::findOrFail($id);

            // Cập nhật thông tin topic
            $topic->name = $request->name;
            $topic->slug = Str::slug($request->name);
            $topic->description = $request->description;
            $topic->sort_order = $request->sort_order;
            $topic->status = $request->status;
            $topic->updated_by = 1;
            $topic->updated_at = now(); // Lấy thời gian cập nhật hiện tại

            $topic->save();

            return redirect()->route('topic.index')->with('success', 'Topic updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
    public function delete(string $id)
    {
        $topic = Topic::find($id);
        if ($topic != null) {
            $topic->delete();
            return redirect()->route('topic.index')->with('success', 'Xóa vào thùng rác thành công!');
        }
        return redirect()->route("topic.index")->with('error', 'Failed to delete');
    }
    public function restore(string $id)
    {
        $topic = Topic::withTrashed()->where('id', $id)->first();
        if ($topic != null) {
            $topic->restore();
            return redirect()->route('admin.topic.trash')->with('success', 'Khôi phục thành công!');
        }
        return redirect()->route("topic.trash")->with('error', 'Failed to restore');
    }
    public function destroy(string $id)
    {
        $topic = Topic::withTrashed()->where('id', $id)->first();
        if ($topic != null) {
            if ($topic->image && File::exists(public_path("images/topic/" . $topic->image))) {
                File::delete(public_path("images/topic/" . $topic->image));
            }
            $topic->forceDelete();
            return redirect()->route('admin.topic.trash')->with('success', 'Xóa  thành công!');
        }
        return redirect()->route("admin.topic.trash")->with('error', 'Failed to delete');
    }

    public function trash()
    {
        // Thay vì get(), sử dụng paginate() để phân trang kết quả
        $topics = Topic::onlyTrashed()
            ->orderBy('deleted_at', 'DESC')->select('id', 'name', 'description', 'status', 'deleted_at')
            ->paginate(10);  // Phân trang, ví dụ 10 bản ghi mỗi trang

        // Trả về view với dữ liệu phân trang
        return view('backend.topic.trash', compact('topics'));
    }

    public function status(string $id)
    {
        $topic = Topic::find($id);

        if ($topic) {
            $topic->status = $topic->status ? 0 : 1;
            $topic->updated_by = 1;
            $topic->updated_at = now();

            if ($topic->save()) {
                return redirect()->route('topic.index')->with('success', 'Trạng thái đã được cập nhật thành công!');
            }
        }

        return redirect()->route('topic.index')->with('error', 'Không tìm thấy topic để cập nhật trạng thái.');
    }
    public function show($id)
    {
        $topic = Topic::select("id", "name", "slug", "description", "sort_order", "status")
            ->findOrFail($id);

        return view('backend.topic.show', compact('topic'));
    }
}
