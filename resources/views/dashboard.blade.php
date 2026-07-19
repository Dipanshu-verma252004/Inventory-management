@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><h4 class="mb-1">Dashboard</h4><p class="text-muted mb-0">Inventory overview for {{ now()->format('d M Y') }}</p></div>
</div>

<div class="row g-3 mb-4">
    @foreach ([
        ['Total Products', $dashboard['totalProducts'], 'bx-package', 'primary'],
        ['Total Customers', $dashboard['totalCustomers'], 'bx-user', 'info'],
        ['Total Suppliers', $dashboard['totalSuppliers'], 'bx-group', 'warning'],
        ['Total Purchases', '₹ ' . number_format($dashboard['totalPurchases'], 2), 'bx-cart', 'secondary'],
        ['Total Sales', '₹ ' . number_format($dashboard['totalSales'], 2), 'bx-line-chart', 'success'],
        ['Current Stock Value', '₹ ' . number_format($dashboard['stockValue'], 2), 'bx-wallet', 'danger'],
    ] as [$label, $value, $icon, $color])
        <div class="col-xl-2 col-md-4 col-sm-6"><div class="card h-100"><div class="card-body"><div class="d-flex justify-content-between"><div><small class="text-muted">{{ $label }}</small><h5 class="mb-0 mt-2">{{ $value }}</h5></div><span class="badge bg-label-{{ $color }} rounded p-2"><i class="bx {{ $icon }} fs-4"></i></span></div></div></div></div>
    @endforeach
</div>

<div class="card mb-4"><div class="card-header"><h5 class="mb-0">Today's Summary</h5></div><div class="card-body"><div class="row text-center">
    <div class="col-md-4 border-end"><small class="text-muted d-block">Today's Purchase</small><h4 class="mt-2 mb-0">₹ {{ number_format($dashboard['todayPurchase'], 2) }}</h4></div>
    <div class="col-md-4 border-end"><small class="text-muted d-block">Today's Sales</small><h4 class="mt-2 mb-0 text-success">₹ {{ number_format($dashboard['todaySales'], 2) }}</h4></div>
    <div class="col-md-4"><small class="text-muted d-block">Today's Profit</small><h4 class="mt-2 mb-0 {{ $dashboard['todayProfit'] >= 0 ? 'text-success' : 'text-danger' }}">₹ {{ number_format($dashboard['todayProfit'], 2) }}</h4></div>
</div></div></div>

<div class="row g-4 mb-4"><div class="col-lg-6"><div class="card h-100"><div class="card-header"><h5 class="mb-0">Monthly Purchase</h5></div><div class="card-body"><div id="purchaseChart"></div></div></div></div><div class="col-lg-6"><div class="card h-100"><div class="card-header"><h5 class="mb-0">Monthly Sales</h5></div><div class="card-body"><div id="salesChart"></div></div></div></div></div>

<div class="row g-4"><div class="col-lg-6"><div class="card h-100"><div class="card-header d-flex justify-content-between"><h5 class="mb-0">Recent Purchases</h5><a href="{{ route('purchases.index') }}">View all</a></div><div class="table-responsive"><table class="table table-hover mb-0"><thead><tr><th>Purchase No</th><th>Supplier</th><th class="text-end">Amount</th></tr></thead><tbody>@forelse($recentPurchases as $purchase)<tr><td>{{ $purchase->purchase_no }}</td><td>{{ $purchase->supplier->supplier_name ?? '-' }}</td><td class="text-end">₹ {{ number_format($purchase->total_amount, 2) }}</td></tr>@empty<tr><td colspan="3" class="text-center text-muted">No purchases yet.</td></tr>@endforelse</tbody></table></div></div></div>
<div class="col-lg-6"><div class="card h-100"><div class="card-header d-flex justify-content-between"><h5 class="mb-0">Recent Sales</h5><a href="{{ route('sales.index') }}">View all</a></div><div class="table-responsive"><table class="table table-hover mb-0"><thead><tr><th>Sale No</th><th>Customer</th><th class="text-end">Amount</th></tr></thead><tbody>@forelse($recentSales as $sale)<tr><td>{{ $sale->sale_no }}</td><td>{{ $sale->customer->customer_name ?? '-' }}</td><td class="text-end">₹ {{ number_format($sale->total_amount, 2) }}</td></tr>@empty<tr><td colspan="3" class="text-center text-muted">No sales yet.</td></tr>@endforelse</tbody></table></div></div></div>
<div class="col-12"><div class="card"><div class="card-header d-flex justify-content-between"><h5 class="mb-0">Low Stock Products</h5><a href="{{ route('products.index') }}">View products</a></div><div class="table-responsive"><table class="table table-hover mb-0"><thead><tr><th>Product</th><th>SKU</th><th class="text-end">Current Stock</th><th class="text-end">Minimum Stock</th></tr></thead><tbody>@forelse($lowStockProducts as $product)<tr><td>{{ $product->product_name }}</td><td>{{ $product->sku ?: '-' }}</td><td class="text-end"><span class="badge bg-label-danger">{{ $product->opening_stock }}</span></td><td class="text-end">{{ $product->minimum_stock }}</td></tr>@empty<tr><td colspan="4" class="text-center text-muted">No low-stock products.</td></tr>@endforelse</tbody></table></div></div></div></div>
@endsection

@push('scripts')
<script>
const dashboardLabels = @json($chartLabels);
const chartOptions = (name, data, color) => ({ chart: { type: 'bar', height: 300, toolbar: { show: false } }, series: [{ name, data }], xaxis: { categories: dashboardLabels }, colors: [color], dataLabels: { enabled: false }, yaxis: { labels: { formatter: value => '₹ ' + value.toLocaleString() } }, tooltip: { y: { formatter: value => '₹ ' + value.toLocaleString(undefined, {minimumFractionDigits: 2}) } } });
new ApexCharts(document.querySelector('#purchaseChart'), chartOptions('Purchase', @json($purchaseSeries), '#696cff')).render();
new ApexCharts(document.querySelector('#salesChart'), chartOptions('Sales', @json($salesSeries), '#71dd37')).render();
</script>
@endpush
