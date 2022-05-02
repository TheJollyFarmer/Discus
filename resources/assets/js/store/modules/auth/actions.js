import api from "../../../api/auth";
import { hasLength } from "../../../utils/helpers";
import types from "./types";

export default {
  register({ dispatch }, payload) {
    api.register(payload).then(user => {
      dispatch("setUser", user);
    });
  },

  login({ dispatch }, payload) {
    api
      .login(payload)
      .then(user => dispatch("setUser", user))
      .then(() => dispatch("fetchUserData"));
  },

  getAuthUser({ commit, dispatch }) {
    let authUser = api.getAuthUser();

    if (hasLength(authUser)) {
      commit(types.SET_USER, authUser);
      dispatch("setBreadcrumb", authUser.username);
      dispatch("fetchUserData");
    }
  },

  setUser({ commit, dispatch }, user) {
    dispatch("toggleContent", "modal", { root: true });
    dispatch("setBreadcrumb", user.username);

    commit(types.SET_USER, user);

    api.setAuthUser(user);
  },

  setBreadcrumb({ commit }, username) {
    commit(types.SET_BREADCRUMB_LABEL, username);
    commit(types.SET_BREADCRUMB_LINK_DATA, username);
  },

  fetchUserData({ dispatch }) {
    dispatch("friends/getData");
    dispatch("friendRequests/getData");
    dispatch("messages/getData");
    dispatch("notifications/getData");
  },

  logout() {
    api.logout().then(() => {
      if (!api.homeIsCurrentRoute()) {
        api.setAuthUser({});
        api.goToHome("home");
      }
    });
  }
};
