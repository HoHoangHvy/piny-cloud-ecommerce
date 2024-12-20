<template>
    <div>
        <button @click="openPopup">Open Payment Popup</button>
        <div id="payos-popup"></div> <!-- This div will contain the iframe -->
    </div>
</template>

<script setup>

const getCheckoutUrl = async (orderId) => {
    try {
        const response = await axios.post('/api/create-payment-link', {
            order_id: orderId,
        });
        let payOSConfig = new PayOSConfig({
            RETURN_URL: "https://yourwebsite.com/payment-success",
            ELEMENT_ID: "payos-popup",
            CHECKOUT_URL: response.data.checkoutUrl,
            embedded: false,
            onSuccess: (event) => {
                console.log("Payment successful:", event);
            },
            onCancel: (event) => {
                console.log("Payment cancelled:", event);
            },
            onExit: (event) => {
                console.log("Popup closed:", event);
            },
        });
        return response.data.checkoutUrl;
    } catch (error) {
        console.error('Error fetching checkout URL:', error);
    }
}
// Initialize PayOSConfig


// Initialize PayOS popup
const {open, exit} = PayOSCheckout.usePayOS(payOSConfig);

// Method to open the popup
const openPopup = () => {
    open();
};
</script>
