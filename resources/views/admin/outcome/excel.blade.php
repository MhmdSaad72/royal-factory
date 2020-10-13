<table class="table">
    <thead>
        <tr>
            <th>{{ __('translations.loop_number') }}</th>
            <th>{{ __('translations.process_number_outcome') }}</th>
            <th>{{ __('translations.created_at') }}</th>
            <th>{{ __('translations.outcome_period') }}</th>
            <th>{{ __('translations.materials') }}</th>
            <th>{{ __('translations.materials_quantities') }}</th>
            <th>{{ __('translations.products') }}</th>
            <th>{{ __('translations.productss_quantities') }}</th>
        </tr>
    </thead>
    <tbody>
    @foreach($outcomes as $item)
      @foreach ($item->materials as $value)
        @foreach ($item->products as $product)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->process_number }}</td>
            <td>{{ $item->created_at }}</td>
            <td>{{ $item->outcomePeriod($item->id) }}</td>
            <td>{{ $value->name }}</td>
            <td>{{ $value->pivot->quantity }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->pivot->quantity }}</td>
        </tr>
        @endforeach
      @endforeach
    @endforeach
    </tbody>
</table>
