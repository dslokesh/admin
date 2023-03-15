<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\SyncLog;
use App\Models\ProductCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ProductSyncFromSf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'productSync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Product Sync From salesforce Successfully';

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
        $url = "https://mrtsos--full.sandbox.my.salesforce-sites.com/services/apexrest/Products11?clientid=bXlxdWlwd2lic2l0ZWFkbWlu&clientkeys=bXlxdWlwd2lic2l0ZWFkbWluQHBhc3N3b3Jk";

    $response = Http::get($url);
    $jsonData = $response->json();
    $responseBody =  json_decode($jsonData, true);
    //dd($jsonData);
  
    $insert_data_product = [];
    $insert_data_category = [];

    if($responseBody!='')
    {
      foreach ($responseBody as $result) {
            
              $catnameSf ='';
              $productNameSf ='';
              $MMSISf ='';
              $serial_NumberSf='';
              $expiration_DateSf='';
              $start_DateSf='';
              $imageURLSf='';
              $rrrPriceSf=0;
              $discountSf=0;
              $netPrice=0;

              if(isset($result['PBSI__Item__r']['Photo_URL__c']))
              $imageURLSf = $result['PBSI__Item__r']['Photo_URL__c'];

              if(isset($result['PBSI__Item__r']['Item_Category__c']))
              $catnameSf = $result['PBSI__Item__r']['Item_Category__c'];

              if(isset($result['PBSI__Item__r']['PBSI__altdescription__c']))
              $productNameSf = $result['PBSI__Item__r']['PBSI__altdescription__c'];
              
              if(isset($result['PBSI__Software_Key__c']))
              $MMSISf = $result['PBSI__Software_Key__c'];

              if(isset($result['PBSI__Serial_Number__c']))
              $serial_NumberSf = $result['PBSI__Serial_Number__c'];

              if(isset($result['PBSI__Waranty_Expiration_Date__c']))
              $expiration_DateSf = $result['PBSI__Waranty_Expiration_Date__c'];
              if(isset($result['PBSI__Waranty_Start_Date__c']))
              $start_DateSf = $result['PBSI__Waranty_Start_Date__c'];
              $product_id_sf = $result['Id'];
            
              if(isset($result['PBSI__Item__r']['PBSI__salesprice__c']))
              $rrrPriceSf = $result['PBSI__Item__r']['PBSI__salesprice__c'];

              if(isset($result['PBSI__Account__r']['Customer_Discount__c']))
              $discountSf = $result['PBSI__Account__r']['Customer_Discount__c'];

              if($discountSf>0)
              {
                $netPrice = (($discountSf*$rrrPriceSf) /100);
              }
              else
              {
                $netPrice = $rrrPriceSf;
              }

             // print_r($result);
             // exit;
             if(($productNameSf!='') && ($catnameSf!=''))
             {
                $product = Product::where("name", $productNameSf);
                if ($product->count()==0) {
                    if ($catnameSf!='') {
                        $category = Category::where("name", $catnameSf);
                        if ($category->count()>0) {
                            $cat = $category->first();
                            $cat_id = $cat->id;
                        } else {
                            $category = new Category();
                            $category->name = $catnameSf;
                            $category->save();
                            $cat_id = $category->id;
                        }

                        $subCategory = Category::where("name", 'Item Top Level Family')->where("parent_id", $cat_id);
                        if ($subCategory->count()>0) {
                            $cat_sub = $subCategory->first();
                            $category_id = $cat_sub->id;
                        } else {
                            $subcat = new Category();
                            $subcat->name = 'Item Top Level Family';
                            $subcat->parent_id = $cat_id;
                            $subcat->save();
                            $category_id = $subcat->id;
                        }


                        $uuid2 = Str::uuid()->toString();
                        $data_cat = [
                          'id'      => $uuid2,
                          'sf_id'      => $product_id_sf,
                          'category_id'   => $category_id, 
                      ];
      
                    }

                    $uuid = Str::uuid()->toString();
                    $data = [
                      'id'      => $uuid,
                      'product_id_sf'      => $product_id_sf,
                      'name'               => $productNameSf, 
                      'rrr_price'          => $rrrPriceSf,
                      'net_price'          => $netPrice,
                      'discount'          => $discountSf,
                      'MMSI'               => $MMSISf,
                      'serial_number'      => $serial_NumberSf,
                      'start_date'         => Carbon::parse($start_DateSf)->format('Y-m-d'),
                      'end_date'           => Carbon::parse($expiration_DateSf)->format('Y-m-d'),
                      'expiry_date'        => Carbon::parse($expiration_DateSf)->format('Y-m-d'),
                      'status'             => 1,
                  ];
                  $insert_data_product[] = $data;
                 
                $insert_data_category[] = $data_cat;

                $uuid3 = Str::uuid()->toString();
                $url = $imageURLSf;
                $arrContextOptions=array(
                  "ssl"=>array(
                      "verify_peer"=>false,
                      "verify_peer_name"=>false,
                  ),
              );  
              $contents = file_get_contents($url, false, stream_context_create($arrContextOptions));
              /*
              $url = $url;
              $contents = file_get_contents($url); // to get file
              $name = basename($url); // to get file name
              $fileNameExt = pathinfo($url, PATHINFO_EXTENSION); // to get extension
              $name2 =pathinfo($url, PATHINFO_FILENAME); //file name without extension
              */
                $name = basename($url);;
                $fileNameExt = pathinfo($url, PATHINFO_EXTENSION);
                $newName = "/uploads/products/".date('His').rand() . time().$name. '.' . $fileNameExt;
                $destinationPath = public_path('/');
                if (!empty($contents) && strlen($contents) > 0) {
                  if (($fileNameExt=='png') || ($fileNameExt=='jpg') || ($fileNameExt=='jpeg') || ($fileNameExt=='gif')) {
                      file_put_contents($destinationPath.$newName, $contents);

                      $data_image = [
                      'id'      => $uuid3,
                      'sf_id'      => $product_id_sf,
                      'image'   => $newName,
                      'file_type'   => $fileNameExt,
                      'upload_file_type'   => 'Image',
                      'status'   =>1,
                    ];
      
                      $insert_data_image[] = $data_image;
                  }
                }
              }
             
              }
             
          }
        
              $total_product= count($insert_data_product);
              $insert_data_product = collect($insert_data_product);

              $chunks = $insert_data_product->chunk(500);
              foreach ($chunks as $chunk)
              {
                
                $pro  = \DB::table('products')->insert($chunk->toArray());
              }

              $insert_data_category = collect($insert_data_category);

              $chunks_cat = $insert_data_category->chunk(500);
              foreach ($chunks_cat as $chunk_cat)
              {
                $pro  = \DB::table('category_products')->insert($chunk_cat->toArray());
              }

              $insert_data_image = collect($insert_data_image);

              $chunks_image = $insert_data_image->chunk(500);
              foreach ($chunks_image as $chunks_image)
              {
                $pro  = \DB::table('product_images')->insert($chunks_image->toArray());
              }

              if($total_product>0)
              {
                \DB::select('CALL `syncProductToCategory`()');
                \DB::select('CALL `ImageSync`()');
                  $log = new SyncLog();
                  $log->type = 'product';
                  $log->total_record = $total_product;
                  $log->save();
              }


    }
	
	$this->line('Product Sync From salesforce Successfully.');
	exit;
    }
}
