@extends('layouts.admin.app')
@section('pageTitle') Invoices @endsection
@section('content')

    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">
                <!--begin::Layout-->
                <form action="{{ route('user.createinvoice') }}" method="POST" >
                    @csrf
                    <div class="d-flex flex-column flex-lg-row">
                        <!--begin::Content-->
                        <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-9">
                            <!--begin::Card-->
                            <div class="card">
                                <!--begin::Card body-->
                                <div class="card-body p-12">
                                    <!--begin::Form-->
                                    <form action="" method="POST" id="kt_invoice_form">
                                        <!--begin::Wrapper-->
                                        <div class="d-flex flex-column align-items-start flex-xxl-row">

                                            <!--begin::Input group-->
                                            <div class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4" data-bs-toggle="tooltip" data-bs-trigger="hover" title="Enter invoice number">
                                                <span class="fs-2x fw-bolder text-gray-800">Payment</span>
                                            </div>
                                            <div class="d-flex flex-center flex-equal fw-row text-nowrap order-2 order-xxl-2 me-4" data-bs-toggle="tooltip" data-bs-trigger="hover" title="Enter invoice number">
                                                <small>Please contact support for <b>Custom Quotation</b></small>
                                            </div>
                                            <!--end::Input group-->

                                        </div>
                                        <!--end::Top-->
                                        <!--begin::Separator-->
                                        <div class="separator separator-dashed my-10"></div>
                                        <!--end::Separator-->

                                        <!--begin::Input group-->
                                        <div class="d-flex align-items-center justify-content-end flex-equal order-3 fw-row" data-bs-toggle="tooltip" data-bs-trigger="hover" title="Please Select Plan">
                                            <input type="hidden" name="plan" value="financial" id="plan">
                                            <div  class="radio-group row justify-content-between px-3 text-center a">
                                                <div data-plan="starter" class="col-auto mr-sm-2 mx-1 card-block  py-0 text-center radio  ">
                                                    <div class="flex-row">
                                                        <div class="col">
                                                            <h3 class="plan-heading">Starter</h3>
                                                            <div class="pic"> <img class="irc_mut img-fluid" src="{{asset('images/plan.png')}}" width="100" height="100"> </div>
                                                            <p>$150 / Single PR</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div data-plan="financial" class="col-auto ml-sm-2 mx-1 card-block  py-0 text-center radio selected ">
                                                    <div class="flex-row">
                                                        <div class="col">
                                                            <h3 class="plan-heading">Financial</h3>
                                                            <div class="pic"> <img class="irc_mut img-fluid" src="{{asset('images/plan.png')}}" width="100" height="100"> </div>
                                                            <p>$399 / Single PR</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Input group-->

                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end::Content-->
                        <!--begin::Sidebar-->
                        <div class="flex-lg-auto min-w-lg-300px">
                            <!--begin::Card-->
                            <div class="card" data-kt-sticky="true" data-kt-sticky-name="invoice" data-kt-sticky-offset="{default: false, lg: '200px'}" data-kt-sticky-width="{lg: '250px', lg: '300px'}" data-kt-sticky-left="auto" data-kt-sticky-top="150px" data-kt-sticky-animation="false" data-kt-sticky-zindex="95">
                                <!--begin::Card body-->
                                <div class="card-body p-10">
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-bolder fs-6 text-gray-700">Currency</label>
                                        <!--end::Label-->
                                        <!--begin::Select-->
                                        <input type="hidden" name="currency" value="USD">
                                        <select disabled required name="currency" aria-label="Select a Timezone" data-control="select2" data-placeholder="Select currency" class="form-select form-select-solid">
                                            <option value=""></option>
                                            <option data-kt-flag="flags/united-states.svg"  selected value="USD">
                                                <b>USD</b>&#160;-&#160;USA dollar</option>
                                            <option data-kt-flag="flags/united-kingdom.svg" {{ (isset($invoice) && "GBP" == $invoice->currency)?'selected':'' }} value="GBP">
                                                <b>GBP</b>&#160;-&#160;British pound</option>
                                            <option data-kt-flag="flags/australia.svg" {{ (isset($invoice) && "AUD" == $invoice->currency)?'selected':'' }} value="AUD">
                                                <b>AUD</b>&#160;-&#160;Australian dollar</option>
                                            <option data-kt-flag="flags/japan.svg" {{ (isset($invoice) && "JPY" == $invoice->currency)?'selected':'' }} value="JPY">
                                                <b>JPY</b>&#160;-&#160;Japanese yen</option>
                                            <option data-kt-flag="flags/sweden.svg" {{ (isset($invoice) && "SEK" == $invoice->currency)?'selected':'' }} value="SEK">
                                                <b>SEK</b>&#160;-&#160;Swedish krona</option>
                                            <option data-kt-flag="flags/canada.svg" {{ (isset($invoice) && "CAD" == $invoice->currency)?'selected':'' }} value="CAD">
                                                <b>CAD</b>&#160;-&#160;Canadian dollar</option>
                                            <option data-kt-flag="flags/switzerland.svg" {{ (isset($invoice) && "CHF" == $invoice->currency)?'selected':'' }} value="CHF">
                                                <b>CHF</b>&#160;-&#160;Swiss franc</option>
                                        </select>
                                        <!--end::Select-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Separator-->
                                    {{--                            <div class="separator separator-dashed mb-8"></div>--}}
                                    <!--end::Separator-->
                                    <!--begin::Input group-->
                                    {{--                            <div class="mb-8">--}}
                                    {{--                                <!--begin::Option-->--}}
                                    {{--                                <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack mb-5">--}}
                                    {{--                                    <span class="form-check-label ms-0 fw-bolder fs-6 text-gray-700">Payment method</span>--}}
                                    {{--                                    <input class="form-check-input" type="checkbox" checked="checked" value="" />--}}
                                    {{--                                </label>--}}
                                    {{--                                <!--end::Option-->--}}
                                    {{--                                <!--begin::Option-->--}}
                                    {{--                                <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack mb-5">--}}
                                    {{--                                    <span class="form-check-label ms-0 fw-bolder fs-6 text-gray-700">Late fees</span>--}}
                                    {{--                                    <input class="form-check-input" type="checkbox" value="" />--}}
                                    {{--                                </label>--}}
                                    {{--                                <!--end::Option-->--}}
                                    {{--                                <!--begin::Option-->--}}
                                    {{--                                <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">--}}
                                    {{--                                    <span class="form-check-label ms-0 fw-bolder fs-6 text-gray-700">Notes</span>--}}
                                    {{--                                    <input class="form-check-input" type="checkbox" value="" />--}}
                                    {{--                                </label>--}}
                                    {{--                                <!--end::Option-->--}}
                                    {{--                            </div>--}}
                                    <!--end::Input group-->
                                    <!--begin::Separator-->
                                    <div class="separator separator-dashed mb-8"></div>
                                    <!--end::Separator-->
                                    <!--begin::Actions-->
                                    <div class="mb-0">
                                        <!--begin::Row-->
                                        {{--                                <div class="row mb-5">--}}
                                        {{--                                    <!--begin::Col-->--}}
                                        {{--                                    <div class="col">--}}
                                        {{--                                        <a href="#" class="btn btn-light btn-active-light-primary w-100">Preview</a>--}}
                                        {{--                                    </div>--}}
                                        {{--                                    <!--end::Col-->--}}
                                        {{--                                    <!--begin::Col-->--}}
                                        {{--                                    <div class="col">--}}
                                        {{--                                        <a href="#" class="btn btn-light btn-active-light-primary w-100">Download</a>--}}
                                        {{--                                    </div>--}}
                                        {{--                                    <!--end::Col-->--}}
                                        {{--                                </div>--}}
                                        <!--end::Row-->

                                        <input type="submit" name="pay" value="Pay Now" class="btn btn-primary w-100 mb-5">

                                        <input type="submit" name="pay" value="Pay Later" class="btn btn-warning w-100 mb-5">
                                    </div>
                                    <!--end::Actions-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end::Sidebar-->

                    </div>
                </form>
                <!--end::Layout-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Content-->
@endsection
@section('script')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
    <script type="text/javascript" src="{{asset('js/create.js')}}"></script>
    <style>
        .card-block {
            width: 200px;
            border: 1px solid lightgrey;
            border-radius: 5px !important;
            background-color: #FAFAFA;
            margin-bottom: 30px;
        }


        .cursor-pointer {
            cursor: pointer;
            color: #42A5F5;
        }

        .plan-heading{
            margin-top: 10px;
        }
        .pic {
            margin-bottom: 20px;
        }


        .radio {
            display: inline-block;
            border-radius: 0;
            box-sizing: border-box;
            cursor: pointer;
            color: #000;
            font-weight: 500;
            -webkit-filter: grayscale(100%);
            -moz-filter: grayscale(100%);
            -o-filter: grayscale(100%);
            -ms-filter: grayscale(100%);
            filter: grayscale(100%);
        }


        .radio:hover {
            box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.1);
        }

        .radio.selected {
            box-shadow: 0px 8px 16px 0px #EEEEEE;
            -webkit-filter: grayscale(0%);
            -moz-filter: grayscale(0%);
            -o-filter: grayscale(0%);
            -ms-filter: grayscale(0%);
            filter: grayscale(0%);
        }

        .selected {
            background-color: #E0F2F1;
        }

        .a {
            justify-content: center !important;
        }


        .btn {
            border-radius: 0px;
        }

        .btn,
        .btn:focus,
        .btn:active {
            outline: none !important;
            box-shadow: none !important;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('.radio-group .radio').click(function () {
                $('.selected .fa').removeClass('fa-check');
                $('.radio').removeClass('selected');
                $(this).addClass('selected');
                $('#plan').val($(this).attr("data-plan"));
            });
            swal("Alert","Please purchase press release credit to publish your press release!");
        });

    </script>

@endsection
