<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\RentLog;
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
        $rentTransactions = RentTransaction::whereDate('rent_date', Carbon::now()->format('Y-m-d'))
            ->orWhereDate('return_date', Carbon::now()->format('Y-m-d'))
            ->get();
    
        foreach ($rentTransactions as $rentTransaction) {
            $rentLogsExist = RentLog::where('rent_transaction_id', $rentTransaction->id)->exists();
    
            if (!$rentLogsExist) {
                $product = Product::find($rentTransaction->product_id);
                if ($product) {
                    $product->is_rented = 'yes';
                    $product->save();
                }
            }
        }
    }    
}
