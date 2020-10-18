<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Book;
use App\Models\User;
use App\Notifications\StatusUpdate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myBorrow()
    {
        if (Auth::check()) {
            $id = Auth::user()->id;
            $borrow_request = Borrow::where('status', 1)->get();

            // new StatusUpdate($borrow_request->User->)
            return response()->json(
                [
                    'message' => 'Your Borrow Request',
                    'data' => $borrow_request,
                ]
            );
        } else {
            return response()->json(
                'message',
                'You should login'
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        //     $borrows = new Borrow();

        //     $request->validate([
        //         'day'=>'required|integer',
        //         'quantity'=>'required|integer',
        //     ]);
        //     if(Auth::check())
        //     {
        //     $user_id = Auth::user()->id
        //    // $borrow_request = Borrow::where(['book_id','$id'],['user_id',$user_id],['status',1])->get();

        //     if(count($borrow_request) == 0)
        //         {
        //             $borrows->user_id = $user_id;
        //             $borrows->book_id= $request->id;
        //             $return_date = Carbon::now()->addDays($request->day);
        //             $borrows->return_date= $return_date;
        //             $borrows->requested_quantity= $request->quantity;
        //             if($borrows->save())
        //             {

        //                 $email = Auth::user()->email;
        //                 $user = User::where('email', $email)->first();
        //                 $user->notify(
        //                     new StatusUpdate($borrows->status)
        //                 );
        //                 return response()->json(['message'=>'Your request is submitted']);
        //             }
        //             else
        //             {
        //                 return response()->json(['error'=>'error in requesting']);
        //             }
        //         }
        //         else
        //         {
        //             return response()->json(['error'=>'You have already requested the book once.']);
        //         }

        //     }
        //     return response()->json(['error'=>'Please Login First']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Borrow  $borrow
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Borrow  $borrow
     * @return \Illuminate\Http\Response
     */
    public function edit(Borrow $borrow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Borrow  $borrow
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Borrow $borrow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Borrow  $borrow
     * @return \Illuminate\Http\Response
     */
    public function destroy(Borrow $borrow)
    {
        //
    }
}