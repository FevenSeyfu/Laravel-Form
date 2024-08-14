<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
     // POST request to add new product
     public function store(Request $request)
     {
        $validatedData = $request->validate([
            'productName' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0.01',
        ]);
        $products = $this->getProducts();

        $newProduct = [
            'id' => uniqid(),
            'productName' => $validatedData['productName'],
            'quantity' => $validatedData['quantity'],
            'price' => $validatedData['price'],
            'dateTimeSubmitted' => now()->format('Y-m-d H:i:s'),
            'totalValue' => $validatedData['quantity'] * $validatedData['price']
        ];

        $products[] = $newProduct;
        $this->saveProducts($products);

        return redirect('/')->with('success', 'Product added successfully!');
    }
      
    // Show form and product list
    public function index(){
        $products = $this->getProducts();
        usort($products, function ($a, $b) {
            return strtotime($b['dateTimeSubmitted']) - strtotime($a['dateTimeSubmitted']);
        });
        return view('products.index', compact('products'));
    }
     // Edit product list
     public function update(Request $request, string $id){

        // Validate the data
        $validatedData = $request->validate([
            'productName' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0.01',
        ]);

        $products = $this->getProducts();

        foreach ($products as &$product) {
            if ($product['id'] == $id) {
                $product['productName'] = $validatedData['productName'];
                $product['quantity'] = $validatedData['quantity'];
                $product['price'] = $validatedData['price'];
                $product['totalValue'] = $validatedData['quantity'] * $validatedData['price'];
                break;
            }
        }
        $this->saveProducts($products);
        return redirect('/')->with('success', 'Product updated successfully!');
    }

    private function getProducts(){
        if (Storage::exists('products.json')) {
            return json_decode(Storage::get('products.json'),true);
        }
            return [];
    }

    private function saveProducts($products){
        Storage::put('products.json', json_encode($products));
    }
}
