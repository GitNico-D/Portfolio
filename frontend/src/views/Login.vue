<template>
	<b-container fluid>
		<BackgroundPage circleColor="#485DA6"/>
		<!-- <Transition v-show="showTransition" directionAnimation="left"/> -->
		<b-row class="justify-content-center align-items-center">
			<b-card title="Connexion">
					<hr>
				<b-card-body class="border-lg">
					<b-form @submit.prevent="handleLogin">
						<b-form-group id="input-group-1" label="Email" label-for="input-1">
							<b-form-input 
								id="input-1" 
								v-model="user.email" 
								v-validate="'required'"
								type="email" 
								name="email"
								placeholder="Enter email" 
								>
							</b-form-input>
							<b-alert 
								v-if="errors.has('email')" 
								variant="danger" 
								show 
								dismissible
								>Un email est requis !</b-alert>
						</b-form-group>
					<b-form-group id="input-group-2" label="Mot de Passe" label-for="input-2" class="mb-5">
							<b-form-input 
								id="input-2" 
								v-model="user.password" 
								v-validate="'required'"
								type="password"
								name="password"
								placeholder="Entrer mot de passe">
							</b-form-input>
							<b-alert 
								v-if="errors.has('password')"
								variant="danger" 
								show 
								dismissible
								>Un mot de passe est requis !</b-alert>
						</b-form-group>
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
					</b-form>
				</b-card-body>
			</b-card>
		</b-row>
	</b-container>
</template>

<script>
import BackgroundPage from '@/components/BackgroundPage.vue'
// import Transition from '@/components/Transition.vue'
// import errorRedirection from '@/services/errorRedirection'
import User from '@/models/user'

export default {
	name: 'Login',
	components: {
		BackgroundPage,
		// Transition
	},
	data() {
		return {
			// showTransition: true,
			// form: {
				user: new User('', ''),
				loading: false,
				message: ''
			// }
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
		handleLogin() {
			this.loading = true;
			this.$validator.validateAll
				.then(isValid => {
					if(!isValid) {
						this.loading = false;
						return;
					}

					if(this.user.email && this.user.password) {
						this.$store.dispatch('auth/login', this.user).then (
							() => { 
								this.$router.push('admin');
							},
							error => {
								this.loading =false;
								this.message =
								(error.response && error.response.data) || 
								error.message || 
								error.toString();
							}
						)
					}
				})
		}
			// actionTransition () {
			//     this.showTransition = true;
			//     setTimeout(() => {
			//         this.showTransition = false;
			//     },1300);
			// },
		// onSubmit(event) {
		// 	event.preventDefault()
		// 	this.axios.post(process.env.VUE_APP_API_URL + '/login_check', {
		// 		email: this.email,
		// 		username: this.email,
		// 		password: this.password
		// 	})
		// 	.then(function (response) {
		// 		console.log(response);
		// 	})
		// 	.catch(function (error) {
		// 		errorRedirection(error);
		// 		console.log(error);
		// 	})
		// },        
	},
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