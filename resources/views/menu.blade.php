@extends('layouts.app')

@section('content')
    <div>
        <table class="table">
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
                        <form >
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmation" onclick="actionHandle({{$menu}},'delete')">Delete</button>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#confirmation" onclick="actionHandle({{$menu}},'edit')">Edit</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirmation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="confirmation" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="confirm_type" class="modal-title" id="staticBackdropLabel"></h5>
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
                            <label for="pid">Name</label>
                            <input class="form-control" type="text" id="name" name="name">
                        </div>
                        <div>
                            <label for="pid">Path</label>
                            <input class="form-control" type="text" id="path" name="path">
                        </div>
                        <div>
                            <label for="pid">Icon</label>
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
            formData = {
                _token: "{{csrf_token()}}",
                id: menuData.id,
                pid: menuData.pid,
                name: menuData.name,
                path: menuData.path,
                icon: menuData.icon,
            }

           $.ajax({
               url: action,
               method: "POST",
               data: (action === 'delete') ? {id: menuData.id, _token: "{{csrf_token()}}"} : formData,
               success: function (response) {
                   window.location.href = "{{route('menu.get')}}";
               }
           })
        });
    }
</script>

<style>
    .hide-edit-form {
        display: none;
    }
</style>

