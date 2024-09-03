document.addEventListener('DOMContentLoaded', function() {
    const deliveryBtn = document.getElementById('delivery-btn');
    const pickupBtn = document.getElementById('pickup-btn');
    const deliveryAddressSection = document.getElementById('delivery-address');
    const proceedToPaymentBtn = document.getElementById('proceed-to-payment-btn');
    const paymentSection = document.getElementById('payment-section');

    // When "Delivery" is clicked, show the address section
    deliveryBtn.addEventListener('click', function() {
        deliveryAddressSection.style.display = 'block';
        paymentSection.style.display = 'none';
    });

    // When "Pickup" is clicked, proceed directly to payment
    pickupBtn.addEventListener('click', function() {
        deliveryAddressSection.style.display = 'none';
        paymentSection.style.display = 'block';
    });

    // When "Proceed to Payment" is clicked, show the payment section
    proceedToPaymentBtn.addEventListener('click', function() {
        paymentSection.style.display = 'block';
    });
});
