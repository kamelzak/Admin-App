<template>
    <div class="container">
        <div class="row justify-content-center" v-if="$gate.isUser()">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-body">
                        Tasks
                    </div>
                    
                </div>
            </div>
        </div>
        <div v-if="!$gate.isUser()">
            <not-found></not-found>
        </div>
    </div>
</template>

<script>
    export default {

    }
</script>
