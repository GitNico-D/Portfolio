<template>
    <b-container fluid>
        <BackgroundPage circleColor="#485DA6"/>
        <!-- <Transition v-show="showTransition" directionAnimation="left"/> -->
        <b-row class="justify-content-center align-items-center">
            <b-card title="Connexion">
                <hr>
                <b-card-body class="border-lg">
                    <b-form>
                        <b-form-group id="input-group-1" label="Email" label-for="input-1">
                            <b-form-input id="input-1" v-model="form.email" type="email" placeholder="Enter email" required>
                            </b-form-input>
                        </b-form-group>
                        <b-form-group id="input-group-2" label="Mot de Passe" label-for="input-2" class="mb-5">
                            <b-form-input id="input-2" v-model="form.password" placeholder="Entrer mot de passe" required>
                            </b-form-input>
                        </b-form-group>
                        <hr>
                        <b-button type="submit" variant="primary">Submit</b-button>
                    </b-form>
                </b-card-body>
            </b-card>
        </b-row>
    </b-container>
</template>

<script>
import BackgroundPage from '@/components/BackgroundPage.vue'
// import Transition from '@/components/Transition.vue'
import errorRedirection from '@/services/errorRedirection'

export default {
components: {
        BackgroundPage,
        // Transition
    },
    data() {
        return {
            // showTransition: true,
            form: {
                email: '',
                password: ''
                }
            }
        },
    methods: {
        // actionTransition () {
        //     this.showTransition = true;
        //     setTimeout(() => {
        //         this.showTransition = false;
        //     },1300);
        // },
        onSubmit(event) {
            event.preventDefault()
            this.axios.post(process.env.VUE_APP_API_URL + '/login_check', {
                email: this.email,
                username: this.email,
                password: this.password
            })
            .then(function (response) {
                console.log(response);
            })
            .catch(function (error) {
                errorRedirection(error);
                console.log(error);
            })
        },        
    },
    // created() {
    //     setTimeout(() => {
    //         this.showTransition = false;
    //     },1300);
    // },
}
</script>

<style lang="scss">
.card {
    // background: transparent!important;
    border: 1px solid $blue!important;
    color: $blue;
}

</style>