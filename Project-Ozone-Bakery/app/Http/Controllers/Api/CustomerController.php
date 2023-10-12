<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index() {
        $customers = Customer::get();
        return $customers;
    }

    public function store(Request $request) {
        $request->validate ([
            'name'      => 'required|min:3|max:256',
            'tel'     => 'required|string|size:10'
        ]);

        $customer = new Customer();
        $customer->name = $request->get('name');
        $customer->tel = $request->get('tel');
        $customer->save();
        $customer->refresh();
        return $customer;
    }

    public function show(Customer $customer) {
        return $customer;
    }

    public function destroy(Customer $customer) {
        $customer->delete();
        return ["message" => "delete successfully"];
    }

    public function update(Request $request, Customer $customer) {
        $request->validate ([
            'name' => 'nullable|min:3|max:256',
            'tel' => 'nullable|string|size:10'
        ]);

        if ($request->has('name')) $customer->name = $request->input('name');
        if ($request->has('tel')) $customer->tel = $request->input('tel');

        $customer->save();
        $customer->refresh();
        return $customer;
    }
}
