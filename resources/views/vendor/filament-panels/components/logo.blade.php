<div
    {{
        $attributes->class([
            'fi-logo',
        ])
    }}
>
    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 p-1">
        <img 
            src="{{ asset('images/logo1.png') }}" 
            alt="{{ filament()->getBrandName() ?? 'Logo' }}"
            class="h-full w-full object-contain rounded-full"
        />
    </div>
</div>
