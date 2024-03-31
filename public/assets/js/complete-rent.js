document.addEventListener('DOMContentLoaded', function() {
    let completeButtons = document.querySelectorAll('.btn-complete');

    completeButtons.forEach(button => {
        button.addEventListener('click', function() {
            let rentTransactionId = button.dataset.rentTransactionId;
            let totalPrice = button.dataset.totalPrice;
            let actualReturnDate = new Date().toISOString(); // Current timestamp

            fetch('penyewaan-poktan', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    rent_transaction_id: rentTransactionId,
                    total_price: totalPrice,
                    actual_return_date: actualReturnDate
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data.message); // Log the response from the server
                // Optionally, you can perform other actions here, such as updating the UI
            })
            .catch(error => {
                console.error('Error:', error);
                // Handle errors here
            });
        });
    });
});
