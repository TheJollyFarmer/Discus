import api from "./index";

export default {
  register(payload) {
    return api.request("post", api.route("register"), payload);
  },

  login(payload) {
    return api.request("post", api.route("login"), payload);
  },

  logout() {
    return api.request("post", api.route("logout"));
  },

  getAuthUser() {
    return api.getItem("local", "authUser") || {};
  },

  setAuthUser(user) {
    return api.setItem("local", "authUser", user);
  },

  homeIsCurrentRoute() {
    return api.route().current("home");
  },

  goToHome() {
    return api.goTo("home");
  }
};
