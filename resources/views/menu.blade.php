@extends('layouts.app')

@section('content')
    <div>
        <div class="card">
            <div class="card-header">
                Menu Management
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#new-menu">New Menu</button>
            </div>
        </div>
        <table class="table mt-3">
            <thead>
            <th scope="col">ID</th>
            <th scope="col">PID</th>
            <th scope="col">Menu</th>
            <th scope="col">Path</th>
            <th scope="col">Icon</th>
            <th scope="col">Updated At</th>
            <th scope="col">Action</th>
            </thead>
            <tbody>
            @foreach($menus as $menu)
                <tr>
                    <td>{{$menu->id}}</td>
                    <td>{{$menu->pid}}</td>
                    <td>{{$menu->name}}</td>
                    <td>{{$menu->path}}</td>
                    <td>{{$menu->icon}}</td>
                    <td>{{$menu->updated_at}}</td>
                    <td>
                        <div >
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmation" onclick="actionHandle({{$menu}},'delete')">Delete</button>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#confirmation" onclick="actionHandle({{$menu}},'edit')">Edit</button>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <!-- Form modal for add new data -->
    <div class="modal fade" id="new-menu" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="new-menu-form" action="{{route('menu.add')}}" method="POST" onsubmit="addMenuSubmit()">
                        @csrf
                        <div>
                            <label for="new-menu-form-pid">PID</label>
                            <input class="form-control" type="text" name="new-menu-form-pid" id="new-menu-form-pid">
                        </div>
                        <div>
                            <label for="new-menu-form-name">Name</label>
                            <input class="form-control" type="text" name="new-menu-form-name" id="new-menu-form-name">
                        </div>
                        <div>
                            <label for="new-menu-form-path">Path</label>
                            <input class="form-control" type="text" name="new-menu-form-path" id="new-menu-form-path">
                        </div>
                        <div>
                            <label for="new-menu-form-icon">Icon</label>
                            <input class="form-control" type="text" name="new-menu-form-icon" id="new-menu-form-icon">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addMenuSubmit(event)">Add Menu</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Form modal for update data -->
    <div class="modal fade" id="confirmation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="confirm_type" class="modal-title" ></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span id="confirm_content"></span>
                    <form id="form_edit" action="">
                        <div>
                            <label for="pid">PID</label>
                            <input class="form-control" type="text" id="pid" name="pid">
                        </div>
                        <div>
                            <label for="name">Name</label>
                            <input class="form-control" type="text" id="name" name="name">
                        </div>
                        <div>
                            <label for="path">Path</label>
                            <input class="form-control" type="text" id="path" name="path">
                        </div>
                        <div>
                            <label for="icon">Icon</label>
                            <input class="form-control" type="text" id="icon" name="icon">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="confirmHandle()">OK</button>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    let menuData;
    let actionType;
    function actionHandle(menu,type) {
        menuData = menu;
        if (type === 'delete'){
            actionType = 'delete';
            document.getElementById('confirm_type').innerText = 'Confirm Delete ?';
            document.getElementById('confirm_content').innerText = 'Delete menu: ' + menu.name;
            $('#form_edit').addClass('hide-edit-form');
        }
        else {
            actionType = 'edit';
            $('#form_edit').removeClass('hide-edit-form');
            document.getElementById('confirm_type').innerText = 'Confirm Edit ?';
            document.getElementById('confirm_content').innerText = 'Edit menu: ' + menu.name;

            $('#pid').val(menuData.pid) ;
            $('#name').val(menuData.name) ;
            $('#path').val(menuData.path) ;
            $('#icon').val(menuData.icon) ;
        }
    }

    function confirmHandle(){
        $(document).ready(function () {
            let action = (actionType === 'delete') ? "{{route('menu.delete')}}" : "{{route('menu.edit')}}";
            let updateForm = {
                _token: "{{csrf_token()}}",
                id: menuData.id,
                pid: $('#pid').val(),
                name: $('#name').val(),
                path: $('#path').val(),
                icon: $('#icon').val(),
            }

           $.ajax({
               url: action,
               method: "POST",
               data: (action === 'delete') ? {id: menuData.id, _token: "{{csrf_token()}}"} : updateForm,
               success: function (response) {
                   window.location.href = "{{route('menu.get')}}";
               }
           })
        });
    }

    function addMenuSubmit(e) {
        try{
            e.preventDefault();
            $(document).ready(function () {
                let data = $('#new-menu-form').serializeArray().reduce(function (acc, cur) {
                    acc[cur.name.replace('new-menu-form-', '')] = cur.value;
                    return acc;
                },{});
                data['_token'] = "{{csrf_token()}}" ;

                $.ajax({
                    url: "{{route('menu.add')}}",
                    method: "POST",
                    data: data,
                    success: function (response) {
                        window.location.href = "{{route('menu.get')}}";
                    },
                    error: function (response) {
                        console.log(response)
                    }
                })
            })
        }
        catch (e) {
            console.log(e)
        }

    }
</script>

<style>
    .hide-edit-form {
        display: none;
    }
</style>

