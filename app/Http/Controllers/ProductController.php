<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Repositories\ProductRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Session;

class ProductController extends AppBaseController
{
    private $productRepository;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepository = $productRepo;
    }

    public function index(Request $request)
    {
        $products = $this->productRepository->all();

        return view('products.index')->with('products', $products);
    }

    public function displayGrid(Request $request)
    {
        $products = \App\Models\Product::all();

        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart');

            $totalQty = 0;

            foreach ($cart as $product => $qty) {
                $totalQty = $totalQty + $qty;
            }

            $totalItems = $totalQty;
        } else {
            $totalItems = 0;
        }

        return view('products.displaygrid')
            ->with('products', $products)
            ->with('totalItems', $totalItems);
    }

    public function addToCart($id)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        Session::put('cart', $cart);

        return response()->json([
            'count' => array_sum($cart)
        ]);
    }

    public function emptycart()
    {
        if (Session::has('cart')) {
            Session::forget('cart');
        }

        return response()->json(['success' => true], 200);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(CreateProductRequest $request)
    {
        $input = $request->all();

        $product = $this->productRepository->create($input);

        Flash::success('Product saved successfully.');

        return redirect(route('products.index'));
    }

    public function show($id)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Flash::error('Product not found');

            return redirect(route('products.index'));
        }

        return view('products.show')->with('product', $product);
    }

    public function edit($id)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Flash::error('Product not found');

            return redirect(route('products.index'));
        }

        return view('products.edit')->with('product', $product);
    }

    public function update($id, UpdateProductRequest $request)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Flash::error('Product not found');

            return redirect(route('products.index'));
        }

        $product = $this->productRepository->update($request->all(), $id);

        Flash::success('Product updated successfully.');

        return redirect(route('products.index'));
    }

    public function destroy($id)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Flash::error('Product not found');

            return redirect(route('products.index'));
        }

        $this->productRepository->delete($id);

        Flash::success('Product deleted successfully.');

        return redirect(route('products.index'));
    }
}