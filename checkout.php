<?php include("includes/config.php"); ?>

<!-- RWS Header Starts -->

<?php include("application/gtheader.php"); ?>

<!-- RWS Header Starts -->        



<!-- RWS Dashboard Starts -->

<div class="container rws-contentgap">

	<h1 style="margin-top:0;">Checkout</h1>

    

    <div class="row">                        <div class="col-md-12 col-sm-12 col-xs-12">                            <form action="#">                                <div class="table-content table-responsive">                                    <table>                                        <thead>                                            <tr>                                                <th class="product-thumbnail">Image</th>                                                <th class="product-name">Product</th>                                                <th class="product-price">Price</th>                                                <th class="product-quantity">Quantity</th>                                                <th class="product-subtotal">Total</th>                                                <th class="product-remove">Remove</th>                                            </tr>                                        </thead>                                        <tbody>                                            <tr>                                                <td class="product-thumbnail"><a href="#"><img src="images/idea-picture.jpg" alt="" style="max-width:100px;"></a></td>                                                <td class="product-name"><a href="#">Gravida et mattis</a></td>                                                <td class="product-price"><span class="amount">$89.00</span></td>                                                <td class="product-quantity"><input value="1" type="number"></td>                                                <td class="product-subtotal">$89.00</td>                                                <td class="product-remove"><a href="#"><i class="fa fa-times"></i></a></td>                                            </tr>                                            <tr>                                                <td class="product-thumbnail"><a href="#"><img src="images/idea-picture.jpg" alt="" style="max-width:100px;"></a></td>                                                <td class="product-name"><a href="#">convallis intertdum</a></td>                                                <td class="product-price"><span class="amount">$300.00</span></td>                                                <td class="product-quantity"><input value="1" type="number"></td>                                                <td class="product-subtotal">$300.00</td>                                                <td class="product-remove"><a href="#"><i class="fa fa-times"></i></a></td>                                            </tr>                                        </tbody>                                    </table>                                </div>                                <div class="row">                                    <div class="col-md-8 col-sm-7 col-xs-12">                                        <div class="buttons-cart">                                            <input value="Update Cart" type="submit">                                            <a href="#">Continue Shopping</a>                                        </div>                                        <div class="coupon">                                            <h3>Coupon</h3>                                            <p>Enter your coupon code if you have one.</p>                                            <input placeholder="Coupon code" type="text">                                            <input value="Apply Coupon" type="submit">                                        </div>                                    </div>                                    <div class="col-md-4 col-sm-5 col-xs-12">                                        <div class="cart_totals">                                            <h2>Cart Totals</h2>                                            <table width="100%">                                                <tbody>                                                    <tr class="cart-subtotal">                                                        <th>Subtotal</th>                                                        <td><span class="amount">$389.00</span></td>                                                    </tr>                                                    <tr class="order-total">                                                        <th>Total</th>                                                        <td>                                                            <strong><span class="amount">$389.00</span></strong>                                                        </td>                                                    </tr>                                                </tbody>                                            </table>                                            <div class="wc-proceed-to-checkout">                                                <a href="#">Proceed to Checkout</a>                                            </div>                                        </div>                                    </div>                                </div>                            </form>                        </div>                    </div>    

    

</div>

<!-- RWS Dashboard Starts -->        



<!-- RWS Footer Starts -->

<?php include("application/gtfooter.php"); ?>

<!-- RWS Footer Starts --> 