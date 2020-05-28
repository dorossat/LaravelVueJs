<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-5">
                <div class="card">
                    
                    <div class="card-header text-primary">
                        <i class="nav-icon fas fa-user"></i>
                        Users Component

                        <div class="card-tools">
                            <button class="btn btn-success" data-toggle="modal" data-target="#addUser">Add user
                                <i class="fas fa-user-plus"></i>
                            </button>
                        </div>

                    </div>

                    
                    <div class="card-body">
                        <table class="table table-hover table-fixed">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>
                                        <a href="#">Edit
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="#"> / Delete
                                            <i class="fa fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">2</th>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>
                                        <a href="#">Edit
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="#"> / Delete
                                            <i class="fa fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="addUserLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserLabel">Add new user</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Add user here !
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success">Add user</button>
            </div>
            </div>
        </div>
        </div>



    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
