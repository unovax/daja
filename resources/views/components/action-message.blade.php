@props(['on', 'background' => 'green'])

<div x-data="{ shown: false, timeout: null }"
    x-init="@this.on('{{ $on }}', () => { clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 2000);  })"
    x-show.transition.out.opacity.duration.1500ms="shown"
    x-transition:leave.opacity.duration.1500ms
    style="display: none;
    "
    {{ $attributes->merge(['class' => 'absolute bottom-0 right-0 p-2 w-full max-w-[600px] z-[1000] ']) }}>
    <div
        class="px-4 py-2 rounded-md shadow-2xl"
        style="
            background-color: {{ $background }};">
        {{ $slot->isEmpty() ? 'Saved.' : $slot }}
    </div>
</div>
