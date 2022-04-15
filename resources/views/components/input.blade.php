<div class="form-group">
    <label for="{{ $field }}">
        {{ ucwords($field) }}
        @if (isset($rqd))
            <span class="text-danger"> *</span>
        @endif
    </label>
    <input type="{{ $type }}" class="{{ $fileform ?? 'form-control' }} {{ $classes ?? '' }}" name="{{ str_replace(' ', '', $field) }}" placeholder="Enter {{ ucwords($field)}}"
    @if (isset($value))
        value="{{ $value }}"
    @else
        value="{{ old(str_replace(' ', '', $field)) }}"
    @endif
    @if (isset($required))
        required
    @endif
    @if (isset($read))
        readonly
    @endif
   >
</div>
