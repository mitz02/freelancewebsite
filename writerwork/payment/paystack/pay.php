<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <script src="https://js.paystack.co/v1/inline.js"></script>
</head>
<body>
  <form id="paymentForm">
    <div class="form-group">
      <label for="email">Email Address</label>
      <input type="email" id="email-address" required />
    </div>
    <div class="form-group">
      <label for="amount">Amount</label>
      <input type="tel" id="amount" required />
    </div>
    <div class="form-group">
      <label for="first-name">First Name</label>
      <input type="text" id="first-name" />
    </div>
    <div class="form-group">
      <label for="last-name">Last Name</label>
      <input type="text" id="last-name" />
    </div>
    <div class="form-submit">
      <button type="submit" onclick="payWithPaystack(event)">Pay</button>
    </div>
  </form>

  <script>
    function generateReferenceNumber() {
      const timestamp = new Date().getTime();
      const randomDigits = Math.floor(Math.random() * 10000);
      return `${timestamp}${randomDigits}`;
    }

    var paymentForm = document.getElementById('paymentForm');
    paymentForm.addEventListener('submit', function (event) {
      event.preventDefault(); // Prevent default form submission behavior
      payWithPaystack();
    }, false);

    function payWithPaystack() {
      var amountInput = document.getElementById('amount');
      var emailInput = document.getElementById('email-address');

      // Validate amount
      var amount = parseFloat(amountInput.value);
      if (isNaN(amount) || amount <= 0) {
        alert('Please enter a valid amount.');
        return;
      }

      var handler = PaystackPop.setup({
        key: 'pk_test_27bf31c3c4f1c280976217934a3136d9189cb7b6',
        email: emailInput.value,
        amount: amount * 100,
        currency: 'NGN',
        ref: generateReferenceNumber(),
        callback: function (response) {
          var reference = response.reference;
          alert('Payment complete! Reference: ' + reference);
          // Make an AJAX call to your server with the reference to verify the transaction
        },
        onClose: function () {
          alert('Transaction was not completed, window closed.');
        },
      });

      handler.openIframe();
    }
  </script>
</body>
</html>
