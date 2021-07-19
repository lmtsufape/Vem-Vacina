<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://i.ibb.co/TKtxVYM/cabecalho-2.png" class="logo" alt="Prefeitura de Garanhuns" style="width: 90%">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
