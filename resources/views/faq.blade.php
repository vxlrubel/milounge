@extends('layouts.app')

@section('title') FAQs @endsection

@push('style')
    <link rel="stylesheet" href="/assets/css/link-more.css"/>
@endpush
@section('content')
    <!--Faq Section Start-->
    <section class="faq-section text-start">
        <div class="container">
            <div class="faq-all-content">
                <div class="row">
                    <div class="col-md-10 m-auto text-center">
                        <div class="refund-policy-header faq-header">
                            <h1>FAQs</h1>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="faq-question-content">
                            <div class="faq-content-header">
                                <h1><span><i class="fa-solid fa-caret-right"></i></span>I’ve got a problem with a current order</h1>
                                <h4>How do I change the delivery address for my order?</h4>
                            </div>
                            <div class="faq-question-details">
                                <p>Once you’ve placed your order with us, and it’s been accepted by the restaurant, you won’t be able to change the delivery address on your order. This is because a courier may have already been assigned.</p>
                                <p>You can try calling us directly, You also have the option to cancel your order and order again with the correct delivery address – but please bear in mind that you could be charged an amount up to the full order value when canceling.</p>
                                <div>
                                    <h4>I have not received an order confirmation email</h4>
                                    <ul>
                                        <li>Please check your spam box or spam filter rule and</li>
                                        <li>Allow or permit “orderreceipts@redmango.online” email address in your spam filter rule (i.e. outlook.com)</li>
                                        <li>You can also download a copy of your receipt from “My Orders” -> “View Orders”</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="faq-question-content">
                            <div class="faq-content-header">
                                <h1><span><i class="fa-solid fa-caret-right"></i></span>I've had an issue while ordering</h1>
                                <h4>What should I do if I’ve accidentally ordered twice?</h4>
                            </div>
                            <div class="faq-question-details">
                                <p>If your order is for delivery or collection, you’ll need to cancel either one of your orders as soon as possible. To do this, please call us asap , also sent an email to refund@redmango.online providing order id and restaurant or takeaway business name.</p>
                                <div>
                                    <h4>What happens if my payment fails?</h4>
                                    <p>Payments can fail for all kinds of reasons, but here are a few things worth double-checking:</p>
                                    <ul>
                                        <li>Make sure you typed in the card details correctly (we’ve all done it)</li>
                                        <li>Check your card hasn’t expired (again, we’ve all been there)</li>
                                        <li>See if you entered the right billing address (especially if it’s different to your delivery address)</li>
                                    </ul>
                                </div>
                                <p>If none of the above works, there may be the option to pay for your order with cash. It could also be worth contacting your bank to check your available balance or to see if the issue lies at their end.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="faq-question-content">
                            <div class="faq-content-header">
                                <h1><span><i class="fa-solid fa-caret-right"></i></span>Payment Processing</h1>
                                <h4>Do you store Payment information?</h4>
                            </div>
                            <div class="faq-question-details">
                                <p>No, we don’t store any CARD or payment information. Our payment processing partner</p>
                                <ul>
                                    <li>Cardstream <a href="https://cardstream.com/" target="_blank">(https://cardstream.com/)</a></li>
                                    <li>EVO payments UK  <a href="https://evopayments.co.uk/" target="_blank">(https://evopayments.co.uk/)</a></li>
                                </ul>
                                <div>
                                    <h4>Why do I see “REDMANGO” as Payment references in my bank statement?</h4>
                                    <p>This website is maintained by “Redmango.online”. We use their secure payment gateway to process our online orders. This is the reason it appears as REDMANGO in your bank statement.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9 m-auto">
                        <div class="faq-footer">
                            <h1>Can't find what you are looking for?</h1>
                            <p>Please <a href="/contact-us">contact us</a> and one of our team will respond as quickly as possible.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--About Us Section End-->
@endsection

@push('script')
    <script>
        const {createApp} = Vue

        createApp({
            data() {
                return {
                    message: 'Hello Vue!',
                }
            }
        }).mount('#app')

    </script>
@endpush
