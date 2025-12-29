@props(['disabled' => false])
<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-ensa-blue focus:ring-ensa-blue rounded-xl shadow-sm py-3']) !!}>