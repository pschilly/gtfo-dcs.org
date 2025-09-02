@php
    $headerImage = \Inerba\DbConfig\DbConfig::get('brand.header-image', '');
    $imageUrl = empty($headerImage)
        ? ''
        : (request()->isSecure() ? secure_asset('/storage/' . $headerImage) : asset('/storage/' . $headerImage));
@endphp

<div class="bg-cover bg-center bg-no-repeat bg-blend-multiply h-48 bg-gray-600" style="background-image: url('{{ $imageUrl }}');"></div>