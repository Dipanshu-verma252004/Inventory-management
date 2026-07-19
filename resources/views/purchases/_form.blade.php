<div class="row">

    <div class="col-md-4 mb-3">

        <label>Supplier</label>

        <select
            name="supplier_id"
            class="form-select">

            <option value="">Select Supplier</option>

            @foreach($suppliers as $supplier)

                <option value="{{ $supplier->id }}"
                    {{ old('supplier_id',$purchase->supplier_id ?? '') == $supplier->id ? 'selected' : '' }}>

                    {{ $supplier->supplier_name }}

                </option>

            @endforeach

        </select>

    </div>

    <div class="col-md-4 mb-3">

        <label>Purchase Date</label>

        <input
            type="date"
            name="purchase_date"
            value="{{ old('purchase_date',$purchase->purchase_date ?? '') }}"
            class="form-control">

    </div>

    <div class="col-md-4 mb-3">

        <label>Invoice No</label>

        <input
            type="text"
            name="invoice_no"
            value="{{ old('invoice_no',$purchase->invoice_no ?? '') }}"
            class="form-control">
            

    </div>

</div>

<hr>

<h5>Purchase Items</h5>

<div class="table-responsive">

<table class="table table-bordered" id="purchaseTable">

    <thead>

    <tr>

        <th width="35%">Product</th>

        <th width="15%">Qty</th>

        <th width="20%">Purchase Price</th>

        <th width="20%">Subtotal</th>

        <th width="10%"></th>

    </tr>

    </thead>

    <tbody>

@php

if(old('product_id')){

    $items = collect(old('product_id'))->map(function($id,$index){

        return (object)[

            'product_id'=>$id,

            'quantity'=>old('quantity')[$index],

            'purchase_price'=>old('purchase_price')[$index],

            'subtotal'=>old('quantity')[$index]*old('purchase_price')[$index],

        ];

    });

}else{

    $items = isset($purchase)
            ? $purchase->items
            : collect([(object)[

                'product_id'=>'',

                'quantity'=>1,

                'purchase_price'=>'',

                'subtotal'=>''

            ]]);

}

@endphp

@foreach($items as $item)

<tr>

    <td>

        <select name="product_id[]" class="form-select">

            <option value="">Select Product</option>

            @foreach($products as $product)

                <option
                    value="{{ $product->id }}"
                    {{ $item->product_id == $product->id ? 'selected' : '' }}>

                    {{ $product->product_name }}

                </option>

            @endforeach

        </select>

    </td>

    <td>

        <input
            type="number"
            name="quantity[]"
            class="form-control qty"
            value="{{ $item->quantity }}">

    </td>

    <td>

        <input
            type="number"
            step="0.01"
            name="purchase_price[]"
            class="form-control price"
            value="{{ $item->purchase_price }}">

    </td>

    <td>

        <input
            type="text"
            class="form-control subtotal"
            value="{{ $item->subtotal }}"
            readonly>

    </td>

    <td>

        <button
            type="button"
            class="btn btn-danger removeRow">

            <i class="bx bx-trash"></i>

        </button>

    </td>

</tr>

@endforeach

</tbody>

</table>

<div class="mb-3">

    <button
        type="button"
        class="btn btn-success"
        id="addRow">

        <i class="bx bx-plus"></i>

        Add More Product

    </button>

</div>

</div>

<div class="row mt-4">

    <div class="col-md-3">

        <label>Total Amount</label>

        <input
            type="text"
            name="total_amount"
            id="total_amount"
            value="{{ old('total_amount', $purchase->total_amount ?? 0) }}"
            class="form-control"
            readonly>

    </div>

    <div class="col-md-3">

        <label>Paid Amount</label>

        <input
            type="number"
            step="0.01"
            name="paid_amount"
            id="paid_amount"
            value="{{ old('paid_amount',$purchase->paid_amount ?? 0) }}"
            class="form-control">

    </div>

    <div class="col-md-3">

        <label>Due Amount</label>

        <input
            type="text"
            name="due_amount"
            id="due_amount"
            value="{{ old('due_amount', $purchase->due_amount ?? 0) }}"
            class="form-control"
            readonly>

    </div>

    <div class="col-md-3">

        <label>Status</label>

        <select
        name="status"
        class="form-select">

        <option value="1"
        {{ old('status',$purchase->status ?? 1)==1 ? 'selected':'' }}>

        Completed

        </option>

        <option value="0"
        {{ old('status',$purchase->status ?? 1)==0 ? 'selected':'' }}>

        Pending

        </option>

        </select>

    </div>

    

</div>
<div class="row mt-4">

    <div class="col-md-12 text-start">

        <a href="{{ route('purchases.index') }}"
           class="btn btn-secondary">

            Cancel

        </a>

        <button type="submit" class="btn btn-primary">

            <i class="bx bx-save"></i>

            {{ isset($purchase) ? 'Update Purchase' : 'Save Purchase' }}

        </button>

    </div>

</div>

@push('scripts')
<script>
$(function () {
    function calculateTotal() {
        let total = 0;

        $('#purchaseTable .subtotal').each(function () {
            total += parseFloat($(this).val()) || 0;
        });

        const paid = parseFloat($('#paid_amount').val()) || 0;

        $('#total_amount').val(total.toFixed(2));
        $('#due_amount').val(Math.max(0, total - paid).toFixed(2));
    }

    $('#addRow').on('click', function () {
        const row = `
            <tr>
                <td>
                    <select name="product_id[]" class="form-select">
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" name="quantity[]" value="1" min="1" class="form-control qty"></td>
                <td><input type="number" step="0.01" min="0" name="purchase_price[]" class="form-control price"></td>
                <td><input type="text" class="form-control subtotal" value="0.00" readonly></td>
                <td><button type="button" class="btn btn-danger removeRow"><i class="bx bx-trash"></i></button></td>
            </tr>`;

        $('#purchaseTable tbody').append(row);
    });

    $(document).on('input change', '.qty, .price, #paid_amount', function () {
        const row = $(this).closest('tr');

        if (row.length) {
            const qty = parseFloat(row.find('.qty').val()) || 0;
            const price = parseFloat(row.find('.price').val()) || 0;
            row.find('.subtotal').val((qty * price).toFixed(2));
        }

        calculateTotal();
    });

    $(document).on('click', '.removeRow', function () {
        if ($('#purchaseTable tbody tr').length > 1) {
            $(this).closest('tr').remove();
            calculateTotal();
        }
    });

    $('#purchaseTable tbody tr').each(function () {
        const qty = parseFloat($(this).find('.qty').val()) || 0;
        const price = parseFloat($(this).find('.price').val()) || 0;
        $(this).find('.subtotal').val((qty * price).toFixed(2));
    });

    calculateTotal();
});
</script>
@endpush
