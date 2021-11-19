<template>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-4" v-if="$gate.isAuthor()">
                <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tasks list</h3>
                    
                    <div class="card-tools">
                    <button class="btn btn-success" @click="addTaskModal">Add <i class="fas fa-plus fa-fw"></i></button>
                    </div>
                    
                    <!-- Add/Edit task modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel" v-if="!editMode">Add a new task</h5>
                            <h5 class="modal-title" id="exampleModalLabel" v-if="editMode">Update task</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="editMode ? updateTask() :createTask()">
                            <div class="modal-body">
                                <div class="form-group">
                                <label for="name">Name</label>
                                <input class="form-control" :class="{ 'is-invalid': form.errors.has('name') }"  v-model="form.name" type="text" name="name" required>
                                <HasError :form="form" field="name" />
                                </div>
                                <div class="form-group">
                                <label for="start_date">Starting date</label><br>
                                <date-picker v-model="form.start_date" valueType="format"></date-picker>
                                <HasError :form="form" field="start_date" />
                                </div>  
                                <div class="form-group">
                                <label for="end_date">Ending date</label><br>
                                <date-picker v-model="form.end_date" valueType="format"></date-picker>
                                <HasError :form="form" field="end_date" />
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
                    <!-- end Add/Edit task modal -->
                </div> 
                <!-- end card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Starting date</th>
                        <th>Ending date</th>
                        <th><div class="d-flex justify-content-center">Users assigned</div></th>
                        <th>Actions</th>
                        <th><div class="d-flex justify-content-center">Mark as ended</div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(task, idx) in tasks.data" :key="idx">
                        <td>{{ idx + 1 }}</td>
                        <td>{{ task.name }}</td>
                        <td>{{ task.start_date }}</td>
                        <td>{{ task.end_date  }}</td>
                        <td>
                          <div class="d-flex justify-content-center">
                            <a href="#" @click="showUsersModal(task.id)"><i class="fa fa-users green"></i></a>
                          </div>
                        </td>
                        <td>
                            <div>
                                <a href="#" @click="editTaskModal(task)"><i class="fa fa-edit blue"></i></a>
                                <a href="#" @click="deleteTask(task.id)"><i class="fa fa-trash red"></i></a>
                            </div>
                        </td>
                        <td>
                          <div class="d-flex justify-content-center">
                            <a href="#" @click="endTask(task.id)"><i class="fa fa-check-square green"></i></a>
                          </div>
                        </td>
                        </tr>
                    </tbody>
                    </table>
                </div>
                <!-- end card-body -->
                <div class="card-footer">
                    <div class="float-right">
                    <pagination :data="tasks" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
                </div>
            </div>
            <div v-if="!$gate.isAuthor()">
                <not-found></not-found>
            </div>
        </div>
        <!-- Users assigned modal -->
        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Users assigned list</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                  <table v-if="users_assigned.length>0" class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Abort</th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, idx) in users_assigned" :key="idx">
                          <td>{{user.name}}</td>
                          <td>{{user.email}}</td>
                          <td><a href="#" @click="abortTask(task_id,user.id)"><i class="fa fa-user-times red"></i></a></td>
                        </tr>
                    </tbody>
                  </table>
                  <div v-if="users_assigned.length==0"> 
                    No users assigned to this task yet
                  </div>
                  <hr>
                  <h5 class="modal-title" id="exampleModalLabel">Assign user to this task</h5>
                  <form @submit.prevent="assignUser(task_id)">
                    <div class="d-flex justify-content-start mt-3">
                      <div class="form-group">
                          <input class="form-control" :class="{ 'is-invalid': form.errors.has('email') }"  v-model="form2.email" type="email" name="email" placeholder="Email" required>
                          <HasError :form="form2" field="email" />
                      </div>
                      <div class="ml-2">
                        <button type="submit" class="btn btn-primary">Assign</button>
                      </div>
                    </div>
                  </form>
                </div>
            
                <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
        </div>
        <!-- end users assigned modal -->
    </div>
</template>

