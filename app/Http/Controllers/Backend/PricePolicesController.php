<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\PricePoliceRequestForm;
use App\Models\PricePolice;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PricePolicesController extends Controller
{

    # construct
    public function __construct()
    {
    }

    # pricePolice list
    public function index(Request $request)
    {

        $pricePolices = PricePolice::latest();
        $pricePolices = $pricePolices->paginate(paginationNumber());
        return view('backend.pages.pricePolices.index', compact('pricePolices'));
    }

     # return create form
     public function create()
     {
        return view('backend.pages.pricePolices.create');
     }
     
     public function store(PricePoliceRequestForm $request)
     {
        $pricePolices             = new PricePolice();
        $pricePolices->name       = $request->name;
        $pricePolices->num      = $request->num;
        $pricePolices->discount_rate      = $request->discount_rate;
        $pricePolices->status    = 1;
        $pricePolices->created_by = auth()->user()->id;      
        $pricePolices->save();

        flash('Thêm mới chính sách bán hàng thành công')->success();
        return redirect()->route('admin.pricePolices.index');
     }

    # update status 
    public function updateStatus(Request $request)
    {
        $pricePolices = PricePolice::findOrFail($request->id);
        $pricePolices->status = $request->status;
        if ($pricePolices->save()) {
            return 1;
        }
        return 0;
    }

    public function edit($id)
    {
        $pricePolice  = PricePolice::findOrFail($id);
        return view('backend.pages.pricePolices.edit', compact('pricePolice'));
    }

    public function update(Request $request)
    {
        $pricePolice             = PricePolice::findOrFail($request->id);
        $pricePolice->name       = $request->name;
        $pricePolice->num      = $request->num;
        $pricePolice->discount_rate      = validatePhone($request->discount_rate);
        $pricePolice->save();
        flash(localize('Cập nhật chính sách bán hàng thành công'))->success();
        return redirect()->route('admin.pricePolices.index');
    }

    public function delete($id)
    {
        PricePolice::where('id', $id)->forceDelete();
        flash(localize('Xoá chính sách bán hàng thành công'))->success();
        return redirect()->route('admin.pricePolices.index');
    }
}
