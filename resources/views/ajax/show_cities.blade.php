<option value=""> --- </option>
@forelse($data as $city)
<option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : null }}>{{ $city->name }}</option>
@empty
@endforelse