<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CourseIntro;
use App\Models\Promocode;
use App\Models\Tariff;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Basket;
use App\Models\UserCourse;
use App\Models\UserCourseIntro;
use App\Models\UserPromocode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Service\Paybox;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        $request->validate([
            'tariff_id' =>  'required|exists:tariffs,id',
        ],[
            'tariff_id.exists'  =>  'Тарифа не существует'
        ]);
        $user = auth()->user();
        $tariff = Tariff::find($request['tariff_id']);
        $price = $tariff->price;
        if (isset($request['promocode'])) {
            $promocode = Promocode::where('code', $request['promocode'])->first();
            $discount = ($price * $promocode->procent) / 100;
            $price = $price - $discount;
        }
        $transaction = Transaction::create([
            'user_id'   =>  $user->id,
            'price'     =>  $price,
            'interval'  =>  60,
            'created_at'    =>  Carbon::now(),
        ]);
        $req = [
            'pg_salt'   =>  'some random string',
            'pg_amount' =>  $price,
            'pg_description'    =>  'payment',
            'pg_order_id'   =>  "$user->id",
            'tariff_id' =>  $tariff->id,
            'transaction_id'    =>  $transaction->id,
            'promocode' =>  $request['promocode'],
        ];
        $payment = new Paybox($req);
        $response = $payment->initPay($req);

        return self::response(200, $response, 'success');
    }

    public function successPayment($user, $tariff, $transaction, $promocode)
    {
        $tariff = Tariff::find($tariff);
        User::find($user)->update([
            'tariff_id'    =>  $tariff->id,
            'deadline'      =>  Carbon::now()->addMonths(3),
            'count'     =>  $tariff->count,
        ]);
        Transaction::find($transaction)->update([
            'status'    =>  Transaction::STATUS_SUCCESS
        ]);
        $promocode = Promocode::where('code', $promocode)->first();
        $promocode->status = 'used';
        $promocode->save();

        UserPromocode::where('user_id', $user)->where('promocode_id', $promocode->id)->update([
            'status'    => UserPromocode::STATUS_SUCCESS
        ]);

        $baskets = Basket::where('user_id', $user)->where('tariff_id', $tariff->id)->where('status', Basket::STATUS_IN_PROCESS)->get();
        if (count($baskets) > 0 || count($baskets) == 0) {
            foreach ($baskets as $basket) {
                UserCourse::insert([
                    'user_id'   =>  $user,
                    'course_id' =>  $basket['course_id'],
                    'status'        =>  'in_process',
                    'created_at'    =>  Carbon::now(),
                ]);
                $intros = CourseIntro::whereCourseId($basket['course_id'])->get();
                foreach ($intros as $intro) {
                    UserCourseIntro::insert([
                        'course_intro_id'   =>  $intro->id,
                        'user_id'   =>  $user,
                    ]);
                }
            }
        }
        Basket::where('user_id', $user)->where('tariff_id', $tariff->id)->where('status', Basket::STATUS_IN_PROCESS)->update([
            'status'    =>  'success'
        ]);

        return \Redirect::to('https://jaryq.online/');
    }

    public function success($user, $tariff, $transaction)
    {
        $tariff = Tariff::find($tariff);
        User::find($user)->update([
            'tariff_id'    =>  $tariff->id,
            'deadline'      =>  Carbon::now()->addMonths(3),
            'count'     =>  $tariff->count,
        ]);
        Transaction::find($transaction)->update([
            'status'    =>  Transaction::STATUS_SUCCESS
        ]);
        $baskets = Basket::where('user_id', $user)->where('tariff_id', $tariff->id)->where('status',Basket::STATUS_IN_PROCESS)->get();
        if (count($baskets) > 0 || count($baskets) == 0) {
            foreach ($baskets as $basket) {
                UserCourse::insert([
                    'user_id'   =>  $user,
                    'course_id' =>  $basket['course_id'],
                    'status'        =>  'in_process',
                    'created_at'    =>  Carbon::now(),
                ]);
                $intros = CourseIntro::whereCourseId($basket['course_id'])->get();
                foreach ($intros as $intro) {
                    UserCourseIntro::insert([
                        'course_intro_id'   =>  $intro->id,
                        'user_id'   =>  $user,
                    ]);
                }
            }
        }
        Basket::where('user_id', $user)->where('tariff_id', $tariff->id)->where('status', Basket::STATUS_IN_PROCESS)->update([
            'status'    =>  'success'
        ]);

        return \Redirect::to('https://jaryq.online/');
    }

    public function reject($user, $tariff, $transaction)
    {
        User::find($user)->update([
            'tariff_id' =>  null,
            'deadline'      =>  null,
            'count'     =>  0,
        ]);
        Transaction::find($transaction)->update([
            'status'    =>  Transaction::STATUS_REJECT
        ]);
        $baskets = Basket::where('user_id', $user)->where('tariff_id', $tariff)->where('status', Basket::STATUS_IN_PROCESS)->update([
            'status'    =>  'reject'
        ]);

        return \Redirect::to('https://jaryq.online/');
    }

    public function promocode(Request $request)
    {
        $request->validate([
            'promocode' => 'required',
            'tariff_id' =>  'required|exists:tariffs,id'
        ]);
        $user = auth()->user();
        $tariff = Tariff::find($request['tariff_id']);
        $price = $tariff->price;
        if (Promocode::whereCode($request['promocode'])->exists()) {
            $promocode = Promocode::whereCode($request['promocode'])->first();
            $discount = ($price * $promocode->procent) / 100;
            $price = $price - $discount;
            UserPromocode::insert([
                'user_id'   =>  $user->id,
                'promocode_id'  =>  $promocode->id,
                'created_at'    =>  Carbon::now(),
            ]);

            return response()->json([
                'price' => $tariff->price,
                'new_price' => $price,
                'discount' => $discount,
            ], 200);

//            if ($promocode->status == 'in_process') {
//                $discount = ($price * $promocode->procent) / 100;
//                $price = $price - $discount;
//
//                return response()->json([
//                    'price' => $tariff->price,
//                    'new_price' => $price,
//                    'discount' => $discount,
//                ], 200);
//            } else {
//                return self::response(400, null, 'Промокод уже используется!');
//            }
        }

        return self::response(400, null, 'Промокод не найден!');
    }
}
