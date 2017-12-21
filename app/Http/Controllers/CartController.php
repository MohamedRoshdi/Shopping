<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\Order;
use App\Product;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $carts=DB::select('select * from carts ');
        $products=DB::select('select * from products ');
        $orders=DB::select('select o.id, quantity, total_price, product_name, price, cart_name
                            from orders o,products p,carts c  
                            where o.cart_id = c.id and o.product_id = p.id ');

        $data = array("carts" => $carts, "products" => $products, "orders"=>$orders);

        return view('welcome', ['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Validation
        $request->validate([
//            'cart_name' => 'required|unique:carts'

        ]);

        $data = $request->all();
        DB::table('carts')->insert(
            ['cart_name' => $data['cartName']]
        );

        // redirect
        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'cart_id' => 'required:carts'
        ]);

        //store
        $data = $request->all();
        $order = new Order;
        $order->cart_id = $data['cart_id'];
        $order->total_price = $data['price'];
        $order->product_id = $data['product_id'];
        $order->save();
        // redirect
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validation
//        $request->validate([
//            'cart_id' => 'required:carts',
//            'price' => 'required'
//        ]);

        //store
        $data=$request->all();
//        $post=Order::find($id);
//        dd(@$post);
//        $post->quantity=$data['quantity'+$id];
//        $post->total_price=$data['price']*$post->quantity;
//        $post->update();
        $total = (float)$data['price'] * $data["updateQuantity$id"];

        DB::table('orders')
            ->where('id', $id)
            ->update(['quantity' => $data["updateQuantity$id"],
                'total_price' => $total]);

        //redirect
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // *********  Function to delete one order in the Cart ****************
    public function destroy($id)
    {
        order::where('id',$id)->delete();
        return back();
    }

    // *********  Function to delete all orders in the Cart ****************
    public function emptyCart(Request $request, $id)
    {
        order::where('cart_id',$id)->delete();
        return back();
    }

    // *********  Function to delete one order in the Cart ****************
    public function deleteOrder($id = 0)
    {
        dd($id);
        order::find($id)->delete();
        return back();
    }
}
