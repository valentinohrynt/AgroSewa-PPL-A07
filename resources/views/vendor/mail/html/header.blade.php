@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://i.ibb.co/10Rn0g2/as-logo.png" class="logo" alt="AgroSewa-Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
