import api from "../../../../api/friendRequests";
import types from "./types";
import Vue from "vue";
import { getKeys, normalise } from "../../../../utils/helpers";

export default {
  getData({ commit, dispatch, getters, rootState, state }) {
    dispatch("listenForRequests");

    if (!state.completed && !state.progress) {
      commit(types.TOGGLE_PROGRESS);

      api
        .getFriendRequests(rootState.auth.user.username, getters.getOffset)
        .then(friendRequests => {
          friendRequests.length
            ? dispatch("addData", friendRequests)
            : dispatch("setCompleted");
        });
    }
  },

  listenForRequests({ dispatch, rootState }) {
    Vue.prototype.$echo
      .private("App.User." + rootState.auth.user.id)
      .listen("UserHasNewFriendRequest", e => {
        dispatch("addDatum", e);
      });
  },

  addData({ commit }, data) {
    commit(types.TOGGLE_PROGRESS);
    commit(types.ADD_DATA, normalise(data, "friendRequests", null, true));
    commit(types.ADD_KEYS, getKeys(data, true));
  },

  setCompleted({ commit }) {
    commit(types.TOGGLE_PROGRESS);
    commit(types.SET_COMPLETED);
  },

  addDatum({ commit }, datum) {
    commit(types.ADD_DATUM, normalise(datum, "friendRequests"));
    commit(types.ADD_KEY, datum.id);
    commit(types.INCREMENT_UNREAD_COUNT);
  },

  acceptFriendRequest({ commit, dispatch }, friend) {
    api.acceptFriendRequest(friend).then(() => {
      dispatch("removeRequest", friend);
    });
  },

  declineFriendRequest({ commit, dispatch }, friend) {
    api.declineFriendRequest(friend).then(() => {
      dispatch("removeRequest", friend);
    });
  },

  removeRequest({ commit, getters, state }, friend) {
    let index = state.keys.indexOf(friend);

    commit(types.DELETE_DATUM, index);

    if (index < state.unreadCount) {
      commit(types.DECREMENT_UNREAD_COUNT);
    }
  }
};
