<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\DownloadableProductsModel;
use App\ProductsModel;
use App\CartModel ;
use App\OrderModel;


class ProductsController extends Controller
{

    static $OrderID = 0 ;
    /* this function is for adding products to shopping cart */
    public function add($type,$id){
       $this->$type($id) ;
        $total = $this->getTotal();
       return $total ;
    }
    /*this function is for downloadable products only */
    public function Downloadable($id){
       $data = DownloadableProductsModel::where('id',$id)->get();
        $this->AddToCart($data);


    }
    //this function is for palpable products only
    public function products($id){
       $data = ProductsModel::where('id',$id)->get();
        $this->AddToCart($data);
    }
    //this function is for adding items to cart
    public function AddToCart($data){
       $item['ProductId'] = $data['id'];
       $item['price'] = $data['price'];
        CartModel::create($item);

    }
    //this item is for creating orders
    public function CreateOrder(){
        $date['owner'] = "jone doe";
        $order = OrderModel::create($date);
        $this::$OrderID = $order['id'] ;

    }
    //this function is for calculating sum for the order
    public function getTotal(){
        $id = $this::$OrderID ;
        $total = CartModel::where('orderid',$id)->list('price')->count();
        return $total ;
    }
}
