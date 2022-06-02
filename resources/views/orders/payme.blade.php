@extends('layouts.frontLayout.front_design')
@section('content')
<?php use App\Order; ?>

<?php
                $orderDetails = Order::getOrderDetails(Session::get('order_id'));
                $orderDetails = json_decode(json_encode($orderDetails));
?>
<div class="container" style="text-align: center; padding-top: 150px; padding-bottom: 150px;">
<body onload="Paycom.Button('#form-payme', '#button-container')">
<form id="form-payme" method="POST" action="https://checkout.paycom.uz/">
    <input type="hidden" name="merchant" value="587f72c72cac0d162c722ae2">
    <input type="hidden" name="account[order_id]" value="{{ Session::get('order_id') }}">
    <input type="hidden" name="amount" value="{{ Session::get('grand_total') }}">
    <input type="hidden" name="lang" value="uz">
    <input type="hidden" name="button" data-type="svg" value="colored">
    <div id="button-container"></div>
</form>
<!-- ... -->
<script src="https://cdn.paycom.uz/integration/js/checkout.min.js"></script>
</body>
</div>
@endsection