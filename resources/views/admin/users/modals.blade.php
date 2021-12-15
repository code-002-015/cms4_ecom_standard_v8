
<div class="modal effect-scale" id="modalUserDeactivate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Deactivate User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('users.deactivate')}}" method="post">
                @csrf
                <input type="hidden" id="deactivate_user_id" name="user_id">
                <div class="modal-body">
                    <p>You're about to deactivate this user. Do you want to continue?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-danger">Yes, Deactivate</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal effect-scale" id="modalUserActivate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Activate User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('users.activate')}}" method="post">
                @csrf
                <input type="hidden" id="activate_user_id" name="user_id">
                <div class="modal-body">
                    <p>You're about to activate this user. Do you want to continue?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Yes, Activate</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
