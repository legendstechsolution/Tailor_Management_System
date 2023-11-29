document.addEventListener('DOMContentLoaded', function () {


  
    // Function to hide the error toast after 2 seconds
    function hideError() {
        var toast = document.getElementById('errorToast');
        var bsToast = new bootstrap.Toast(toast);
        bsToast.hide();
    }
    const inputIds = [
      'order_quantity',
      'rate',
      'amount',
      'dtp_charges',
      'total',
      'gst_percent',
      'gst_value',
      'grant_total',
      'advance',
      'discount',
      'balance_to_pay',
      'final_amount_paid',
  ];
  
  const inputs = {};
  
  inputIds.forEach(id => {
      inputs[id] = document.getElementById(id);
      inputs[id].addEventListener('input', calculateTotal);
  });
  
  function calculateTotal() {
      // Retrieve values from input fields
      const values = {};
      for (const id in inputs) {
          values[id] = parseFloat(inputs[id].value) || 0;
      }
  
      const { order_quantity, rate, dtp_charges, gst_percent, advance, discount, final_amount_paid } = values;
  
      // Perform calculations
      const amount = order_quantity * rate;
      const overall = amount + dtp_charges;
      const gstValue = (amount * gst_percent) / 100;
      const grantTotalValue = amount + dtp_charges + gstValue - discount;
      const balanceToPayValue = grantTotalValue - advance;
  
      // Update input values
      inputs.amount.value = isNaN(amount) ? '' : amount.toFixed(2);
      inputs.total.value = isNaN(overall) ? '' : overall.toFixed(2);
      inputs.gst_value.value = isNaN(gstValue) ? '' : gstValue.toFixed(2);
      inputs.grant_total.value = isNaN(grantTotalValue) ? '' : grantTotalValue.toFixed(2);
      inputs.balance_to_pay.value = isNaN(balanceToPayValue) ? '' : balanceToPayValue.toFixed(2);
  
      // Calculate the new balance to pay based on the user's input for "final amount paid"
      const finalAmountPaidValue = parseFloat(final_amount_paid) || 0;
      const updatedBalanceToPay = balanceToPayValue - finalAmountPaidValue;
  
      // Update the "Balance to Pay" input field
      inputs.balance_to_pay.value = isNaN(updatedBalanceToPay) ? '' : updatedBalanceToPay.toFixed(2);
  }
  calculateTotal()
 

});
var myToastEl = document.getElementById('errorToast');
var bsToast = new bootstrap.Toast(myToastEl);
bsToast.show();

// Hide the error toast after 2 seconds
setTimeout(hideError, 2000);

