<table class="table">
    <thead>
        <tr>
            <th>{{ __('translations.loop_number') }}</th>
            <th>{{ __('translations.product') }}</th>
            <th>{{ __('translations.quantity') }}</th>
            <th>{{ __('translations.process_number_store') }}</th>
            <th>{{ __('translations.exit_date') }}</th>
            <th>{{ __('translations.deliver_name') }}</th>
        </tr>
    </thead>
    <tbody>
    @foreach($stores as $item)
      @foreach ($item->products as  $value)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $value->name}}</td>
            <td>{{ $value->pivot->quantity}}</td>
            <td>{{ $item->process_number }}</td>
            <td>{{ $item->created_at }}</td>
            <td>{{ $item->deliver_name}}</td>
        </tr>
      @endforeach
    @endforeach
    </tbody>
</table>
