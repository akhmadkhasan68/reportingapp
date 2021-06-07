<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Report;
use App\Models\ReportImage;
use App\Models\Village;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::with('address')->where('type', 'member')->get();
        foreach($users as $user)
        {
            $report = Report::create([
                'user_id' => $user->id,
                'name' => 'coba report',
                'description' => 'blablablablablabla',
                'province_id' => $user->address->province_id,
                'regency_id' => $user->address->regency_id,
                'district_id' => $user->address->district_id,
                'village_id' => Village::where('district_id', $user->address->district_id)->inRandomOrder()->first()->id,
                'address' => 'blablablablablablabla'
            ]);

            for($i = 0; $i <= 3; $i++){
                ReportImage::create([
                    'report_id' => $report->id,
                    'photo' => 'photo.jpg'
                ]);
            }
        }
    }
}
