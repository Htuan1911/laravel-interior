<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Đăng ký các command thủ công
     */
    protected $commands = [
        \App\Console\Commands\UpdateOrderStatus::class,
    ];

    /**
     * Lịch chạy tác vụ tự động
     */
    protected function schedule(Schedule $schedule): void
    {
        // Gọi command đã định nghĩa
        $schedule->command('orders:auto-update-status')->everyMinute();
    }

    /**
     * Nạp tất cả các command
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
