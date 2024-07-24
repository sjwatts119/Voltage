@props(['on'])

<div x-data="{ shown: false, timeout: null, message: '' }"
     x-init="@this.on('{{ $on }}', event => {
         clearTimeout(timeout);
         if (event.message) { message = event.message; }
         shown = true;
         timeout = setTimeout(() => { shown = false }, 5000);
     })"
     x-show.transition.out.opacity.duration.1500ms="shown"
     x-transition:leave.opacity.duration.1500ms
     style="display: none;"
    {{ $attributes->merge(['class' => 'text-sm text-gray-600 dark:text-gray-400']) }}>
    <span x-text="message"></span>
</div>
