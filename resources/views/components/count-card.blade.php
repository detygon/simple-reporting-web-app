@props(['title', 'subtitle' => '', 'content', 'color' => 'blue'])

<div {{ $attributes->merge(['class' => 'bg-white overflow-hidden shadow sm:rounded-lg']) }}>
    <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
        @if(isset($icon))
            <div class="p-3 rounded-full bg-{{$color}}-600 bg-opacity-75">
                {{ $icon }}
            </div>
        @endif
        <div class="mx-5">
            <div class="text-gray-900 text-xl font-bold">{{ $title }}</div>
            @if($subtitle)
                <div class="text-gray-500">{{ $subtitle }}</div>
            @endif
            <h4 class="text-4xl font-semibold text-gray-600 mt-1">{{ $content }}</h4>
        </div>
    </div>
</div>
