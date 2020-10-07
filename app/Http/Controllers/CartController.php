<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\selectedItem;

class CartController extends Controller
{
    public function showCart()
    {   
        //show items added in cart stored in session

        $selcteditems = Session::has('selcteditems') ? Session::get('selcteditems') : array();
        $fees = \App\fee::all();
        $zones = \App\zone::all();

        return view('cart',[
            'items'=>$selcteditems ?? 'Doesnot exist',
            'fees' => $fees,
            'zones' => $zones

        ]);
    }
    public function removeItem($id)
    {
        //remove item from cart array stored in session

        $selcteditems = Session::get('selcteditems'); 
        $number_of_items = Session::has('number_of_items') ? Session::get('number_of_items') : 0;

        for($i=0;$i<sizeof($selcteditems);$i++)
        {
            if($selcteditems[$i]->item->id == $id)
            {
                $number_of_items-=$selcteditems[$i]->Quantity;
                unset($selcteditems[$i]);
                $selcteditems = array_values($selcteditems);
                Session::put('selcteditems', $selcteditems);
                Session::put('number_of_items',$number_of_items );

            }
        }
        return redirect('cart');

    }
    public function AddToCart(Request $request)
    {
        /*
            add item in cart array in not exist or increment quantity existing item in cart array 
            and increment number of items in cart
        */
        $id=$request['name'];
        $number_of_items = Session::has('number_of_items') ? Session::get('number_of_items') : 0;
        $selcteditems = Session::has('selcteditems') ? Session::get('selcteditems') : array();
        $found=false;
        $item = \App\item::findorfail($id);
        if($item->quantity<=0)
            {
                $message='No enough items available';
                return response()->json(['message'=>$message]);
            }
        foreach($selcteditems as $selcteditem)
        {
            if($selcteditem->item->id == $id)
            {
                if($item->quantity<$selcteditem->Quantity+0.5)
                {
                    $message='No enough items available';
                    return response()->json(['message'=>$message]);
                }
                else
                {
                    $selcteditem->Quantity+=0.5;
                    $found=true;
                }
            }
        }
        if($found==false)
        {
            $item = new selectedItem($id);
            array_push($selcteditems,$item);
        }
    
    $number_of_items+=0.5;
    Session::put('number_of_items',$number_of_items );
    Session::put('selcteditems',$selcteditems);

    return response()->json(['countCart'=>$number_of_items]);

    }
    public function decrementItem(Request $request)
    {
        /*
           dencrement quantity existing item in cart array 
            and dencrement number of items in cart
        */
        $id=$request['id'];
        $selcteditems = Session::get('selcteditems'); 
        $number_of_items = Session::has('number_of_items') ? Session::get('number_of_items') : 0;
        $totalprice=0;

        for($i=0;$i<sizeof($selcteditems);$i++)
        {
            if($selcteditems[$i]->item->id == $id && $selcteditems[$i]->Quantity > 0.5)
            {
                $number_of_items-=0.5;
                $selcteditems[$i]->Quantity-=0.5;
                $quantity=$selcteditems[$i]->Quantity;
                $item_total_price=$quantity*$selcteditems[$i]->item->price;
                Session::put('selcteditems', $selcteditems);
                Session::put('number_of_items',$number_of_items );

            }
            $totalprice+=$selcteditems[$i]->Quantity*$selcteditems[$i]->item->price;

        }
        return response()->json(['quantity'=>$quantity,
                                'item_total_price'=>$item_total_price,
                                'countCart'=>$number_of_items,
                                'totalprice'=>$totalprice]);
    }
    public function incrementItem(Request $request)
    {
         /*
           increment quantity existing item in cart array 
            and increment number of items in cart
        */
        $id=$request['id'];
        $selcteditems = Session::get('selcteditems'); 
        $number_of_items = Session::has('number_of_items') ? Session::get('number_of_items') : 0;
        $totalprice=0;
        $item = \App\item::findorfail($id);

        for($i=0;$i<sizeof($selcteditems);$i++)
        {
            if($selcteditems[$i]->item->id == $id)
            {
                if($item->quantity<$selcteditems[$i]->Quantity+0.5){
                    $message='No enough items available';
                    return response()->json(['message'=>$message]);
                }
                $number_of_items+=0.5;
                $selcteditems[$i]->Quantity+=0.5;
                $quantity=$selcteditems[$i]->Quantity;
                $item_total_price=$quantity*$selcteditems[$i]->item->price;
                Session::put('selcteditems', $selcteditems);
                Session::put('number_of_items',$number_of_items );

            }
            $totalprice+=$selcteditems[$i]->Quantity*$selcteditems[$i]->item->price;

        }
        return response()->json(['quantity'=>$quantity,
                                'item_total_price'=>$item_total_price,
                                'countCart'=>$number_of_items,
                                'totalprice'=>$totalprice]);

    }
    
}
