<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\RentTransaction;
use Illuminate\Console\Command;

class UpdateIsRentedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-is-rented-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $rentedProducts = RentTransaction::whereDate('rent_date', Carbon::now()->format('Y-m-d'))
        ->where('is_rented', 'no')
        ->get();

        foreach ($rentedProducts as $rentedProduct) {
            $product = $rentedProduct->product;
            $product->is_rented = 'yes';
            $product->save();
        }
    }
}
