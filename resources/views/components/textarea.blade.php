<div class="form-group">
    <label for="{{ $field }}">{{ ucwords($field) }}</label>
    <textarea class="form-control {{$class ?? ''}}" placeholder="Enter {{ ucwords($field) }}" name="{{ str_replace(' ', '', $field) }}" rows="{{$rows ?? '3'}}" style="{{ $style ?? 'min-height:150px;' }}">@isset($value){{ $value }}@else{{ old(str_replace(' ', '', $field)) }}@endisset</textarea>
</div>
