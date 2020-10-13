<table class="table">
    <thead>
        <tr>
            <th>{{ __('translations.loop_number') }}</th>
            <th>{{ __('translations.material_name') }}</th>
            <th>{{ __('translations.supplier_name') }}</th>
            <th>{{ __('translations.date_of_order') }}</th>
            <th>{{ __('translations.process_number_order') }}</th>
            <th>{{ __('translations.quantity') }}</th>
            <th>{{ __('translations.expire_date') }}</th>
        </tr>
    </thead>
    <tbody>
    @foreach($orders as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->material['name']}}</td>
            <td>{{ $item->supplier['name']}}</td>
            <td>{{ $item->created_at }}</td>
            <td>{{ $item->process_number }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->expire_date }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
