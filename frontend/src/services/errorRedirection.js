import router from "../router";
import store from "../store";

//Redirection when user go to wrong or unknown page
export default function errorRedirection(error) {
  if (error.request) {
    store.commit("ADD_ERROR", "Le serveur semble être indisponible");
    router.push({
      name: "ErrorView",
      params: {
        errorStatus: "500"
      }
    });
  } else {
    router.push({
      name: "ErrorView",
      params: {
        errorStatus: "404"
      }
    });
  }
}
