<template>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-4" v-if="$gate.isAuthor()">
                <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ended Tasks list</h3>
                </div> 
                <!-- end card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Starting date</th>
                        <th>Ended date</th>
                        <th><div class="d-flex justify-content-center">Users assigned</div></th>
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
                      </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, idx) in users_assigned" :key="idx">
                          <td>{{user.name}}</td>
                          <td>{{user.email}}</td>
                        </tr>
                    </tbody>
                  </table>
                  <div v-if="users_assigned.length==0"> 
                    No users we assigned to this task
                  </div>
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
    export default {
        data() {
            return {
            tasks : [],
            users_assigned : [],
            }
        },
        methods: {
            getTasks() {
              if (this.$gate.isAuthor()) {
                axios.get('/api/ended-tasks')
                  .then(response => this.tasks=response.data)
                  .catch(error => console.log(error));
              }
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
              $('#exampleModal2').modal('show');
            },
        },
        mounted() {
            this.getTasks();
        },
    }
</script>
