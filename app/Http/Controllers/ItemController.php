<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;


class ItemController extends Controller
{
    
    protected $items_per_page = 10;
   public function validation($request)
   {
      //validate data passed from add item view or edit item view

      $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string'],
        'quantity' => ['required', 'numeric'],
        'price' => ['required', 'numeric'],
        'cost' => ['required', 'numeric'],
        'product' => ['required', 'numeric'],
        'barcode' => ['required','string', 'max:255'],
        'img' => ['required']

  ]);

   }
   public function product($num) 
   {
       //show items has product with num choosen
       if (Auth::user() && auth()->user()->type==1)
       {
       $items = \App\item::orderBy('id', 'DESC')
                      ->where('product','=',$num)
                      ->paginate($this->items_per_page);
       }
       else{
         $items = \App\item::where('hide','=',NULL)
                  ->orderBy('id', 'DESC')
                  ->where('product','=',$num)
                  ->paginate($this->items_per_page);
          
       }
       return view('shop')->with(compact('items'));

   }
   public function welcome(){

      if (Auth::user() && auth()->user()->type==1)
      {
      $newArrivals = \App\item::orderBy('id', 'DESC')->take(4)->get();
      $items = \App\item::orderBy('id', 'DESC')->get()->slice(4, 8);
      $donation = \App\item::where('description', 'like', '%Donation%')
      ->orderBy('id', 'DESC')->get(); 
      }
      else{
        $newArrivals = \App\item::where('hide','=',NULL)->orderBy('id', 'DESC')->take(4)->get();
        $items = \App\item::where('hide','=',NULL)->orderBy('id', 'DESC')->get()->slice(4, 8);
        $donation = \App\item::where('hide','=',NULL)
              ->where('description', 'like', '%Donation%')
              ->orderBy('id', 'DESC')->get(); 
      }
      $home_images = \App\home_image::orderBy('id', 'DESC')->get();
      return view('welcome',[
        'newArrivals'=>$newArrivals,
        'items'=>$items,
        'donation'=>$donation,
        'home_images'=>$home_images,

        ]);
  

   }
   public function shop(){

    if (Auth::user() && auth()->user()->type==1)
    {
    $items = \App\item::orderBy('id', 'DESC')->paginate($this->items_per_page);
    }
    else{
      $items = \App\item::where('hide','=',NULL)->orderBy('id', 'DESC')->paginate($this->items_per_page);

    }
    return view('shop',[
      'items'=>$items
      ]);


 }
 

    public function create()
    {
      //retieve all categories and passed to add item view

        $categories = \App\category::all();

        return view('additem',[
            'categories'=>$categories
        ]);

    }


    public function store(Request $request)
    {
      //create new item in items table and create images in images table 
      $this->validation($request);
        $item = new  \App\item;
        $item->name = $request['name'];
        $item->description=$request['description'];
        $item->quantity=$request['quantity'];
        $item->price=$request['price'];
        $item->cost=$request['cost'];
        $item->barcode=$request['barcode'];
        $item->category_id=$request['category'];
        $item->product=$request['product'];
        $item->save();
    
        $item_id = $item->id;
        $files = $request->file('img');
            foreach ($files as $file){
              $name = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
             $file->move("images", $name);
             $image = new \App\image;
     
             $image->name = $name;
             $image->item_id=$item_id;
     
             $image->save();
           }
             return redirect('home');
    }

   
    public function show($id)
    {
      //retrieve show single item by id

        $item = \App\item::findorfail($id);

        return view('item',[
            'item'=>$item,
        ]);
        
    }

   
    public function edit($id)
    {
      //retieve all categories and item data to pass to edit item view

        $item = \App\item::findorfail($id);
        $categories = \App\category::all();
        return view('edititem',[
            'item'=>$item,
            'categories'=>$categories
        ]);

    }


    public function update(Request $request, $id)
    {
      //update item with new data passed

      $this->validation($request);  
        $item = \App\item::find($id);
        $item->name = $request['name'];
        $item->description=$request['description'];
        $item->quantity=$request['quantity'];
        $item->price=$request['price'];
        $item->cost=$request['cost'];
        $item->category_id=$request['category'];
        $item->barcode=$request['barcode'];
        $item->product=$request['product'];
        $item->save();
        $item_id = $item->id;
        if($files = $request->file('img')){
            foreach ($files as $file){
             $name = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
             $file->move("images", $name);
             $image = new \App\image;
             $image->name = $name;
             $image->item_id=$item_id;   
             $image->save();
           }
        }

        return redirect('home');
    }


    public function destroy($id)
    {
      //delete item with passed item

        $item = \App\item::findorfail($id);
        $item->delete();
        return redirect()->back();

    }
    public function deleteImage($id)
    {
      //delete image from images table with passed id

        $image = \App\image::find($id);
        DB::table('images')->where('id', '=', $id)->delete();
        echo $image->name;
        if(\File::exists(public_path('images/'.$image->name))){

            \File::delete(public_path('images/'.$image->name));
        
          }else{
        
           echo 'File does not exists.';
        
          }

        return redirect()->back();

    }
    
    function search(Request $request)
    {
      //search for item in items table by item name

     if($request->ajax())
     {
      $query = $request['query'];
      
      $output = '';
      
      if($query != '')
      {
     
        if (Auth::user() && auth()->user()->type==1)
        {
          $items = \App\item::where('name', 'like', '%'.$query.'%')
          ->orderBy('id', 'DESC')->get();        }
        else{
          $items = \App\item::where('hide','=',NULL)->where('name', 'like', '%'.$query.'%')
          ->orderBy('id', 'DESC')->get();
        }

         
     
      
    
   
      $total_row = $items->count();
      if($total_row > 0)
      {
       foreach($items as $item)
       {
        
         $output.='<a href="'.route("item.show",["id" => $item->id]).'"><p>'.$item->name.'</p></a>';
       }
      }
      else{
        $output.='<p>Sorry, nothing found</p>';
      }
    }
      return response()->json(['result'=>$output]);
    
     }
    }
    public function hide($id)
    {
      $item = \App\item::findorfail($id);
      if($item->hide!=1){
        $item->hide=1;
      }
      else
      {
        $item->hide=NULL;
      }
      $item->save();
      return redirect()->back();

    }
}

