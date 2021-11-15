<template>
     <div class="container">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card card-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header text-white" style="background-image:url('./img/background-profile.png')">
                    <h3 class="widget-user-username">{{form.name}}</h3>
                    <h5 class="widget-user-desc">{{form.type}}</h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" :src="getProfilePicture()" alt="User Avatar">
                </div>
                <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                        <h5 class="description-header">3,200</h5>
                        <span class="description-text">SALES</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                        <h5 class="description-header">13,000</h5>
                        <span class="description-text">FOLLOWERS</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4">
                        <div class="description-block">
                        <h5 class="description-header">35</h5>
                        <span class="description-text">PRODUCTS</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                </div>
            </div>

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
                                    <input type="text" v-model="form.name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                    <HasError :form="form" field="name" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-12">
                                    <input type="email" v-model="form.email" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                     <HasError :form="form" field="email" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputExperience" class="col-sm-2 control-label">Biography</label>

                                    <div class="col-sm-12">
                                    <textarea v-model="form.bio" class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }" ></textarea>
                                     <HasError :form="form" field="bio" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="photo" class="col-sm-2 control-label">Profile Photo</label>
                                    <div class="col-sm-12">
                                        <input type="file" @change="updateProfilePicture" name="photo" class="form-input">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="col-sm-12 control-label">Password (leave empty if not changing)</label>
                                    <div class="col-sm-12">
                                        <input v-model="form.password" type="password" class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" placeholder="Password">
                                        <HasError :form="form" field="password" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation" class="col-sm-12 control-label">Password confirmation (leave empty if not changing)</label>
                                    <div class="col-sm-12">
                                        <input v-model="form.password_confirmation" type="password" class="form-control" placeholder="Password confirmation">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-12">
                                    <button type="submit" @click.prevent="updateProfile" class="btn btn-success">Update</button>
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
</template>

<script>
import Form from 'vform';
import axios from 'axios';

    export default {
        data() {
            return {
                form : new Form({
                    id: '',
                    name : '',
                    email : '',
                    password : '',
                    password_confirmation : '',
                    type : '',
                    bio : '',
                    photo : ''
                })
            }
        },
        methods: {
            getProfilePicture() {
                let photo = (this.form.photo.length > 200) ? this.form.photo : "img/profile/"+ this.form.photo ;
                return photo;
            },
            getProfile() {
                axios.get('/api/profile')
                .then(response => {
                    this.form.fill(response.data);
                })
                .catch(error => {
                    console.log(error);
                }); 
            },
            updateProfilePicture(e) {
                let file = e.target.files[0];
                let reader = new FileReader();
                if (file['size'] < 2111775) {
                    reader.onloadend = (file) => {
                    //console.log('RESULT', reader.result);
                    this.form.photo = reader.result;
                    }
                    reader.readAsDataURL(file);
                }
                else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'The file must not be more than 2 mb '
                    })
                }
            },
            updateProfile() {
                this.$Progress.start();
                this.form.put('/api/profile')
                .then(response => {
                    Fire.$emit('UsersChanged');
                    Toast.fire({
                    icon: 'success',
                    title: 'User updated successfully'
                    });
                    this.$Progress.finish();
                })
                .catch(error => {
                    this.$Progress.fail();
                    console.log(error);
                });
            }
        },
        mounted() {
            this.getProfile();
            Fire.$on('UsersChanged', () => {
            this.getProfile();
          });
        },
    }
</script>

<style>
.widget-user-header{
    background-position: center center;
    background-size: cover;
    height: 250px !important;
}
.widget-user .card-footer{
    padding: 0;
}
 
</style>
