<tr>
  <td class="header">
    <a href="{{ $url }}" style="display: inline-block;">
      @if (trim($slot) === 'Laravel')
      <img src="https://hashim.com.tr/wp-content/themes/hashim/assets/img/hashim.svg" class="logo"
        alt="hashimproperty Logo">
      @else
      {{ $slot }}
      @endif
    </a>
  </td>
</tr>
