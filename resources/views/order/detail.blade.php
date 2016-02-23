<div class="right-content mdl-shadow--2dp" ng-controller="DetailViewController" ng-class="{'open':layout.opened}" right-layout>
    <div class="right-content__head">
        <div class="right-content__head--close">
            <i class="material-icons" ng-click="layout.close();">clear</i>
        </div>
        <div class="right-content__head--title">
            <p><% currentItem.order_number %></p>
            <p class="small">Status: <% currentItem.status %></p>
        </div>

        <div class="mdl-layout-spacer"></div>
        <div class="right-content__head--menu">
            <button id="right-content-menu" class="mdl-button mdl-js-button mdl-button--icon">
                <i class="material-icons">more_vert</i>
            </button>
            <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="right-content-menu">
                <li class="mdl-menu__item">Some Action</li>
                <li class="mdl-menu__item">Another Action</li>
                <li disabled class="mdl-menu__item">Disabled Action</li>
                <li class="mdl-menu__item">Yet Another Action</li>
            </ul>
        </div>
    </div>
    <div class="mdl-accordion mdl-js-accordion">
        <div class="mdl-accordion__tab-bar">
            <a href="#panel-sales-order" class="mdl-accordion__tab is-active"><i class="material-icons">assignment</i>Sales Order</a>
        </div>

        <div class="mdl-accordion__panel is-active" id="panel-sales-order">
            <div class="list-items">

                <div class="list-items_item" ng-repeat="item in currentItem.order_items">
                    <div class="list-items_item--image">
                        <img src="/assets/images/products/octowand.jpg" alt="" />
                        <span class="count"><% item.quantity | number : 0 %></span>
                    </div>
                    <div class="list-items_item--title">
                        <p class="name"><% item.sku %></p>
                        <p class="sku">SKU: <% item.sku %></p>
                    </div>
                    <div class="list-items_item--price">$<% item.price | number : 2 %></div>
                </div>
            </div>
            <div class="totals">
                <div class="totals__item">
                    <div class="totals__item-title">
                        <p>Subtotal</p>
                        <span></span>
                    </div>
                    <div class="totals__item-total">$<% currentItem.payment.subtotal | number : 2 %></div>
                </div>
                <div class="totals__item">
                    <div class="totals__item-title">
                        <p>Discount</p>
                        <span><% currentItem.coupon_code %></span>
                    </div>
                    <div class="totals__item-total">-$<% currentItem.payment.discount_amount | number : 2 %></div>
                </div>
                <div class="totals__item">
                    <div class="totals__item-title">
                        <p>Shipping</p>
                        <span>Expedited 2 Bussiness Days</span>
                    </div>
                    <div class="totals__item-total">$<% currentItem.payment.shipping_amount | number : 2 %></div>
                </div>
                <div class="totals__item">
                    <div class="totals__item-title">
                        <p>Tax</p>
                        <span>CA Tax Classes</span>
                    </div>
                    <div class="totals__item-total">$<% currentItem.payment.tax_amount | number : 2 %></div>
                </div>
                <div class="totals__item">
                    <div class="totals__item-title">
                        <p>Grand Total</p>
                        <span></span>
                    </div>
                    <div class="totals__item-total">$<% currentItem.payment.grand_total | number : 2 %></div>
                </div>
            </div>
        </div>

        <div class="mdl-accordion__tab-bar">
            <a href="#panel-customer" class="mdl-accordion__tab"><i class="material-icons">person</i>Customer</a>
        </div>

        <div class="mdl-accordion__panel" id="panel-customer">
            <div class="info-block">
                <div class="info-block__line">
                    <div class="info-block__field">
                        <div class="info-block__field--label">Last Name</div>
                        <div class="info-block__field--value"><% currentItem.billing_address.lastname %></div>
                    </div>
                    <div class="info-block__field">
                        <div class="info-block__field--label">First Name</div>
                        <div class="info-block__field--value"><% currentItem.billing_address.firstname %></div>
                    </div>
                </div>
                <div class="info-block__line">
                    <div class="info-block__field">
                        <div class="info-block__field--label">Email</div>
                        <div class="info-block__field--value"><% currentItem.billing_address.email %></div>
                    </div>
                </div>
                <div class="info-block__line">
                    <div class="info-block__field">
                        <div class="info-block__field--label">Phone</div>
                        <div class="info-block__field--value"><% currentItem.billing_address.phone %></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mdl-accordion__tab-bar">
            <a href="#panel-shipments" class="mdl-accordion__tab"><i class="material-icons">local_airport</i>Shipments</a>
        </div>

        <div class="mdl-accordion__panel" id="panel-shipments">
            <div class="info-block">
                <div class="info-block__line">
                    <div class="info-block__field wide">
                        <div class="info-block__field--label">Ship To</div>
                        <div class="info-block__field--value">
                            <% currentItem.shipping_address.firstname %> <% currentItem.shipping_address.lastname %>,<br/>
                            <% currentItem.shipping_address.address_1 %>
                                <br /><% currentItem.shipping_address.city %>, <% currentItem.shipping_address.state %> <% currentItem.shipping_address.country %> <% currentItem.shipping_address.zipcode %>
                        </div>
                    </div>
                </div>
                <div class="info-block__line">
                    <div class="info-block__field wide">
                        <div class="info-block__field--label">Tracking No</div>
                        <div class="info-block__field--value">9400 1000 00000 0000 00</div>
                    </div>
                </div>
                <div class="info-block__line">
                    <div class="info-block__field wide">
                        <div class="info-block__field--label">Carrier service</div>
                        <div class="info-block__field--value">UPS Standard</div>
                    </div>
                </div>
                <div class="info-block__line">
                    <div class="info-block__field wide">
                        <div class="info-block__field--label">Shipping Type</div>
                        <div class="info-block__field--value">Standard 5-7 days</div>
                    </div>
                </div>
                <div class="info-block__line">
                    <div class="info-block__field">
                        <div class="info-block__field--label">Items</div>
                        <div class="info-block__field--value wide products">
                            <div class="info-block__field--product" id="products-tt-<% $index %>" ng-repeat="item in currentItem.order_items track by $index" onFinishRender>
                                <img src="/assets/images/products/octowand.jpg" alt="" />
                                <span class="count"><% item.quantity | number : 0 %></span>
                            </div>
                            <div class="mdl-tooltip mdl-tooltip--right mdl-tooltip--top mdl-tooltip--large" for="products-tt-">
                                Item <br/>Sku: sku
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mdl-accordion__tab-bar">
            <a href="#panel-payments" class="mdl-accordion__tab"><i class="material-icons">credit_card</i>Payments</a>
        </div>

        <div class="mdl-accordion__panel" id="panel-payments">
            <div class="info-block">
                <div class="info-block__line">
                    <div class="info-block__field wide">
                        <div class="info-block__field--label">Bill To</div>
                        <div class="info-block__field--value">

                            <% currentItem.billing_address.address_1 %>
                            <br /><% currentItem.billing_address.city %>, <% currentItem.billing_address.state %> <% currentItem.billing_address.country %> <% currentItem.billing_address.zipcode %>
                        </div>
                    </div>
                </div>
                <div class="info-block__line">
                    <div class="info-block__field wide">
                        <div class="info-block__field--label">Credit card</div>
                        <div class="info-block__field--value">0000 0000 0000 0000</div>
                    </div>
                </div>
                <div class="info-block__line">
                    <div class="info-block__field">
                        <div class="info-block__field--label">Pay Method</div>
                        <div class="info-block__field--value cards wide">
                            <% currentItem.payment.payment_method %>
                            <!-- <img src="/assets/images/payment/mc.png" alt="" />
                            <img src="/assets/images/payment/visa.png" alt="" />
                            <img src="/assets/images/payment/ae.png" alt="" />
                            <img src="/assets/images/payment/dc.png" alt="" />
                            <img src="/assets/images/payment/pp.png" alt="" /> -->
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="mdl-accordion__tab-bar">
            <a href="#panel-communications" class="mdl-accordion__tab"><i class="material-icons">comment</i>Communications</a>
        </div>

        <div class="mdl-accordion__panel" id="panel-communications">
            <div class="info-block">
                <div class="info-block__line">
                    <div class="info-block__field">
                        <div class="info-block__field--label">Internal</div>
                        <div class="info-block__field--value">Type here</div>
                    </div>
                </div>
                <div class="info-block__line">
                    <div class="info-block__field">
                        <div class="info-block__field--label">External</div>
                        <div class="info-block__field--value">Type here</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mdl-accordion__tab-bar">
            <a href="#panel-audit-trail" class="mdl-accordion__tab"><i class="material-icons">history</i>Audit Trail</a>
        </div>

        <div class="mdl-accordion__panel" id="panel-audit-trail">
            <div class="order-history">
                <div class="order-history__item">
                    <div class="order-history__item--icon">
                        <i class="material-icons">account_circle</i>
                    </div>
                    <div class="order-history__item--info">
                        <p class="date"><i class="material-icons">alarm</i> 02/22/2016 08:48am</p>
                        <p class="text">System - order was shipped</p>
                    </div>
                </div>
                <div class="order-history__item">
                    <div class="order-history__item--icon">
                        <i class="material-icons">account_circle</i>
                    </div>
                    <div class="order-history__item--info">
                        <p class="date"><i class="material-icons">alarm</i> 02/22/2016 10:48am</p>
                        <p class="text">Johm Doe - Requested for a refund, order was shipped back to station</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>