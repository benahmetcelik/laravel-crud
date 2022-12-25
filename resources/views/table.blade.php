<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ translate('tables',$model_details['model']->getTable()) }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
            <tr>
                @foreach($model_details['tableColumns'] as $key => $value)
                    <th>{{ translate('columns',$value['title']) }}</th>
                @endforeach
                @foreach($model_details['tableActions'] as $key => $action)
                    <th>{{ translate('actions',$key) }}</th>
                @endforeach

            </tr>
            </thead>
            <tbody>
            @if($model->count() > 0)
                @foreach($model as $data)
                    <tr>
                        @foreach($model_details['tableColumns'] as $key => $column)
                            <td class="{{ $column['class'] }}">
                                @if($column['type'] == 'image')
                                    <img src="{{ $data->{$key} }}" alt="{{ $data->{$key} }}" class="img-thumbnail" width="100">
                                @elseif($column['type'] == 'date')
                                    {{ $data->{$key}->format('d-m-Y') }}
                                @elseif($column['type'] == 'datetime')
                                    {{ $data->{$key}->format('d-m-Y H:i:s') }}
                                @elseif($column['type'] == 'time')
                                    {{ $data->{$key}->format('H:i:s') }}
                                @elseif($column['type'] == 'relation')
                                    {{ $data->{$key}->{$column['relation']['column']} }}
                                @else
                                    {{ $data->{$key} }}
                                @endif
                            </td>
                        @endforeach
                        @foreach($model_details['tableActions'] as $key => $action)

                            <td>
                                @if($action['type'] == 'link')
                                    <a href="{{ route($action['route'],$data->id) }}"
                                       class="btn btn-primary btn-sm"><i class="{{ $action['icon'] }} me-2"></i> {{ translate('actions',$key) }}</a>
                                @else
                                    <form action="{{ route($action['route'],$data->id) }}" method="post">
                                        @csrf
                                        @method($action['method'])
                                        <button type="submit"
                                                class="btn btn-danger btn-sm"><i class="{{ $action['icon'] }} me-2"></i>{{ translate('actions',$key) }}</button>
                                    </form>
                            @endif


                    @endforeach
                    </tr>
                @endforeach

            @else
                <tr>
                    <td colspan="{{ count($model_details['tableColumns']) }}"
                        class="text-center">{{ translate('table','no_data') }}</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            {{ $model->links() }}
        </ul>
    </div>
</div>
