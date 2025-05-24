<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequestForm;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CustomersController extends Controller
{

    # construct
    public function __construct()
    {
        $this->middleware(['permission:customers'])->only('index');
        $this->middleware(['permission:ban_customers'])->only(['updateBanStatus']);
    }

    # customer list
    public function index(Request $request)
    {
        $searchKey = null;
        $is_banned = null;
        $type = null;

        $customers = User::where('user_type', 'customer')->latest();
        if ($request->search != null) {
            $customers = $customers->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }
        if ($request->type !== null && $request->type !== '') {
            $customers = $customers->where('type', '=', $request->type);
            $type = $request->type;
        }

        if ($request->is_banned != null) {
            $customers = $customers->where('is_banned', $request->is_banned);
            $is_banned    = $request->is_banned;
        }

        $customers = $customers->paginate(paginationNumber());
        return view('backend.pages.customers.index', compact('customers', 'searchKey', 'is_banned', 'type'));
    }

     # return create form
     public function create()
     {
        $users = User::where('type', '=', 1)->where('is_active', '=', 1)->where('is_banned', '=', 0)->get();
        return view('backend.pages.customers.create', compact('users'));
     }
     
     public function store(CustomerRequestForm $request)
     {
         if (User::where('email', $request->email)->first() == null) {
             $user             = new User;
             $user->code       = $request->code;
             $user->name       = $request->name;
             $user->email      = $request->email;
             $user->phone      = validatePhone($request->phone);
             $user->user_type  = "customer";
             $user->password   = Hash::make($request->password);
             $user->is_active    = 1;
             $user->created_by = auth()->user()->id;    
             $user->parent_id = data_get($request, 'parent_id');
             $user->type = data_get($request, 'type');    
             $user->email_verified_at = date('Y-m-d H:i:s');
             $user->save();
 
             flash('Thêm mới khách hàng thành công')->success();
             return redirect()->route('admin.customers.index');
         }
         flash(localize('Email already used'))->error();
         return back();
     }

    # update status 
    public function updateBanStatus(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->is_banned = $request->status;
        if ($user->save()) {
            return 1;
        }
        return 0;
    }

    public function edit($id)
    {
        $user  = User::findOrFail($id);
        $users = User::where('type', '=', 1)->where('is_active', '=', 1)->where('is_banned', '=', 0)->where('id', '!=', $id)->get();
        return view('backend.pages.customers.edit', compact('user', 'users'));
    }

    public function update(Request $request)
    {
        $exit_email = User::where('email', $request->email)->where('id', '!=', $request->id)->first();
        if ($exit_email) {
            flash(localize('This Email address already exit'))->warning();
            return redirect()->back();
        }
        $user             = User::findOrFail($request->id);
        $user->code       = $request->code;
        $user->name       = $request->name;
        $user->email      = $request->email;
        $user->phone      = validatePhone($request->phone);
        $user->parent_id    = $request->parent_id;
        $user->init_number    = $request->init_number;
        $user->init_amount    = $request->init_amount;
        $user->type     = data_get($request, 'type');  
        if (strlen($request->password) > 0) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        flash(localize('Cập nhật khách hàng thành công'))->success();
        return redirect()->route('admin.customers.index');
    }

    public function delete($id)
    {
        User::where('id', $id)->forceDelete();
        flash(localize('Xoá khách hàng thành công'))->success();
        return redirect()->route('admin.customers.index');
    }
}
