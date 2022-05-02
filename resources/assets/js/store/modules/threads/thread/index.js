import actions from "./actions";
import comments from "./comments/index";
import getters from "./getters";
import mutations from "./mutations";
import state from "./state";

export default {
  namespaced: true,

  modules: {
    comments
  },

  state,
  actions,
  mutations,
  getters
};
