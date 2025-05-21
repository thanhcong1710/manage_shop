<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\MediaManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Str;
use App\Providers\UtilityServiceProvider as u;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    # customer dashbaord
    public function index()
    {
        return view('frontend.default.pages.users.dashboard');
    }

    # customer's order history
    public function orderHistory()
    {
        $orders = auth()->user()->orders()->latest()->paginate(paginationNumber());
        return view('frontend.default.pages.users.orderHistory', ['orders' => $orders]);
    }

    # customer's address
    public function address()
    {
        $user = auth()->user();
        $addresses = $user->addresses()->latest()->get();
        $countries = Country::isActive()->get();

        return view('frontend.default.pages.users.address', [
            'addresses' => $addresses,
            'countries' => $countries,
        ]);
    }

    # customer's profile
    public function profile()
    {
        $user = auth()->user();
        return view('frontend.default.pages.users.profile', ['user' => $user]);
    }

    # update profile
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        if ($request->type == "info") {
            # update info
            $request->validate(
                [
                    'avatar' => 'nullable|max:4000|mimes:jpeg,png,webp,jpg'
                ],
                [
                    'avatar.max' => 'Max file size is 4MB!'
                ]
            );

            if ($request->hasFile('avatar')) {
                $mediaFile = new MediaManager;
                $mediaFile->user_id = auth()->user()->id;
                $mediaFile->media_file = $request->file('avatar')->store('uploads/media');
                $mediaFile->media_size = $request->file('avatar')->getSize();
                $mediaFile->media_name = $request->file('avatar')->getClientOriginalName();
                $mediaFile->media_extension = $request->file('avatar')->getClientOriginalExtension();

                if (getFileType(Str::lower($mediaFile->media_extension)) != null) {
                    $mediaFile->media_type = getFileType(Str::lower($mediaFile->media_extension));
                } else {
                    $mediaFile->media_type = "unknown";
                }
                $mediaFile->save();
                $user->avatar = $mediaFile->id;
            }

            $user->name = $request->name;
            $user->phone = validatePhone($request->phone);
            $user->save();
            flash(localize('Profile updated successfully'))->success();
            return back();
        }
        else {
            # update password
            $request->validate(
                [
                    'password' => 'required|confirmed|min:6'
                ]
            );
            $user->password = Hash::make($request->password);
            $user->save();
            flash(localize('Password updated successfully'))->success();
            return back();
        }
    }

    public function getDataAgency(Request $request)
    {
        $report_type = data_get ($request, 'report_type') ? data_get($request, 'report_type') : 1;
        $cond = "";
        if ($report_type == 1) {
            $cond .= " AND o.created_at >= '".date('Y-m-01 00:00:00')."'";
        }else if ($report_type == 2) {
            $cond .= " AND o.created_at <'".date('Y-01-01 00:00:00')."' AND o.created_at >= '".date('Y-m-01 00:00:00', strtotime('first day of last month'))."'";
        }
        $user = auth()->user();
        $userTree = DB::select("WITH RECURSIVE tree_paths AS (
                -- Bắt đầu từ thư mục gốc A
                SELECT id, name, parent_id
                FROM users
                WHERE id = $user->id

                UNION ALL

                -- Lấy các thư mục con đệ quy
                SELECT t.id, t.name, t.parent_id
                FROM users t
                INNER JOIN tree_paths tp ON t.parent_id = tp.id
            )
            SELECT *
            FROM tree_paths");
        $condInSql="0";
        foreach($userTree AS $row){
            $condInSql.=",".data_get($row,'id');
        }
        $list_users = u::query("SELECT
            u.id,
            u.name,
            u.parent_id,
            IFNULL(SUM(oi.qty), 0) AS total_qty,
            IFNULL(SUM(oi.total_price), 0) AS total_amount
        FROM users AS u
            LEFT JOIN orders AS o ON o.user_id = u.id AND o.payment_status = 'paid' $cond
            LEFT JOIN order_items AS oi ON oi.order_id = o.id
        WHERE u.type = 1
            AND u.user_type = 'customer'
            AND u.is_active = 1
            AND u.is_banned = 0
            AND u.id IN ($condInSql) 
        GROUP BY u.id");
        $data = u::data_tree($list_users);
        if(empty($data) && !empty($list_users)){
            $data [] = [
                'name' => $list_users[0]->name ?? 'No name',
                'title' => $list_users[0]->total_qty . " sản phẩm (" . number_format($list_users[0]->total_amount) . " đ)",
                'className' => $list_users[0]->class ?? 'product-dept', // nếu có cột class trong DB
            ];
        }
        return response()->json($data);
    }

}
