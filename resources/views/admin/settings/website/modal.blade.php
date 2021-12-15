<div class="modal effect-scale" id="prompt-remove-logo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">{{__('standard.settings.website.remove_logo_confirmation_title')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{__('standard.settings.website.remove_logo_confirmation')}}</p>
            </div>
            <form action="{{route('website-settings.remove-logo')}}" method="POST">
            @csrf
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-danger">Yes, remove logo</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal effect-scale" id="prompt-remove-icon" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">{{__('standard.settings.website.remove_icon_confirmation_title')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{__('standard.settings.website.remove_icon_confirmation')}}</p>
            </div>
            <form action="{{route('website-settings.remove-icon')}}" method="POST">
            @csrf
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-danger">Yes, remove icon</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal effect-scale" id="prompt-delete-social" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">{{__('standard.settings.website.remove_social_account_confirmation_title')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{__('standard.settings.website.remove_social_account_confirmation')}}</p>
            </div>
            <form action="{{route('website-settings.remove-media')}}" method="POST">
            @csrf
            <input type="hidden" id="mid" name="id">
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-danger">Yes, remove account</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
