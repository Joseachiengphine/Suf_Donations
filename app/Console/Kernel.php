<?php

namespace App\Console;

use App\Models\DonationRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function (){
//            $from = date('2018-01-01');
            $to = date('2023-05-02');
            $today = Carbon::now();
            $to = $today;
            $from = $today->subtract(1, 'week');

            $all_donation_requests = DonationRequest::whereBetween('last_update', [$from, $to])->get();
            $all_donation_requests_confirmed = DonationRequest::whereBetween('last_update', [$from, $to])->get();

//            $users = User::orderBy('created_at', 'ASC')->get();
//            foreach ($users as $user) {
//                $sales_report = PDF::loadView('reports.sale_report', ['user' => $user]);
            $donations_report = PDF::loadView('weekly_donations_report', ['allPaymentsRaised' => $all_donation_requests]);
            $pdf = $donations_report->output();
            $data = ['details' => 'This email is to notify you of this week sales and challenges we are facing as Sales department',
                'manager_name' => $user->name
            ];
            Mail::send('reports.email_body', $data, function ($message) use ($user, $pdf) {
                $message->subject('Weekly Donations Request Summary');
                $message->from('suf@strathmore.edu.com');
                $message->to('suf@strathmore.edu');
                $message->attachData($pdf, 'donations.pdf', [
                    'mime' => 'application/pdf',
                ]);
            });
//            }
        });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
