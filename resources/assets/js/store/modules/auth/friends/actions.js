import api from "../../../../api/friends";
import types from "./types";
import { getKeys, normalise } from "../../../../utils/helpers";

export default {
  getData({ commit, dispatch, getters, rootState, state }) {
    if (!state.completed && !state.progress) {
      commit(types.TOGGLE_PROGRESS);

      api
        .getFriends(rootState.auth.user.username, getters.getOffset)
        .then(friends => {
          friends.length
            ? dispatch("addData", friends)
            : dispatch("setCompleted");
        });
    }
  },

  addData({ commit }, friends) {
    commit(types.TOGGLE_PROGRESS);
    commit(types.ADD_DATA, normalise(friends, "friends"));
    commit(types.ADD_KEYS, getKeys(friends));
  },

  setCompleted({ commit }) {
    commit(types.TOGGLE_PROGRESS);
    commit(types.SET_COMPLETED);
  }
};
