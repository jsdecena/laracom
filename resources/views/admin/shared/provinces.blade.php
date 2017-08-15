@if(!$provinces->isEmpty())
    <table class="table">
        <tbody>
        <tr>
            <td class="col-md-4">Name</td>
            <td class="col-md-4">Status</td>
            <td class="col-md-4">Actions</td>
        </tr>
        </tbody>
        <tbody>
        @foreach($provinces as $province)
            <tr>
                <td>{{ $province['name'] }}</td>
                <td>@include('layouts.status', ['status' => $country['status']])</td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('countries.provinces.show', [$country, $province['id']]) }}" class="btn btn-default"><i class="fa fa-eye"></i> View</a>
                        <a href="{{ route('countries.provinces.edit', [$country, $province['id']]) }}" class="btn btn-primary"><i class="fa fa-eye"></i> Edit</a>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="box-footer">
        {{ $provinces->links() }}
    </div>
@endif