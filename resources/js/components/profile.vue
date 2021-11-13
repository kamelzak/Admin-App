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
                    <img class="img-circle" src="img/avatar.png" alt="User Avatar">
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
                                    <input type="text" v-model="form.name" class="form-control" id="inputName" placeholder="Name">
                                     
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-12">
                                    <input type="email" v-model="form.email" class="form-control" id="inputEmail" placeholder="Email" >
                                     
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputExperience" class="col-sm-2 control-label">Biography</label>

                                    <div class="col-sm-12">
                                    <textarea v-model="form.bio" class="form-control" id="inputExperience" placeholder="Experience" ></textarea>
                                     
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="photo" class="col-sm-2 control-label">Profile Photo</label>
                                    <div class="col-sm-12">
                                        <input type="file" @change="updateProfilePicture" name="photo" class="form-input">
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="password" class="col-sm-12 control-label">Passport (leave empty if not changing)</label>

                                    <div class="col-sm-12">
                                    <input type="password"
                                        
                                        class="form-control"
                                        id="password"
                                        placeholder="Passport"
                                        
                                    >
                                     
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
            getProfile() {
                axios.get('/api/profile')
                .then(response => {
                    this.form.fill(response.data);
                })
                .catch(error => console.log(error));
            },
            updateProfilePicture(e) {
                //console.log('uploading picture');
                let file = e.target.files[0];
                let reader = new FileReader();
                reader.onloadend = (file) => {
                    //console.log('RESULT', reader.result);
                    this.form.photo = reader.result;
                }
                reader.readAsDataURL(file);
            },
            updateProfile() {
                this.form.put('/api/profile')
                .then(response => {

                })
                .catch(error => console.log(error));
            }
        },
        mounted() {
            this.getProfile();
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
