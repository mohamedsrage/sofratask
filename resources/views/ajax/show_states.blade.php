<option value=""> --- </option>
@forelse($data as $state)
<option value="{{ $state->id }}" {{ old('state_id') == $state->id ? 'selected' : null }}>{{ $state->name }}</option>
@empty
@endforelse