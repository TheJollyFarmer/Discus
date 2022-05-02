import actions from "./actions";
import getters from "./getters";
import mutations from "./mutations";
import state from "./state";
import thread from "../threads/thread/index";

export default {
  namespaced: true,

  modules: {
    thread
  },

  state,
  actions,
  mutations,
  getters
};
