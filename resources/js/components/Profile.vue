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
                            <div class="tab-pane" id="activity">
                                <h3 class="text-center">Display User Activity</h3>
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
                                    <label for="password" class="col-sm-12 control-label">Passport (leave empty if not changing)</label>

                                    <div class="col-sm-12">
                                    <input type="password" v-model="form.password" class="form-control" id="password" placeholder="Passport" :class="{ 'is-invalid': form.errors.has('password') }">
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
            axios.get('api/profile').then( ( {data} ) => {
              this.form.fill(data);
            });
        },

        updatePhoto(event) {
            let file = event.target.files[0];
            console.log(file);
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
          return "images/profile/"+this.form.photo;
        }

      },

      mounted() {
        console.log('Component mounted.')
      },

      created() {
        this.getData();
      }
    }
</script>
