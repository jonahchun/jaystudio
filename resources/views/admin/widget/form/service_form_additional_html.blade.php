{{-- Hold Popup --}}
<div id="hold-popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-star"></i> {{ __('Put on hold service') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('Please, fill in the reason?') }}</p>
                <textarea rows="4" class="form-control" name="reason" required="required"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> {{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary"><i class="fa fa-check-square-o"></i> {{ __('Submit') }}</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
window.serviceHoldPopup = function(urlLink) {
    $("#hold-popup").modal('show');
    $("#hold-popup .btn-primary").click(function() {
        $(this).parents('form').attr('action', urlLink).submit();
    });
};
</script>

{{-- Complete Popup --}}
<div id="complete-popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-star"></i> {{ __('Complete service') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                @if(in_array($form->getInstance()->type, [\App\Services\Model\Source\Type::PHOTO, \App\Services\Model\Source\Type::VIDEO]))
                <div class="form-group">
                    <label for="upload-link">{{ __('Upload Link') }}</label>
                    <input type="text" class="form-control" id="upload-link" name="complete[upload]" />
                </div>
                @endif
                <div class="form-group">
                    <label for="delivery-location">{{ __('Delivery Location') }}</label>
                    <select class="form-control" id="delivery-location" name="complete[pickup_location_id]">
                        @foreach(\App\Core\Model\PickupLocation::all() as $location)
                        <option value="{{ $location->id }}" @if($location->id == 2) selected @endif>{{ $location->title }}</option>
                        @endforeach
                        <option value="">{{ __('Shipped') }}</option>
                    </select>
                </div>
                <div class="form-group" id="complete-tracking-link-container" style="display:none;">
                    <label for="complete-tracking-link">{{ __('Tracking Link') }}</label>
                    <input type="text" class="form-control" id="complete-tracking-link" name="complete[tracking_link]" required="required" />
                </div>
                <div class="form-group">
                    <label for="complete-comment">{{ __('Comment') }}</label>
                    <textarea rows="4" class="form-control" id="complete-comment" name="complete[comment]"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> {{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary"><i class="fa fa-check-square-o"></i> {{ __('Submit') }}</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
window.serviceCompletePopup = function(urlLink,completeModalShow) {

    if(completeModalShow == 1){
        $("#complete-popup").modal('show');
        $('#delivery-location').change(function() {
            if($(this).val()) {
                $('#complete-tracking-link-container').hide();
            } else {
                $('#complete-tracking-link-container').show();
            }
        });
        $("#complete-popup .btn-primary").click(function() {
            $(this).parents('form').attr('action', urlLink).submit();
        });
    }else{
        $('#complete-popup .btn-primary').parents('form').attr('action', urlLink).submit();
    }
};
</script>

{{-- Send Teaser Popup --}}
<div id="send-teaser-popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-star"></i> {{ __('Send Teaser Email') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="teaser-download-link">{{ __('Download Link') }}</label>
                    <input type="text" class="form-control" id="teaser-download-link" name="teaser[download_link]" required="required" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> {{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary"><i class="fa fa-check-square-o"></i> {{ __('Submit') }}</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
window.teaserEmailPopup = function(urlLink) {
    $("#send-teaser-popup").modal('show');
    $("#send-teaser-popup .btn-primary").click(function() {
        $(this).parents('form').attr('action', urlLink).submit();
    });
};
</script>

{{-- Send Engagement Session Popup --}}
<div id="send-engagement-session-popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-star"></i> {{ __('Send Engagement Session Gallery') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="engagement-session-access-code">{{ __('Access Code') }}</label>
                    <input type="text" class="form-control" id="engagement-session-access-code" name="engagement_session[access_code]" required="required" />
                </div>
                <div class="form-group">
                    <label for="engagement-session-password">{{ __('Password') }}</label>
                    <input type="text" class="form-control" id="engagement-session-password" name="engagement_session[password]" required="required" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> {{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary"><i class="fa fa-check-square-o"></i> {{ __('Submit') }}</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
window.engagementSessionEmailPopup = function(urlLink) {
    $("#send-engagement-session-popup").modal('show');
    $("#send-engagement-session-popup .btn-primary").click(function() {
        $(this).parents('form').attr('action', urlLink).submit();
    });
};
</script>
