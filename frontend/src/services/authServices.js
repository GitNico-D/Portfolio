import axios from "axios";

//Authentification service permit to verified user credentials. 
//If it's good return a jwt token and save it in local Storage  
class AuthServices {
  login(user) {
    console.log(user);
    return axios
      .post(process.env.VUE_APP_API_URL + "/login_check", {
        email: user.email,
        password: user.password
      })
      .then(response => {
        if (response.data.token) {
          localStorage.setItem("user", JSON.stringify(response.data));
        }
        return response.data;
      });
  }
  //When logout remove the item contains the token
  logout() {
    localStorage.removeItem("user");
  }
}

export default new AuthServices();
