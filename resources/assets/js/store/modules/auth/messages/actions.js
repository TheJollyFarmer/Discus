import api from "../../../../api/messages";
import filters from "../../../../utils/filters";
import types from "./types";
import Vue from "vue";
import { getKeys, normalise } from "../../../../utils/helpers";

export default {
  getData({ commit, dispatch, getters, state }) {
    if (!state.progress && !state.completed) {
      commit(types.TOGGLE_PROGRESS);

      return api.getLatestMessages(getters.getOffset).then(messages => {
        messages.length
          ? dispatch("addData", messages)
          : dispatch("setComepleted");
      });
    }
  },

  addData({ commit, dispatch, getters }, data) {
    let messages = getters.getLatestMessages(data);

    commit(types.TOGGLE_PROGRESS);
    commit(types.ADD_DATA, normalise(messages, "messages"));
    commit(types.ADD_KEYS, getKeys(messages));

    dispatch("listenForMessages");
  },

  setCompleted({ commit }) {
    commit(types.TOGGLE_PROGRESS);
    commit(types.SET_COMPLETED);
  },

  listenForMessages({ dispatch, state }) {
    state.keys.forEach(group => {
      Vue.prototype.$echo
        .private("groups." + group)
        .listen("UserSentMessage", e => {
          dispatch("updateMessage", e);
        });
    });
  },

  addDatum({ commit }, datum) {
    commit(types.ADD_DATUM, normalise(datum, "messages"));
    commit(types.ADD_KEY, getKeys(datum));
    commit(types.INCREMENT_UNREAD_COUNT);
  },

  updateMessage({ commit, state }, message) {
    commit(types.UPDATE_DATUM, { id: message.group, datum: message });
    commit(types.UPDATE_KEY, message.group);
    commit(types.INCREMENT_UNREAD_COUNT);
  },

  markAllAsRead({ dispatch, state }) {
    if (state.unreadCount !== 0) {
      dispatch("setAllAsRead");
    }
  },

  setAllAsRead({ commit, state }) {
    commit(types.SET_UNREAD_COUNT_TO_ZERO);

    for (const item of Object.values(state.data)) {
      if (!item.read_at) {
        commit(types.SET_AS_READ, {
          id: item.group,
          value: filters.timestamp()
        });
      }
    }
  },

  markAs({ dispatch }, { group, marked }) {
    marked ? dispatch("setAsUnread", group) : dispatch("setAsRead", group);
  },

  setAsRead({ commit }, id) {
    commit(types.DECREMENT_UNREAD_COUNT);
    commit(types.SET_AS_READ, { id, value: filters.timestamp() });
  },

  setAsUnread({ commit }, id) {
    commit(types.INCREMENT_UNREAD_COUNT);
    commit(types.SET_AS_UNREAD, { id, value: null });
  }
};
