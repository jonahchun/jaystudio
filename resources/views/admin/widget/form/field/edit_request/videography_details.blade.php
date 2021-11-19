@if(is_array(optional($edit_request->detail)['highlight_reel']) && !optional($edit_request->detail['highlight_reel'])['no_edits'])
    <h3>{{ __('Highlight Reel') }}</h3>
    <table class="table">
        <thead>
            <tr>
                <th class="align-top"><strong>{{ __('Timestamp') }}</strong></th>    
                <th class="align-top"><strong>{{ __('Comment') }}</strong></th>
            </tr>
        </thead>
        <tbody>
        @foreach($edit_request->detail['highlight_reel'] as $row)
            <tr>
                <td style="width:20%;">{{ optional($row)['timestamp'] }}</td>
                <td>{{ optional($row)['description'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <br /><br />
@endif
@if(is_array(optional($edit_request->detail)['full_video']) && !optional($edit_request->detail['full_video'])['no_edits'])
    <h3>{{ __('Full Video') }}</h3>
    <table class="table">
        <thead>
            <tr>
                <th class="align-top"><strong>{{ __('Timestamp') }}</strong></th>    
                <th class="align-top"><strong>{{ __('Comment') }}</strong></th>
            </tr>
        </thead>
        <tbody>
        @foreach($edit_request->detail['full_video'] as $row)
            <tr>
                <td style="width:20%;">{{ optional($row)['timestamp'] }}</td>
                <td>{{ optional($row)['description'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
