---
title: Donations
description: Looking to make a donation?
layout: page
backing_img: /assets/images/money_transfer__monochromatic.svg
backing_scalar: "height:90%;"
uses:
 - qrcodes
---

You probably ended up here from my GitHub page. Since I still am not 18, I can't finish signing up to [GitHub Sponsors](). Due to this, I had to get a little creative with my donations setup.

## Where does the money go?

Honestly, coffee. Although, if you send a message along with a donation containing a request, I'll use it for something else.

## Do people actually donate to you?

Yes, although not too often. Most commonly, people donate Bitcoin and Stellar to me (thank you!).

## How do I donate?

Click one of the following for instructions:

<div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
          PayPal
        </button>
      </h2>
    </div>
    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        <a href="https://paypal.me/{{site.paypal_username}}">Click here</a> to be redirected to my PayPal page.
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h2 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            Bitcoin
        </button>
      </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
    <div class="card-body">
      <p>My Bitcoin donations address is: <strong>{{site.btc_address}}</strong></p><div class="card-body">
        <div id="btcqr"></div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h2 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Stellar
        </button>
      </h2>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
        <p>My Stellar donations address is: <strong>{{site.stellar_address}}</strong></p><div class="card-body">
        <div id="stlrqr"></div>
      </div>
    </div>
  </div>
</div>