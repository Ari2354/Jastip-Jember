 src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" 

    function initMap() {
        // Inisialisasi peta
        const map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: -7.123456, lng: 113.123456 },
            zoom: 15,
        });
    }

    // Contoh kode untuk memulai transaksi
const snap = require('midtrans-client');

let snapClient = new snap.Snap({
    isProduction: false,
    serverKey: 'YOUR_SERVER_KEY',
    clientKey: 'YOUR_CLIENT_KEY'
});

// Buat transaksi
let parameter = {
    "transaction_details": {
        "order_id": "order-id-123",
        "gross_amount": 10000
    },
    "credit_card": {
        "secure": true
    }
};

snapClient.createTransaction(parameter)
    .then((transaction) => {
        // Dapatkan URL untuk redirect ke halaman pembayaran
        let redirectUrl = transaction.redirect_url;
        console.log(redirectUrl);
    });


