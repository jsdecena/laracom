<table class="table">
    <thead>
    <tr>
        <td class="col-md-4">Name</td>
        <td class="col-md-4">Actions</td>
    </tr>
    </thead>
    <tbody>
    @foreach($cities as $city)
        <tr>
            <td>{{ $city['name'] }}</td>
            <td>
                <div class="btn-group">
                    <a href="{{ route('admin.countries.provinces.cities.edit', [$countryId, $province->id, $city['id']]) }}" class="btn btn-primary"><i class="fa fa-eye"></i> Edit</a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>