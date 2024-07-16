<?php

namespace Database\Seeders;

use App\Models\Privacy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrivacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $pr1 = new Privacy();
        $pr1->name = 'Công khai';
        $pr1->description="Mọi người có thể thấy bài viết";
        $pr1->save();

        $pr2 = new Privacy();
        $pr2->name = 'Đặt lịch';
        $pr2->description="Đặt lịch công khai bài viết";
        $pr2->save();
        
        $pr3 = new Privacy();
        $pr3->name = 'Bất kì ai có liên kết';
        $pr3->description="Chỉ những người có liên kết đến bài viết này, mới có thể xem được";
        $pr3->save();

        $pr4 = new Privacy();
        $pr4->name = 'Chỉ mình tôi';
        $pr4->description="Chỉ có bạn mới có thể xem bài viết này. Bản nháp của bạn đã được lưu tự động khi bạn nhập";
        $pr4->save();
    }
}
