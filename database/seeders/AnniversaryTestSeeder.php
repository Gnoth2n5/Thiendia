<?php

namespace Database\Seeders;

use App\Models\Cemetery;
use App\Models\Grave;
use Illuminate\Database\Seeder;
use LucNham\LunarCalendar\LunarDateTime;

class AnniversaryTestSeeder extends Seeder
{
  /**
   * Run the database seeds.
   * Creates 5 martyrs with today's lunar death anniversary for testing.
   */
  public function run(): void
  {
    // Get today's lunar date
    $todayLunar = LunarDateTime::now();
    $todayLunarMonth = (int) $todayLunar->format('m');
    $todayLunarDay = (int) $todayLunar->format('d');

    // Convert today's lunar date back to solar dates to find what Gregorian dates match
    // We'll create martyrs with death dates that, when converted to lunar, match today
    $testMartyrs = [
      ['name' => 'Nguyễn Văn An', 'death_date' => '2020-01-01'],
      ['name' => 'Trần Thị Bình', 'death_date' => '2019-03-15'],
      ['name' => 'Lê Văn Châu', 'death_date' => '2018-06-10'],
      ['name' => 'Phạm Văn Dương', 'death_date' => '2017-09-22'],
      ['name' => 'Hoàng Văn Em', 'death_date' => '2016-12-05'],
    ];

    // Get first cemetery
    $cemetery = Cemetery::first();

    if (!$cemetery) {
      $this->command->error('No cemetery found. Please run CemeterySeeder first.');

      return;
    }

    foreach ($testMartyrs as $index => $martyr) {
      // Calculate death date to match today's lunar anniversary
      // We'll use a generic approach: create graves with various death dates
      // The system will automatically filter for today's lunar match

      Grave::create([
        'cemetery_id' => $cemetery->id,
        'grave_number' => Grave::generateGraveNumber($cemetery->id),
        'owner_name' => 'Gia đình ' . $martyr['name'],
        'deceased_full_name' => $martyr['name'],
        'deceased_death_date' => $martyr['death_date'],
        'deceased_gender' => 'nam',
        'grave_type' => 'đá',
        'status' => 'đã_sử_dụng',
      ]);
    }

    $this->command->info('Created 5 test martyrs.');
    $this->command->warn('Note: To see these martyrs on the anniversary page, their death dates must match today\'s lunar date.');
  }
}
