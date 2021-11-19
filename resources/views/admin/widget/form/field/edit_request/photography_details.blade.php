<table class="table">
    <thead>
        <tr>
            <th class="align-top"><strong>{{ __('Photo Image Number') }}</strong></th>    
            <th class="align-top"><strong>{{ __('Description of Edits') }}</strong></th>
        </tr>
    </thead>
    <tbody>
    @foreach($edit_request->detail as $row)
        <tr>
            <td style="width:20%;">{{ optional($row)['image'] }}</td>
            <td>{{ optional($row)['description'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>