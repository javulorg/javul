// public/js/donation.js create a new folder name js in public
function handleDonationClick(buttonId) {
    $(document).on('click', buttonId, function () {
        let donateUrl = $(this).data('url');
        console.log(donateUrl, 'donateUrl')

        $.ajax({
            url: donateUrl,
            method: 'POST',
            data:{
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                console.log(res, 'res');
                if (res && res.redirect_url) {
                    window.location.href = res.redirect_url;
                }

                // Step 2: Now send to transfer-from-unit
                // $.ajax({
                //     url: '/funds/transfer-from-unit',
                //     method: 'POST',
                //     data: {
                //         _token: $('meta[name="csrf-token"]').attr('content'),
                //         unit_id: res.unit_id,
                //         username: res.username,
                //         donate_amount: res.donate_amount,
                //         donate_to_type: res.donate_to_type
                //     },
                //     success: function (response) {
                //         console.log(response, 'responseresponse')
                //         Swal.fire({
                //             icon: 'success',
                //             title: 'Transaction Successful!',
                //             text: 'Transaction ID: ' + response.transaction_id
                //         }).then(() => {
                //             window.location.href = '/donation-list?unit=' + res.unit_id;
                //         });
                //     },
                //     error: function (xhr) {
                //         console.log(xhr)
                //         let message = 'Something went wrong.';
                //         if (xhr.responseJSON && xhr.responseJSON.errors) {
                //             message = Object.values(xhr.responseJSON.errors).join('\n');
                //         }
                //         Swal.fire({
                //             icon: 'error',
                //             title: 'Transaction Failed',
                //             text: message
                //         });
                //     }
                // });
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Unable to fetch donation data.'
                });
            }
        });
    });
}
