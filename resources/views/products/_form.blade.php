<div class="row">

    <!-- Category -->
    <div class="col-md-6 mb-3">
        <label class="form-label">Category <span class="text-danger">*</span></label>

        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
            <option value="">Select Category</option>

            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach

        </select>

        @error('category_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Brand -->
    <div class="col-md-6 mb-3">
        <label class="form-label">Brand <span class="text-danger">*</span></label>

        <select name="brand_id" class="form-select @error('brand_id') is-invalid @enderror">

            <option value="">Select Brand</option>

            @foreach($brands as $brand)

                <option value="{{ $brand->id }}"
                    {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>
                    {{ $brand->name }}
                </option>

            @endforeach

        </select>

        @error('brand_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Supplier -->
    <div class="col-md-6 mb-3">

        <label class="form-label">
            Supplier
        </label>

        <select name="supplier_id" class="form-select">

            <option value="">Select Supplier</option>

            @foreach($suppliers as $supplier)

                <option value="{{ $supplier->id }}"
                    {{ old('supplier_id', $product->supplier_id ?? '') == $supplier->id ? 'selected' : '' }}>

                    {{ $supplier->supplier_name }}

                </option>

            @endforeach

        </select>

    </div>

    <!-- Unit -->

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Unit
        </label>

        <select name="unit_id" class="form-select">

            <option value="">Select Unit</option>

            @foreach($units as $unit)

                <option value="{{ $unit->id }}"
                    {{ old('unit_id', $product->unit_id ?? '') == $unit->id ? 'selected' : '' }}>

                    {{ $unit->name }}

                </option>

            @endforeach

        </select>

    </div>

    <!-- Product Name -->

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Product Name
        </label>

        <input
            type="text"
            name="product_name"
            class="form-control"
            value="{{ old('product_name', $product->product_name ?? '') }}">

    </div>

    <!-- SKU -->

    <div class="col-md-6 mb-3">

        <label class="form-label">

            SKU

        </label>

        <input
            type="text"
            name="sku"
            class="form-control"
            value="{{ old('sku', $product->sku ?? '') }}">

    </div>

    <!-- Barcode -->

    <div class="col-md-6 mb-3">

        <label class="form-label">

            Barcode

        </label>

        <input
            type="text"
            name="barcode"
            class="form-control"
            value="{{ old('barcode', $product->barcode ?? '') }}">

    </div>

    <!-- Purchase Price -->

    <div class="col-md-6 mb-3">

        <label class="form-label">

            Purchase Price

        </label>

        <input
            type="number"
            step="0.01"
            name="purchase_price"
            class="form-control"
            value="{{ old('purchase_price', $product->purchase_price ?? '') }}">

    </div>

    <!-- Selling Price -->

    <div class="col-md-6 mb-3">

        <label class="form-label">

            Selling Price

        </label>

        <input
            type="number"
            step="0.01"
            name="selling_price"
            class="form-control"
            value="{{ old('selling_price', $product->selling_price ?? '') }}">

    </div>

    <!-- Opening Stock -->

    <div class="col-md-3 mb-3">

        <label class="form-label">

            Opening Stock

        </label>

        <input
            type="number"
            name="opening_stock"
            class="form-control"
            value="{{ old('opening_stock', $product->opening_stock ?? 0) }}">

    </div>

    <!-- Minimum Stock -->

    <div class="col-md-3 mb-3">

        <label class="form-label">

            Minimum Stock

        </label>

        <input
            type="number"
            name="minimum_stock"
            class="form-control"
            value="{{ old('minimum_stock', $product->minimum_stock ?? 0) }}">

    </div>

    <!-- Image -->

    <div class="col-md-6 mb-3">

        <label class="form-label">

            Product Image

        </label>

        <input
            type="file"
            name="image"
            class="form-control">

        @isset($product)
            @if(isset($product) && $product->image)

            <img
            src="{{ asset('storage/'.$product->image) }}"
            id="preview"
            width="120"
            class="mt-2 rounded">

            @else

            <img
            id="preview"
            style="display:none"
            width="120"
            class="mt-2 rounded">

            @endif
        @endisset

    </div>

    <!-- Description -->

    <div class="col-md-12 mb-3">

        <label class="form-label">

            Description

        </label>

        <textarea
            rows="5"
            name="description"
            class="form-control">{{ old('description', $product->description ?? '') }}</textarea>

    </div>

    <!-- Status -->

    <div class="col-md-6 mb-3">

        <label class="form-label">

            Status

        </label>

        <select name="status" class="form-select">

            <option value="1"
                {{ old('status', $product->status ?? 1) == 1 ? 'selected' : '' }}>

                Active

            </option>

            <option value="0"
                {{ old('status', $product->status ?? 1) == 0 ? 'selected' : '' }}>

                Inactive

            </option>

        </select>

    </div>

</div>