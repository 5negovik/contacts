<?php

namespace App\Console;

use App\Mail\NoticeUserBirthdayContact;
use App\Models\Contact;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use function Symfony\Component\Routing\Loader\forDirectory;


class Kernel extends ConsoleKernel
{


    protected function schedule(Schedule $schedule): void
    {
        // Уведомление пользователей о дне рождении контакта
        $schedule->call(function(){

            $birthday_persons = Contact::query()
                //вариант с карбоном:
                //->selectRaw("*, MONTH(birthday) = " . Carbon::now()->month . " AND DAYOFMONTH(birthday) = " . Carbon::now()->day . " as today")

                //вариант на чистом sql:
                ->selectRaw("*, MONTH(birthday) = MONTH(NOW()) AND DAYOFMONTH(birthday) = DAYOFMONTH(NOW()) as today")

                ->havingRaw('today = 1')
                ->with('user')
                ->get();


            foreach ($birthday_persons as $item) {
                Mail::to($item->user->email)->locale('ru')->send(new NoticeUserBirthdayContact($item));

                //Storage::disk('public')->append('test.txt', $item . PHP_EOL); //для теста можно удалить..
            }

        })->everyMinute(); //hourly() почемуто не работает, возможно это связанно с моим OS
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }


    //php artisan schedule:run
    //cd C:\OSPanel\domains\contacts && php artisan schedule:run
}
