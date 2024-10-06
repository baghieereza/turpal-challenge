<?php

namespace App\Http\Services;

use App\Models\Availability;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductService
{
    private Product $product;
    private Availability $availability;

    public function __construct(Product $product , Availability $availability)
    {
        $this->product = $product;
        $this->availability = $availability;
    }

    public function search($text , $startDate = null , $endDate=null)
    {
        $today = Carbon::now()->format('Y-m-d');
        $defaultEndDate = Carbon::now();
        $defaultEndDate = $defaultEndDate->addWeeks(Product::DefaultFilterPeriod);

        $startDate = !is_null($startDate) ? Carbon::parse($startDate)->format('Y-m-d') : $today;
        $endDate = !is_null($endDate) ? Carbon::parse($endDate)->format('Y-m-d') : $defaultEndDate->format('Y-m-d');

        $products = Product::query()


            // Checking availability
            ->whereHas('availabilities', function ($query) use ($today) {
                $query->where('start_time', '<=', $today)
                ->where('end_time', '>=', $today);
            })

            // filtering by dates
            ->with(['availabilities' => function ($query) use ($startDate, $endDate) {
                $query->where('start_time','>=', $startDate)->where('end_time','<=' , $endDate );
            }]);

        // Searching by product title
        if ($text) {
            $products->where('products.name', 'like', '%' . $text . '%');
        }
        $products = $products->get();


        return $products->map(function ($product) {
            $minimumPrice = $product->availabilities->min('price');

            return [
                'title' => $product->name,
                'minimumPrice' => $minimumPrice.' AED',
                'thumbnail' => $product->thumbnail,
            ];
        });

    }
}
