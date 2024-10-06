<?php

namespace App\Console\Commands;

use App\Models\Availability;
use App\Models\Product;
use Carbon\Carbon;
use HeavenlyTours\HeavenlyToursApi;
use Illuminate\Console\Command;

class PullingHeavenlyToursData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'heavenlyTours:pull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'pulling data from heavenly tours';
    private HeavenlyToursApi $heavenlyToursApi;

    public function __construct(HeavenlyToursApi $heavenlyToursApi)
    {
        parent::__construct();
        $this->heavenlyToursApi = $heavenlyToursApi;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tours = $this->gettingTours();
        $details = $this->gettingTourDetail($tours);
        $prices = $this->gettingPrices();
        $this->importingData($details, $prices);
    }

    public function gettingTours()
    {
        return $this->heavenlyToursApi->getTours();
    }

    public function gettingTourDetail($tours)
    {
        $details = [];
        foreach ($tours as $tour) {
            $result = $this->heavenlyToursApi->getTourDetails($tour['id']);
            $thumbnail = "";
            foreach ($result['photos'] as $photo){
                if ($photo['type'] == 'thumbnail'){
                    $thumbnail = $photo['url'];
                }
            }
            $details[] = [
                'id' => $result['id'],
                'name' => $result['title'],
                'description' => $result['description'],
                'thumbnail' => $thumbnail
            ];
        }
        return $details;
    }

    public function gettingPrices()
    {
        $prices = [];
        for ($i = 0; $i <= 13; $i++) {
            $now = Carbon::now();
            $now = $now->addDays($i)->toDateString();
            $price_items =  $this->heavenlyToursApi->getPricePerDate($now);
            foreach ($price_items as $item){
                $prices[] = [
                    'id' => $item['tourId'],
                    'price' => $item['price'],
                    'start_time' => $now,
                    'end_time' => $now
                ];
            }
        }
        return $prices;
    }

    public function importingData($details, $prices)
    {
        $availability = [];
        foreach ($details as $detail){
            $product_id = Product::query()->updateOrCreate($detail)->id;
            foreach ($prices as $price){
                if ($price['id'] == $detail['id']){
                    unset($price['id']);
                    $price['product_id'] = $product_id;
                    $availability[]=$price;
                }
            }
        }
        Availability::query()->upsert($availability, 'id');
    }
}
