<div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">
            Unit Name <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $unit->name ?? '') }}"
            placeholder="Enter Unit Name">

        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">
            Short Name <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="short_name"
            class="form-control @error('short_name') is-invalid @enderror"
            value="{{ old('short_name', $unit->short_name ?? '') }}"
            placeholder="Kg / Pc / Box">

        @error('short_name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Status
        </label>

        <select name="status" class="form-select">

            <option value="1"
                {{ old('status', $unit->status ?? 1) == 1 ? 'selected' : '' }}>
                Active
            </option>

            <option value="0"
                {{ old('status', $unit->status ?? 1) == 0 ? 'selected' : '' }}>
                Inactive
            </option>

        </select>

    </div>

    <div class="col-md-12 mb-3">

        <label class="form-label">
            Description
        </label>

        <textarea
            name="description"
            rows="4"
            class="form-control @error('description') is-invalid @enderror"
            placeholder="Enter Description">{{ old('description', $unit->description ?? '') }}</textarea>

        @error('description')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

</div>