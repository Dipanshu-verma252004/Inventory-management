<div class="card">
    <div class="card-header"><h4 class="mb-0">{{ isset($sale) ? 'Edit Sale' : 'Create Sale' }}</h4></div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Customer</label>
                <select name="customer_id" class="form-select" required>
                    <option value="">Select Customer</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" @selected(old('customer_id', $sale->customer_id ?? '') == $customer->id)>{{ $customer->customer_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Sale Date</label>
                <input type="date" name="sale_date" class="form-control" value="{{ old('sale_date', $sale->sale_date ?? now()->toDateString()) }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Invoice No <small class="text-muted">(blank = auto generated)</small></label>
                <input type="text" name="invoice_no" class="form-control" value="{{ old('invoice_no', $sale->invoice_no ?? '') }}">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered" id="saleTable">
                <thead><tr><th>Product</th><th>Available</th><th>Price</th><th>Qty</th><th>Subtotal</th><th></th></tr></thead>
                <tbody>
                    @php
                        $items = old('product_id')
                            ? collect(old('product_id'))->map(fn ($productId, $index) => (object) ['product_id' => $productId, 'quantity' => old('quantity')[$index] ?? 1, 'selling_price' => old('selling_price')[$index] ?? '', 'subtotal' => 0])
                            : (isset($sale) ? $sale->items : collect([(object) ['product_id' => '', 'quantity' => 1, 'selling_price' => '', 'subtotal' => 0]]));
                    @endphp
                    @foreach ($items as $item)
                        <tr>
                            <td>
                                <select name="product_id[]" class="form-select product" required>
                                    <option value="">Select Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->selling_price }}" data-stock="{{ $product->opening_stock }}" @selected($item->product_id == $product->id)>{{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="text" class="form-control stock" readonly></td>
                            <td><input type="number" step="0.01" min="0" name="selling_price[]" class="form-control price" value="{{ $item->selling_price }}" required></td>
                            <td><input type="number" min="1" name="quantity[]" class="form-control qty" value="{{ $item->quantity }}" required></td>
                            <td><input type="text" class="form-control subtotal" value="{{ $item->subtotal }}" readonly></td>
                            <td><button type="button" class="btn btn-danger removeRow"><i class="bx bx-trash"></i></button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button type="button" class="btn btn-success mb-3" id="addRow"><i class="bx bx-plus"></i> Add Product</button>

        <div class="row"><div class="col-md-4 offset-md-8">
            <label class="form-label">Total Amount</label>
            <input type="number" step="0.01" name="total_amount" id="totalAmount" class="form-control" value="{{ old('total_amount', $sale->total_amount ?? 0) }}" readonly>
            <label class="form-label mt-3">Paid Amount</label>
            <input type="number" step="0.01" min="0" name="paid_amount" id="paidAmount" class="form-control" value="{{ old('paid_amount', $sale->paid_amount ?? 0) }}">
            <label class="form-label mt-3">Due Amount</label>
            <input type="number" step="0.01" name="due_amount" id="dueAmount" class="form-control" value="{{ old('due_amount', $sale->due_amount ?? 0) }}" readonly>
            <label class="form-label mt-3">Status</label>
            <select name="status" class="form-select"><option value="1" @selected(old('status', $sale->status ?? 1) == 1)>Completed</option><option value="0" @selected(old('status', $sale->status ?? 1) == 0)>Pending</option></select>
        </div></div>
        <div class="text-end mt-4"><a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a> <button type="submit" class="btn btn-primary">{{ isset($sale) ? 'Update Sale' : 'Save Sale' }}</button></div>
    </div>
</div>

@push('scripts')
<script>
$(function () {
    const productOptions = `{!! '<option value="">Select Product</option>' . $products->map(fn ($product) => '<option value="' . $product->id . '" data-price="' . $product->selling_price . '" data-stock="' . $product->opening_stock . '">' . e($product->product_name) . '</option>')->implode('') !!}`;
    const emptyRow = () => `<tr><td><select name="product_id[]" class="form-select product" required>${productOptions}</select></td><td><input type="text" class="form-control stock" readonly></td><td><input type="number" step="0.01" min="0" name="selling_price[]" class="form-control price" required></td><td><input type="number" min="1" name="quantity[]" value="1" class="form-control qty" required></td><td><input type="text" class="form-control subtotal" value="0.00" readonly></td><td><button type="button" class="btn btn-danger removeRow"><i class="bx bx-trash"></i></button></td></tr>`;

    function updateRow(row, useProductPrice) {
        const option = row.find('.product option:selected');
        const stock = Number(option.data('stock')) || 0;
        row.find('.stock').val(option.val() ? stock : '');
        row.find('.qty').attr('max', stock || null);
        if (useProductPrice && option.val()) row.find('.price').val(Number(option.data('price')).toFixed(2));
        const quantity = Number(row.find('.qty').val()) || 0;
        const price = Number(row.find('.price').val()) || 0;
        row.find('.subtotal').val((quantity * price).toFixed(2));
        row.toggleClass('table-warning', option.val() && quantity > stock);
    }
    function calculateTotal() {
        let total = 0;
        $('#saleTable tbody tr').each(function () { updateRow($(this), false); total += Number($(this).find('.subtotal').val()) || 0; });
        const paid = Number($('#paidAmount').val()) || 0;
        $('#totalAmount').val(total.toFixed(2));
        $('#dueAmount').val(Math.max(0, total - paid).toFixed(2));
    }
    $('#addRow').on('click', () => $('#saleTable tbody').append(emptyRow()));
    $(document).on('change', '.product', function () { updateRow($(this).closest('tr'), true); calculateTotal(); });
    $(document).on('input change', '.qty, .price, #paidAmount', calculateTotal);
    $(document).on('click', '.removeRow', function () { if ($('#saleTable tbody tr').length > 1) { $(this).closest('tr').remove(); calculateTotal(); } });
    calculateTotal();
});
</script>
@endpush
