<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'review' => ['required', 'string', 'max:255'],
        ]);
            $review = new  \App\review;
            $review->item_id = $request['id'];
            $review->review = $request['review'];
            $review->user_id = auth()->id();
            $review->save();
            return redirect()->back();
    }
    public function delete($id)
    {
        $review = \App\review::find($id);
        $review->delete();
        return redirect()->back();
    }
}
