<?php

namespace App\Http\Controllers\Backend\Stocks;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Product;
use App\Models\ProductVariationStock;
use App\Models\StockInOut;
use Illuminate\Http\Request;
use App\Providers\UtilityServiceProvider as u;

class StocksController extends Controller
{

    # construct
    public function __construct()
    {
        $this->middleware(['permission:add_stock'])->only(['create', 'store']);
    }
    # add stock form
    public function createStockInOut()
    {
        $location_id = $request->location_id ?? 1;
        $products = u::query("SELECT p.name, p.id, pvs.stock_qty FROM products AS p 
                LEFT JOIN product_variations AS pv ON pv.product_id = p.id
                LEFT JOIN product_variation_stocks AS pvs ON pvs.product_variation_id = pv.id AND pvs.location_id = $location_id
            WHERE p.is_published=1 AND p.deleted_at IS NULL");
        $locations = Location::latest()->where('is_published', 1)->get();
        return view('backend.pages.stocks.createStockInOut', compact('products', 'locations', 'location_id'));
    }

    # add stock form
    public function create()
    {
        $location_id = $request->location_id ?? 1;
        $products = u::query("SELECT p.name,pvs.stock_qty FROM product_variation_stocks  AS pvs 
                LEFT JOIN product_variations AS pv ON pvs.product_variation_id = pv.id
                LEFT JOIN products AS p ON p.id=pv.product_id
            WHERE pvs.location_id = $location_id AND p.is_published=1 AND p.deleted_at IS NULL");
        $locations = Location::latest()->where('is_published', 1)->get();
        return view('backend.pages.stocks.create', compact('products', 'locations', 'location_id'));
    }

    # get variation stock
    public function getVariationStocks(Request $request)
    {
        $product = Product::findOrFail((int) $request->product_id);
        $location_id = $request->location_id;
        return [
            'success'   => true,
            'variation_stocks'  => view('backend.pages.stocks.variation_stocks', compact('product', 'location_id'))->render()
        ];
    }

    # add stock
    public function store(Request $request)
    {
        if ($request->has('product_variation_id')) {
            $productVariationStock = ProductVariationStock::where('product_variation_id', $request->product_variation_id)
                ->where('location_id', $request->location_id)->first();
            if (is_null($productVariationStock)) {
                $productVariationStock = new ProductVariationStock;
                $productVariationStock->product_variation_id = $request->product_variation_id;
                $productVariationStock->location_id = $request->location_id;
            }
            $productVariationStock->stock_qty = $request->stock;
            $productVariationStock->save();
        } else {
            foreach ($request->variationsIds as $key => $productVariationId) {
                $productVariationStock = ProductVariationStock::where('product_variation_id', $productVariationId)
                    ->where('location_id', $request->location_id)->first();

                if (is_null($productVariationStock)) {
                    $productVariationStock = new ProductVariationStock;
                    $productVariationStock->product_variation_id = $productVariationId;
                    $productVariationStock->location_id = $request->location_id;
                }
                $productVariationStock->stock_qty = $request->variationStocks[$key];
                $productVariationStock->save();
            }
        }
        flash(localize('Stock updated successfully'))->success();
        return back();
    }

    public function storeStockInOut(Request $request)
    {
        $location_id = data_get($request, 'location_id');   
        $inputCount = $request->inputCount;
        $stock_in_out_id =u::insertSimpleRow([
            'location_id' => $location_id,
            'type' => data_get($request, 'type'),
            'note' => data_get($request, 'note'),
            'created_at' => date('Y-m-d H:i:s'),
            'creator_id' => auth()->user()->id,
        ], 'stock_in_outs');
        foreach($inputCount AS $k=> $row){
            u::insertSimpleRow([
                'product_id' => $k,
                'stock_in_out_id' => $stock_in_out_id,
                'num' => $row
            ], 'stock_in_out_items');
            if($request->type == 1){
                u::query("UPDATE product_variation_stocks AS pvs 
                    LEFT JOIN product_variations AS pv ON pv.id= pvs.product_variation_id
                    SET pvs.stock_qty = GREATEST(pvs.stock_qty - $row, 0)
                    WHERE pv.product_id = $k AND pvs.location_id= $location_id");
            } elseif ($request->type ==2){
                u::query("UPDATE product_variation_stocks AS pvs 
                LEFT JOIN product_variations AS pv ON pv.id= pvs.product_variation_id
                SET pvs.stock_qty = GREATEST(pvs.stock_qty + $row, 0)
                WHERE pv.product_id = $k AND pvs.location_id= $location_id");
            }
        }
        $textFlash = data_get($request, 'type') == 1 ? localize('Thêm phiếu xuất kho thành công') : localize('Thêm phiếu nhập kho thành công');
        flash($textFlash)->success();
        return back();
    }

    public function indexStockInOut(Request $request)
    {
        $searchKey = null;
        $type = $request->type;
        $location_id = data_get($request, 'location_id') ?? 1;

        $stockInOuts = StockInOut::where('location_id', $location_id)->latest();
        // if ($request->search != null) {
        //     $customers = $customers->where('name', 'like', '%' . $request->search . '%')
        //         ->orWhere('email', 'like', '%' . $request->search . '%');
        //     $searchKey = $request->search;
        // }
        

        if ($type) {
            $stockInOuts = $stockInOuts->where('type', $type);
        }

        $stockInOuts = $stockInOuts->with('creator')->paginate(paginationNumber());
        return view('backend.pages.stocks.indexStockInOut', compact('stockInOuts', 'type', 'location_id'));
    }

    public function showStockInOut(Request $request ,$id)
    {
        $stockInOut = StockInOut::with('creator')->find($id);
        $products = u::query("SELECT p.name,si.num FROM stock_in_out_items AS si
                LEFT JOIN products AS p ON p.id=si.product_id
            WHERE si.stock_in_out_id = $id");
        $locations = Location::latest()->where('is_published', 1)->get();
        return view('backend.pages.stocks.showStockInOut', compact('products', 'stockInOut'));
    }
}
