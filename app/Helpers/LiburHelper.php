<?

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class LiburHelper
{
    public static function isTodayHoliday()
    {
        $today = now()->toDateString(); // format: YYYY-MM-DD
        $response = Http::get('https://api-harilibur.vercel.app/api');

        if ($response->successful()) {
            $holidays = $response->json();

            foreach ($holidays as $holiday) {
                if ($holiday['holiday_date'] === $today) {
                    return true;
                }
            }
        }

        return false;
    }
}
