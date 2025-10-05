<div class="row">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-8 ">
                                    <h4 class="card-title">
                                      Role permissions ({{ $role_name->role_name }}) </h4>
                                </div>
                            </div>
                        </div>
                        <div class="row ml-1 mt-2">
                            @for($k=0;$k<$half;$k++)
                                <div class="col-md-4">
                                    @if(!empty($chunks[0][$k]->id))
                                        <input class="permissions" role_id="{{ $role_id }}" name="permission_id[{{ $chunks[0][$k]->id }}]" value="{{ $chunks[0][$k]->id }}" permission_id="{{ $chunks[0][$k]->id }}" id="{{ $chunks[0][$k]->id }}" type="checkbox" @if(in_array($chunks[0][$k]->id,$allowed_permissions)) {{ "checked" }}@endif/><label style="margin: 7px 0px 0px 10px;" for="{{ $chunks[0][$k]->id }}">{{ "  ".$chunks[0][$k]->permission }}</label>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    @if(!empty($chunks[1][$k]->id))
                                        <input class="permissions" role_id="{{ $role_id }}" name="permission_id[{{ $chunks[1][$k]->id }}]" value="{{ $chunks[1][$k]->id }}" permission_id="{{ $chunks[1][$k]->id }}" id="{{ $chunks[1][$k]->id }}" type="checkbox" @if(in_array($chunks[1][$k]->id,$allowed_permissions)) {{ "checked" }}@endif/><label style="margin: 7px 0px 0px 10px;" for="{{ $chunks[1][$k]->id }}">{{ "  ".$chunks[1][$k]->permission }}</label>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    @if(!empty($chunks[2][$k]->id))
                                        <input class="permissions" role_id="{{ $role_id }}" name="permission_id[{{ $chunks[2][$k]->id }}]" value="{{ $chunks[2][$k]->id }}" permission_id="{{ $chunks[2][$k]->id }}" id="{{ $chunks[2][$k]->id }}" type="checkbox" @if(in_array($chunks[2][$k]->id,$allowed_permissions)) {{ "checked" }}@endif/><label style="margin: 7px 0px 0px 10px;" for="{{ $chunks[2][$k]->id }}">{{ "  ".$chunks[2][$k]->permission }}</label>
                                    @endif
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
