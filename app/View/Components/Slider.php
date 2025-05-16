<?php

namespace App\View\Components;

use App\Models\Banner; // Model tương ứng với bảng banners
use Illuminate\View\Component;

class Slider extends Component
{
    /**
     * Danh sách các banner mới nhất.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $latestBanners;

    /**
     * Tạo một instance mới của component Slider.
     */
    public function __construct()
    {
        $this->latestBanners = $this->getLatestBanners();
    }

    /**
     * Lấy danh sách 3 banner mới nhất.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getLatestBanners()
    {
        return Banner::where('status', 1) // Lọc các banner có trạng thái kích hoạt
            ->latest() // Sắp xếp giảm dần theo cột created_at
            ->take(3) // Giới hạn 3 banner
            ->get();
    }

    /**
     * Lấy view đại diện cho component này.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('components.slider', [
            'banners' => $this->latestBanners,
        ]);
    }
}
