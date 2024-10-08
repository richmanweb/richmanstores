<?php

namespace App\Http\Controllers;

use App\Models\SellerPackage;
use App\Models\SellerPackagePayment;
use Illuminate\Http\Request;

class SellerPackagePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function offline_payment_request()
    {
        $package_payment_requests = SellerPackagePayment::where('offline_payment', 1)->orderBy('id', 'desc')->paginate(10);
        return view('backend.manual_payment_methods.seller_package_payment_request', compact('package_payment_requests'));
    }

    public function offline_payment_approval($id)
    {
        $package_payment    = SellerPackagePayment::findOrFail($id);
        $package_details    = SellerPackage::findOrFail($package_payment->seller_package_id);
        $package_payment->approval      = 1;
        if ($package_payment->save()) {
            $seller                                 = $package_payment->user->shop;
            $seller->seller_package_id              = $package_payment->seller_package_id;
            $seller->product_upload_limit           = $package_details->product_upload_limit;
            $seller->commission                     = $package_details->commission;
            $seller->package_invalid_at             = date('Y-m-d', strtotime($seller->package_invalid_at . ' +' . $package_details->duration . 'days'));
            if ($seller->save()) {
                flash(translate('Offline Seller Package Payment approved successfully.'))->success();
                return back();
            }
        }
        flash(translate('Something went wrong'))->error();
        return back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
