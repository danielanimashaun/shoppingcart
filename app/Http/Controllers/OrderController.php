<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Repositories\OrderRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Session;

class OrderController extends AppBaseController
{
    private $orderRepository;

    public function __construct(OrderRepository $orderRepo)
    {
        $this->orderRepository = $orderRepo;
    }

    public function index(Request $request)
    {
        $orders = $this->orderRepository->all();

        return view('orders.index')->with('orders', $orders);
    }

    public function checkout()
    {
        if (Session::has('cart')) {
            $cart = Session::get('cart');
            $lineitems = array();

            foreach ($cart as $productid => $qty) {
                $lineitem['product'] = \App\Models\Product::find($productid);
                $lineitem['qty'] = $qty;
                $lineitems[] = $lineitem;
            }

            return view('orders.checkout')->with('lineitems', $lineitems);
        } else {
            Flash::error('There are no items in your cart');

            return redirect(route('products.displaygrid'));
        }
    }

    public function placeorder(Request $request)
    {
        $productids = $request->productid;
        $quantities = $request->quantity;

        for ($i = 0; $i < sizeof($productids); $i++) {
            $order = new \App\Models\Order();
            $order->product_id = $productids[$i];
            $order->quantity = $quantities[$i];
            $order->save();
        }

        Session::forget('cart');

        Flash::success('Your Order has Been Placed');

        return redirect(route('products.displaygrid'));
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(CreateOrderRequest $request)
    {
        $input = $request->all();

        $order = $this->orderRepository->create($input);

        Flash::success('Order saved successfully.');

        return redirect(route('orders.index'));
    }

    public function show($id)
    {
        $order = $this->orderRepository->find($id);

        if (empty($order)) {
            Flash::error('Order not found');

            return redirect(route('orders.index'));
        }

        return view('orders.show')->with('order', $order);
    }

    public function edit($id)
    {
        $order = $this->orderRepository->find($id);

        if (empty($order)) {
            Flash::error('Order not found');

            return redirect(route('orders.index'));
        }

        return view('orders.edit')->with('order', $order);
    }

    public function update($id, UpdateOrderRequest $request)
    {
        $order = $this->orderRepository->find($id);

        if (empty($order)) {
            Flash::error('Order not found');

            return redirect(route('orders.index'));
        }

        $order = $this->orderRepository->update($request->all(), $id);

        Flash::success('Order updated successfully.');

        return redirect(route('orders.index'));
    }

    public function destroy($id)
    {
        $order = $this->orderRepository->find($id);

        if (empty($order)) {
            Flash::error('Order not found');

            return redirect(route('orders.index'));
        }

        $this->orderRepository->delete($id);

        Flash::success('Order deleted successfully.');

        return redirect(route('orders.index'));
    }
}