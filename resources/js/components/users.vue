<template>
    <div class="container">
        <div class="row">
          <div class="col-12 mt-4">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Table</h3>
                
                <div class="card-tools">
                   <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Add New <i class="fas fa-user-plus fa-fw"></i></button>
                </div>
                
                <!-- New user modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add new</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form @submit.prevent="createUser">
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
                              <input class="form-control" v-model="form.password" type="password" placeholder="password" required>
                              <HasError :form="form" field="password" />
                            </div>   

                            <div class="form-group">
                              <label for="password_confirmation">Password confirmation</label>
                              <input class="form-control" v-model="form.password_confirmation" type="password" placeholder="password_confirmation" required>
                            </div> 
                         
                        </div>
                      
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
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
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(user, idx) in users" :key="idx">
                      <td>{{ user.id }}</td>
                      <td>{{ user.name }}</td>
                      <td>{{ user.email }}</td>
                      <td><span class="tag tag-success">{{ user.type }}</span></td>
                      <td>
                          <div>
                            <a href="#">
                                <i class="fa fa-edit blue"></i>
                            </a>
                            <a href="#">
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
            name : '',
            email : '',
            password : '',
            password_confirmation : '',
            type : '',
            bio : '',
            photo : ''
          }),
          users : []
           
        }
      },
      methods: {
            createUser() {
              this.form.post('/api/users');
            },
            getUsers() {
              axios.get('/api/users')
                .then(response => this.users=response.data);
            }
        },
        mounted() {
          this.getUsers();
        },
    }
</script>
