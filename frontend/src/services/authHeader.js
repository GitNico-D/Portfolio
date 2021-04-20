//Set the Authorization header for private request
export default function authHeader() {
  let user = JSON.parse(localStorage.getItem("user"));

  if (user && user.token) {
    return {
      Authorization: "Bearer " + user.token
    };
  } else {
    return {};
  }
}
