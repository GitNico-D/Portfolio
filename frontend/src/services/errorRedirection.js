import router from "../router";
import store from "../store";

export default function errorRedirection(error) {
  console.log(error);
  if (error.response) {
    let errors = JSON.parse(JSON.stringify(error.response.data));
    store.commit("ADD_ERROR", errors.message);
    router.push({
      name: "ErrorView",
      params: {
        errorStatus: "Erreur Api -" + errors.code
      }
    });
  } else if (error.request) {
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
