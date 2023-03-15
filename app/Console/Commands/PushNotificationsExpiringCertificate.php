<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Certificate;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Helpers\SiteHelpers;

class PushNotificationsExpiringCertificate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expiringCertificate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'notifications Expiring Certificate';

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
	
	$productsOneMonth 	= Certificate::has("user")->with("user")->where("expiry_date" , $expiringDateOneMonth)->where("certificate_type" , 'User')->get();
	$products14Days 	= Certificate::has("user")->with("user")->where("expiry_date" , $expiringDate14Days)->where("certificate_type" , 'User')->get();
	$products7Days 		= Certificate::has("user")->with("user")->where("expiry_date" , $expiringDate7Days)->where("certificate_type" , 'User')->get();
	$products3Days 		= Certificate::has("user")->with("user")->where("expiry_date" , $expiringDate3Days)->where("certificate_type" , 'User')->get();
	$products2Days 		= Certificate::has("user")->with("user")->where("expiry_date" , $expiringDate2Days)->where("certificate_type" , 'User')->get();
	$products1Days 		= Certificate::has("user")->with("user")->where("expiry_date" , $expiringDate1Days)->where("certificate_type" , 'User')->get();
	
	$productsExpired 		= Certificate::has("user")->with("user")->where("expiry_date" , $expired)->where("certificate_type" , 'User')->get();
	
	$type = "ProfileScreen";
	foreach($productsOneMonth as $oneMonth)
	{
		if(isset($oneMonth->user))
		{
			$title = "Expiring Certification";
			$body = "Your ".$oneMonth->certificate_title." certification expires in 30 days think about booking a refresher course now."; 
			SiteHelpers::sendNotification(array($oneMonth->user->id),$title,$body,$type);
		}
		
	}
	
	foreach($products14Days as $product14Days)
	{
		if(isset($product14Days->user))
		{
			$title = "Expiring Certification";
			$body = "Your ".$product14Days->certificate_title." certification expires in 14 days think about booking a refresher course now."; 
			SiteHelpers::sendNotification(array($product14Days->user->id),$title,$body,$type);
		}
		
	}
	
	foreach($products7Days as $product7Days)
	{
		if(isset($product7Days->user))
		{
			$title = "Expiring Certification";
			$body = "Your ".$product7Days->certificate_title." certification expires in 7 days think about booking a refresher course now."; 
			SiteHelpers::sendNotification(array($product7Days->user->id),$title,$body,$type);
		}
		
	}
	
	foreach($products3Days as $product3Days)
	{
		if(isset($product3Days->user))
		{
			$title = "Expiring Certification";
			$body = "Your ".$product3Days->certificate_title." certification expires in 3 days think about booking a refresher course now."; 
			SiteHelpers::sendNotification(array($product3Days->user->id),$title,$body,$type);
		}
		
	}
	
	foreach($products2Days as $product2Days)
	{
		if(isset($product2Days->user))
		{
			$title = "Expiring Certification";
			$body = "Your ".$product2Days->certificate_title." certification expires in 2 days think about booking a refresher course now."; 
			SiteHelpers::sendNotification(array($product2Days->user->id),$title,$body,$type);
		}
		
	}
	
	foreach($products1Days as $product1Days)
	{
		if(isset($product1Days->user))
		{
			$title = "Expiring Certification";
			$body = "Your ".$product1Days->certificate_title." certification expires in 1 day think about booking a refresher course now."; 
			SiteHelpers::sendNotification(array($product1Days->user->id),$title,$body,$type);
		}
		
	}
	
	foreach($productsExpired as $productExpired)
	{
		if(isset($productExpired->user))
		{
			
			$title = "Expired Certification";
			$body = "Your ".$productExpired->certificate_title." certification has now expired and is no longer valid.  Please contact Your Manager"; 
			SiteHelpers::sendNotification(array($productExpired->user->id),$title,$body,$type);
		}
		
	}
		
	$this->line('Expiring Certification Notification Sent Successfully.');
	exit;
    }
}
