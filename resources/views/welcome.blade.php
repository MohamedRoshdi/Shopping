<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ShoppingCart</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .product{
                position: relative;
                text-align: center;
            }
            .product img{
                height: 250px;
                width: 100%;
            }
            .product p{
                font-size: 20px;
            }
            .product button{
                margin: 5px auto;
                display: block;
            }
            .sale{
                width: 100px;
                position: relative;
                top: -250px;
                float: right;
            }
            .deleteAll{

            }
        </style>

    </head>
    <body>
        <div class="container">
            <h3 class="content">Welcom To Shopping Carts</h3>
            <p data-placement="top" data-toggle="tooltip" title="Create"><button class="btn btn-primary " data-title="Create" data-toggle="modal" data-target="#create" >Create New Cart</button></p>
            {{-- **************** Carts ****************** --}}
            @forelse($data['carts'] as $cart)
                <div class="alert alert-info">
                    <span>{{$cart->cart_name}}</span>
                    <form style="top: -25px; position: relative" action="{{route('emptyCart',['cart_id'=>$cart->id])}}" method="POST">
                        {{csrf_field()}}
                        <button type="submit" class="deleteAll btn btn-danger pull-right">Empty All</button>
                    </form>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="mytable" class="table table-bordred table-striped">
                                <thead>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Edit</th>
                                <th>Delete</th>
                                </thead>
                                <tbody>
                                @foreach($data['orders'] as $order)
                                    @if($order->cart_name == $cart->cart_name)
                                        <tr>
                                            <td>{{$order->product_name}}</td>
                                            <td>$ {{$order->price}}</td>
                                            <td>{{$order->quantity}}</td>
                                            <td>$ {{$order->total_price}}</td>

                                            <td><p data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit{{$order->id}}" ><span class="glyphicon glyphicon-pencil"></span></button></p></td>
                                            {{-- Update Product Quantity Model --}}
                                            <form action="{{route('home.update',['order_id'=>$order->id, 'price'=>$order->price])}}" method="POST">
                                                {{method_field('PUT')}}
                                                {{csrf_field()}}
                                                <div class="modal fade" id="edit{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                                <h4 class="modal-title custom_align" id="Heading">Edit Your Product Quantity</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <input class="form-control" type="number" name="updateQuantity{{$order->id}}" placeholder="{{$order->quantity}}">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer ">
                                                                <button type="submit" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                            </form>

                                            <form action="{{route('home.destroy',['order_id'=>$order->id])}}" method="POST">
                                                {{method_field('DELETE')}}
                                                {{csrf_field()}}
                                                <td><p data-placement="top" data-toggle="tooltip" title="Delete"><button type="submit" class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button></p></td>
                                            </form>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">NO Carts</div>
            @endforelse

            {{-- Create New Cart --}}
            <form action="{{route('home.create')}}">
                {{method_field('PUT')}}
                {{csrf_field()}}
                <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="create" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                <h4 class="modal-title custom_align" id="Heading">Create New Cart</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="cartName" placeholder="Cart Name">
                                </div>
                            </div>
                            <div class="modal-footer ">
                                <button type="submit" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span> Create</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </form>

            {{-- **************** Products ****************** --}}
            <div class="alert alert-info">Products</div>
            <div class="row">
                @forelse($data['products'] as $product)
                <div class="product thumbnail col-lg-3" >
                    <img src="images/{{$product->product_photo}}" alt="Product Image">
                    @if($product->sale > 0)
                        <div class="sale alert alert-danger">Sale: {{$product->sale}}%</div>
                    @endif
                    <div class="clearfix"></div>
                    <p>{{$product->product_name}}</p>
                    <span>$ {{$product->price}}</span>
                    @foreach($data['carts'] as $cart)
                        <form action="{{route('addProductToCart',['cart_id'=>$cart->id, 'price'=>$product->price, 'product_id'=>$product->id])}}" method="POST">
                            {{csrf_field()}}
                            <button type="submit" class="btn btn-sucess">Add To {{$cart->cart_name}}</button>
                        </form>
                    @endforeach

                </div>
                @empty
                    <div class="alert alert-info">NO Products</div>
                @endforelse
            </div>

        </div>
    </body>
</html>
