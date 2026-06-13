@props(['name'])
@error($name)
    <p style="color:#DC2626; font-size:13px; margin-top:4px;">✕ {{ $message }}</p>
@enderror
