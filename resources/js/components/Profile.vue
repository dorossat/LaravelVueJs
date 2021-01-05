<template>
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-md-12">
                <div class="col-md-12">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-info">
                <h3 class="widget-user-username">{{ this.form.name}}</h3>
              </div>
              <div class="widget-user-image">
                <img class="img-circle elevation-3" :src="getPhoto()" alt="User Avatar">
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">Id</h5>
                      <span class="description-text">{{ this.form.id}}</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">Email</h5>
                      <span class="description-text">{{this.form.email}}</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header">Role</h5>
                      <span class="description-text">{{ this.form.role }}</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.widget-user -->

            <!-- tab -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Activity</a></li>
                        <li class="nav-item"><a class="nav-link active show" href="#settings" data-toggle="tab">Settings</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Activity Tab -->
                            <div v-if="this.hasActivity" class="tab-pane" id="activity">
                                <div class="card">
                                <div v-for="act in activities" :key="act.id" class="card-body">
                                  <h5 class="card-title">{{ act.name }}</h5>
                                  <p class="card-text">{{ act.description }}</p>
                                  <button @click="deleteActivity(act.id)" class="btn btn-danger">Delete activity</button>
                                  <hr>
                                </div>
                              </div>
                            </div>
                            <div v-else class="tab-pane" id="activity">
                                <h3 class="text-center text-danger">No activities !</h3>
                            </div>
                            <!-- Setting Tab -->
                            <div class="tab-pane active show" id="settings">
                                <form class="form-horizontal">
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-12">
                                    <input type="" v-model="form.name" class="form-control" id="inputName" placeholder="Name" :class="{ 'is-invalid': form.errors.has('name') }">
                                     <has-error :form="form" field="name"></has-error>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-12">
                                    <input type="email" v-model="form.email" class="form-control" id="inputEmail" placeholder="Email" :class="{ 'is-invalid': form.errors.has('email') }">
                                    <has-error :form="form" field="email"></has-error>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="photo"  class="col-sm-2 control-label">Profile Photo</label>
                                    <div class="col-sm-12">
                                        <input type="file" @change="updatePhoto" name="photo" class="form-input">
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="password" class="col-sm-12 control-label">Password (leave empty if not changing)</label>

                                    <div class="col-sm-12">
                                    <input type="password" v-model="form.password" class="form-control" id="password" placeholder="Password" :class="{ 'is-invalid': form.errors.has('password') }">
                                    <has-error :form="form" field="password"></has-error>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-12">
                                    <button @click.prevent="UpdateProfile"  type="submit" class="btn btn-success">Update</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
          </div>
          <!-- end tabs -->

          </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
      data() {
            return {
                hasActivity : false,
                user_id : '',
                activities : {},
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

        getData() {
            axios.get('api/profile/' + this.form.id).then( ( {data} ) => {
              this.form.fill(data);
              this.user_id = data.id; // save user_id to display actvities          
            });
        },

        getActivity(){
          axios.get('api/activity/' + this.user_id).then( ( {data} ) => {
              if(data.length > 0){
                this.activities = data;
                this.hasActivity = true;
              }
              else
                this.hasActivity = false;                          
            });
        },

        deleteActivity(id){
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
                            axios.delete('api/activity/' + id)
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

        updatePhoto(event) {
            let file = event.target.files[0];
            //console.log(file);
            let reader = new FileReader();
            // Check file size
            if(file.size <= 2097152){ // 2MB
              reader.onloadend = (file) => {
                this.form.photo = reader.result;
                //console.log(this.form.photo);
              }
              reader.readAsDataURL(file);
            }
            else{
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'You are updating a large file !'
              })
            }
            
        },

        UpdateProfile(){
          this.$Progress.start();
                this.form.put('api/profile/' + this.form.id)
                    .then(
                        () => {
                            this.$Progress.start();
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

        getPhoto() {
          let prefix = (this.form.photo.match(/\//) ? '' : '/images/profile/');
          return prefix + this.form.photo;
        },
      },

      mounted() {
        setInterval(() => this.getActivity(), 7000);
      },

      created() {
        this.getData();        
      }
    }
</script>
