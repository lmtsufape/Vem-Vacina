

<div class="form-group">
    <label for="exampleInputEmail1">{{ $label }}</label>
    <input  type="{{ $type }}" name="{{ $name }}" value="{{ $value }}" class="form-control {{ $class }}  @error($name) is-invalid @enderror" placeholder="{{ $placeholder }}" id="{{ $id }}"  {{ $disabled ? 'disabled' : '' }}>
    @error($name)
            <div class="invalid-feedback">
                <strong>{{$message}}</strong>
            </div>
    @enderror
</div>
