import actions from "./actions";
import getters from "./getters";
import mutations from "./mutations";
import state from "./state";
import friends from "./friends/index";
import friendRequests from "./friendrequests/index";
import groups from "./groups/index";
import messages from "./messages/index";
import notifications from "./notifications/index";

export default {
  namespaced: true,

  modules: {
    friends,
    friendRequests,
    groups,
    messages,
    notifications
  },

  state,
  actions,
  mutations,
  getters
};
