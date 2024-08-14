<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
     // POST request to add new product
     public function store(Request $request)
     {
         $products = $this->getProducts();
 
         $newProduct = [
             'id' => uniqid(),
             'productName' => $request->input('productName'),
             'quantity' => $request->input('quantity'),
             'price' => $request->input('price'),
             'dateTimeSubmitted' => now()->format('Y-m-d H:i:s'),
             'totalValue' => $request->input('quantity') * $request->input('price')
         ];
 
         $products[] = $newProduct;
         $this->saveProducts($products);
         return redirect('/');
     }
      
     // Show form and product list
     public function index(){
         $products = $this->getProducts();
         return view('products.index', compact('products'));
     }

     private function getProducts(){
        if (Storage::exists('products.json')) {
            return json_decode(Storage::get('products.json'), true);
        }
        return [];
    }

     // Edit product list
     public function update(Request $request, string $id){
        $products = $this->getProducts();

        foreach ($products as &$product) {
            if ($product['id'] == $id) {
                $product['productName'] = $request->input('productName');
                $product['quantity'] = $request->input('quantity');
                $product['price'] = $request->input('price');
                $product['totalValue'] = $request->input('quantity') * $request->input('price');
                break;
            }
        }
    
        $this->saveProducts($products);
    
        return redirect('/');
    }
    private function saveProducts($products){
        Storage::put('products.json', json_encode($products));
    }
}
