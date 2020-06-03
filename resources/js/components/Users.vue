<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-5">
                <div class="card">
                    
                    <div class="card-header text-dark text-bold">
                        <i class="nav-icon fas fa-user"></i>
                        Users Component

                        <div class="card-tools">
                            <button class="btn btn-success" @click="AddUser">Add user
                                <i class="fas fa-user-plus"></i>
                            </button>
                        </div>

                    </div>

                    
                    <div class="card-body">
                        <table class="table table-hover table-fixed">
                            <thead>
                                <tr class="text-primary">
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Created at</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="user in users" :key="user.id">
                                    <th scope="row">{{ user.id}}</th>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email}}</td>
                                    <td>{{ user.role | upText }}</td> <!-- upText is a filter created in app.js -->
                                    <td>{{ user.created_at | myDate }}</td>
                                    <td>
                                        <a style="color:#9F8D0F;" href="#" @click="UpdateUser(user)">Edit
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a style="color:red;" href="#" @click="deleteUser(user.id)"> / Delete
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
<div class="modal fade" id="UserModal" tabindex="-1" role="dialog" aria-labelledby="UserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 v-show="!editModal" class="modal-title" id="UserModalLabel">Add new user</h5>
                <h5 v-show="editModal" class="modal-title" id="UserModalLabel">Update user</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

        <form @submit.prevent="editModal ? UserModalUpdate() : UserModalAdd()">
            <div class="modal-body">

                <form>
                    <div class="form-group">
                        <input v-model="form.name" type="text" name="name" placeholder="Enter name"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>
                    </div>

                    <div class="form-group">
                        <input v-model="form.email" type="text" name="email" placeholder="Enter email"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                        <has-error :form="form" field="email"></has-error>
                    </div>

                    <div class="form-group">
                        <select v-model="form.role"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('role') }">
                            <option value="">Select user role</option>
                            <option value="user" class="text-bold">User</option>
                            <option value="admin" class="text-bold">Admin</option>
                            </select>
                        <has-error :form="form" field="role"></has-error>
                    </div>

                    <div class="form-group">
                        <input v-model="form.password" type="password" name="password" placeholder="Enter password"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                        <has-error :form="form" field="password"></has-error>
                    </div>
                </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button v-show="!editModal" type="submit" class="btn btn-success">Add user</button>
                <button v-show="editModal" type="submit" class="btn btn-info">Update user</button>
            </div>
        </form>

            </div>
        </div>
    </div>



</div>
</template>

<script>
    export default {
        data() {
            return {
                editModal : false,
                users : {}, 
                form : new Form({
                    id : '',
                    name     : '' ,
                    email    : '' ,
                    role : '' ,
                    password : '' ,
                    photo : ''
                })
            }
        },

        methods : {

            // Display users
            loadUser() {
                axios.get("api/user").then (( {data} ) => (this.users = data));
            },

            // Add new user
            UserModalAdd() {
                
                this.form.post('api/user')
                    .then(
                        () => {
                            this.$Progress.start();
                            $("#UserModal").modal('hide');
                            Toast.fire({
                            icon: 'success',
                            title: 'User created successfully'
                            })
                            this.$Progress.finish();
                        }
                    )
                    .catch(
                        () => {
                            this.$Progress.start();
                            this.$Progress.fail();
                        }
                    );
                
            },

            // Update user
            UserModalUpdate(){
                this.$Progress.start();
                this.form.put('api/user/'+ this.form.id)
                    .then(
                        () => {
                            this.$Progress.start();
                            $("#UserModal").modal('hide');
                            Toast.fire({
                            icon: 'success',
                            title: 'User updated successfully'
                            })
                            this.$Progress.finish();
                        }
                    )
                    .catch(
                        () => {
                            this.$Progress.start();
                            this.$Progress.fail();
                        }
                    );

            },
            // Delete User
            deleteUser(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        // Send request to the server
                    if(result.value){
                            this.form.delete('api/user/'+id)
                        .then( () => {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        })
                        .catch( () => {
                                Swal('Failed', 'Something was wrong !', 'warning')
                        })
                    }
                    })
            },

            // Display Modal to add user
            AddUser() {
                this.editModal = false;
                this.form.reset();
                this.form.clear();
                $("#UserModal").modal("show");

            },

            // Display Modal to update user
            UpdateUser(user) {
                this.editModal = true;
                this.form.fill(user);
                this.form.clear(); // clear errors
                $("#UserModal").modal("show")
            }
        },

        created() {
            this.loadUser();
            setInterval(() => this.loadUser(), 2000);
        }
    }
</script>
