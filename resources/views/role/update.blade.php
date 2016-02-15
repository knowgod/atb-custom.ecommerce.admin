    <div class="mdl-grid">
        <div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
            <div class="grid-pop-header mdl-color--blue-500 ">
                <div class="mdl-layout-title">
                    <h4>Update Role</h4>
                </div>
                <button ng-click="onClose()" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/role/update') }}" ng-controller="GridFormController"
                  ng-init="formUrl='{{ url('/role/update') }}'; formData={{ $role->toJson() }}"  onsubmit="return false;">

                <input type="hidden" name="_token" ng-model="formData._token" id="csrf-token" value="{{ csrf_token() }}" />

                <input type="hidden" class="form-control" ng-model="formData.id" name="id" value="{{$role->getId()}}">

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" ng-class="{'is-invalid': formDataErrors.name}">
                    <input class="mdl-textfield__input" name="name" ng-model="formData.name" type="text" id="name" value="{{$role->getName()}}" >
                    <label class="mdl-textfield__label" for="name">Role Name</label>
                    <span class="mdl-textfield__error"><% formDataErrors.firstname[0] %></span>
                </div>

                <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="super_admin">
                  <input type="checkbox" id="super_admin" name="super_admin" ng-model="formData.super_admin" class="mdl-checkbox__input" @if(in_array('*', $role->getPermissions())) checked @endif()>
                  <span class="mdl-checkbox__label">Allow Everything (Super Admin)</span>
                </label>

                @foreach($permissions as $policy=>$policyPermissions)
                    <h5>{{$policy}}</h5>
                    @foreach($policyPermissions as $perm)
                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="{{$policy}}.{{$perm}}">
                          <input type="checkbox" id="{{$policy}}.{{$perm}}" name="{{$policy}}.{{$perm}}" ng-model="formData.policies.{{$policy}}.{{$perm}}" @if(in_array($policy . '.' . $perm, $role->getPermissions())) checked @endif() class="mdl-checkbox__input">
                          <span class="mdl-checkbox__label">{{$perm}}</span>
                        </label>
                    @endforeach
                @endforeach

                <div class="buttons">
                    <button ng-click="dataSubmit()" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
