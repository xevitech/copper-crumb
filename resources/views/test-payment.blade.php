<!DOCTYPE html>
<html>
<head>
    <title>Test HDFC Payment</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>HDFC Payment Test</h2>

    <form id="payment-form">
        <!-- Original fields -->
        <label>Date:</label>
        <input type="date" name="date" value="{{ date('Y-m-d') }}"><br><br>
        <label>Due Date:</label>
        <input type="date" name="due_date" value="{{ date('Y-m-d') }}"><br><br>
    
        <label>Warehouse ID:</label>
        <input type="text" name="warehouse_id" value="1"><br><br>
    
        <label>Amount:</label>
        <input type="text" name="amount" value="601"><br><br>
    
        <label>Customer ID:</label>
        <input type="text" name="customer_id" value="1"><br><br>

    
        {{-- <label>Order ID:</label>
        <input type="text" name="order_id" value="ORD{{ time() }}"><br><br> --}}
    
        <!-- Walk-in customer -->
        <h4>Walk-in Customer</h4>
        <label>Full Name:</label>
        <input type="text" name="walkin_customer[full_name]" value=""><br>
        <label>Phone:</label>
        <input type="text" name="walkin_customer[phone]" value=""><br>
        <label>Email:</label>
        <input type="text" name="walkin_customer[email]" value=""><br><br>
    
        <!-- Billing -->
        <h4>Billing</h4>
        <label>Name:</label>
        <input type="text" name="billing[name]" value="Rishabh Sharma"><br>
        <label>Email:</label>
        <input type="email" name="billing[email]" value="rishabh0123@yopmail.com"><br>
        <label>Phone:</label>
        <input type="text" name="billing[phone]" value="02656352653"><br>
        <label>Address Line 1:</label>
        <input type="text" name="billing[address_line_1]" value="mohali 5 phase"><br>
        <label>Address Line 2:</label>
        <input type="text" name="billing[address_line_2]" value=""><br>
        <label>City:</label>
        <input type="text" name="billing[city]" value="Mohali"><br>
        <label>State:</label>
        <input type="text" name="billing[state]" value="Punjab"><br>
        <label>Zip:</label>
        <input type="text" name="billing[zip]" value="DDD"><br>
        <label>Country:</label>
        <input type="text" name="billing[country]" value="India"><br><br>
    
        <!-- Shipping -->
        <h4>Shipping</h4>
        <label>Name:</label>
        <input type="text" name="shipping[name]" value="Rishabh Sharma"><br>
        <label>Email:</label>
        <input type="email" name="shipping[email]" value="rishabh0123@yopmail.com"><br>
        <label>Phone:</label>
        <input type="text" name="shipping[phone]" value="02656352653"><br>
        <label>Address Line 1:</label>
        <input type="text" name="shipping[address_line_1]" value="mohali 5 phase"><br>
        <label>Address Line 2:</label>
        <input type="text" name="shipping[address_line_2]" value=""><br>
        <label>City:</label>
        <input type="text" name="shipping[city]" value="Mohali"><br>
        <label>State:</label>
        <input type="text" name="shipping[state]" value="Punjab"><br>
        <label>Zip:</label>
        <input type="text" name="shipping[zip]" value="DDD"><br>
        <label>Country:</label>
        <input type="text" name="shipping[country]" value="India"><br><br>
    
        <!-- Payment Info -->
        <h4>Payment & Discount</h4>
        <label>Tax:</label>
        <input type="number" name="tax" value="0"><br>
        <label>Discount:</label>
        <input type="number" name="discount" value="0"><br>
        <label>Loyalty Discount:</label>
        <input type="number" name="loyalty_discount" value="0"><br>
        <label>Discount Type:</label>
        <input type="text" name="discount_type" value=""><br>
        {{-- <label>Payment Type:</label>
        <input type="text" name="payment_type" value="upi"><br> --}}
        {{-- <label>Total Paid:</label> --}}
        {{-- <input type="text" name="total_paid" value="601"><br> --}}
        {{-- <label>Table Number:</label>
        <input type="text" name="table_number" value=""><br><br> --}}
    
        <!-- Bank Info -->
        {{-- <h4>Bank Info</h4>
        <label>Account Number:</label> --}}
        {{-- <input type="text" name="bank_info[ac_no]" value=""><br>
        <label>Transaction Number:</label>
        <input type="text" name="bank_info[t_no]" value=""><br>
        <label>Date:</label>
        <input type="date" name="bank_info[date]" value="2025-04-10"><br><br> --}}
    
        <label>Notes:</label><br>
        <textarea name="notes">NOTES GOES HERE</textarea><br>
        <label>Status:</label>
        <input type="text" name="status" value=""><br><br>
    
        <!-- Items -->
        <h4>Items</h4>
        <label>Item ID:</label>
        <input type="hidden" name="items[0][id]" value="1">
        <label>Attribute ID:</label>
        <input type="text" name="items[0][attribute][id]" value="">
        <label>Attribute Name:</label>
        <input type="text" name="items[0][attribute][name]" value="">
        <label>Attribute Item ID:</label>
        <input type="text" name="items[0][attribute_item][id]" value="">
        <label>Attribute Item Name:</label>
        <input type="text" name="items[0][attribute_item][name]" value="">
        <label>Is Variant:</label>
        <input type="text" name="items[0][is_variant]" value="0">
        <label>Product ID:</label>
        <input type="text" name="items[0][product_id]" value="1">
        <label>Split Sale:</label>
        <input type="text" name="items[0][split_sale]" value="">
        <label>SKU:</label>
        <input type="text" name="items[0][sku]" value="CC00000001COF">
        <label>Name:</label>
        <input type="text" name="items[0][name]" value="Speciality Single Origin Chikmagalur Region">
        <label>Price:</label>
        <input type="text" name="items[0][price]" value="600">
        <label>Stock:</label>
        <input type="text" name="items[0][stock]" value="989">
        <label>Quantity:</label>
        <input type="text" name="items[0][quantity]" value="1">
        <label>Tax Status:</label>
        <input type="text" name="items[0][tax_status]" value="included">
        <label>Custom Tax:</label>
        <input type="text" name="items[0][custom_tax]" value="12">
        <label>Discount:</label>
        <input type="text" name="items[0][discount]" value="10">
        <label>Discount Type:</label>
        <input type="text" name="items[0][discount_type]" value="percent"><br><br>
    
        <!-- Payments -->
        <h4>Payments</h4>
        {{-- <label>Payment 1 Type:</label> --}}
        {{-- <input type="text" name="payments[0][type]" value="cash">
        <label>Payment 1 Amount:</label>
        <input type="number" name="payments[0][amount]" value="0"><br> --}}
    
        <label>Payment 2 Type:</label>
        <input type="text" name="payments[0][type]" value="online">
        <label>Payment 2 Amount:</label>
        <input type="number" name="payments[0][amount]" value="601">
        <input type="text" name="payments[0][selected]" value="true"><br>
    
        {{-- <label>Payment 3 Type:</label>
        <input type="text" name="payments[2][type]" value="card">
        <label>Payment 3 Amount:</label>
        <input type="number" name="payments[2][amount]" value="0"><br>
    
        <label>Payment 4 Type:</label>
        <input type="text" name="payments[3][type]" value="zomato">
        <label>Payment 4 Amount:</label>
        <input type="number" name="payments[3][amount]" value="0"><br>
    
        <label>Payment 5 Type:</label>
        <input type="text" name="payments[4][type]" value="dinein">
        <label>Payment 5 Amount:</label>
        <input type="number" name="payments[4][amount]" value="0"><br>
    
        <label>Payment 6 Type:</label>
        <input type="text" name="payments[5][type]" value="swiggy">
        <label>Payment 6 Amount:</label>
        <input type="number" name="payments[5][amount]" value="0"><br><br> --}}
    
        <button type="submit">Pay Now</button>
    </form>
    

    

    <script>
        $('#payment-form').on('submit', function(e) {
            e.preventDefault();

            const formData = $(this).serializeArray();
            const payload = {};

            formData.forEach(({ name, value }) => {

                if (value === 'true') value = true;
                else if (value === 'false') value = false;

                const keys = name.replace(/\]/g, '').split('[');
                let ref = payload;
                for (let i = 0; i < keys.length; i++) {
                    if (i === keys.length - 1) {
                        ref[keys[i]] = value;
                    } else {
                        ref[keys[i]] = ref[keys[i]] || (isNaN(keys[i + 1]) ? {} : []);
                        ref = ref[keys[i]];
                    }
                }
            });

            console.log("Payload: ", payload);

            $.ajax({
                // url: 'https://2dfe-49-43-99-214.ngrok-free.app/api/v1/checkout',
                url: '{{ url('/api/v1/checkout') }}',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(payload),
                success: function(response) {
                    console.log('API success:', response);
                    if (response?.payment_url) {
                        window.location.href = response.payment_url;
                    } else {
                        console.log('No payment link returned.');
                    }
                },
                error: function(xhr) {
                    console.error('API error:', xhr.responseJSON);
                }
            });
        });
    </script>
</body>
</html>
