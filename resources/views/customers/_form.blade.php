<div class="card">

<div class="card-header">

<h4>

{{ isset($customer) ? 'Edit Customer' : 'Add Customer' }}

</h4>

</div>

<div class="card-body">

<div class="row">

<div class="col-md-6 mb-3">

<label>Customer Name</label>

<input
type="text"
name="customer_name"
class="form-control"
required
value="{{ old('customer_name',$customer->customer_name ?? '') }}">

@error('customer_name')

<div class="text-danger">{{ $message }}</div>

@enderror

</div>

<div class="col-md-6 mb-3">

<label>Mobile</label>

<input
type="text"
name="mobile"
class="form-control"
required
value="{{ old('mobile',$customer->mobile ?? '') }}">

@error('mobile')

<div class="text-danger">{{ $message }}</div>

@enderror

</div>

<div class="col-md-6 mb-3">

<label>Email</label>

<input
type="email"
name="email"
class="form-control"
value="{{ old('email',$customer->email ?? '') }}">

@error('email')

<div class="text-danger">{{ $message }}</div>

@enderror

</div>

<div class="col-md-6 mb-3">

<label>GST No</label>

<input
type="text"
name="gst_no"
class="form-control"
value="{{ old('gst_no',$customer->gst_no ?? '') }}">

@error('gst_no')

<div class="text-danger">{{ $message }}</div>

@enderror

</div>

<div class="col-md-12 mb-3">

<label>Address</label>

<textarea
name="address"
class="form-control"
rows="3">{{ old('address',$customer->address ?? '') }}</textarea>

@error('address')

<div class="text-danger">{{ $message }}</div>

@enderror

</div>

<div class="col-md-4 mb-3">

<label>Status</label>

<select
name="status"
class="form-select">

<option value="1"
{{ old('status',$customer->status ?? 1)==1 ? 'selected':'' }}>

Active

</option>

<option value="0"
{{ old('status',$customer->status ?? 1)==0 ? 'selected':'' }}>

Inactive

</option>

</select>

@error('status')

<div class="text-danger">{{ $message }}</div>

@enderror

</div>

</div>

<div class="text-end">

<a
href="{{ route('customers.index') }}"
class="btn btn-secondary">

Cancel

</a>

<button
type="submit"
class="btn btn-primary">

{{ isset($customer) ? 'Update Customer' : 'Save Customer' }}

</button>

</div>

</div>

</div>
