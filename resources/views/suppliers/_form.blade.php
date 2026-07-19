<div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">
            Supplier Name <span class="text-danger">*</span>
        </label>

        <input type="text"
               name="supplier_name"
               class="form-control @error('supplier_name') is-invalid @enderror"
               value="{{ old('supplier_name', $supplier->supplier_name ?? '') }}"
               placeholder="Enter Supplier Name">

        @error('supplier_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Company Name</label>

        <input type="text"
               name="company_name"
               class="form-control"
               value="{{ old('company_name', $supplier->company_name ?? '') }}"
               placeholder="Enter Company Name">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Contact Person</label>

        <input type="text"
               name="contact_person"
               class="form-control"
               value="{{ old('contact_person', $supplier->contact_person ?? '') }}"
               placeholder="Enter Contact Person">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">GST Number</label>

        <input type="text"
               name="gst_number"
               class="form-control"
               value="{{ old('gst_number', $supplier->gst_number ?? '') }}"
               placeholder="Enter GST Number">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">
            Phone <span class="text-danger">*</span>
        </label>

        <input type="text"
               name="phone"
               class="form-control @error('phone') is-invalid @enderror"
               value="{{ old('phone', $supplier->phone ?? '') }}"
               placeholder="Enter Phone">

        @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Alternate Phone</label>

        <input type="text"
               name="alternate_phone"
               class="form-control"
               value="{{ old('alternate_phone', $supplier->alternate_phone ?? '') }}"
               placeholder="Enter Alternate Phone">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Email</label>

        <input type="email"
               name="email"
               class="form-control"
               value="{{ old('email', $supplier->email ?? '') }}"
               placeholder="Enter Email">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Website</label>

        <input type="text"
               name="website"
               class="form-control"
               value="{{ old('website', $supplier->website ?? '') }}"
               placeholder="https://example.com">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">City</label>

        <input type="text"
               name="city"
               class="form-control"
               value="{{ old('city', $supplier->city ?? '') }}">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">State</label>

        <input type="text"
               name="state"
               class="form-control"
               value="{{ old('state', $supplier->state ?? '') }}">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Country</label>

        <input type="text"
               name="country"
               class="form-control"
               value="{{ old('country', $supplier->country ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Postal Code</label>

        <input type="text"
               name="postal_code"
               class="form-control"
               value="{{ old('postal_code', $supplier->postal_code ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Status</label>

        <select name="status" class="form-select">

            <option value="1" {{ old('status', $supplier->status ?? 1) == 1 ? 'selected' : '' }}>
                Active
            </option>

            <option value="0" {{ old('status', $supplier->status ?? 1) == 0 ? 'selected' : '' }}>
                Inactive
            </option>

        </select>

    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Address</label>

        <textarea name="address"
                  rows="4"
                  class="form-control">{{ old('address', $supplier->address ?? '') }}</textarea>
    </div>

</div>