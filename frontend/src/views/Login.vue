<template>
	<b-container fluid>
		<BackgroundPage circleColor="#485DA6"/>
		<!-- <Transition v-show="showTransition" directionAnimation="left"/> -->
		<b-row class="justify-content-center align-items-center">
			<b-card title="Connexion">
					<hr>
				<b-card-body class="border-lg">
					<ValidationObserver ref="form" v-slot="{ }">
						<form @submit.prevent="onSubmit">
							<ValidationProvider :rules="{ required: true, email: true }" name="e-mail" v-slot="{ errors }">
								<b-form-group id="input-group-1" label="Email" label-for="input-1">
									<b-form-input 
										id="input-1" 
										v-model="user.email" 
										type="email"
										placeholder="Entrer email">
									</b-form-input>
									<b-alert  
										variant="danger" 
										v-if="errors[0]"
										show>
										{{ errors[0] }}
									</b-alert>
								</b-form-group>
							</ValidationProvider>
							<ValidationProvider rules="required" v-slot="{ errors }">
								<b-form-group id="input-group-2" label="Mot de Passe" label-for="input-2" class="mb-5">
									<b-form-input 
										id="input-2" 
										v-model="user.password" 
										type="password"
										name="password"
										placeholder="Entrer mot de passe">
									</b-form-input>
									<b-alert 
										variant="danger" 
										v-if="errors[0]"
										show>
										{{ errors[0] }}
									</b-alert>
								</b-form-group>
							</ValidationProvider>
							<b-form-group>
								<b-button block type="submit" variant="info" :disabled="loading">
									<b-spinner v-show="loading" label="Spinning"></b-spinner>
									<span>Se connecter</span>
								</b-button>
							</b-form-group>
							<b-form-group>
								<b-alert 
									v-if="message"
									variant="danger" 
									show 
									dismissible
									>{{ message }}</b-alert>
							</b-form-group>
						</form>
					</ValidationObserver>
				</b-card-body>
			</b-card>
		</b-row>
	</b-container>
</template>

<script>
import BackgroundPage from '@/components/BackgroundPage.vue'
// import Transition from '@/components/Transition.vue'
// import errorRedirection from '@/services/errorRedirection'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import { mapActions } from 'vuex'

export default {
	name: 'Login',
	components: {
		BackgroundPage,
		ValidationProvider,
		ValidationObserver
		// Transition
	},
	data() {
		return {
			// showTransition: true,
			email: '',
			user: {
				email: '',
				password: ''
			},
			loading: false,
			message: ''
		}
	},
	computed: {
		loggedIn() {
			return this.$store.state.auth.status.loggedIn
		}
	},
	created() {
		if (this.loggedIn) {
			this.$router.push('/admin')
		}
	},
	methods: {
		...mapActions([
			'login'
			]),
		onSubmit() {
			this.loading = true;
			this.$refs.form.validate()
				.then(isValid => {
					if(!isValid) {
						this.loading = false;
						return;
					}
					if(this.user.email && this.user.password) {
						this.$store.dispatch('auth/login', this.user)
							.then(() => {
								this.$router.push('/admin');
							})
							.catch(() => {
								this.loading =false;
								this.message = "Identifiants invalides !"
								// this.message = error.message
							})
						}
					})
				}
		}
				
		// },
			// actionTransition () {
			//     this.showTransition = true;
			//     setTimeout(() => {
			//         this.showTransition = false;
			//     },1300);
			// },       
	// },
    // mounted() {
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