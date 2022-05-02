import { isNotEqualTo, isTrue } from "../../helpers/getters";

export default {
  isLoggedIn: isNotEqualTo("user", null),
  isCreatedBy: isTrue("user/id"),
  isAdmin: (state, getters) => getters.isLoggedIn && state.user.isAdmin,
  isThreadOwner: (state, getters, rootState, rootGetters) => {
    return (
      getters.isLoggedIn &&
      state.user.id === rootGetters["threads/thread/getOwner"]
    );
  }
};
