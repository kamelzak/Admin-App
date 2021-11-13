<template>
    <div class="container">
        <div class="row">
          <div class="col-12 mt-4">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Table</h3>
                
                <div class="card-tools">
                   <button class="btn btn-success" @click="addUserModal">Add New <i class="fas fa-user-plus fa-fw"></i></button>
                </div>
                
                <!-- New user modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" v-if="!editMode">Add new user</h5>
                        <h5 class="modal-title" id="exampleModalLabel" v-if="editMode">Update user</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form @submit.prevent="editMode ? updateUser() :createUser()">
                        <div class="modal-body">
                            <div class="form-group">
                              <label for="name">Name</label>
                              <input class="form-control" v-model="form.name" type="text" name="name" required>
                              <HasError :form="form" field="name" />
                            </div>
                            <div class="form-group">
                              <label for="email">Email</label>
                              <input class="form-control" v-model="form.email" type="email" name="email" required>
                              <HasError :form="form" field="email" />
                            </div>  
                            <div class="form-group">
                              <label for="bio">Bio</label>
                              <textarea class="form-control" v-model="form.bio" type="text" name="bio"></textarea>
                              <HasError :form="form" field="bio" />
                            </div> 
                            <div class="form-group">
                                <label for="bio">User role</label>
                                <select class="form-control" name="type" v-model="form.type" id="type">
                                  <option value="admin">Admin</option>
                                  <option value="user">Standard user</option>
                                  <option value="author">author</option>
                                </select>
                                <HasError :form="form" field="type" />
                            </div>

                            <div class="form-group">
                              <label for="password">Password</label>
                              <input class="form-control" v-model="form.password" type="password" >
                              <HasError :form="form" field="password" />
                            </div>   

                            <div class="form-group">
                              <label for="password_confirmation">Password confirmation</label>
                              <input class="form-control" v-model="form.password_confirmation" type="password" >
                            </div> 
                         
                        </div>
                      
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary" v-if="!editMode">Create</button>
                          <button type="submit" class="btn btn-primary" v-if="editMode">Update</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- end modal -->
              </div> 
              <!-- end card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Role</th>
                      <th>Registered at</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(user, idx) in users" :key="idx">
                      <td>{{ user.id }}</td>
                      <td>{{ user.name }}</td>
                      <td>{{ user.email }}</td>
                      <td>{{ user.type | capitalize }}</td>
                      <td>{{ user.created_at | myDate }}</td>
                      <td>
                          <div>
                            <a href="#" @click="editUserModal(user)">
                                <i class="fa fa-edit blue"></i>
                            </a>
                            <a href="#" @click="deleteUser(user.id)">
                                <i class="fa fa-trash red"></i>
                            </a>
                          </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- end card-body -->
            </div>
            <!-- end card -->
          </div>
        </div>

    </div>

    
</template>

<script>
import Form from 'vform';

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
          }),
          users : [],
          editMode : false
        }
      },
      methods: {
            getUsers() {
              axios.get('/api/users')
                .then(response => this.users=response.data.data)
                .catch(error => console.log(error));
            },
            createUser() {
              this.form.post('/api/users')
                .then(response => {
                  this.$Progress.start();
                  Fire.$emit('UsersChanged');
                  $('#exampleModal').modal('hide');
                  Toast.fire({
                    icon: 'success',
                    title: 'User created successfully'
                  });
                  this.$Progress.finish();
                })
                .catch(error => console.log(error));
            },
            updateUser() {
              this.$Progress.start();
              this.form.put('/api/users/'+this.form.id)
              .then(response => {
                Fire.$emit('UsersChanged');
                $('#exampleModal').modal('hide');
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
            },
            deleteUser(id) {
                Swal.fire({
                text: "Are you sure you want to delete this user ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) {
                    axios.delete('api/users/'+id)
                    .then(response => {
                      Fire.$emit('UsersChanged');
                      Swal.fire(
                      'Deleted!',
                      'the user has been deleted.',
                      'success'
                    )
                    })
                    .catch(error => console.log(error));
                  }
              });
            },
            addUserModal() {
              this.editMode = false;
              this.form.reset();
              $('#exampleModal').modal('show');
            },
            editUserModal(user) {
              this.editMode = true;
              this.form.reset();
              this.form.fill(user);
              $('#exampleModal').modal('show');
            }
        },
        mounted() {
          this.getUsers();
          Fire.$on('UsersChanged', () => {
            this.getUsers();
          });
        },
    }
</script>
