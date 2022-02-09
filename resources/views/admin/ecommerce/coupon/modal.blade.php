<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Your Available Coupons</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-single-tab" data-toggle="tab" href="#nav-single" role="tab" aria-controls="nav-single" aria-selected="true">Single</a>
                        <a class="nav-item nav-link" id="nav-multiple-tab" data-toggle="tab" href="#nav-multiple" role="tab" aria-controls="nav-multiple" aria-selected="false">Multiple <span class="badge badge-success cart-counter">{{ count($customerCoupons) }}</span></a>
                        <a class="nav-item nav-link" id="nav-collectibles-tab" data-toggle="tab" href="#nav-collectibles" role="tab" aria-controls="nav-collectibles" aria-selected="false">Collectibles <span class="badge badge-success cart-counter" id="total_collectibles"></span></a>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active p-3 border border-top-0 rounded-bottom" id="nav-single" role="tabpanel" aria-labelledby="nav-single-tab">
                        <div class="table-history" style="overflow-x:auto;">
                            <table class="table table-hover small text-left overflow-auto">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col" class="align-middle text-nowrap" width="10%">
                                            <div class="form-check">&nbsp;</div>
                                        </th>
                                        <th scope="col" class="align-middle text-nowrap text-center">Name</th>
                                        <th scope="col" class="align-middle text-nowrap text-center" width="50%">Deal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($customerCoupons)
                                        @foreach($customerCoupons as $coupon)
                                            @if($coupon->details->combination == 0)
                                                <tr>
                                                    <td class="align-middle">
                                                        <div class="form-check">
                                                            <input type="hidden" id="couponcode{{$coupon->coupon_id}}" value="{{$coupon->details->coupon_code}}">
                                                            <input type="hidden" id="couponterms{{$coupon->coupon_id}}" value="{{$coupon->details->terms_and_conditions}}">
                                                            <input type="radio" name="single-options" class="cb" id="cb{{$coupon->coupon_id}}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <strong>{{$coupon->details->name}}</strong>
                                                    </td>
                                                    <td class="align-middle" width="30%">
                                                        {{$coupon->details->terms_and_conditions    }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @else
                                        <td>
                                            <div class="alert alert-warning" role="alert">
                                                No Record found
                                            </div>
                                        </td>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade p-3 border border-top-0 rounded-bottom" id="nav-multiple" role="tabpanel" aria-labelledby="nav-multiple-tab">
                        <div class="table-history" style="overflow-x:auto;">
                            <table class="table table-hover small text-left overflow-auto">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col" class="align-middle text-nowrap">Name</th>
                                        <th scope="col" class="align-middle text-nowrap text-center" width="50%">Reward</th>
                                        <th width="15%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($customerCoupons)
                                        @foreach($customerCoupons as $coupon)
                                            <tr>
                                                <input type="hidden" id="discountpercentage{{$coupon->coupon_id}}" value="{{$coupon->details->percentage}}">
                                                <input type="hidden" id="discountamount{{$coupon->coupon_id}}" value="{{$coupon->details->amount}}">
                                                <input type="hidden" id="couponcode{{$coupon->coupon_id}}" value="{{$coupon->details->coupon_code}}">
                                                <input type="hidden" id="couponterms{{$coupon->coupon_id}}" value="{{$coupon->details->description}}">
                                                <td>
                                                    <strong>{{$coupon->details->name}}</strong>
                                                </td>
                                                <td class="align-middle text-center" width="30%">
                                                    {{ $coupon->details->description }}
                                                </td>
                                                <td>
                                                    @if($coupon->details->amount_discount_type == 1)
                                                        @if (\Route::current()->getName() == 'cart.front.show')
                                                            <button type="button" id="couponBtn{{$coupon->coupon_id}}" class="btn btn-sm btn-primary" onclick="use_coupon('{{$coupon->coupon_id}}')">Use Now</button>
                                                        @else
                                                            <button type="button" id="couponBtn{{$coupon->coupon_id}}" class="btn btn-sm btn-primary" onclick="use_coupon('{{$coupon->coupon_id}}')" style="display: @if(\App\Models\CouponCart::coupon_exist($coupon->coupon_id) > 0) none @endif;">Use Now</button>
                                                            <span class="text-success" id="couponSpan{{$coupon->coupon_id}}" style="display: @if(\App\Models\CouponCart::coupon_exist($coupon->coupon_id) == 0) none @endif;">Already Use</span>
                                                        @endif
                                                        
                                                    @endif

                                                    @if($coupon->details->amount_discount_type == 2)
                                                        <button type="button" id="couponBtn{{$coupon->coupon_id}}" class="btn btn-sm btn-primary" onclick="choose_product('{{$coupon->coupon_id}}')">Use Now</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <td>
                                            <div class="alert alert-warning" role="alert">
                                                No Record found
                                            </div>
                                        </td>
                                    @endif
                                </tbody>
                            </table>
                        </div>  
                    </div>

                    <div class="tab-pane fade p-3 border border-top-0 rounded-bottom" id="nav-collectibles" role="tabpanel" aria-labelledby="nav-collectibles-tab">
                        <div class="table-history" style="overflow-x:auto;">
                            <table class="table table-hover small text-left overflow-auto">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col" class="align-middle text-nowrap text-center">Name</th>
                                        <th scope="col" class="align-middle text-nowrap text-center" width="50%">Deal</th>
                                        <th scope="col" width="15%"></th>
                                    </tr>
                                </thead>
                                <tbody id="collectibles">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalCartProduct" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Products</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tab-content" id="nav-tabContent">
                    <table class="table table-hover small text-left overflow-auto">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="align-middle text-nowrap" width="10%">
                                    <div class="form-check">&nbsp;</div>
                                </th>
                                <th scope="col" class="align-middle text-nowrap">Name</th>
                            </tr>
                        </thead>
                        <tbody id="cart_products">
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="apply_reward_to_product();">Apply</button>
            </div>
        </div>
    </div>
</div>