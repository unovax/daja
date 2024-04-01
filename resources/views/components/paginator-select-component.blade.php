@props(['attributes' => '', 'class' => ''])

<select {{ $attributes->merge(['class' => 'rounded-md bg-gray-300 dark:bg-gray-800 ' . $class]) }}>
    <option>50</option>
    <option>100</option>
    <option>250</option>
    <option>500</option>
    <option>1000</option>
</select>