<script>
import Form from 'vform';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

    export default {
      data() {
        return {
          form : new Form({
            id: '',
            name : '',
            start_date : '',
            end_date : ''
          }),
          tasks : [],
          editMode : false,
          users_assigned : [],
          task_id : '',
          form2 : new Form({
            email : ''
          })
        }
      },
      components: {
        DatePicker 
      },
      methods: {
            getTasks() {
              if (this.$gate.isAuthor()) {
                axios.get('/api/tasks')
                  .then(response => this.tasks=response.data)
                  .catch(error => console.log(error));
              }
            },
            createTask() {
              this.form.post('/api/tasks')
                .then(response => {
                  this.$Progress.start();
                  Fire.$emit('TasksChanged');
                  $('#exampleModal').modal('hide');
                  Toast.fire({
                    icon: 'success',
                    title: 'Task created successfully'
                  });
                  this.$Progress.finish();
                })
                .catch(error => console.log(error));
            },
            updateTask() {
              this.$Progress.start();
              this.form.put('/api/tasks/'+this.form.id)
              .then(response => {
                Fire.$emit('TasksChanged');
                $('#exampleModal').modal('hide');
                Toast.fire({
                  icon: 'success',
                  title: 'Task updated successfully'
                });
                this.$Progress.finish();
              })
              .catch(error => {
                this.$Progress.fail();
                console.log(error);
              });
            },
            deleteTask(id) {
                Swal.fire({
                text: "Are you sure you want to delete this task ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) {
                    axios.delete('api/tasks/'+id)
                    .then(response => {
                      Fire.$emit('TasksChanged');
                      Swal.fire(
                      'Deleted!',
                      'the task has been deleted.',
                      'success'
                    )
                    })
                    .catch(error => { 
                      console.log(error);
                      Swal.fire({
                        icon: 'error',
                        text: 'Something went wrong!',
                      });
                    });
                  }
              });
            },
            addTaskModal() {
              this.editMode = false;
              this.form.reset();
              $('#exampleModal').modal('show');
            },
            editTaskModal(task) {
              this.editMode = true;
              this.form.reset();
              this.form.fill(task);
              $('#exampleModal').modal('show');
            },
            getResults(page = 1) {
              axios.get('/api/tasks?page=' + page)
                .then(response => {
                  this.tasks = response.data;
                });
            },
            getUsersAssigned(task_id) {
              axios.get('/api/tasks/'+task_id+'/users')
                  .then(response => this.users_assigned=response.data)
                  .catch(error => console.log(error));
            },
            showUsersModal(task_id) {
              this.getUsersAssigned(task_id);
              Fire.$on('UsersAssignedChanged', () => {
                this.getUsersAssigned(task_id);
              });
              this.task_id = task_id;
              $('#exampleModal2').modal('show');
            },
            abortTask(task_id, user_id) {
              Swal.fire({
                text: "Are you sure you want to unassign this user from this task ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
              }).then((result) => {
                if (result.isConfirmed) {
                  axios.get('/api/tasks/'+task_id+'/detach/'+user_id)
                  .then(response => {
                    Fire.$emit('UsersAssignedChanged');
                  })
                  .catch(error => console.log(error));
                }
              })
            },
            assignUser(task_id) {
              this.form2.post('/api/tasks/'+task_id+'/attach')
                .then(response => {
                  this.form2.email = '';
                  Fire.$emit('UsersAssignedChanged');
                })
                .catch(error => console.log(error));
            },
            endTask(task_id) {
              Swal.fire({
                text: "Are you sure you want to mark this task as ended ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
              }).then((result) => {
                if (result.isConfirmed) {
                  axios.post('/api/tasks/'+task_id+'/end')
                  .then(response => {
                    Fire.$emit('TasksChanged');
                  })
                  .catch(error => console.log(error));
                }
              })
            }
        },
        mounted() {
            /*
          Fire.$on('searching', () => {
            let query = this.$parent.search;
            axios.get('/api/user?q='+ query)
            .then(response => {
              this.users = response.data;
            })
            .catch(error => console.log(error));
          });
          */
          this.getTasks();
          Fire.$on('TasksChanged', () => {
            this.getTasks();
          });
        },
    }
</script>
