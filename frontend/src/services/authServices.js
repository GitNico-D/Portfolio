import axios from 'axios';

class AuthServices 
{
	login(user)
	{
		console.log(user);
		return axios
			.post(process.env.VUE_APP_API_URL + '/login_check', {
				email: user.email,
				password: user.password
			})
			.then(response => {
				if(response.data.token) {
					localStorage.setItem('user', JSON.stringify(response.data));
				}
				return response.data;
			});
		
	}

	logout() 
	{
		localStorage.removeItem('user');
	}
}

export default new AuthServices();