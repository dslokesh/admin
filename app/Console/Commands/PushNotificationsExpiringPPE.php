<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Helpers\SiteHelpers;

class PushNotificationsExpiringPPE extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expiringPPE';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'notifications Expiring PPE';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
		
	$currentDate = Carbon::now()->format('Y-m-d');
	$expiringDateOneMonth = Carbon::now()->addMonths(1)->format('Y-m-d');
	$expiringDate14Days = Carbon::now()->addDays(14)->format('Y-m-d');	
	$expiringDate7Days 	= Carbon::now()->addDays(7)->format('Y-m-d');	
	$expiringDate3Days 	= Carbon::now()->addDays(3)->format('Y-m-d');	
	$expiringDate2Days 	= Carbon::now()->addDays(3)->format('Y-m-d');	
	$expiringDate1Days 	= Carbon::now()->addDays(1)->format('Y-m-d');
	$expired 	= Carbon::now()->subDays(1)->format('Y-m-d');
	
	$productsOneMonth 	= Product::has("assignment")->with("assignment")->where("expiry_date" , $expiringDateOneMonth)->get();
	$products14Days 	= Product::has("assignment")->with("assignment")->where("expiry_date" , $expiringDate14Days)->get();
	$products7Days 		= Product::has("assignment")->with("assignment")->where("expiry_date" , $expiringDate7Days)->get();
	$products3Days 		= Product::has("assignment")->with("assignment")->where("expiry_date" , $expiringDate3Days)->get();
	$products2Days 		= Product::has("assignment")->with("assignment")->where("expiry_date" , $expiringDate2Days)->get();
	$products1Days 		= Product::has("assignment")->with("assignment")->where("expiry_date" , $expiringDate1Days)->get();
	$productsExpired 	= Product::has("assignment")->with("assignment")->where("expiry_date" , $expired)->get();
	
	$type = "MyPPE";
	
	foreach($productsOneMonth as $oneMonth)
	{
		if(isset($oneMonth->assignment))
		{
			$title = "Expiring PPE";
			$body = "Your ".$oneMonth->name." is due for a service inspection in 30 days ";
			SiteHelpers::sendNotification(array($oneMonth->assignment->user_id),$title,$body,$type);
		}
		
	}
	
	foreach($products14Days as $product14Days)
	{
		if(isset($product14Days->assignment))
		{
			$title = "Expiring PPE";
			$body = "Your ".$product14Days->name." is due for a service inspection in 14 days ";
			SiteHelpers::sendNotification(array($product14Days->assignment->user_id),$title,$body,$type);
		}
		
	}
	
	foreach($products7Days as $product7Days)
	{
		if(isset($product7Days->assignment))
		{
			$title = "Expiring PPE";
			$body = "Your ".$product7Days->name." is due for a service inspection in 7 days ";
			SiteHelpers::sendNotification(array($product7Days->assignment->user_id),$title,$body,$type);
		}
		
	}
	
	foreach($products3Days as $product3Days)
	{
		if(isset($product3Days->assignment))
		{
			$title = "Expiring PPE";
			$body = "Your ".$product3Days->name." is due for a service inspection in 3 days ";
			SiteHelpers::sendNotification(array($product3Days->assignment->user_id),$title,$body,$type);
		}
		
	}
	
	foreach($products2Days as $product2Days)
	{
		if(isset($product2Days->assignment))
		{
			$title = "Expiring PPE";
			$body = "Your ".$product2Days->name." is due for a service inspection in 2 days ";
			SiteHelpers::sendNotification(array($product2Days->assignment->user_id),$title,$body,$type);
		}
		
	}
	
	foreach($products1Days as $product1Days)
	{
		if(isset($product1Days->assignment))
		{
			$title = "Expiring PPE";
			$body = "Your ".$product1Days->name." is due for a service inspection in 1 day ";
			SiteHelpers::sendNotification(array($product1Days->assignment->user_id),$title,$body,$type);
		}
		
	}
	
	foreach($productsExpired as $productExpired)
	{
		if(isset($productExpired->assignment))
		{
			$title = "Expired PPE";
			$body = "Your ".$productExpired->name." is no longer valid for use, do not use it. Please contact Your Manager ";
			SiteHelpers::sendNotification(array($productExpired->assignment->user_id),$title,$body,$type);
		}
		
	}
		
	$this->line('Expiring PPE Notification Sent Successfully.');
	exit;
    }
}
