import api from "../../../../api/messages";
import dataStructures from "../../../../utils/dataStructures";
import types from "./types";
import Vue from "vue";
import { getKeys, normalise } from "../../../../utils/helpers";

export default {
  getData({ commit, dispatch, getters, state }, group) {
    if (!state.completed && !state.progress) {
      commit(types.TOGGLE_PROGRESS);

      return api.getMessages(group, getters.getOffset).then(messages => {
        messages.length
          ? dispatch("addData", { messages, group })
          : dispatch("setCompleted");
      });
    }
  },

  addData({ commit, dispatch }, { messages, group }) {
    commit(types.TOGGLE_PROGRESS);
    commit(types.ADD_DATA, normalise(messages, "conversations"));
    commit(types.ADD_KEYS, getKeys(messages));

    dispatch("listenForMessages", group);
  },

  setCompleted({ commit }) {
    commit(types.TOGGLE_PROGRESS);
    commit(types.SET_COMPLETED);
  },

  listenForMessages({ dispatch }, group) {
    Vue.prototype.$echo
      .private("groups." + group)
      .listen("UserSentMessage", e => {
        dispatch("addMessage", e);
      });
  },

  submitMessage({ commit }, payload) {
    return api.submitMessage(payload).then(message => {
      commit(types.ADD_KEY, message.id);
      commit(types.ADD_DATUM, dataStructures.conversations(message));
    });
  },

  deleteMessage({ commit }, message) {
    api.deleteMessage(message).then(() => {
      commit(types.DELETE_DATUM, message.id);
      commit(types.DELETE_KEY, message.id);
    });
  },

  addMessage({ commit }, message) {
    commit(types.ADD_KEY, message.id);
    commit(types.ADD_DATUM, message);
  }
};
