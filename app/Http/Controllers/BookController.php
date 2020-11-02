<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Borrow;
use App\Notifications\StatusUpdate;
use Twilio\Rest\Client;
use Twilio\Jwt\ClientToken;

use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBooks()
    {

        $books = Book::where('quantity', '>', 0,)->get();
        return response()->json([
            'Books' => $books
        ]);
    }
    public function getSingle($id)
    {

        $book = Book::find($id);
        return response()->json([
            'Book' => $book
        ]);
    }
    public function Pending($status, $user_id, $book)
    {
        $borrow_request = Borrow::where([['user_id', $user_id], ['book_id', $book]])->update(['status' => $status]);
        $user = User::where('id', $user_id)->first();
        $user->notify(
            new StatusUpdate($status)
        );

        return response()->json(
            [
                'message' => 'Borrow Accepted or Rejected',
                'data' => $borrow_request,
            ]
        );
    }
    public function requested()
    {

        $borrow_request = Borrow::where('status', 1)->get();
        return response()->json(
            [
                'message' => 'Borrow Request',
                'data' => $borrow_request,
            ]
        );
    }
    public function sendSms()
    {
        $accountSid = config('app.twilio')['TWILIO_ACCOUNT_SID'];
        $authToken  = config('app.twilio')['TWILIO_AUTH_TOKEN'];
        $appSid     = config('app.twilio')['TWILIO_APP_SID'];
        $client = new Client($accountSid, $authToken);

        // Use the client to do fun stuff like send text messages!
        $client->messages->create(
            // the number you'd like to send the message to
            '+00619845703020',
            array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => '+12082685376',
                // the body of the text message you'd like to send
                'body' => 'Hey Deepika! It’s test from your LMShub Project!'
            )
        );
        return response()->json(
            [
                'message' => 'Borrow Accepted or Rejected',
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $books = new Book();
        $request->validate([
            'title' => 'required|string',
            'ISBN' => 'required|string',
            'description' => 'required|string',
            'author' => 'required|string',
            'quantity' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . request()->image->getClientOriginalExtension();
            request()->image->move(public_path('books'), $imageName);
            $books->image_url = $imageName;
            $isbn = $request->ISBN;
            $isbn = $isbn . $books->id . time();
            $books->ISBN = $isbn;
            $books->title = $request->title;
            $books->description = $request->description;
            $books->author = $request->author;
            $books->quantity = $request->quantity;
            $books->save();
            return response()->json([
                "success" => true,
                "message" => "Book added successfully!!",
                "file" => $imageName
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        $book->title = is_null($request->title) ? $book->title : $book->title;
        $book->author = is_null($request->author) ? $book->author : $book->author;
        $book->quantity = is_null($request->quantity) ? $book->quantity : $book->quantity;

        if ($book->save()) {
            return response()->json([
                "message" => "records updated successfully"
            ], 200);
        } else {
            return response()->json([
                "message" => "Book not found"
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Book::where('id', $id)->exists()) {
            $book = Book::find($id);
            $book->delete();

            return response()->json([
                "message" => "book deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Book not found"
            ], 404);
        }
    }
}
